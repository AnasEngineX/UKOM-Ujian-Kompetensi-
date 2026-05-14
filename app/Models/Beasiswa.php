<?php
/*
|--------------------------------------------------------------------------
| Author      : Anas Atthariq
| Tanggal     : 13 Mei 2026
| Deskripsi   : Program dashboard pendaftaran beasiswa mahasiswa
|--------------------------------------------------------------------------
*/

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Beasiswa extends Model
{
    protected $table = 'beasiswa';
    protected $fillable = [
    'nama',
    'email',
    'no_telepon',
    'semester',
    'ipk',
    'pilihan_beasiswa',
    'file_berkas_syarat',
    'status_ajuan'
    ];
}
