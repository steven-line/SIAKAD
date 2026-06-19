<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Dosen;

class Biodata extends Model
{
    protected $table = 'biodata';
    public $incrementing = false;
    protected $primaryKey = 'nrp';
    public $timestamps = false;

    protected $guarded = [];

    // Accessor untuk mendapatkan nama dosen wali
   public function getDosenwaliNamaAttribute()
    {
        // Ambil data mahasiswa terkait
        $mahasiswa = $this->mahasiswa; // relasi ke Mahasiswa

        if (!$mahasiswa || empty($mahasiswa->dosen_wali)) {
            return '-';
        }

        // Cari dosen berdasarkan nim_dosen
        $dosen = Dosen::where('nim_dosen', $mahasiswa->dosen_wali)->first();
        return $dosen ? $dosen->nama : '-';
    }

    // Relasi ke Mahasiswa (opsional)
    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class, 'nrp', 'nrp');
    }
}