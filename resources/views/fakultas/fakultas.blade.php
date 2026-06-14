@extends('layouts.template')

@section('content')
  <div class="container-fluid">
    <div class="page-title">
      <div class="row">
        <div class="col-sm-6">
          <h3>Fakultas</h3>
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
            <li class="breadcrumb-item active">Fakultas</li>
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
            <h5>Data Fakultas</h5>
            <button class="btn btn-primary btn-sm" data-bs-toggle="offcanvas" data-bs-target="#offcanvasCreate"
              aria-controls="offcanvasRight">
              + Tambah Fakultas
            </button>
          </div>
          {{-- Tabel --}}
          <div class="card-body">
            <div class="table-responsive custom-scrollbar">
              <table class="display table-striped border" id="basic-1">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>Nama Fakultas</th>
                    <th>Kode Fakultas</th>
                    <th>Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($fakultas as $index => $f)
                    <tr>
                      <td>{{ $index + 1 }}.</td>
                      <td>{{ $f->nama_fakultas }}</td>
                      <td>{{ $f->kode_fakultas }}</td>
                      <td>
                        <ul class="action">
                          <li class="edit">
                            <a type="button" data-bs-toggle="offcanvas"
                              data-bs-target="#offcanvasEdit{{ $f->id }}" aria-controls="offcanvasRight">
                              <i class="fa-regular
                              fa-pen-to-square"></i>
                            </a>
                          </li>
                          <li class="delete">
                            <form action="{{ route('fakultas.destroy', $f) }}" method="POST" style="display: inline;">
                              @csrf
                              @method('DELETE')
                              <button type="button" onclick="confirmDelete(this)" class="btn p-0 border-0 bg-transparent">
                                <i class="fa-solid fa-trash-can"></i>
                              </button>
                            </form>
                          </li>                          
                        </ul>
                      </td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  
  {{-- Offcanvas Add Section --}}
  <div class="card-body common-flex common-offcanvas">
    <div class="offcanvas offcanvas-end" id="offcanvasCreate" tabindex="-1" aria-labelledby="offcanvasRightLabel">
      <div class="offcanvas-header pb-0">
        <h5 class="offcanvas-title" id="offcanvasRightLabel">Offcanvas End</h5>
        <button class="btn-close" type="button" data-bs-dismiss="offcanvas" aria-label="Close"></button>
      </div>
      <div class="offcanvas-body custom-input custom-scrollbar">
        <form action="{{ route('fakultas.store') }}" method="POST" class="needs-validation" novalidate>
          @csrf
          <div class="modal-body">
            <div class="mb-3">
              <label for="nama_fakultas" class="form-label">Nama Fakultas<span class="text-danger">*</span></label>
              <input type="text" class="form-control" name="nama_fakultas" required>
              <div class="invalid-feedback">Nama Fakultas harus diisi</div>
            </div>
            <div class="mb-3">
              <label for="kode_fakultas" class="form-label">Kode Fakultas<span class="text-danger">*</span></label>
              <input type="text" class="form-control" name="kode_fakultas" required>
              <div class="invalid-feedback">Kode Fakultas harus diisi</div>
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
  {{-- Offcanvas Edit Section --}}
  @foreach ($fakultas as $f)
    <div class="card-body common-flex common-offcanvas">
      <div class="offcanvas offcanvas-end" id="offcanvasEdit{{ $f->id }}" tabindex="-1"
        aria-labelledby="offcanvasRightLabel">
        <div class="offcanvas-header pb-0">
          <h5 class="offcanvas-title" id="offcanvasRightLabel">Edit Fakultas</h5>
          <button class="btn-close" type="button" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body custom-input custom-scrollbar">
          <form action="{{ route('fakultas.update', $f) }}" method="POST" class="needs-validation" novalidate>
            @csrf
            @method('PUT')
            <div class="modal-body">
              <div class="mb-3">
                <label for="nama_fakultas" class="form-label">Nama Fakultas<span class="text-danger">*</span></label>
                <input type="text" class="form-control" name="nama_fakultas"
                  value="{{ old('nama_fakultas', $f->nama_fakultas) }}" required>
                <div class="invalid-feedback">Nama Fakultas harus diisi</div>
              </div>

              <div class="mb-3">
                <label for="kode_fakultas" class="form-label">Kode Fakultas<span class="text-danger">*</span></label>
                <input type="text" class="form-control" name="kode_fakultas"
                  value="{{ old('kode_fakultas', $f->kode_fakultas) }}" required>
                <div class="invalid-feedback">Kode Fakultas harus diisi</div>
              </div>
            </div>

            <div class="modal-footer">
              <button type="button" class="btn btn-danger" data-bs-dismiss="offcanvas">Close</button>
              <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  @endforeach
@endsection
