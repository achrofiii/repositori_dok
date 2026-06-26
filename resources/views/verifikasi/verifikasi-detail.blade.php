@extends('layouts.template')

@section('content')
<div class="container-fluid">
    <div class="page-title">
        <div class="row">
            <div class="col-sm-6">
                <h3>Detail Dokumen</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">
                            <svg class="stroke-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-home') }}"></use>
                            </svg></a></li>
                    <li class="breadcrumb-item"><a href="{{ route('dokumen.index') }}">Dokumen</a></li>
                    <li class="breadcrumb-item active">Detail</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header pb-0 card-no-border d-flex justify-content-between align-items-center">
                    <h5>Informasi Detail Dokumen</h5>
                    <a href="{{ url()->previous() }}" class="btn btn-secondary btn-sm"><i class="fa-solid fa-arrow-left me-1"></i> Kembali</a>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 mb-4 text-center">
                            @if ($dokumen->thumbnail_path)
                                <img src="{{ asset('storage/dokumen/thumbnail/' . $dokumen->thumbnail_path) }}"
                                    class="img-fluid rounded shadow" alt="Thumbnail" style="max-height: 400px; object-fit: cover; width: 100%;">
                            @else
                                <img src="{{ asset('images/default_thumbnail.png') }}" class="img-fluid rounded shadow"
                                    alt="No Thumbnail">
                            @endif
                            <div class="mt-3">
                                <a href="{{ route('auth.dokumen.download', $dokumen) }}" class="btn btn-success w-100">
                                    <i class="fa-solid fa-download me-1"></i> Unduh File
                                </a>
                            </div>
                        </div>

                        <div class="col-md-8 mb-4">
                            <h4 class="mb-3">{{ $dokumen->judul }}</h4>
                            <table class="table table-sm table-borderless">
                                <tr>
                                    <td class="text-muted" style="width:150px">Pemilik Dokumen</td>
                                    <td>: <strong>{{ $dokumen->user->name ?? '-' }}</strong></td>
                                </tr>
                                <tr>
                                    <td class="text-muted">Kategori</td>
                                    <td>: {{ $dokumen->kategori->nama_kategori ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td class="text-muted">Tahun Publikasi</td>
                                    <td>: {{ $dokumen->tahun_publikasi }}</td>
                                </tr>
                                <tr>
                                    <td class="text-muted">Kata Kunci</td>
                                    <td>: {{ $dokumen->kata_kunci }}</td>
                                </tr>
                                <tr>
                                    <td class="text-muted">Fakultas</td>
                                    <td>: {{ $dokumen->fakultas->nama_fakultas ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td class="text-muted">Jurusan</td>
                                    <td>: {{ $dokumen->jurusan->nama_jurusan ?? '-' }}</td>
                                </tr>
                                @if ($dokumen->dosen)
                                    <tr>
                                        <td class="text-muted">Dosen Pembimbing</td>
                                        <td>: {{ $dokumen->dosen->name }}</td>
                                    </tr>
                                @endif
                                @if ($dokumen->nilai_kelayakan)
                                    <tr>
                                        <td class="text-muted">Nilai Kelayakan</td>
                                        <td>: <span class="badge badge-light-success">{{ $dokumen->nilai_kelayakan }}</span></td>
                                    </tr>
                                @endif
                                <tr>
                                    <td class="text-muted">Status Dokumen</td>
                                    <td>: 
                                        @php
                                            $statusColor = 'warning';
                                            if ($dokumen->status === 'diterima') $statusColor = 'success';
                                            elseif ($dokumen->status === 'ditolak') $statusColor = 'danger';
                                            elseif ($dokumen->status === 'direvisi') $statusColor = 'info';
                                        @endphp
                                        <span class="badge bg-{{ $statusColor }}">{{ ucfirst($dokumen->status) }}</span>
                                    </td>
                                </tr>
                                @if($dokumen->catatan_revisi)
                                    <tr>
                                        <td class="text-muted">Catatan/Revisi</td>
                                        <td>: <span class="text-danger fw-bold">{{ $dokumen->catatan_revisi }}</span></td>
                                    </tr>
                                @endif
                            </table>
                            <hr>
                            <h6 class="text-muted mb-2">Abstrak:</h6>
                            <p class="f-14 text-justify" style="line-height: 1.6;">{{ $dokumen->abstrak }}</p>
                        </div>
                    </div>
                    
                    @if($dokumen->file_path)
                    <div class="row mt-4">
                        <div class="col-12">
                            <h5 class="mb-3">Preview File Dokumen</h5>
                            <div class="border rounded p-2 bg-light">
                                <iframe src="{{ asset('storage/dokumen/file/' . $dokumen->file_path) }}" width="100%" height="600px" style="border: none; border-radius: 5px;"></iframe>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
