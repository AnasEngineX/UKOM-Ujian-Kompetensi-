@extends('layouts.app')

@section('title', 'Daftar Beasiswa')

@section('content')
/*
|--------------------------------------------------------------------------
| Author      : Anas Atthariq
| Tanggal     : 13 Mei 2026
| Deskripsi   : Program dashboard pendaftaran beasiswa mahasiswa
|--------------------------------------------------------------------------
*/
<div class="page-header fade-in-up">
    <h1><i class="fa-solid fa-file-pen me-2" style="color:#818cf8"></i>Form Pendaftaran Beasiswa</h1>
    <p>Isi data berikut dengan lengkap dan benar untuk mendaftar beasiswa</p>
</div>

{{-- Pesan sukses --}}
@if(session('success'))
    <div class="alert-glass-success mb-4 fade-in-up">
        <i class="fa-solid fa-circle-check"></i>
        {{ session('success') }}
    </div>
@endif

{{-- Validation errors --}}
@if($errors->any())
    <div class="alert-glass-danger mb-4 fade-in-up">
        <i class="fa-solid fa-triangle-exclamation"></i>
        <div>
            <strong>Terdapat {{ $errors->count() }} kesalahan input:</strong>
            <ul class="mb-0 mt-1">
                @foreach($errors->all() as $error)
                    <li style="font-size:.82rem">{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    </div>
@endif

{{-- IPK akan di-generate random oleh JavaScript saat semester dipilih --}}

<div class="form-glass fade-in-up">

    <form action="{{ route('dashboard.store') }}"
          method="POST"
          enctype="multipart/form-data"
          id="form-daftar-beasiswa">

        @csrf

        {{-- ===== SECTION: Data Pribadi ===== --}}
        <div class="section-title ps-0" style="margin:0 0 1.2rem">
            <i class="fa-solid fa-user me-1" style="color:#818cf8"></i>
            Data Pribadi
        </div>

        <div class="row g-3 mb-3">

            {{-- Nama --}}
            <div class="col-md-6">
                <label class="form-label" for="nama">Nama Lengkap <span style="color:#f87171">*</span></label>
                <input type="text"
                       name="nama"
                       id="nama"
                       class="form-control @error('nama') is-invalid-custom @enderror"
                       placeholder="Masukkan nama lengkap"
                       value="{{ old('nama') }}"
                       required>
                @error('nama')
                    <span class="text-danger-sm"><i class="fa-solid fa-circle-exclamation me-1"></i>{{ $message }}</span>
                @enderror
            </div>

            {{-- Email --}}
            <div class="col-md-6">
                <label class="form-label" for="email">Email <span style="color:#f87171">*</span></label>
                <input type="email"
                       name="email"
                       id="email"
                       class="form-control @error('email') is-invalid-custom @enderror"
                       placeholder="contoh@email.com"
                       value="{{ old('email') }}"
                       required>
                @error('email')
                    <span class="text-danger-sm"><i class="fa-solid fa-circle-exclamation me-1"></i>{{ $message }}</span>
                @enderror
            </div>

            {{-- No Telepon (format number saja) --}}
            <div class="col-md-6">
                <label class="form-label" for="no_telepon">Nomor HP <span style="color:#f87171">*</span></label>
                <input type="number"
                       name="no_telepon"
                       id="no_telepon"
                       class="form-control @error('no_telepon') is-invalid-custom @enderror"
                       placeholder="08xxxxxxxxxx"
                       value="{{ old('no_telepon') }}"
                       required>
                @error('no_telepon')
                    <span class="text-danger-sm"><i class="fa-solid fa-circle-exclamation me-1"></i>{{ $message }}</span>
                @enderror
            </div>

            {{-- Semester --}}
            <div class="col-md-6">
                <label class="form-label" for="semester">Semester Saat Ini <span style="color:#f87171">*</span></label>
                <select name="semester"
                        id="semester"
                        class="form-select @error('semester') is-invalid-custom @enderror"
                        required>
                    <option value="">-- Pilih Semester --</option>
                    @for($i = 1; $i <= 8; $i++)
                        <option value="{{ $i }}" {{ old('semester') == $i ? 'selected' : '' }}>
                            Semester {{ $i }}
                        </option>
                    @endfor
                </select>
                @error('semester')
                    <span class="text-danger-sm"><i class="fa-solid fa-circle-exclamation me-1"></i>{{ $message }}</span>
                @enderror
            </div>

        </div>

        <hr class="divider">

        {{-- ===== SECTION: Data Akademik ===== --}}
        <div class="section-title ps-0" style="margin:0 0 1.2rem">
            <i class="fa-solid fa-graduation-cap me-1" style="color:#818cf8"></i>
            Data Akademik
        </div>

        <div class="row g-3 mb-3">

            {{-- IPK (otomatis random saat pilih semester) --}}
            <div class="col-md-4">
                <label class="form-label" for="ipk">IPK <small style="color:#64748b">(otomatis dari sistem)</small></label>
                <input type="text"
                       name="ipk"
                       id="ipk"
                       class="form-control"
                       value=""
                       placeholder="Pilih semester terlebih dahulu"
                       readonly>
                <span class="text-danger-sm" id="ipk-warning" style="display:none">
                    <i class="fa-solid fa-triangle-exclamation me-1"></i>
                    IPK anda di bawah 3.0 — tidak dapat mendaftar beasiswa.
                </span>
                <span class="text-danger-sm" id="ipk-success" style="display:none; color:#34d399">
                    <i class="fa-solid fa-circle-check me-1"></i>
                    IPK memenuhi syarat — silakan pilih beasiswa.
                </span>
            </div>

            {{-- Pilihan Beasiswa --}}
            <div class="col-md-8">
                <label class="form-label" for="pilihan_beasiswa">
                    Pilihan Beasiswa <span style="color:#f87171">*</span>
                </label>
                <select name="pilihan_beasiswa"
                        id="pilihan_beasiswa"
                        class="form-select @error('pilihan_beasiswa') is-invalid-custom @enderror"
                        disabled
                        required>
                    <option value="">-- Pilih Jenis Beasiswa --</option>
                    <option value="Beasiswa Akademik"
                            {{ old('pilihan_beasiswa') === 'Beasiswa Akademik' ? 'selected' : '' }}>
                        <i class="fa-solid fa-book-open"></i> Beasiswa Akademik
                    </option>
                    <option value="Beasiswa Non Akademik"
                            {{ old('pilihan_beasiswa') === 'Beasiswa Non Akademik' ? 'selected' : '' }}>
                        Beasiswa Non Akademik
                    </option>
                </select>
                @error('pilihan_beasiswa')
                    <span class="text-danger-sm"><i class="fa-solid fa-circle-exclamation me-1"></i>{{ $message }}</span>
                @enderror
            </div>

        </div>

        <hr class="divider">

        {{-- ===== SECTION: Upload Berkas ===== --}}
        <div class="section-title ps-0" style="margin:0 0 1.2rem">
            <i class="fa-solid fa-paperclip me-1" style="color:#818cf8"></i>
            Upload Berkas Syarat
        </div>

        <div class="mb-4">
            <label class="form-label" for="file_berkas_syarat">
                File Berkas (PDF, JPG, PNG, ZIP – maks. 5 MB)
                <span style="color:#f87171">*</span>
            </label>
            <input type="file"
                   name="file_berkas_syarat"
                   id="file_berkas_syarat"
                   class="form-control @error('file_berkas_syarat') is-invalid-custom @enderror"
                   accept=".pdf,.jpg,.jpeg,.png,.zip"
                   disabled>
            @error('file_berkas_syarat')
                <span class="text-danger-sm"><i class="fa-solid fa-circle-exclamation me-1"></i>{{ $message }}</span>
            @enderror
        </div>

        {{-- Hidden: status_ajuan (sesuai prosedur: "belum di verifikasi") --}}
        <input type="hidden" name="status_ajuan" value="belum di verifikasi">

        {{-- ===== TOMBOL ===== --}}
        <div class="d-flex gap-3 flex-wrap">
            <button type="submit"
                    id="btn-submit-daftar"
                    class="btn-primary-gradient"
                    disabled>
                <i class="fa-solid fa-paper-plane"></i> Kirim Pendaftaran
            </button>

            <a href="{{ route('dashboard') }}"
               id="btn-kembali"
               class="btn-secondary-outline">
                <i class="fa-solid fa-arrow-left"></i> Kembali
            </a>
        </div>

    </form>

</div>

{{-- ===== JS: Generate IPK random saat pilih semester ===== --}}
@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const semesterSelect   = document.getElementById('semester');
        const ipkInput         = document.getElementById('ipk');
        const ipkWarning       = document.getElementById('ipk-warning');
        const ipkSuccess       = document.getElementById('ipk-success');
        const pilihanBeasiswa  = document.getElementById('pilihan_beasiswa');
        const fileBerkas       = document.getElementById('file_berkas_syarat');
        const btnSubmit        = document.getElementById('btn-submit-daftar');

        /**
         * Generate IPK random antara 1.00 – 4.00
         * Hasilnya dibulatkan 2 desimal.
         */
        function generateRandomIPK() {
            // Random antara 1.00 sampai 4.00
            const ipk = (Math.random() * 3) + 1; // range 1.0 – 4.0
            return parseFloat(ipk.toFixed(2));
        }

        /**
         * Enable / disable elemen berdasarkan nilai IPK.
         */
        function applyIPKLogic(ipkValue) {
            if (ipkValue >= 3) {
                // IPK >= 3: aktifkan pilihan beasiswa, upload, dan tombol simpan
                pilihanBeasiswa.disabled = false;
                fileBerkas.disabled      = false;
                btnSubmit.disabled       = false;

                ipkWarning.style.display = 'none';
                ipkSuccess.style.display = 'block';

                // Otomatis kursor pindah ke pilihan beasiswa (prosedur poin 7)
                pilihanBeasiswa.focus();
            } else {
                // IPK < 3: disable pilihan beasiswa, upload berkas, dan tombol simpan
                pilihanBeasiswa.disabled = true;
                fileBerkas.disabled      = true;
                btnSubmit.disabled       = true;

                // Reset pilihan beasiswa
                pilihanBeasiswa.value = '';

                ipkWarning.style.display = 'block';
                ipkSuccess.style.display = 'none';
            }
        }

        // Event: saat semester dipilih → generate IPK random
        semesterSelect.addEventListener('change', function () {
            if (this.value === '') {
                // Tidak ada semester dipilih → kosongkan IPK
                ipkInput.value = '';
                pilihanBeasiswa.disabled = true;
                fileBerkas.disabled      = true;
                btnSubmit.disabled       = true;
                ipkWarning.style.display = 'none';
                ipkSuccess.style.display = 'none';
                return;
            }

            // Generate IPK random dari sistem
            const randomIPK = generateRandomIPK();
            ipkInput.value  = randomIPK;

            // Terapkan logika enable/disable berdasarkan IPK
            applyIPKLogic(randomIPK);
        });
    });
</script>
@endpush

@endsection
