{{-- Widget Stats Dosen --}}
<div class="col-xxl-auto col-sm-6 box-col-3">
    <div class="row">
        <div class="col-xl-12">
            <div class="card widget-1">
                <div class="card-body">
                    <div class="widget-content">
                        <div class="widget-round secondary">
                            <div class="bg-round">
                                <svg>
                                    <use href="{{ asset('') }}assets/svg/icon-sprite.svg#c-revenue"></use>
                                </svg>
                                <svg class="half-circle svg-fill">
                                    <use href="{{ asset('') }}assets/svg/icon-sprite.svg#halfcircle"></use>
                                </svg>
                            </div>
                        </div>
                        <div>
                            <h4><span class="counter" data-target="{{ $totalDokumenDiterima }}">0</span></h4>
                            <span class="f-light">Dokumen Diterima</span>
                        </div>
                    </div>
                    <div class="font-success f-w-500 f-12 mt-1">
                        <i class="me-1" data-feather="check-circle"></i> Sudah diverifikasi
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-12">
            <div class="card widget-1">
                <div class="card-body">
                    <div class="widget-content">
                        <div class="widget-round warning">
                            <div class="bg-round">
                                <svg>
                                    <use href="{{ asset('') }}assets/svg/icon-sprite.svg#c-profit"></use>
                                </svg>
                                <svg class="half-circle svg-fill">
                                    <use href="{{ asset('') }}assets/svg/icon-sprite.svg#halfcircle"></use>
                                </svg>
                            </div>
                        </div>
                        <div>
                            <h4><span class="counter" data-target="{{ $totalDokumenDitolak }}">0</span></h4>
                            <span class="f-light">Dokumen Belum Diverifikasi</span>
                        </div>
                    </div>
                    <div class="font-warning f-w-500 f-12 mt-1">
                        <i class="me-1" data-feather="clock"></i> Menunggu tindakan
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="col-xxl-auto col-sm-6 box-col-3">
    <div class="row">
        <div class="col-xl-12">
            <div class="card widget-1">
                <div class="card-body">
                    <div class="widget-content">
                        <div class="widget-round success">
                            <div class="bg-round">
                                <svg>
                                    <use href="{{ asset('') }}assets/svg/icon-sprite.svg#c-customer"></use>
                                </svg>
                                <svg class="half-circle svg-fill">
                                    <use href="{{ asset('') }}assets/svg/icon-sprite.svg#halfcircle"></use>
                                </svg>
                            </div>
                        </div>
                        <div>
                            <h4><span class="counter" data-target="{{ $totalDokumenDipublikasi }}">0</span></h4>
                            <span class="f-light">Dokumen Dipublikasi</span>
                        </div>
                    </div>
                    <div class="font-success f-w-500 f-12 mt-1">
                        <i class="me-1" data-feather="globe"></i> Dapat diakses publik
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-12">
            <div class="card widget-1">
                <div class="card-body">
                    <div class="widget-content">
                        <div class="widget-round primary">
                            <div class="bg-round">
                                <svg class="fill-primary">
                                    <use href="{{ asset('') }}assets/svg/icon-sprite.svg#c-invoice"></use>
                                </svg>
                                <svg class="half-circle svg-fill">
                                    <use href="{{ asset('') }}assets/svg/icon-sprite.svg#halfcircle"></use>
                                </svg>
                            </div>
                        </div>
                        <div>
                            <h4><span class="counter" data-target="{{ $totalMahasiswaBimbingan }}">0</span></h4>
                            <span class="f-light">Mahasiswa Bimbingan</span>
                        </div>
                    </div>
                    <div class="font-primary f-w-500 f-12 mt-1">
                        <i class="me-1" data-feather="users"></i> Mahasiswa unik
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Tabel Dokumen Menunggu Verifikasi --}}
<div class="col-12 mt-2">
    <div class="card">
        <div class="card-header pb-2 card-no-border d-flex justify-content-between align-items-center">
            <h5>Dokumen Menunggu Verifikasi</h5>
            <a href="{{ route('documents.verifikasi.index') }}" class="btn btn-primary btn-sm">Lihat Semua</a>
        </div>
        <div class="card-body pt-0">
            <div class="table-responsive">
                <table class="table table-bordernone table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>Judul</th>
                            <th>Mahasiswa</th>
                            <th>Kategori</th>
                            <th>Tanggal Upload</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($dokumenMenunggu as $dok)
                            <tr>
                                <td>{{ Str::limit($dok->judul, 40) }}</td>
                                <td>{{ $dok->user->name ?? '-' }}</td>
                                <td><span
                                        class="badge badge-light-secondary">{{ $dok->kategori->nama_kategori ?? '-' }}</span>
                                </td>
                                <td class="f-light f-12">{{ $dok->created_at->format('d M Y') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted py-3">
                                    <i class="fa-solid fa-check-double me-1 text-success"></i> Tidak ada dokumen
                                    menunggu verifikasi.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
