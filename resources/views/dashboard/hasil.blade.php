@extends('layouts.app')

@section('title', 'Data Pendaftar Beasiswa')

@section('content')

<div class="page-header fade-in-up d-flex align-items-start justify-content-between flex-wrap gap-3">
    <div>
        <h1><i class="fa-solid fa-table-list me-2" style="color:#818cf8"></i>Data Pendaftar Beasiswa</h1>
        <p>Daftar seluruh mahasiswa yang telah mendaftar beasiswa</p>
    </div>
    <a href="{{ route('dashboard.daftar') }}" class="btn-primary-gradient" id="btn-tambah-data">
        <i class="fa-solid fa-plus"></i> Tambah Pendaftar
    </a>
</div>

{{-- Alert sukses --}}
@if(session('success'))
    <div class="alert-glass-success mb-4 fade-in-up">
        <i class="fa-solid fa-circle-check"></i>
        {{ session('success') }}
    </div>
@endif

{{-- ===== TABEL DATA ===== --}}
<div class="card-glass fade-in-up" style="overflow:hidden">

    {{-- Header tabel --}}
    <div class="p-4 d-flex align-items-center justify-content-between border-bottom" style="border-color:rgba(255,255,255,.08)!important">
        <div>
            <h6 class="mb-0" style="color:#f1f5f9;font-weight:600">
                Semua Pendaftar
            </h6>
            <small style="color:#94a3b8">
                Total: <strong style="color:#818cf8">{{ $beasiswa->count() }}</strong> data
            </small>
        </div>
    </div>

    {{-- Tabel --}}
    <div class="table-responsive">
        <table class="table-glass w-100" id="tabel-beasiswa">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>No Telepon</th>
                    <th>Semester</th>
                    <th>IPK</th>
                    <th>Pilihan Beasiswa</th>
                    <th>Berkas</th>
                    <th>Status</th>
                    <th style="text-align:center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($beasiswa as $index => $item)
                <tr id="row-beasiswa-{{ $item->id }}">
                    <td style="color:#64748b;font-weight:600">{{ $index + 1 }}</td>
                    <td>
                        <div style="font-weight:600;color:#f1f5f9">{{ $item->nama }}</div>
                    </td>
                    <td>{{ $item->email }}</td>
                    <td>{{ $item->no_telepon }}</td>
                    <td>
                        <span style="color:#818cf8;font-weight:600">Sem {{ $item->semester }}</span>
                    </td>
                    <td>
                        <span style="color:{{ $item->ipk >= 3 ? '#34d399' : '#f87171' }};font-weight:700">
                            {{ $item->ipk }}
                        </span>
                    </td>
                    <td>
                        @if($item->pilihan_beasiswa === 'Beasiswa Akademik')
                            <span style="color:#818cf8;font-size:.82rem;font-weight:600">
                                <i class="fa-solid fa-book-open me-1"></i>Akademik
                            </span>
                        @else
                            <span style="color:#34d399;font-size:.82rem;font-weight:600">
                                <i class="fa-solid fa-trophy me-1"></i>Non-Akademik
                            </span>
                        @endif
                    </td>
                    <td>
                        @if($item->file_berkas_syarat)
                            <a href="{{ asset('berkas/' . $item->file_berkas_syarat) }}"
                               target="_blank"
                               id="link-berkas-{{ $item->id }}"
                               class="btn-edit-sm"
                               style="font-size:.75rem">
                                <i class="fa-solid fa-file-arrow-down"></i> Unduh
                            </a>
                        @else
                            <span style="color:#475569;font-size:.8rem">—</span>
                        @endif
                    </td>
                    <td>
                        @php
                            $status = $item->status_ajuan ?? 'Menunggu Verifikasi';
                            $badgeClass = match(true) {
                                str_contains(strtolower($status), 'diterima')     => 'badge-approved',
                                str_contains(strtolower($status), 'ditolak')      => 'badge-rejected',
                                default                                            => 'badge-pending',
                            };

                            // Hitung sisa waktu verifikasi (1 menit dari created_at)
                            $verifikasiAt = $item->created_at->addMinute();
                            $sisaDetik    = max(0, now()->diffInSeconds($verifikasiAt, false));
                            $isPending    = in_array($status, ['Menunggu Verifikasi', 'belum di verifikasi']);
                            $masihPending = $isPending && $sisaDetik > 0;
                        @endphp

                        <span class="badge-status {{ $badgeClass }}" id="badge-{{ $item->id }}">
                            {{ $status }}
                        </span>

                        {{-- Countdown timer untuk status pending --}}
                        @if($masihPending)
                            <div class="countdown-timer" id="timer-{{ $item->id }}"
                                 data-sisa="{{ $sisaDetik }}"
                                 data-id="{{ $item->id }}"
                                 style="margin-top:.4rem;font-size:.72rem;color:#fcd34d;font-weight:600">
                                <i class="fa-solid fa-clock me-1"></i>
                                <span class="timer-text">{{ gmdate('i:s', $sisaDetik) }}</span>
                            </div>
                        @endif
                    </td>
                    <td>
                        <div class="d-flex gap-2 justify-content-center">
                            {{-- Lihat Detail (Read Only) --}}
                            <a href="{{ route('dashboard.show', $item->id) }}"
                               id="btn-show-{{ $item->id }}"
                               class="btn-edit-sm">
                                <i class="fa-solid fa-eye"></i> Lihat Detail
                            </a>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="10" style="text-align:center;padding:3rem;color:#475569">
                        <i class="fa-solid fa-inbox fa-2x mb-2 d-block" style="opacity:.4"></i>
                        Belum ada data pendaftar beasiswa.
                        <a href="{{ route('dashboard.daftar') }}" style="color:#818cf8">Daftar sekarang</a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>

{{-- ===== JS: Countdown Timer & Auto-Refresh ===== --}}
@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const timers = document.querySelectorAll('.countdown-timer');

        if (timers.length === 0) return;

        timers.forEach(function (timerEl) {
            let sisaDetik = parseInt(timerEl.dataset.sisa);
            const timerText = timerEl.querySelector('.timer-text');

            const interval = setInterval(function () {
                sisaDetik--;

                if (sisaDetik <= 0) {
                    clearInterval(interval);
                    // Waktu habis → reload halaman agar status terupdate dari server
                    timerText.textContent = 'Memverifikasi...';
                    timerEl.style.color = '#818cf8';
                    setTimeout(function () {
                        location.reload();
                    }, 800);
                    return;
                }

                // Format mm:ss
                const menit = Math.floor(sisaDetik / 60);
                const detik = sisaDetik % 60;
                timerText.textContent =
                    String(menit).padStart(2, '0') + ':' +
                    String(detik).padStart(2, '0');
            }, 1000);
        });
    });
</script>
@endpush

@endsection