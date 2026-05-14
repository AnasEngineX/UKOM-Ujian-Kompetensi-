@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
/*
|--------------------------------------------------------------------------
| Author      : Anas Atthariq
| Tanggal     : 13 Mei 2026
| Deskripsi   : Program dashboard pendaftaran beasiswa mahasiswa
|--------------------------------------------------------------------------
*/
<div class="page-header fade-in-up">
    <h1><i class="fa-solid fa-house-chimney me-2" style="color:#818cf8"></i>Dashboard</h1>
    <p>Selamat datang di Sistem Informasi Pendaftaran Beasiswa</p>
</div>

{{-- ===== STAT CARDS ===== --}}
<div class="row g-4 mb-4">
    <div class="col-md-4 fade-in-up fade-in-up-delay-1">
        <div class="card-stat">
            <div class="stat-icon" style="background:rgba(79,70,229,.2)">
                <i class="fa-solid fa-users" style="color:#818cf8"></i>
            </div>
            <div>
                <div class="stat-value">{{ $total }}</div>
                <div class="stat-label">Total Pendaftar</div>
            </div>
        </div>
    </div>

    <div class="col-md-4 fade-in-up fade-in-up-delay-2">
        <div class="card-stat">
            <div class="stat-icon" style="background:rgba(14,165,233,.2)">
                <i class="fa-solid fa-book-open" style="color:#38bdf8"></i>
            </div>
            <div>
                <div class="stat-value">{{ $akademik }}</div>
                <div class="stat-label">Beasiswa Akademik</div>
            </div>
        </div>
    </div>

    <div class="col-md-4 fade-in-up fade-in-up-delay-3">
        <div class="card-stat">
            <div class="stat-icon" style="background:rgba(16,185,129,.2)">
                <i class="fa-solid fa-trophy" style="color:#34d399"></i>
            </div>
            <div>
                <div class="stat-value">{{ $nonAkademik }}</div>
                <div class="stat-label">Beasiswa Non-Akademik</div>
            </div>
        </div>
    </div>
</div>

{{-- ===== INFO BEASISWA ===== --}}
<div class="row g-4">

    {{-- Card Beasiswa Akademik --}}
    <div class="col-md-6 fade-in-up fade-in-up-delay-1">
        <div class="card-glass h-100 p-4">
            <div class="d-flex align-items-center gap-3 mb-3">
                <div class="stat-icon" style="background:rgba(79,70,229,.2)">
                    <i class="fa-solid fa-book-open" style="color:#818cf8"></i>
                </div>
                <div>
                    <h5 class="mb-0 fw-700" style="color:#f1f5f9">Beasiswa Akademik</h5>
                    <small style="color:#94a3b8">Untuk mahasiswa berprestasi akademik</small>
                </div>
            </div>
            <hr class="divider">
            <ul class="list-unstyled mb-0" style="color:#94a3b8; font-size:.88rem">
                <li class="mb-2">
                    <i class="fa-solid fa-circle-check me-2" style="color:#818cf8"></i>
                    Minimal IPK 3.0
                </li>
                <li class="mb-2">
                    <i class="fa-solid fa-circle-check me-2" style="color:#818cf8"></i>
                    Semester 1 – 8
                </li>
                <li class="mb-2">
                    <i class="fa-solid fa-circle-check me-2" style="color:#818cf8"></i>
                    Upload berkas PDF / JPG / ZIP
                </li>
                <li>
                    <i class="fa-solid fa-circle-check me-2" style="color:#818cf8"></i>
                    Tidak sedang menerima beasiswa lain
                </li>
            </ul>
        </div>
    </div>

    {{-- Card Beasiswa Non-Akademik --}}
    <div class="col-md-6 fade-in-up fade-in-up-delay-2">
        <div class="card-glass h-100 p-4">
            <div class="d-flex align-items-center gap-3 mb-3">
                <div class="stat-icon" style="background:rgba(16,185,129,.2)">
                    <i class="fa-solid fa-trophy" style="color:#34d399"></i>
                </div>
                <div>
                    <h5 class="mb-0 fw-700" style="color:#f1f5f9">Beasiswa Non-Akademik</h5>
                    <small style="color:#94a3b8">Untuk mahasiswa berprestasi non-akademik</small>
                </div>
            </div>
            <hr class="divider">
            <ul class="list-unstyled mb-0" style="color:#94a3b8; font-size:.88rem">
                <li class="mb-2">
                    <i class="fa-solid fa-circle-check me-2" style="color:#34d399"></i>
                    Prestasi organisasi / olahraga / seni
                </li>
                <li class="mb-2">
                    <i class="fa-solid fa-circle-check me-2" style="color:#34d399"></i>
                    Minimal IPK 3.0
                </li>
                <li class="mb-2">
                    <i class="fa-solid fa-circle-check me-2" style="color:#34d399"></i>
                    Upload sertifikat pendukung
                </li>
                <li>
                    <i class="fa-solid fa-circle-check me-2" style="color:#34d399"></i>
                    Semester 1 – 8
                </li>
            </ul>
        </div>
    </div>

    {{-- Action Buttons --}}
    <div class="col-12 fade-in-up fade-in-up-delay-3">
        <div class="card-glass p-4 d-flex align-items-center justify-content-between flex-wrap gap-3">
            <div>
                <h6 class="mb-1" style="color:#f1f5f9;font-weight:600">Siap mendaftar?</h6>
                <p class="mb-0" style="color:#94a3b8;font-size:.85rem">Isi formulir pendaftaran sekarang atau lihat data yang sudah masuk.</p>
            </div>
            <div class="d-flex gap-2 flex-wrap">
                <a href="{{ route('dashboard.daftar') }}" class="btn-primary-gradient" id="btn-daftar-beasiswa">
                    <i class="fa-solid fa-file-pen"></i> Daftar Beasiswa
                </a>
                <a href="{{ route('dashboard.hasil') }}" class="btn-secondary-outline" id="btn-lihat-data">
                    <i class="fa-solid fa-table-list"></i> Lihat Data Pendaftar
                </a>
            </div>
        </div>
    </div>

</div>

@endsection
