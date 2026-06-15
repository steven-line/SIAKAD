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
        if (empty($this->dosenwali)) {
            return '-';
        }
        // Ambil 4 karakter pertama (contoh: D001001 -> D001)
        $prefix = substr($this->dosenwali, 0, 4);
        $dosen = Dosen::where('nim_dosen', $prefix)->first();
        return $dosen ? $dosen->nama : '-';
    }

    // Relasi ke Mahasiswa (opsional)
    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class, 'nrp', 'nrp');
    }
}