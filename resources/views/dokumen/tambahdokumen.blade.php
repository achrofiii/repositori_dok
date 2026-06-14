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
                        <li class="breadcrumb-item"><a class="text-dark" href="{{ route('dokumen.index') }}">Dokumen</a>
                        </li>
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
                                ? route('mahasiswa.documents.store')
                                : route('documents.store');
                            $isMahasiswa = auth()->user()->hasRole('mahasiswa');
                        @endphp

                        <form class="row g-3 needs-validation custom-input" novalidate enctype="multipart/form-data"
                            method="POST" action="{{ $routeAction }}">

                            @csrf

                            <div class="col-sm-8">
                                <div class="row g-3">
                                    <div class="col-md-12 position-relative">
                                        <label class="form-label" for="judul">Judul<span
                                                class="text-danger">*</span></label>
                                        <input class="form-control @error('judul') is-invalid @enderror" name="judul"
                                            id="judul" type="text" placeholder="Masukkan judul..."
                                            value="{{ old('judul') }}" required>
                                        @error('judul')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                        <div class="valid-tooltip"></div>
                                    </div>

                                    <div class="col-md-6 position-relative">
                                        <label class="form-label" for="tahun_publikasi">Tahun Publikasi<span
                                                class="text-danger">*</span></label>
                                        <input class="form-control @error('tahun_publikasi') is-invalid @enderror"
                                            id="tahun_publikasi" name="tahun_publikasi" type="number"
                                            placeholder="Contoh: 2024" min="1900" max="2099"
                                            value="{{ old('tahun_publikasi') }}" required>
                                        @error('tahun_publikasi')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                        <div class="valid-tooltip"></div>
                                    </div>

                                    <div class="col-md-6 position-relative">
                                        <label class="form-label" for="kategori">Kategori<span
                                                class="text-danger">*</span></label>
                                        <select class="form-select @error('kategori') is-invalid @enderror" id="kategori"
                                            name="kategori" required>
                                            <option value="" disabled {{ old('kategori') ? '' : 'selected' }}>Pilih...
                                            </option>
                                            @foreach ($kategori as $item)
                                                <option value="{{ $item->id }}"
                                                    {{ old('kategori') == $item->id ? 'selected' : '' }}>
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
                                        <label class="form-label" for="fakultas">Fakultas<span
                                                class="text-danger">*</span></label>
                                        <select class="form-select @error('fakultas') is-invalid @enderror" id="fakultas"
                                            name="fakultas" required
                                            {{ $isMahasiswa && $defaultFakultasId ? 'disabled' : '' }}>
                                            <option value="" disabled
                                                {{ old('fakultas', $defaultFakultasId) ? '' : 'selected' }}>Pilih...
                                            </option>
                                            @foreach ($fakultas as $item)
                                                <option value="{{ $item->id }}"
                                                    {{ old('fakultas', $defaultFakultasId) == $item->id ? 'selected' : '' }}>
                                                    {{ $item->nama_fakultas }}
                                                </option>
                                            @endforeach
                                        </select>
                                        {{-- kalau disabled, tetap kirim valuenya --}}
                                        @if ($isMahasiswa && $defaultFakultasId)
                                            <input type="hidden" name="fakultas" value="{{ $defaultFakultasId }}">
                                            <small class="text-muted f-12"><i
                                                    class="fa-solid fa-info-circle me-1"></i>Sesuai fakultas profil
                                                Anda</small>
                                        @endif
                                        @error('fakultas')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6 position-relative">
                                        <label class="form-label" for="jurusan">Jurusan<span
                                                class="text-danger">*</span></label>
                                        <select class="form-select @error('jurusan') is-invalid @enderror" id="jurusan"
                                            name="jurusan" required
                                            {{ $isMahasiswa && $defaultJurusanId ? 'disabled' : '' }}>
                                            <option value="" disabled
                                                {{ old('jurusan', $defaultJurusanId) ? '' : 'selected' }}>Pilih...</option>
                                            @foreach ($jurusanDefault as $item)
                                                <option value="{{ $item->id }}"
                                                    {{ old('jurusan', $defaultJurusanId) == $item->id ? 'selected' : '' }}>
                                                    {{ $item->nama_jurusan }}
                                                </option>
                                            @endforeach
                                        </select>
                                        {{-- kalau disabled, tetap kirim valuenya --}}
                                        @if ($isMahasiswa && $defaultJurusanId)
                                            <input type="hidden" name="jurusan" value="{{ $defaultJurusanId }}">
                                            <small class="text-muted f-12"><i
                                                    class="fa-solid fa-info-circle me-1"></i>Sesuai jurusan profil
                                                Anda</small>
                                        @endif
                                        @error('jurusan')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-12 position-relative">
                                        <label class="form-label" for="kata_kunci">Kata Kunci<span
                                                class="text-danger">*</span></label>
                                        <input class="form-control @error('kata_kunci') is-invalid @enderror"
                                            id="kata_kunci" name="kata_kunci" type="text"
                                            placeholder="Masukkan kata kunci..." value="{{ old('kata_kunci') }}"
                                            required>
                                        @error('kata_kunci')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                        <div class="valid-tooltip"></div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-4">
                                <div class="col-md-12"
                                    style="display: flex; justify-content: center; margin: 25px 0 20px 0;">
                                    <div class="cardd">
                                        <div class="imagesss">
                                            <img class="imgg" id="imgContainer" src="upload.jpg" width="400"
                                                alt="">
                                            <p class="imgName"></p>
                                        </div>
                                        <label class="labell" for="inputGambar">
                                            <span class="tmbl">Pilih Thumbnail<span class="text-danger">*</span></span>
                                        </label>
                                        <input name="thumbnail" class="inputt" type="file" id="inputGambar"
                                            accept="image/*">
                                    </div>
                                    <script>
                                        imgContainer.src = "{{ asset('uploadImg/upload.jpg') }}";
                                    </script>
                                </div>

                                <div class="col-md-12 position-relative">
                                    <label class="form-label" for="file_dokumen">File<span
                                            class="text-danger">*</span></label>
                                    <input class="form-control @error('file_dokumen') is-invalid @enderror"
                                        id="file_dokumen" name="file_dokumen" type="file" required>
                                    @error('file_dokumen')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            @if ($isMahasiswa)
                                <div class="col-md-12 position-relative">
                                    <label class="form-label" for="dosen_id">Dosen Pembimbing<span
                                            class="text-danger">*</span></label>
                                    <select name="dosen_id" id="dosen_id" class="js-example-basic-single form-control"
                                        required>
                                        <option selected disabled>Cari dosen</option>
                                        @foreach ($dosens as $dosen)
                                            <option value="{{ $dosen->id }}"
                                                {{ old('dosen_id') == $dosen->id ? 'selected' : '' }}>
                                                {{ $dosen->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            @endif

                            <div class="col-12" style="{{ $isMahasiswa ? 'margin-top: -5px;' : '' }}">
                                <label class="form-label" for="abstrak">Abstrak<span
                                        class="text-danger">*</span></label>
                                <textarea class="form-control @error('abstrak') is-invalid @enderror" id="abstrak" name="abstrak"
                                    placeholder="Masukkan Abstrak Anda..." required style="height: 180px; resize: none;">{{ old('abstrak') }}</textarea>
                                @error('abstrak')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                                <div class="invalid-feedback"></div>
                            </div>

                            <div class="col-12">
                                <button class="btn btn-primary" type="submit">Simpan</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>

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
                            $('#jurusan').append('<option value="' + jurusan.id + '">' + jurusan
                                .nama_jurusan +
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
