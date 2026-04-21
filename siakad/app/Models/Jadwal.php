<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jadwal extends Model
{
    // nama tabel (opsional, karena sudah "jadwal")
    protected $table = 'jadwal';

    // field yang boleh diisi (WAJIB untuk create())
    protected $fillable = [
        'kodemk',
        'nama_mk',
        'hari',
        'sesi',
        'jam_mulai',
        'jam_selesai',
        'sks',
        'kategori',
        'semester',
    ];
}