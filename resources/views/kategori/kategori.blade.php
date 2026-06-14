@extends('layouts.template')

@section('content')
  <div class="container-fluid">
    <div class="page-title">
      <div class="row">
        <div class="col-sm-6">
          <h3>Kategori</h3>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">
                <svg class="stroke-icon">
                  <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-home') }}"></use>
                </svg></a></li>
            <li class="breadcrumb-item active">Kategori</li>
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
            <h5>Data Kategori</h5>
            <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#createModal">
              + Tambah Kategori
            </button>
          </div>

          {{-- Modal Tambah --}}
          <div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="createModalLabel">Form Tambah Kategori</h5>
                  <button type="button" class="btn-close py-0" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('kategori.store') }}" method="POST" class="needs-validation" novalidate>
                  @csrf
                  <div class="modal-body">
                    <div class="mb-3">
                      <label for="nama_kategori" class="form-label">Nama Kategori<span class="text-danger">*</span></label>
                      <input type="text" class="form-control" name="nama_kategori" required>
                      <div class="invalid-feedback">Nama kategori harus diisi</div>
                    </div>
                    <div class="mb-3">
                      <label for="deskripsi" class="form-label">Deskripsi</label>
                      <textarea class="form-control" style="resize: none; height:120px" name="deskripsi" required></textarea>
                      <div class="invalid-feedback">Deskripsi harus diisi</div>
                    </div>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                  </div>
                </form>
              </div>
            </div>
          </div>

          {{-- Tabel --}}
          <div class="card-body">
            <div class="table-responsive custom-scrollbar">
              <table class="display table-striped border" id="basic-1">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>Nama Kategori</th>
                    <th>Deskripsi</th>
                    <th>Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($kategoris as $index => $kategori)
                    <tr>
                      <td>{{ $index + 1 }}.</td>
                      <td>{{ $kategori->nama_kategori }}</td>
                      <td>{{ $kategori->deskripsi ?? '-' }}</td>
                      <td>
                        <ul class="action">
                          <li class="edit">
                            <a type="button" data-bs-toggle="modal" data-bs-target="#editModal-{{ $kategori->id }}">
                              <i class="fa-regular fa-pen-to-square"></i>
                            </a>
                          </li>
                          <li class="delete">
                            <form action="{{ route('kategori.destroy', $kategori) }}" method="POST"
                              style="display: inline;">
                              @csrf
                              @method('DELETE')
                              <a type="button" onclick="confirmDelete(this)">
                                <i class="fa-solid fa-trash-can"></i>
                              </a>
                            </form>
                          </li>
                        </ul>
                      </td>
                    </tr>

                    {{-- Modal Edit --}}
                    <div class="modal fade" id="editModal-{{ $kategori->id }}" tabindex="-1"
                      aria-labelledby="editModalLabel-{{ $kategori->id }}" aria-hidden="true">
                      <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="editModalLabel-{{ $kategori->id }}">Form Edit Kategori</h5>
                            <button type="button" class="btn-close py-0" data-bs-dismiss="modal"
                              aria-label="Close"></button>
                          </div>
                          <form action="{{ route('kategori.update', $kategori) }}" method="POST"
                            class="needs-validation" novalidate>
                            @csrf
                            @method('PUT') <!-- Menggunakan method PUT untuk update -->
                            <div class="modal-body">
                              <div class="mb-3">
                                <label for="nama_kategori" class="form-label">Nama Kategori<span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="nama_kategori"
                                  value="{{ $kategori->nama_kategori }}" required>
                                <div class="invalid-feedback">Nama kategori harus diisi</div>
                              </div>
                              <div class="mb-3">
                                <label for="deskripsi" class="form-label">Deskripsi</label>
                                <textarea class="form-control" style="resize: none; height:120px" name="deskripsi" required>{{ $kategori->deskripsi }}</textarea>
                                <div class="invalid-feedback">Deskripsi harus diisi</div>
                              </div>
                            </div>
                            <div class="modal-footer">
                              <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                              <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>
                          </form>
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
