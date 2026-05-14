<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BeasiswaController;

/*
|--------------------------------------------------------------------------
| Author      : Anas Atthariq
| Tanggal     : 13 Mei 2026
| Deskripsi   : Program dashboard pendaftaran beasiswa mahasiswa
|--------------------------------------------------------------------------
*/

// Redirect root ke dashboard
Route::get('/', function () {
    return redirect()->route('dashboard');
});

// Dashboard utama (statistik)
Route::get('/dashboard', [BeasiswaController::class, 'index'])
    ->name('dashboard');

// CREATE — Tampilkan form pendaftaran
Route::get('/dashboard/daftar', [BeasiswaController::class, 'daftar'])
    ->name('dashboard.daftar');

// STORE — Simpan data baru
Route::post('/dashboard/store', [BeasiswaController::class, 'store'])
    ->name('dashboard.store');

// READ — Tampilkan seluruh data pendaftar
Route::get('/dashboard/hasil', [BeasiswaController::class, 'hasil'])
    ->name('dashboard.hasil');

// SHOW — Tampilkan detail data pendaftar (Read Only)
Route::get('/dashboard/{id}/show', [BeasiswaController::class, 'show'])
    ->name('dashboard.show');
