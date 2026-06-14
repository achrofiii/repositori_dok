@extends('layouts.template')

@section('content')
    <div class="container-fluid">
        {{-- Page Title --}}
        <div class="page-title">
            <div class="row">
                <div class="col-sm-6">
                    <h3>SPK PROMETHEE</h3>
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
                        <li class="breadcrumb-item active">SPK PROMETHEE</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">

        {{-- ===== KARTU INFO KRITERIA ===== --}}
        <div class="row mb-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header pb-2">
                        <h5 class="mb-1">Kriteria &amp; Bobot Penilaian</h5>
                        <p class="text-muted f-12 mb-0">
                            Metode: <strong>PROMETHEE II</strong> — Preference Ranking Organization Method for Enrichment
                            Evaluation
                        </p>
                    </div>
                    <div class="card-body pt-2">
                        <div class="row">

                            {{-- C1 --}}
                            <div class="col-md-3 col-sm-6 mb-3">
                                <div class="d-flex align-items-center p-3 rounded"
                                    style="background:rgba(var(--bs-primary-rgb),.07);border-left:4px solid var(--theme-deafult)">
                                    <div class="flex-grow-1">
                                        <p class="mb-1 f-12 text-muted">C1 — Jumlah Unggahan</p>
                                        <h5 class="mb-0 f-w-600">Bobot {{ $bobot['C1'] * 100 }}%</h5>
                                        <span class="badge badge-light-primary f-10 mt-1">Max · Benefit</span>
                                    </div>
                                    <i class="fa-solid fa-upload fa-2x text-primary opacity-50 ms-2"></i>
                                </div>
                            </div>

                            {{-- C2 --}}
                            <div class="col-md-3 col-sm-6 mb-3">
                                <div class="d-flex align-items-center p-3 rounded"
                                    style="background:rgba(var(--bs-success-rgb),.07);border-left:4px solid #54BA4A">
                                    <div class="flex-grow-1">
                                        <p class="mb-1 f-12 text-muted">C2 — Jumlah Unduhan</p>
                                        <h5 class="mb-0 f-w-600">Bobot {{ $bobot['C2'] * 100 }}%</h5>
                                        <span class="badge badge-light-success f-10 mt-1">Max · Benefit</span>
                                    </div>
                                    <i class="fa-solid fa-download fa-2x text-success opacity-50 ms-2"></i>
                                </div>
                            </div>

                            {{-- C3 --}}
                            <div class="col-md-3 col-sm-6 mb-3">
                                <div class="d-flex align-items-center p-3 rounded"
                                    style="background:rgba(var(--bs-warning-rgb),.07);border-left:4px solid #FFAA05">
                                    <div class="flex-grow-1">
                                        <p class="mb-1 f-12 text-muted">C3 — Persentase Kelayakan</p>
                                        <h5 class="mb-0 f-w-600">Bobot {{ $bobot['C3'] * 100 }}%</h5>
                                        <span class="badge badge-light-warning f-10 mt-1">Max · Benefit</span>
                                    </div>
                                    <i class="fa-solid fa-percent fa-2x text-warning opacity-50 ms-2"></i>
                                </div>
                            </div>

                            {{-- C4 --}}
                            <div class="col-md-3 col-sm-6 mb-3">
                                <div class="d-flex align-items-center p-3 rounded"
                                    style="background:rgba(var(--bs-info-rgb),.07);border-left:4px solid #01B8FF">
                                    <div class="flex-grow-1">
                                        <p class="mb-1 f-12 text-muted">C4 — Rerata Nilai Kelayakan</p>
                                        <h5 class="mb-0 f-w-600">Bobot {{ $bobot['C4'] * 100 }}%</h5>
                                        <span class="badge badge-light-info f-10 mt-1">Max · Benefit</span>
                                    </div>
                                    <i class="fa-solid fa-star-half-stroke fa-2x text-info opacity-50 ms-2"></i>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- ===== HASIL RANGKING UTAMA ===== --}}
        <div class="row mb-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header pb-2">
                        <h5 class="mb-0">Tahap 5 — Hasil Rangking Kategori Repositori</h5>
                        <p class="text-muted f-12 mb-0">Φ⁺(a) = Leaving Flow &nbsp;|&nbsp; Φ⁻(a) = Entering Flow
                            &nbsp;|&nbsp; Φ(a) = Net Flow = Φ⁺ − Φ⁻</p>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover table-bordered align-middle text-center">
                                <thead class="table-light">
                                    <tr>
                                        <th style="width:80px">Rangking</th>
                                        <th class="text-start">Kategori</th>
                                        <th>C1<br><small class="text-muted fw-normal f-11">Upload Verified</small></th>
                                        <th>C2<br><small class="text-muted fw-normal f-11">Total Unduh</small></th>
                                        <th>C3<br><small class="text-muted fw-normal f-11">% Kelayakan</small></th>
                                        <th>C4<br><small class="text-muted fw-normal f-11">Rerata Nilai</small></th>
                                        <th>Φ⁺<br><small class="text-muted fw-normal f-11">Leaving</small></th>
                                        <th>Φ⁻<br><small class="text-muted fw-normal f-11">Entering</small></th>
                                        <th>Φ (Net Flow)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($hasil as $item)
                                        <tr @if ($item['rangking'] == 1) style="background:rgba(255,170,5,.06)" @endif>
                                            <td>
                                                @if ($item['rangking'] == 1)
                                                    <span class="badge badge-light-warning p-2 f-13">🥇 1</span>
                                                @elseif ($item['rangking'] == 2)
                                                    <span class="badge badge-light-secondary p-2 f-13">🥈 2</span>
                                                @elseif ($item['rangking'] == 3)
                                                    <span class="badge badge-light-danger p-2 f-13">🥉 3</span>
                                                @else
                                                    <span
                                                        class="badge badge-light-primary p-2 f-13">{{ $item['rangking'] }}</span>
                                                @endif
                                            </td>
                                            <td class="text-start fw-semibold">{{ $item['nama_kategori'] }}</td>
                                            <td>{{ number_format($item['C1']) }}</td>
                                            <td>{{ number_format($item['C2']) }}</td>
                                            <td>{{ number_format($item['C3'], 1) }}%</td>
                                            <td>
                                                {{ number_format($item['C4'], 2) }}
                                                @if ($item['c4_is_default'])
                                                    <span class="badge badge-light-secondary f-10 ms-1"
                                                        title="Tidak ada nilai dospem, pakai nilai default 75">default</span>
                                                @endif
                                            </td>
                                            <td class="text-success fw-semibold">
                                                {{ number_format($item['leaving_flow'], 4) }}</td>
                                            <td class="text-danger fw-semibold">
                                                {{ number_format($item['entering_flow'], 4) }}</td>
                                            <td>
                                                <span
                                                    class="badge p-2 f-12
                      @if ($item['net_flow'] > 0) badge-light-success
                      @elseif($item['net_flow'] < 0) badge-light-danger
                      @else badge-light-secondary @endif">
                                                    {{ number_format($item['net_flow'], 4) }}
                                                </span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        {{-- Keterangan --}}
                        <div class="mt-3 p-3 rounded"
                            style="background:rgba(var(--bs-info-rgb),.05);border:1px dashed rgba(var(--bs-info-rgb),.4)">
                            <p class="mb-1 f-12 fw-semibold">Keterangan:</p>
                            <ul class="mb-0 f-12 text-muted">
                                <li><strong>Φ⁺ (Leaving Flow)</strong>: Seberapa besar kategori ini unggul atas semua
                                    kategori lain. <em>Semakin tinggi semakin baik.</em></li>
                                <li><strong>Φ⁻ (Entering Flow)</strong>: Seberapa besar kategori ini dikalahkan oleh
                                    kategori lain. <em>Semakin kecil semakin baik.</em></li>
                                <li><strong>Φ (Net Flow)</strong>: Leaving − Entering. <em>Nilai tertinggi = peringkat
                                        terbaik.</em></li>
                                <li><strong>Default (C4)</strong>: Nilai <strong>75.00</strong> digunakan jika kategori
                                    tidak memiliki dokumen ber-nilai dospem.</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- ===== MATRIKS KEPUTUSAN ===== --}}
        <div class="row mb-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header pb-2">
                        <h5 class="mb-0">Tahap 1 — Matriks Keputusan</h5>
                        <p class="text-muted f-12 mb-0">Data agregat real-time dari database</p>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-sm table-bordered text-center align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th class="text-start">Alternatif</th>
                                        <th>C1 — Unggahan<br><small class="fw-normal text-muted">w =
                                                {{ $bobot['C1'] }}</small></th>
                                        <th>C2 — Unduhan<br><small class="fw-normal text-muted">w =
                                                {{ $bobot['C2'] }}</small></th>
                                        <th>C3 — % Kelayakan<br><small class="fw-normal text-muted">w =
                                                {{ $bobot['C3'] }}</small></th>
                                        <th>C4 — Rerata Nilai<br><small class="fw-normal text-muted">w =
                                                {{ $bobot['C4'] }}</small></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($matriks as $item)
                                        <tr>
                                            <td class="text-start fw-semibold">{{ $item['nama_kategori'] }}</td>
                                            <td>{{ number_format($item['C1']) }}</td>
                                            <td>{{ number_format($item['C2']) }}</td>
                                            <td>{{ number_format($item['C3'], 2) }}%</td>
                                            <td>
                                                {{ number_format($item['C4'], 2) }}
                                                @if ($item['c4_is_default'])
                                                    <span class="badge badge-light-secondary f-10">default</span>
                                                @endif
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

        {{-- ===== TAHAP 2: SELISIH d(a,b) PER KRITERIA ===== --}}
        <div class="row mb-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header pb-2">
                        <h5 class="mb-0">Tahap 2 — Matriks Selisih d<sub>j</sub>(a,b)</h5>
                        <p class="text-muted f-12 mb-0">
                            Selisih nilai antar alternatif per kriteria. Rumus: d<sub>j</sub>(a,b) = g<sub>j</sub>(a) −
                            g<sub>j</sub>(b)
                        </p>
                    </div>
                    <div class="card-body">
                        @foreach ($kriterias as $k)
                            <p class="fw-semibold mb-1 mt-3">{{ $k }}
                                @if ($k == 'C1')
                                    — Jumlah Unggahan
                                @elseif($k == 'C2')
                                    — Jumlah Unduhan
                                @elseif($k == 'C3')
                                    — Persentase Kelayakan
                                @else
                                    — Rerata Nilai Kelayakan
                                @endif
                            </p>
                            <div class="table-responsive mb-2">
                                <table class="table table-sm table-bordered text-center align-middle">
                                    <thead class="table-light">
                                        <tr>
                                            <th class="text-start">a \ b</th>
                                            @foreach ($alternatifIds as $b)
                                                <th>{{ $matriks[$b]['nama_kategori'] }}</th>
                                            @endforeach
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($alternatifIds as $a)
                                            <tr>
                                                <td class="text-start fw-semibold">{{ $matriks[$a]['nama_kategori'] }}
                                                </td>
                                                @foreach ($alternatifIds as $b)
                                                    @if ($a === $b)
                                                        <td class="table-secondary text-muted">—</td>
                                                    @else
                                                        @php $val = $selisih[$a][$b][$k]; @endphp
                                                        <td
                                                            class="{{ $val > 0 ? 'text-success fw-semibold' : 'text-danger' }}">
                                                            {{ number_format($val, 4) }}
                                                        </td>
                                                    @endif
                                                @endforeach
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        {{-- ===== TAHAP 3: FUNGSI PREFERENSI P(a,b) PER KRITERIA ===== --}}
        <div class="row mb-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header pb-2">
                        <h5 class="mb-0">Tahap 3 — Fungsi Preferensi P<sub>j</sub>(a,b)</h5>
                        <p class="text-muted f-12 mb-0">
                            Tipe I — Usual Criterion: P<sub>j</sub>(a,b) = 1 jika d<sub>j</sub>(a,b) &gt; 0, selain itu = 0
                        </p>
                    </div>
                    <div class="card-body">
                        @foreach ($kriterias as $k)
                            <p class="fw-semibold mb-1 mt-3">{{ $k }}
                                @if ($k == 'C1')
                                    — Jumlah Unggahan
                                @elseif($k == 'C2')
                                    — Jumlah Unduhan
                                @elseif($k == 'C3')
                                    — Persentase Kelayakan
                                @else
                                    — Rerata Nilai Kelayakan
                                @endif
                            </p>
                            <div class="table-responsive mb-2">
                                <table class="table table-sm table-bordered text-center align-middle">
                                    <thead class="table-light">
                                        <tr>
                                            <th class="text-start">a \ b</th>
                                            @foreach ($alternatifIds as $b)
                                                <th>{{ $matriks[$b]['nama_kategori'] }}</th>
                                            @endforeach
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($alternatifIds as $a)
                                            <tr>
                                                <td class="text-start fw-semibold">{{ $matriks[$a]['nama_kategori'] }}
                                                </td>
                                                @foreach ($alternatifIds as $b)
                                                    @if ($a === $b)
                                                        <td class="table-secondary text-muted">—</td>
                                                    @else
                                                        @php $val = $preferensi[$a][$b][$k]; @endphp
                                                        <td>
                                                            @if ($val == 1)
                                                                <span class="badge badge-light-success">1</span>
                                                            @else
                                                                <span class="badge badge-light-secondary">0</span>
                                                            @endif
                                                        </td>
                                                    @endif
                                                @endforeach
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        {{-- ===== MATRIKS INDEKS PREFERENSI π(a,b) ===== --}}
        <div class="row mb-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header pb-2">
                        <h5 class="mb-0">Tahap 4 — Matriks Indeks Preferensi π(a,b)</h5>
                        <p class="text-muted f-12 mb-0">
                            Nilai preferensi multikriteria berbobot. Rumus: π(a,b) = Σ w<sub>j</sub> × P<sub>j</sub>(a,b)
                        </p>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-sm table-bordered text-center align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th class="text-start">π(a \ b)</th>
                                        @foreach ($matriks as $item)
                                            <th>{{ $item['nama_kategori'] }}</th>
                                        @endforeach
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($alternatifIds as $a)
                                        <tr>
                                            <td class="text-start fw-semibold">{{ $matriks[$a]['nama_kategori'] }}</td>
                                            @foreach ($alternatifIds as $b)
                                                @if ($a === $b)
                                                    <td class="table-secondary text-muted">—</td>
                                                @else
                                                    <td
                                                        class="{{ $pi[$a][$b] > 0 ? 'text-success fw-semibold' : 'text-muted' }}">
                                                        {{ number_format($pi[$a][$b], 4) }}
                                                    </td>
                                                @endif
                                            @endforeach
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
@endsection
