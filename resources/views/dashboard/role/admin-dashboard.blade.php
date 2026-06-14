{{-- ROW 2: Widget Stats Admin --}}
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
                            <h4><span class="counter" data-target="{{ $totalDokumen }}">0</span></h4>
                            <span class="f-light">Dokumen Terverifikasi</span>
                        </div>
                    </div>
                    <div class="font-primary f-w-500 f-12 mt-1">
                        <i class="me-1" data-feather="file-text"></i> Total dokumen aktif
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
                            <h4><span class="counter" data-target="{{ $totalMenunggu }}">0</span></h4>
                            <span class="f-light">Menunggu Verifikasi</span>
                        </div>
                    </div>
                    <div class="font-warning f-w-500 f-12 mt-1">
                        <i class="me-1" data-feather="clock"></i> Perlu ditindaklanjuti
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
                            <h4><span class="counter" data-target="{{ $totalDosen }}">0</span></h4>
                            <span class="f-light">Total Dosen</span>
                        </div>
                    </div>
                    <div class="font-success f-w-500 f-12 mt-1">
                        <i class="me-1" data-feather="users"></i> Pengguna aktif
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
                            <h4><span class="counter" data-target="{{ $totalMahasiswa }}">0</span></h4>
                            <span class="f-light">Total Mahasiswa</span>
                        </div>
                    </div>
                    <div class="font-primary f-w-500 f-12 mt-1">
                        <i class="me-1" data-feather="users"></i> Pengguna aktif
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
                            <h4><span class="counter" data-target="{{ $totalKategori }}">0</span></h4>
                            <span class="f-light">Total Kategori</span>
                        </div>
                    </div>
                    <div class="font-secondary f-w-500 f-12 mt-1">
                        <i class="me-1" data-feather="tag"></i> Kategori dokumen
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
                            <h4><span class="counter" data-target="{{ $totalFakultas }}">0</span></h4>
                            <span class="f-light">Total Fakultas</span>
                        </div>
                    </div>
                    <div class="font-warning f-w-500 f-12 mt-1">
                        <i class="me-1" data-feather="home"></i> / <span class="counter"
                            data-target="{{ $totalJurusan }}">0</span> Jurusan
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ROW 3: Tabel Dokumen Terbaru --}}
<div class="col-12 mt-2">
    <div class="card">
        <div class="card-header pb-2 card-no-border d-flex justify-content-between align-items-center">
            <h5>Dokumen Terbaru</h5>
            <span class="badge badge-light-primary f-12">5 terakhir</span>
        </div>
        <div class="card-body pt-0">
            <div class="table-responsive">
                <table class="table table-bordernone table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>Judul</th>
                            <th>Pengunggah</th>
                            <th>Kategori</th>
                            <th>Status</th>
                            <th>Tanggal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($dokumenTerbaru as $dok)
                            <tr>
                                <td>{{ Str::limit($dok->judul, 40) }}</td>
                                <td>{{ $dok->user->name ?? '-' }}</td>
                                <td><span
                                        class="badge badge-light-secondary">{{ $dok->kategori->nama_kategori ?? '-' }}</span>
                                </td>
                                <td>
                                    @if ($dok->is_verified)
                                        <span class="badge badge-light-success">Terverifikasi</span>
                                    @else
                                        <span class="badge badge-light-warning">Menunggu</span>
                                    @endif
                                </td>
                                <td class="f-light f-12">{{ $dok->created_at->format('d M Y') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted">Belum ada dokumen.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
