@extends('layouts.template')

@section('content')
    <div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-sm-6">
                    <h3>Verifikasi Dokumen</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">
                                <svg class="stroke-icon">
                                    <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-home') }}"></use>
                                </svg></a></li>
                        <li class="breadcrumb-item active">Verifikasi</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid datatable-init">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header pb-0 card-no-border d-flex justify-content-between align-items-center">
                        <h5>Data Verifikasi</h5>
                        <span class="badge badge-light-primary f-12">
                            {{ $dokumens->count() }} dokumen menunggu verifikasi
                        </span>
                    </div>

                    <div class="card-body">
                        <div class="table-responsive custom-scrollbar">
                            <table class="display table-striped border" id="basic-1">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        @if (auth()->user()->hasRole('admin'))
                                            <th>Dosen</th>
                                        @else
                                            <th>Mahasiswa</th>
                                        @endif
                                        <th>Judul</th>
                                        <th>Kategori</th>
                                        <th>Fakultas</th>
                                        <th>Jurusan</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($dokumens as $index => $item)
                                        <tr>
                                            <td>{{ $index + 1 }}.</td>
                                            <td>{{ $item->user->name ?? '-' }}</td>
                                            <td>{{ Str::limit($item->judul, 40) }}</td>
                                            <td>{{ $item->kategori->nama_kategori ?? '-' }}</td>
                                            <td>{{ $item->fakultas->nama_fakultas ?? '-' }}</td>
                                            <td>{{ $item->jurusan->nama_jurusan ?? '-' }}</td>
                                            <td>
                                                @php
                                                    $statusColor = 'warning';
                                                    if ($item->status === 'diterima') $statusColor = 'success';
                                                    elseif ($item->status === 'ditolak') $statusColor = 'danger';
                                                    elseif ($item->status === 'direvisi') $statusColor = 'info';
                                                @endphp
                                                <span class="badge bg-{{ $statusColor }}">
                                                    {{ ucfirst($item->status) }}
                                                </span>
                                            </td>
                                            <td>
                                                <ul class="action">
                                                    {{-- Tombol: Lihat Detail --}}
                                                    <li class="info" style="margin-right: 7px">
                                                        <button type="button" class="btn p-0 border-0 bg-transparent"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#modalDetailDokumen{{ $index }}"
                                                            title="Lihat Detail">
                                                            <i class="fa-solid fa-circle-info text-secondary"></i>
                                                        </button>
                                                    </li>

                                                    {{-- Tombol: Verifikasi (buka modal form nilai) --}}
                                                    @if($item->status !== 'direvisi' && $item->status !== 'ditolak')
                                                    <li class="verify" style="margin-right: 7px">
                                                        <button type="button" class="btn p-0 border-0 bg-transparent"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#modalVerifikasi{{ $index }}"
                                                            title="Verifikasi & Beri Nilai">
                                                            <i class="fa-solid fa-check-circle text-success"></i>
                                                        </button>
                                                    </li>
                                                    @endif

                                                    {{-- Tombol: Tolak --}}
                                                    @if($item->status !== 'ditolak')
                                                    <li class="delete" style="margin-right: 7px">
                                                        <button type="button" class="btn p-0 border-0 bg-transparent"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#modalTolak{{ $index }}"
                                                            title="Tolak Dokumen">
                                                            <i class="fa-solid fa-xmark text-danger"></i>
                                                        </button>
                                                    </li>
                                                    @endif

                                                    {{-- Tombol: Revisi --}}
                                                    @if($item->status !== 'direvisi')
                                                    <li class="edit">
                                                        <button type="button" class="btn p-0 border-0 bg-transparent"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#modalRevisi{{ $index }}"
                                                            title="Minta Revisi">
                                                            <i class="fa-solid fa-pen-to-square text-warning"></i>
                                                        </button>
                                                    </li>
                                                    @endif
                                                </ul>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="text-center text-muted py-4">
                                                Tidak ada dokumen yang menunggu verifikasi.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ===================== SEMUA MODAL DI LUAR TABEL ===================== --}}
    @foreach ($dokumens as $index => $item)
        {{-- MODAL DETAIL --}}
        <div class="modal fade" id="modalDetailDokumen{{ $index }}" tabindex="-1"
            aria-labelledby="modalLabelDetail{{ $index }}" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title" id="modalLabelDetail{{ $index }}">Detail Dokumen</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                            aria-label="Tutup"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            {{-- Thumbnail --}}
                            <div class="col-md-4 mb-3 text-center">
                                @if ($item->thumbnail_path)
                                    <img src="{{ asset('storage/dokumen/thumbnail/' . $item->thumbnail_path) }}"
                                        class="img-fluid rounded shadow" alt="Thumbnail">
                                @else
                                    <img src="{{ asset('images/default_thumbnail.png') }}" class="img-fluid rounded shadow"
                                        alt="No Thumbnail">
                                @endif
                            </div>

                            {{-- Info Dokumen --}}
                            <div class="col-md-8">
                                <h5>{{ $item->judul }}</h5>
                                <table class="table table-sm table-borderless">
                                    <tr>
                                        <td class="text-muted" style="width:130px">Kategori</td>
                                        <td>: {{ $item->kategori->nama_kategori ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">Tahun Publikasi</td>
                                        <td>: {{ $item->tahun_publikasi }}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">Kata Kunci</td>
                                        <td>: {{ $item->kata_kunci }}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">Fakultas</td>
                                        <td>: {{ $item->fakultas->nama_fakultas ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">Jurusan</td>
                                        <td>: {{ $item->jurusan->nama_jurusan ?? '-' }}</td>
                                    </tr>
                                    @if ($item->dosen)
                                        <tr>
                                            <td class="text-muted">Dosen Pembimbing</td>
                                            <td>: {{ $item->dosen->name }}</td>
                                        </tr>
                                    @endif
                                    @if ($item->nilai_kelayakan)
                                        <tr>
                                            <td class="text-muted">Nilai Kelayakan</td>
                                            <td>: <span
                                                    class="badge badge-light-success">{{ $item->nilai_kelayakan }}</span>
                                            </td>
                                        </tr>
                                    @endif
                                </table>
                                <hr>
                                <p class="text-muted mb-1"><strong>Abstrak:</strong></p>
                                <p class="f-13">{{ $item->abstrak }}</p>
                            </div>
                        </div>

                        @if($item->file_path)
                        <div class="row mt-3">
                            <div class="col-12">
                                <h6 class="text-muted mb-2">Preview File:</h6>
                                <div class="border rounded p-1 bg-light">
                                    <iframe src="{{ asset('storage/dokumen/file/' . $item->file_path) }}" width="100%" height="400px" style="border: none; border-radius: 4px;"></iframe>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                    <div class="modal-footer">
                        <a href="{{ route('auth.dokumen.download', $item) }}" class="btn btn-success btn-sm">
                            <i class="fa-solid fa-download"></i> Unduh Dokumen
                        </a>
                        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Tutup</button>
                    </div>
                </div>
            </div>
        </div>

        {{-- MODAL VERIFIKASI + NILAI --}}
        <div class="modal fade" id="modalVerifikasi{{ $index }}" tabindex="-1"
            aria-labelledby="modalLabelVerif{{ $index }}" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-success text-white">
                        <h5 class="modal-title" id="modalLabelVerif{{ $index }}">
                            <i class="fa-solid fa-check-circle me-2"></i>Verifikasi Dokumen
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                            aria-label="Tutup"></button>
                    </div>

                    <form
                        action="{{ auth()->user()->hasRole('admin')
                            ? route('documents.verify.dosen', $item->id)
                            : route('documents.verify.mahasiswa', $item->id) }}"
                        method="POST">
                        @csrf
                        @method('PUT')

                        <div class="modal-body">
                            {{-- Info singkat dokumen --}}
                            <div class="p-3 mb-3 rounded"
                                style="background: rgba(var(--bs-success-rgb), 0.07); border-left: 3px solid #54BA4A;">
                                <p class="mb-1 f-13 fw-semibold">{{ $item->judul }}</p>
                                <p class="mb-0 f-12 text-muted">
                                    {{ $item->user->name ?? '-' }} &bull;
                                    {{ $item->kategori->nama_kategori ?? '-' }}
                                </p>
                            </div>

                            {{-- Input Nilai Kelayakan --}}
                            <div class="mb-3">
                                <label for="nilai_kelayakan_{{ $index }}" class="form-label fw-semibold">
                                    Nilai Kelayakan
                                    <small class="text-muted fw-normal">(0 – 100, opsional)</small>
                                </label>
                                <input type="number" class="form-control" id="nilai_kelayakan_{{ $index }}"
                                    name="nilai_kelayakan" min="0" max="100" step="0.01"
                                    placeholder="Contoh: 85.50 — kosongkan jika tidak ada penilaian">
                                <div class="form-text text-muted">
                                    <i class="fa-solid fa-info-circle me-1"></i>
                                    Jika dikosongkan, sistem SPK akan menggunakan nilai default
                                    <strong>75.00</strong> (passing score).
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="submit" class="btn btn-success btn-sm">
                                <i class="fa-solid fa-check me-1"></i> Verifikasi & Terbitkan
                            </button>
                            <button type="button" class="btn btn-secondary btn-sm"
                                data-bs-dismiss="modal">Batal</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- MODAL TOLAK --}}
        <div class="modal fade" id="modalTolak{{ $index }}" tabindex="-1"
            aria-labelledby="modalLabelTolak{{ $index }}" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-danger text-white">
                        <h5 class="modal-title" id="modalLabelTolak{{ $index }}">
                            <i class="fa-solid fa-xmark me-2"></i>Tolak Dokumen
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                            aria-label="Tutup"></button>
                    </div>

                    <form
                        action="{{ auth()->user()->hasRole('admin')
                            ? route('documents.tolak.dosen', $item->id)
                            : route('documents.tolak.mahasiswa', $item->id) }}"
                        method="POST">
                        @csrf
                        @method('PUT')

                        <div class="modal-body">
                            <p>Anda yakin ingin menolak dokumen <strong>{{ $item->judul }}</strong>?</p>
                            
                            <div class="mb-3">
                                <label for="catatan_tolak_{{ $index }}" class="form-label fw-semibold">
                                    Catatan / Alasan Penolakan <small class="text-muted fw-normal">(Opsional)</small>
                                </label>
                                <textarea class="form-control" id="catatan_tolak_{{ $index }}" name="catatan_revisi" rows="3" placeholder="Masukkan alasan dokumen ditolak..."></textarea>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="submit" class="btn btn-danger btn-sm">
                                <i class="fa-solid fa-xmark me-1"></i> Tolak Dokumen
                            </button>
                            <button type="button" class="btn btn-secondary btn-sm"
                                data-bs-dismiss="modal">Batal</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- MODAL REVISI --}}
        <div class="modal fade" id="modalRevisi{{ $index }}" tabindex="-1"
            aria-labelledby="modalLabelRevisi{{ $index }}" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-warning">
                        <h5 class="modal-title" id="modalLabelRevisi{{ $index }}">
                            <i class="fa-solid fa-pen-to-square me-2"></i>Minta Revisi
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Tutup"></button>
                    </div>

                    <form
                        action="{{ auth()->user()->hasRole('admin')
                            ? route('documents.revisi.dosen', $item->id)
                            : route('documents.revisi.mahasiswa', $item->id) }}"
                        method="POST">
                        @csrf
                        @method('PUT')

                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="catatan_revisi_{{ $index }}" class="form-label fw-semibold">
                                    Catatan Revisi <span class="text-danger">*</span>
                                </label>
                                <textarea class="form-control" id="catatan_revisi_{{ $index }}" name="catatan_revisi" rows="4" placeholder="Sebutkan detail apa saja yang perlu direvisi oleh mahasiswa..." required></textarea>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="submit" class="btn btn-warning btn-sm">
                                <i class="fa-solid fa-paper-plane me-1"></i> Kirim Revisi
                            </button>
                            <button type="button" class="btn btn-secondary btn-sm"
                                data-bs-dismiss="modal">Batal</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach
@endsection
