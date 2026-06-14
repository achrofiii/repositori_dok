@extends('layouts.template')

@section('content')
    <div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-sm-6">
                    <h3>Profil Saya</h3>
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
                        <li class="breadcrumb-item active">Profil</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row">

            {{-- Kolom kiri: avatar --}}
            <div class="col-xl-4 col-md-5 mb-4">
                <div class="card text-center">
                    <div class="card-body py-4">
                        <?php
                        $code = crc32(Auth::user()->name);
                        $r = ($code & 0xff0000) >> 16;
                        $g = ($code & 0x00ff00) >> 8;
                        $b = $code & 0x0000ff;
                        $bg = "rgb($r,$g,$b)";
                        ?>
                        <div class="d-flex justify-content-center align-items-center mx-auto mb-3"
                            style="width:80px;height:80px;background-color:{{ $bg }};color:#fff;font-weight:bold;font-size:30px;border-radius:50%;">
                            @avatarinitial(Auth::user()->name)
                        </div>
                        <h5 class="mb-1">{{ Auth::user()->name }}</h5>
                        <p class="text-muted f-13 mb-2">{{ Auth::user()->email }}</p>
                        <span class="badge badge-light-primary f-12">
                            @formatnama(Auth::user()->getRoleNames()->first())
                        </span>

                        @if ($isMahasiswa && $detail?->fakultas)
                            <hr>
                            <p class="mb-0 f-13"><i
                                    class="fa-solid fa-building-columns me-1"></i>{{ $detail->fakultas->nama_fakultas }}</p>
                            @if ($detail?->jurusan)
                                <p class="mb-0 f-13 text-muted">{{ $detail->jurusan->nama_jurusan }}</p>
                            @endif
                            @if ($detail?->angkatan)
                                <p class="mb-0 f-12 text-muted">Angkatan {{ $detail->angkatan }}</p>
                            @endif
                        @elseif ($isDosen && $detail?->fakultas)
                            <hr>
                            <p class="mb-0 f-13"><i
                                    class="fa-solid fa-building-columns me-1"></i>{{ $detail->fakultas->nama_fakultas }}</p>
                            @if ($detail?->bidang_keahlian)
                                <p class="mb-0 f-12 text-muted">{{ $detail->bidang_keahlian }}</p>
                            @endif
                        @endif
                    </div>
                </div>
            </div>

            {{-- Kolom kanan: form --}}
            <div class="col-xl-8 col-md-7">

                @if (session('status') === 'profile-updated')
                    <div class="alert alert-success alert-dismissible fade show">
                        <i class="fa-solid fa-circle-check me-2"></i> Profil berhasil diperbarui.
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif
                @if (session('status') === 'detail-updated')
                    <div class="alert alert-success alert-dismissible fade show">
                        <i class="fa-solid fa-circle-check me-2"></i> Detail profil berhasil disimpan.
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif
                @if (session('status') === 'password-updated')
                    <div class="alert alert-success alert-dismissible fade show">
                        <i class="fa-solid fa-circle-check me-2"></i> Password berhasil diperbarui.
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                {{-- Card: Informasi Akun --}}
                <div class="card mb-4">
                    <div class="card-header pb-2 card-no-border">
                        <h5>Informasi Akun</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('profile.update') }}" method="POST">
                            @csrf @method('PATCH')
                            <div class="mb-3">
                                <label class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                    name="name" value="{{ old('name', $user->name) }}" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Email <span class="text-danger">*</span></label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror"
                                    name="email" value="{{ old('email', $user->email) }}" required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="modal-footer px-0 pb-0">
                                <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>

                {{-- Card: Detail Profil (Mahasiswa / Dosen) --}}
                @if ($isMahasiswa || $isDosen)
                    <div class="card mb-4">
                        <div class="card-header pb-2 card-no-border">
                            <h5>Detail Profil {{ $isMahasiswa ? 'Mahasiswa' : 'Dosen' }}</h5>
                            <p class="text-muted f-12 mb-0">Data ini digunakan sebagai default saat mengunggah dokumen.</p>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('profile.detail') }}" method="POST">
                                @csrf @method('PUT')
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label">Fakultas</label>
                                        <select class="form-select" id="detail_fakultas" name="fakultas_id">
                                            <option value="">Pilih Fakultas...</option>
                                            @foreach ($fakultas as $f)
                                                <option value="{{ $f->id }}"
                                                    {{ old('fakultas_id', $detail?->fakultas_id) == $f->id ? 'selected' : '' }}>
                                                    {{ $f->nama_fakultas }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Jurusan / Prodi</label>
                                        <select class="form-select" id="detail_jurusan" name="jurusan_id">
                                            <option value="">Pilih Jurusan...</option>
                                            @foreach ($jurusans as $j)
                                                <option value="{{ $j->id }}"
                                                    {{ old('jurusan_id', $detail?->jurusan_id) == $j->id ? 'selected' : '' }}>
                                                    {{ $j->nama_jurusan }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    @if ($isMahasiswa)
                                        <div class="col-md-6">
                                            <label class="form-label">Angkatan</label>
                                            <input type="text" class="form-control" name="angkatan"
                                                placeholder="Contoh: 2022" maxlength="10"
                                                value="{{ old('angkatan', $detail?->angkatan) }}">
                                        </div>
                                    @else
                                        <div class="col-md-6">
                                            <label class="form-label">Bidang Keahlian</label>
                                            <input type="text" class="form-control" name="bidang_keahlian"
                                                placeholder="Contoh: Kecerdasan Buatan"
                                                value="{{ old('bidang_keahlian', $detail?->bidang_keahlian) }}">
                                        </div>
                                    @endif

                                    <div class="col-md-6">
                                        <label class="form-label">No. HP</label>
                                        <input type="text" class="form-control" name="no_hp"
                                            placeholder="Contoh: 08123456789" maxlength="20"
                                            value="{{ old('no_hp', $detail?->no_hp) }}">
                                    </div>
                                    <div class="col-md-12">
                                        <label class="form-label">Alamat</label>
                                        <textarea class="form-control" name="alamat" rows="2" placeholder="Alamat lengkap...">{{ old('alamat', $detail?->alamat) }}</textarea>
                                    </div>
                                </div>
                                <div class="modal-footer px-0 pb-0 mt-2">
                                    <button type="submit" class="btn btn-primary btn-sm">Simpan Detail</button>
                                </div>
                            </form>
                        </div>
                    </div>
                @endif

                {{-- Card: Ganti Password --}}
                <div class="card">
                    <div class="card-header pb-2 card-no-border">
                        <h5>Ganti Password</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('profile.password') }}" method="POST">
                            @csrf @method('PUT')
                            <div class="mb-3">
                                <label class="form-label">Password Saat Ini <span class="text-danger">*</span></label>
                                <input type="password"
                                    class="form-control @error('current_password', 'updatePassword') is-invalid @enderror"
                                    name="current_password">
                                @error('current_password', 'updatePassword')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Password Baru <span class="text-danger">*</span></label>
                                <input type="password"
                                    class="form-control @error('password', 'updatePassword') is-invalid @enderror"
                                    name="password">
                                @error('password', 'updatePassword')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Konfirmasi Password Baru <span
                                        class="text-danger">*</span></label>
                                <input type="password" class="form-control" name="password_confirmation">
                            </div>
                            <div class="modal-footer px-0 pb-0">
                                <button type="submit" class="btn btn-warning btn-sm">Perbarui Password</button>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script>
        // Ajax load jurusan saat ganti fakultas di form detail
        document.getElementById('detail_fakultas')?.addEventListener('change', function() {
            const id = this.value;
            const sel = document.getElementById('detail_jurusan');
            sel.innerHTML = '<option value="">Memuat...</option>';
            if (!id) {
                sel.innerHTML = '<option value="">Pilih Jurusan...</option>';
                return;
            }
            fetch('/get-jurusan/' + id)
                .then(r => r.json())
                .then(data => {
                    sel.innerHTML = '<option value="">Pilih Jurusan...</option>';
                    data.forEach(j => sel.innerHTML += `<option value="${j.id}">${j.nama_jurusan}</option>`);
                });
        });
    </script>
@endsection
