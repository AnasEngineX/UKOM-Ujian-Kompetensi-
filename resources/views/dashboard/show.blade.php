@extends('layouts.app')

@section('title', 'Detail Pendaftar Beasiswa')

@section('content')

<div class="page-header fade-in-up">
    <h1><i class="fa-solid fa-eye me-2" style="color:#818cf8"></i>Detail Pendaftar Beasiswa</h1>
    <p>Informasi lengkap pendaftaran beasiswa milik <strong style="color:#818cf8">{{ $beasiswa->nama }}</strong></p>
</div>

<div class="form-glass fade-in-up">

    {{-- ===== SECTION: Data Pribadi ===== --}}
    <div class="section-title ps-0" style="margin:0 0 1.2rem">
        <i class="fa-solid fa-user me-1" style="color:#818cf8"></i>
        Data Pribadi
    </div>

    <div class="row g-3 mb-3">

        {{-- Nama --}}
        <div class="col-md-6">
            <label class="form-label">Nama Lengkap</label>
            <input type="text"
                   class="form-control"
                   value="{{ $beasiswa->nama }}"
                   readonly>
        </div>

        {{-- Email --}}
        <div class="col-md-6">
            <label class="form-label">Email</label>
            <input type="text"
                   class="form-control"
                   value="{{ $beasiswa->email }}"
                   readonly>
        </div>

        {{-- No Telepon --}}
        <div class="col-md-6">
            <label class="form-label">Nomor HP</label>
            <input type="text"
                   class="form-control"
                   value="{{ $beasiswa->no_telepon }}"
                   readonly>
        </div>

        {{-- Semester --}}
        <div class="col-md-6">
            <label class="form-label">Semester Saat Ini</label>
            <input type="text"
                   class="form-control"
                   value="Semester {{ $beasiswa->semester }}"
                   readonly>
        </div>

    </div>

    <hr class="divider">

    {{-- ===== SECTION: Data Akademik ===== --}}
    <div class="section-title ps-0" style="margin:0 0 1.2rem">
        <i class="fa-solid fa-graduation-cap me-1" style="color:#818cf8"></i>
        Data Akademik
    </div>

    <div class="row g-3 mb-3">

        {{-- IPK --}}
        <div class="col-md-4">
            <label class="form-label">IPK</label>
            <input type="text"
                   class="form-control"
                   value="{{ $beasiswa->ipk }}"
                   readonly
                   style="color:{{ $beasiswa->ipk >= 3 ? '#34d399' : '#f87171' }};font-weight:700">
        </div>

        {{-- Pilihan Beasiswa --}}
        <div class="col-md-8">
            <label class="form-label">Pilihan Beasiswa</label>
            <input type="text"
                   class="form-control"
                   value="{{ $beasiswa->pilihan_beasiswa }}"
                   readonly>
        </div>

    </div>

    <hr class="divider">

    {{-- ===== SECTION: Berkas ===== --}}
    <div class="section-title ps-0" style="margin:0 0 1.2rem">
        <i class="fa-solid fa-paperclip me-1" style="color:#818cf8"></i>
        Berkas Syarat
    </div>

    <div class="mb-3">
        @if($beasiswa->file_berkas_syarat)
            <div class="p-3" style="background:rgba(79,70,229,.1);border:1px solid rgba(79,70,229,.25);border-radius:10px">
                <a href="{{ asset('berkas/' . $beasiswa->file_berkas_syarat) }}"
                   target="_blank"
                   id="link-berkas"
                   style="color:#818cf8;font-size:.875rem;font-weight:600">
                    <i class="fa-solid fa-file-arrow-down me-1"></i>{{ $beasiswa->file_berkas_syarat }}
                </a>
            </div>
        @else
            <span style="color:#475569;font-size:.875rem">Tidak ada berkas yang diunggah.</span>
        @endif
    </div>

    <hr class="divider">

    {{-- ===== SECTION: Status Ajuan ===== --}}
    <div class="section-title ps-0" style="margin:0 0 1.2rem">
        <i class="fa-solid fa-clipboard-check me-1" style="color:#818cf8"></i>
        Status Ajuan
    </div>

    <div class="mb-4">
        @php
            $status = $beasiswa->status_ajuan ?? 'Menunggu Verifikasi';
            $badgeClass = match(true) {
                str_contains(strtolower($status), 'diterima')  => 'badge-approved',
                str_contains(strtolower($status), 'ditolak')   => 'badge-rejected',
                default                                         => 'badge-pending',
            };

            // Hitung sisa waktu verifikasi (1 menit dari created_at)
            $verifikasiAt = $beasiswa->created_at->addMinute();
            $sisaDetik    = max(0, now()->diffInSeconds($verifikasiAt, false));
            $isPending    = in_array($status, ['Menunggu Verifikasi', 'belum di verifikasi']);
            $masihPending = $isPending && $sisaDetik > 0;
        @endphp

        <span class="badge-status {{ $badgeClass }}" id="badge-status" style="font-size:.9rem;padding:.45rem 1rem">
            {{ $status }}
        </span>

        {{-- Countdown timer untuk status pending --}}
        @if($masihPending)
            <div id="show-timer" data-sisa="{{ $sisaDetik }}"
                 style="margin-top:.8rem;display:inline-flex;align-items:center;gap:.5rem;
                        background:rgba(245,158,11,.1);border:1px solid rgba(245,158,11,.3);
                        border-radius:10px;padding:.5rem 1rem;font-size:.82rem;color:#fcd34d;font-weight:600">
                <i class="fa-solid fa-hourglass-half"></i>
                Hasil verifikasi dalam: <span id="show-timer-text">{{ gmdate('i:s', $sisaDetik) }}</span>
            </div>
        @endif
    </div>

    {{-- ===== TOMBOL KEMBALI ===== --}}
    <div class="d-flex gap-3 flex-wrap">
        <a href="{{ route('dashboard.hasil') }}"
           id="btn-kembali"
           class="btn-secondary-outline">
            <i class="fa-solid fa-arrow-left"></i> Kembali ke Data Pendaftar
        </a>
    </div>

</div>

{{-- ===== JS: Countdown Timer di Show Page ===== --}}
@if($masihPending ?? false)
@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const timerEl   = document.getElementById('show-timer');
        const timerText = document.getElementById('show-timer-text');

        if (!timerEl) return;

        let sisaDetik = parseInt(timerEl.dataset.sisa);

        const interval = setInterval(function () {
            sisaDetik--;

            if (sisaDetik <= 0) {
                clearInterval(interval);
                timerText.textContent = 'Memverifikasi...';
                timerEl.style.color = '#818cf8';
                timerEl.style.borderColor = 'rgba(129,140,248,.3)';
                timerEl.style.background = 'rgba(79,70,229,.1)';
                setTimeout(function () {
                    location.reload();
                }, 800);
                return;
            }

            const menit = Math.floor(sisaDetik / 60);
            const detik = sisaDetik % 60;
            timerText.textContent =
                String(menit).padStart(2, '0') + ':' +
                String(detik).padStart(2, '0');
        }, 1000);
    });
</script>
@endpush
@endif

@endsection

