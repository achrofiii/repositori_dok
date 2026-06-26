@extends('layouts.template')

@section('content')
  <div class="container-fluid">
    <div class="page-title">
      <div class="row">
        <div class="col-sm-6">
          <h3>Dukumen</h3>
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
            <li class="breadcrumb-item"><a class="text-dark" href="{{ route('dokumen.index') }}">Dokumen</a></li>
            <li class="breadcrumb-item active">Tambah Dokumen</li>
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
            <h5>Form Tambah</h5>
          </div>
          <div class="card-body">
            @php
              $routeAction = auth()->user()->hasRole('mahasiswa')
                  ? route('mahasiswa.documents.update', $dokumen)
                  : route('documents.update', $dokumen);
              $isMahasiswa = auth()->user()->hasRole('mahasiswa');
            @endphp

            <form class="row g-3 needs-validation custom-input" novalidate enctype="multipart/form-data" method="POST"
              action="{{ $routeAction }}">

              @csrf
              @method('PUT')

              <div class="col-sm-8">
                <div class="row g-3">
                  <div class="col-md-12 position-relative">
                    <label class="form-label" for="judul">Judul<span class="text-danger">*</span></label>
                    <input class="form-control @error('judul') is-invalid @enderror" name="judul" id="judul"
                      type="text" placeholder="Masukkan judul..." value="{{ old('judul', $dokumen->judul) }}" required>
                    @error('judul')
                      <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                    <div class="valid-tooltip"></div>
                  </div>

                  <div class="col-md-6 position-relative">
                    <label class="form-label" for="tahun_publikasi">Tahun Publikasi<span
                        class="text-danger">*</span></label>
                    <input class="form-control @error('tahun_publikasi') is-invalid @enderror" id="tahun_publikasi"
                      name="tahun_publikasi" type="number" placeholder="Contoh: 2024" min="1900" max="2099"
                      value="{{ old('tahun_publikasi', $dokumen->tahun_publikasi) }}" required>
                    @error('tahun_publikasi')
                      <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                    <div class="valid-tooltip"></div>
                  </div>

                  <div class="col-md-6 position-relative">
                    <label class="form-label" for="kategori">Kategori<span class="text-danger">*</span></label>
                    <select class="form-select @error('kategori') is-invalid @enderror" id="kategori" name="kategori"
                      required>
                      <option value="" disabled {{ old('kategori', $dokumen->kategori_id) ? '' : 'selected' }}>
                        Pilih...</option>
                      @foreach ($kategori as $item)
                        <option value="{{ $item->id }}"
                          {{ old('kategori', $dokumen->kategori_id) == $item->id ? 'selected' : '' }}>
                          {{ $item->nama_kategori }}
                        </option>
                      @endforeach
                    </select>
                    @error('kategori')
                      <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                    <div class="invalid-tooltip"></div>
                  </div>

                  <div class="col-md-6 position-relative">
                    <label class="form-label" for="fakultas">Fakultas<span class="text-danger">*</span></label>
                    <select class="form-select @error('fakultas') is-invalid @enderror" id="fakultas" name="fakultas"
                      required>
                      <option value="" disabled {{ old('fakultas', $dokumen->fakultas_id) ? '' : 'selected' }}>
                        Pilih...</option>
                      @foreach ($fakultas as $item)
                        <option value="{{ $item->id }}"
                          {{ old('fakultas', $dokumen->fakultas_id) == $item->id ? 'selected' : '' }}>
                          {{ $item->nama_fakultas }}
                        </option>
                      @endforeach
                    </select>
                    @error('fakultas')
                      <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                    <div class="invalid-tooltip"></div>
                  </div>

                  <div class="col-md-6 position-relative">
                    <label class="form-label" for="jurusan">Jurusan<span class="text-danger">*</span></label>
                    <select class="form-select @error('jurusan') is-invalid @enderror" id="jurusan" name="jurusan"
                      required>
                      <option value="" disabled {{ old('jurusan', $dokumen->jurusan_id) ? '' : 'selected' }}>
                        Pilih...</option>
                      @foreach ($jurusanSelected as $jurusan)
                        <option value="{{ $jurusan->id }}"
                          {{ old('jurusan', $dokumen->jurusan_id) == $jurusan->id ? 'selected' : '' }}>
                          {{ $jurusan->nama_jurusan }}
                        </option>
                      @endforeach
                    </select>
                    @error('jurusan')
                      <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                    <div class="invalid-tooltip"></div>
                  </div>

                  <div class="col-md-12 position-relative">
                    <label class="form-label" for="kata_kunci">Kata Kunci<span class="text-danger">*</span></label>
                    <input class="form-control @error('kata_kunci') is-invalid @enderror" id="kata_kunci"
                      name="kata_kunci" type="text" placeholder="Masukkan kata kunci..."
                      value="{{ old('kata_kunci', $dokumen->kata_kunci) }}" required>
                    @error('kata_kunci')
                      <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                    <div class="valid-tooltip"></div>
                  </div>
                </div>
              </div>

              <div class="col-sm-4">
                <div class="col-md-12" style="display: flex; justify-content: center; margin: 25px 0 20px 0;">
                  <div class="cardd">
                    <div class="imagesss">
                      <img class="imgg" id="imgContainer"
                        src="{{ $dokumen->thumbnail_path ? asset('storage/dokumen/thumbnail/' . $dokumen->thumbnail_path) : asset('uploadImg/upload.jpg') }}"
                        width="400" alt="Thumbnail Preview">
                      <p class="imgName"></p>
                    </div>
                    <label class="labell" for="inputGambar">
                      <span class="tmbl">Pilih Thumbnail</span>
                    </label>
                    <input name="thumbnail" class="inputt" type="file" id="inputGambar" accept="image/*">
                  </div>
                  <script>
                      const imgContainer = document.getElementById('imgContainer');
                      const inputGambar = document.getElementById('inputGambar');
                      if (inputGambar && imgContainer) {
                          inputGambar.addEventListener('change', function() {
                              const file = this.files[0];
                              if (file) {
                                  const reader = new FileReader();
                                  reader.onload = function(e) {
                                      imgContainer.src = e.target.result;
                                  }
                                  reader.readAsDataURL(file);
                              }
                          });
                      }
                  </script>
                </div>

                <div class="col-md-12 position-relative" style="margin-bottom: -30px">
                  <label class="form-label" for="file_dokumen">File</label>
                  <input class="form-control @error('file_dokumen') is-invalid @enderror" id="file_dokumen"
                    name="file_dokumen" type="file" accept=".pdf,.doc,.docx">
                  @error('file_dokumen')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                  @enderror

                  @if ($dokumen->file_path)
                    <div class="mt-3">
                      <iframe id="pdfPreview" src="{{ asset('storage/dokumen/file/' . $dokumen->file_path) }}" width="100%" height="300px" style="border: 1px solid #ddd; border-radius: 8px; display: block;"></iframe>
                    </div>
                    <small class="text-muted mt-2 d-block">File saat ini: <a
                        href="{{ asset('storage/dokumen/file/' . $dokumen->file_path) }}" target="_blank">Lihat
                        file di tab baru</a></small>
                  @else
                    <div class="mt-3">
                      <iframe id="pdfPreview" src="" width="100%" height="300px" style="border: 1px solid #ddd; border-radius: 8px; display: none;"></iframe>
                    </div>
                  @endif

                  <script>
                      const fileDokumen = document.getElementById('file_dokumen');
                      const pdfPreview = document.getElementById('pdfPreview');
                      if (fileDokumen && pdfPreview) {
                          fileDokumen.addEventListener('change', function() {
                              const file = this.files[0];
                              if (file && file.type === 'application/pdf') {
                                  const fileURL = URL.createObjectURL(file);
                                  pdfPreview.src = fileURL;
                                  pdfPreview.style.display = 'block';
                              } else {
                                  // Hide preview if not pdf or no file selected
                                  @if(!$dokumen->file_path)
                                  pdfPreview.style.display = 'none';
                                  @else
                                  // Revert to original
                                  pdfPreview.src = "{{ asset('storage/dokumen/file/' . $dokumen->file_path) }}";
                                  @endif
                              }
                          });
                      }
                  </script>
                </div>
              </div>

              @if ($isMahasiswa)
                <div class="col-md-12 position-relative">
                  <label class="form-label" for="dosen_id">Dosen Pembimbing<span class="text-danger">*</span></label>
                  <select name="dosen_id" id="dosen_id" class="js-example-basic-single form-control" required>
                    <option disabled>Cari dosen</option>
                    @foreach ($dosens as $dosen)
                      <option value="{{ $dosen->id }}"
                        {{ old('dosen_id', $dokumen->dosen_id) == $dosen->id ? 'selected' : '' }}>
                        {{ $dosen->name }}
                      </option>
                    @endforeach
                  </select>
                </div>
              @endif

              <div class="col-12" style="{{ $isMahasiswa ? 'margin-top: -5px;' : '' }}">
                <label class="form-label" for="abstrak">Abstrak<span class="text-danger">*</span></label>
                <textarea class="form-control @error('abstrak') is-invalid @enderror" id="abstrak" name="abstrak"
                  placeholder="Masukkan Abstrak Anda..." required style="height: 180px; resize: none;">{{ old('abstrak', $dokumen->abstrak) }}</textarea>
                @error('abstrak')
                  <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
                <div class="invalid-feedback"></div>
              </div>

              <div class="col-12">
                <button class="btn btn-primary" type="submit">Update</button>
              </div>
            </form>

          </div>
        </div>
      </div>
    </div>
  </div>

  {{-- Include select2 dan ajax --}}
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script>
    $('#fakultas').on('change', function() {
      var fakultasId = $(this).val();

      if (fakultasId) {
        $.ajax({
          url: '/get-jurusan/' + fakultasId,
          type: 'GET',
          success: function(data) {
            $('#jurusan').empty().append('<option selected disabled>Pilih...</option>');
            data.forEach(function(jurusan) {
              $('#jurusan').append('<option value="' + jurusan.id + '">' + jurusan.nama_jurusan +
                '</option>');
            });
          }
        });
      } else {
        $('#jurusan').html('<option selected disabled>Pilih Fakultas Dulu</option>');
      }
    });
    window.addEventListener('DOMContentLoaded', function() {
      $('.js-example-basic-single').select2({
        width: '100%',
        language: {
          noResults: function() {
            return "Tidak ada hasil yang ditemukan";
          }
        }
      });
    });
  </script>
@endsection
