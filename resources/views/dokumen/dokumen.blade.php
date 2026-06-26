@extends('layouts.template')

@section('content')
  <div class="container-fluid">
    <div class="page-title">
      <div class="row">
        <div class="col-sm-6">
          <h3>Dokumen</h3>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb">
            <li class="breadcrumb-item">
              <a href="{{ route('dashboard') }}">
                <svg class="stroke-icon">
                  <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-home') }}"></use>
                </svg>
              </a>
            </li>
            <li class="breadcrumb-item active">Dokumen</li>
          </ol>
        </div>
      </div>
    </div>
  </div>

  <div class="container-fluid datatable-init">
    <div class="row">
      <div class="col-sm-12">
        <div class="card">
          <div class="card-header pb-0 card-no-border d-flex justify-content-between align-items-center ">
            <h5>Data Dokumen</h5>

            @php
              $role = Auth::user()->getRoleNames()->first(); // ambil role pertama
              $createRoute = $role === 'mahasiswa' ? route('mahasiswa.documents.create') : route('documents.create'); // dosen (dan fallback lainnya)
              $editRoute = $role === 'mahasiswa' ? 'mahasiswa.documents.edit' : 'documents.edit';
              $isMahasiswa = auth()->user()->hasRole('mahasiswa');
              $routeName = $isMahasiswa ? 'mahasiswa.documents.destroy' : 'documents.destroy';
            @endphp

            @if ($role === 'mahasiswa' || ($role === 'dosen' && !request()->has('filter')))
              {{-- Tombol tambah dokumen --}}
              <a href="{{ $createRoute }}" class="btn btn-primary btn-sm">
                + Tambah Dokumen
              </a>
            @endif

          </div>
          {{-- Tabel --}}
          <div class="card-body">
            <div class="table-responsive custom-scrollbar">
              <table class="display table-striped border" id="basic-1">
                <thead>
                  <tr>
                    <th>No</th>
                    @if ($filter === 'bimbingan')
                      <th>Mahasiswa</th>
                    @elseif ($role === 'mahasiswa')
                      <th>Dosen Pembimbing</th>
                    @endif
                    <th>Judul</th>
                    <th>Tahun</th>
                    <th>Kategori</th>
                    {{-- <th>Fakultas</th> --}}
                    <th>Jurusan</th>
                    <th>Diunduh</th>
                    <th>Status</th>
                    <th>Publikasi</th>
                    <th>Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($dokumens as $index => $dokumen)
                    <tr>
                      <td>{{ $index + 1 }}.</td>
                      @if ($filter === 'bimbingan')
                        <td>{{ $dokumen->user->name ?? '-' }}</td>
                      @elseif ($role === 'mahasiswa')
                        <td>{{ $dokumen->dosen->name ?? '-' }}</td>
                      @endif
                      <td>@judul($dokumen->judul)</td>
                      <td>{{ $dokumen->tahun_publikasi }}</td>
                      <td>{{ $dokumen->kategori->nama_kategori ?? '-' }}</td>
                      {{-- <td>{{ $dokumen->fakultas->kode_fakultas ?? '-' }}</td> --}}
                      <td>{{ $dokumen->jurusan->nama_jurusan ?? '-' }}</td>
                      <td>{{ $dokumen->jumlah_diunduh }}x</td>
                      <td>
                        @php
                          $statusColor = 'warning';
                          if ($dokumen->status === 'diterima') $statusColor = 'success';
                          elseif ($dokumen->status === 'ditolak') $statusColor = 'danger';
                          elseif ($dokumen->status === 'direvisi') $statusColor = 'info';
                        @endphp
                        <span class="badge bg-{{ $statusColor }}">
                          {{ ucfirst($dokumen->status) }}
                        </span>
                        @if($dokumen->status === 'direvisi')
                          <br><small class="text-danger"><i class="fa-solid fa-triangle-exclamation"></i> Ada Revisi</small>
                        @endif
                      </td>
                      <td>
                        <span class="badge bg-{{ $dokumen->is_published ? 'primary' : 'secondary' }}">
                          {{ $dokumen->is_published ? 'Publik' : 'Privat' }}
                        </span>
                      </td>
                      <td>
                        <ul class="action">
                          <li class="info" style="margin-right: 7px">
                            <button type="button" class="btn p-0 border-0 bg-transparent text-secondary"
                              data-bs-toggle="modal" data-bs-target="#modalDetailDokumen{{ $dokumen->id }}">
                              <i class="fa-solid fa-circle-info"></i>
                            </button>
                          </li>
                          
                          @can('verifikasi-dokumen')
                            <li class="unverify" style="margin-right: 7px">
                              <form id="unverify-form-{{ $dokumen }}"
                                action="{{ route('documents.unverify.dosen', $dokumen) }}" method="POST"
                                style="display: inline;">
                                @csrf
                                @method('PUT')
                                <button type="button" class="btn p-0 border-0 bg-transparent text-danger"
                                  onclick="confirmUnverify({{ $dokumen }})" title="Batalkan Verifikasi">
                                  <i class="fa-solid fa-xmark"></i>
                                </button>
                              </form>
                            </li>
                          @endcan
                          @if ($dokumen->status !== 'diterima' && $dokumen->status !== 'ditolak')
                            <li class="edit">
                              <a href="{{ route($editRoute, $dokumen) }}" class="text-warning" title="Edit Dokumen">
                                <i class="fa-regular fa-pen-to-square"></i>
                              </a>
                            </li>
                            <li class="delete">
                              <form action="{{ route($routeName, $dokumen) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="button" onclick="confirmDelete(this)"
                                  class="btn p-0 border-0 bg-transparent text-danger" title="Hapus Dokumen">
                                  <i class="fa-solid fa-trash-can"></i>
                                </button>
                              </form>
                            </li>
                          @endif
                        </ul>
                      </td>
                    </tr>
                    <!-- Modal Detail Dokumen -->
                    <div class="modal fade" id="modalDetailDokumen{{ $dokumen->id }}" tabindex="-1"
                      aria-labelledby="modalLabel{{ $dokumen->id }}" aria-hidden="true">
                      <div class="modal-dialog modal-lg modal-dialog-scrollable">
                        <div class="modal-content">
                          <div class="modal-header bg-primary text-white">
                            <h5 class="modal-title" id="modalLabel{{ $dokumen->id }}">Detail Dokumen</h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                              aria-label="Tutup"></button>
                          </div>
                          <div class="modal-body">
                            <div class="row">
                              {{-- Thumbnail --}}
                              <div class="col-md-4 mb-3 text-center">
                                @if ($dokumen->thumbnail_path)
                                  <img src="{{ asset('storage/dokumen/thumbnail/' . $dokumen->thumbnail_path) }}"
                                    class="img-fluid rounded shadow" alt="Thumbnail">
                                @else
                                  <img src="{{ asset('images/default_thumbnail.png') }}" class="img-fluid rounded shadow"
                                    alt="No Thumbnail">
                                @endif
                              </div>

                              {{-- Informasi Dokumen --}}
                              <div class="col-md-8">
                                <h5>{{ $dokumen->judul }}</h5>
                                <p><strong>Kategori:</strong> {{ $dokumen->kategori->nama_kategori ?? '-' }}</p>
                                <p><strong>Tahun Publikasi:</strong> {{ $dokumen->tahun_publikasi }}</p>
                                <p><strong>Kata Kunci:</strong> {{ $dokumen->kata_kunci }}</p>
                                <p><strong>Fakultas:</strong> {{ $dokumen->fakultas->nama_fakultas ?? '-' }}</p>
                                <p><strong>Jurusan:</strong> {{ $dokumen->jurusan->nama_jurusan ?? '-' }}</p>
                                @if ($dokumen->dosen)
                                  <p><strong>Dosen Pembimbing:</strong> {{ $dokumen->dosen->name }}</p>
                                @endif
                                
                                @if($dokumen->catatan_revisi)
                                <div class="alert alert-warning p-2 mt-2 f-12">
                                  <strong><i class="fa-solid fa-note-sticky me-1"></i> Catatan/Revisi:</strong><br>
                                  {{ $dokumen->catatan_revisi }}
                                </div>
                                @endif
                                
                                <hr>
                                <p><strong>Abstrak:</strong></p>
                                <p>{{ $dokumen->abstrak }}</p>
                              </div>
                            </div>

                            @if($dokumen->file_path)
                            <div class="row mt-3">
                                <div class="col-12">
                                    <h6 class="text-muted mb-2">Preview File:</h6>
                                    <div class="border rounded p-1 bg-light">
                                        <iframe src="{{ asset('storage/dokumen/file/' . $dokumen->file_path) }}" width="100%" height="400px" style="border: none; border-radius: 4px;"></iframe>
                                    </div>
                                </div>
                            </div>
                            @endif
                          </div>
                          <div class="modal-footer">
                            <a href="{{ route('auth.dokumen.download', $dokumen) }}" class="btn btn-success">
                              <i class="fa-solid fa-download"></i> Unduh Dokumen
                            </a>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                          </div>
                        </div>
                      </div>
                    </div>
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
