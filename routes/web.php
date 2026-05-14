<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BeasiswaController;

/*
|--------------------------------------------------------------------------
| Web Routes — SIBEASISWA
|--------------------------------------------------------------------------
| Route untuk mahasiswa: hanya bisa mendaftar dan melihat data.
| Tidak ada fitur edit, update, atau hapus untuk mencegah manipulasi.
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