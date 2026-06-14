@extends('layouts.template')

@section('content')
  <div class="container-fluid">
    <div class="page-title">
      <div class="row">
        <div class="col-sm-6">
          <h3>Jurusan</h3>
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
            <li class="breadcrumb-item active">Jurusan</li>
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
            <h5>Data Jurusan</h5>
            <button class="btn btn-primary btn-sm" data-bs-toggle="offcanvas" data-bs-target="#offcanvasCreate"
              aria-controls="offcanvasRight">
              + Tambah Jurusan
            </button>
          </div>

          {{-- Tabel --}}
          <div class="card-body">
            <div class="table-responsive custom-scrollbar">
              <table class="display table-striped border" id="basic-1">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>Nama Jurusan</th>
                    <th>Kode Jurusan</th>
                    <th>Fakultas</th>
                    <th>Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($jurusans as $index => $jurusan)
                    <tr>
                      <td>{{ $index + 1 }}.</td>
                      <td>{{ $jurusan->nama_jurusan }}</td>
                      <td>{{ $jurusan->kode_jurusan }}</td>
                      <td>
                        {{ $jurusan->fakultas->nama_fakultas ?? '-' }}
                        ({{ $jurusan->fakultas->kode_fakultas ?? '-' }})
                      </td>
                      <td>
                        <ul class="action">
                          <li class="edit">
                            <a type="button" data-bs-toggle="offcanvas"
                              data-bs-target="#offcanvasEdit{{ $jurusan->id }}">
                              <i class="fa-regular fa-pen-to-square"></i>
                            </a>
                          </li>
                          <li class="delete">
                            <form action="{{ route('jurusan.destroy', $jurusan) }}" method="POST"
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
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  {{-- Offcanvass Tambah --}}
  <div class="card-body common-flex common-offcanvas">
    <div class="offcanvas offcanvas-end" id="offcanvasCreate" tabindex="-1" aria-labelledby="offcanvasRightLabel">
      <div class="offcanvas-header pb-0">
        <h5 class="offcanvas-title" id="offcanvasRightLabel">Tambah Jurusan</h5>
        <button class="btn-close" type="button" data-bs-dismiss="offcanvas" aria-label="Close"></button>
      </div>
      <div class="offcanvas-body custom-input custom-scrollbar">
        <form action="{{ route('jurusan.store') }}" method="POST" class="needs-validation" novalidate>
          @csrf
          <div class="modal-body">
            <div class="mb-3">
              <label for="nama_jurusan" class="form-label">Nama Jurusan<span class="text-danger">*</span></label>
              <input type="text" class="form-control" name="nama_jurusan" required>
              <div class="invalid-feedback">Nama Jurusan harus diisi</div>
            </div>
            <div class="mb-3">
              <label for="kode_jurusan" class="form-label">Kode Jurusan<span class="text-danger">*</span></label>
              <input type="text" class="form-control" name="kode_jurusan" required>
              <div class="invalid-feedback">Kode Jurusan harus diisi</div>
            </div>
            <div class="mb-3">
              <label for="fakultas_id" class="form-label">Fakultas<span class="text-danger">*</span></label>
              <select class="form-select" name="fakultas_id" required>
                <option selected disabled>Pilih...</option>
                @foreach ($fakultas as $item)
                  <option value="{{ $item->id }}">{{ $item->nama_fakultas }}</option>
                @endforeach
              </select>
              <div class="invalid-feedback">Fakultas harus dipilih</div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-bs-dismiss="offcanvas">Tutup</button>
            <button type="submit" class="btn btn-primary">Simpan</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  {{-- Offcanvas Edit --}}
  @foreach ($jurusans as $jurusan)
    <div class="card-body common-flex common-offcanvas">
      <div class="offcanvas offcanvas-end" id="offcanvasEdit{{ $jurusan->id }}" tabindex="-1"
        aria-labelledby="offcanvasRightLabel">
        <div class="offcanvas-header pb-0">
          <h5 class="offcanvas-title" id="offcanvasRightLabel">Edit Jurusan</h5>
          <button class="btn-close" type="button" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body custom-input custom-scrollbar">
          <form action="{{ route('jurusan.update', $jurusan) }}" method="POST" class="needs-validation"
            novalidate>
            @csrf
            @method('PUT')
            <div class="modal-body">
              <div class="mb-3">
                <label for="nama_jurusan" class="form-label">Nama Jurusan<span class="text-danger">*</span></label>
                <input type="text" class="form-control" name="nama_jurusan"
                  value="{{ old('nama_jurusan', $jurusan->nama_jurusan) }}" required>
                <div class="invalid-feedback">Nama Jurusan harus diisi</div>
              </div>
              <div class="mb-3">
                <label for="kode_jurusan" class="form-label">Kode Jurusan<span class="text-danger">*</span></label>
                <input type="text" class="form-control" name="kode_jurusan"
                  value="{{ old('kode_jurusan', $jurusan->kode_jurusan) }}" required>
                <div class="invalid-feedback">Kode Jurusan harus diisi</div>
              </div>
              <div class="mb-3">
                <label for="fakultas_id" class="form-label">Fakultas<span class="text-danger">*</span></label>
                <select class="form-select" name="fakultas_id" required>
                  <option selected disabled>Pilih...</option>
                  @foreach ($fakultas as $item)
                    <option value="{{ $item->id }}" {{ $item->id == $jurusan->fakultas_id ? 'selected' : '' }}>
                      {{ $item->nama_fakultas }}
                    </option>
                  @endforeach
                </select>
                <div class="invalid-feedback">Fakultas harus dipilih</div>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-danger" data-bs-dismiss="offcanvas">Tutup</button>
              <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  @endforeach
@endsection
