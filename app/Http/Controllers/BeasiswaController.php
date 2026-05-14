<?php

/*
|--------------------------------------------------------------------------
| Author      : Anas Atthariq
| Tanggal     : 13 Mei 2026
| Deskripsi   : Program dashboard pendaftaran beasiswa mahasiswa
|--------------------------------------------------------------------------
*/

namespace App\Http\Controllers;

use App\Models\Beasiswa;
use Illuminate\Http\Request;
use Carbon\Carbon;

class BeasiswaController extends Controller
{
    /**
     * Mengecek dan memperbarui status ajuan secara otomatis.
     * Jika sudah lewat 1 menit dari waktu pendaftaran dan status masih pending,
     * maka status akan diubah berdasarkan IPK:
     *   - IPK >= 3.5 → "Diterima"
     *   - IPK >= 3.0 tapi < 3.5 → "Ditolak"
     */
    private function autoVerifikasiStatus()
    {
        $pendingRecords = Beasiswa::whereIn('status_ajuan', ['Menunggu Verifikasi', 'belum di verifikasi'])
            ->where('created_at', '<=', Carbon::now()->subMinute())
            ->get();

        /** @var Beasiswa $record */
        foreach ($pendingRecords as $record) {
            if ($record->ipk >= 3.5) {
                $record->status_ajuan = 'Diterima';
            } else {
                $record->status_ajuan = 'Ditolak';
            }
            $record->save();
        }
    }

    /**
     * Menampilkan halaman dashboard utama beserta statistik.
     */
    public function index()
    {
        // Auto-verifikasi setiap kali halaman diakses
        $this->autoVerifikasiStatus();

        $total       = Beasiswa::count();
        $akademik    = Beasiswa::where('pilihan_beasiswa', 'Beasiswa Akademik')->count();
        $nonAkademik = Beasiswa::where('pilihan_beasiswa', 'Beasiswa Non Akademik')->count();

        return view('dashboard.index', compact('total', 'akademik', 'nonAkademik'));
    }

    /**
     * Menampilkan form pendaftaran beasiswa (Create).
     */
    public function daftar()
    {
        return view('dashboard.daftar');
    }

    /**
     * Menyimpan data pendaftaran baru ke database (Store).
     */
    public function store(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'nama'               => 'required|string|max:255',
            'email'              => 'required|email|max:255',
            'no_telepon'         => 'required|string|max:15',
            'semester'           => 'required|integer|between:1,8',
            'ipk'                => 'required|numeric|between:0,4',
            'pilihan_beasiswa'   => 'required|string',
            'file_berkas_syarat' => 'required|file|mimes:pdf,jpg,jpeg,png,zip|max:5120',
            'status_ajuan'       => 'required|string',
        ]);

        // Upload file berkas
        if ($request->hasFile('file_berkas_syarat')) {
            $file     = $request->file('file_berkas_syarat');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('berkas'), $filename);
            $validated['file_berkas_syarat'] = $filename;
        }

        Beasiswa::create($validated);

        return redirect()
            ->route('dashboard.hasil')
            ->with('success', 'Pendaftaran beasiswa berhasil disimpan!');
    }

    /**
     * Menampilkan seluruh data pendaftar beasiswa (Read).
     */
    public function hasil()
    {
        // Auto-verifikasi sebelum menampilkan data
        $this->autoVerifikasiStatus();

        $beasiswa = Beasiswa::latest()->get();

        return view('dashboard.hasil', compact('beasiswa'));
    }

    /**
     * Menampilkan detail data beasiswa (Show — Read Only).
     */
    public function show($id)
    {
        // Auto-verifikasi sebelum menampilkan detail
        $this->autoVerifikasiStatus();

        $beasiswa = Beasiswa::findOrFail($id);

        return view('dashboard.show', compact('beasiswa'));
    }
}
