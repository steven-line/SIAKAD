<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dosen extends Model
{
    protected $primaryKey = 'nim_dosen';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    // ✅ TAMBAHKAN INI
    protected $fillable = [
        'nim_dosen',
        'nama',
        'nip' // 🔥 INI YANG KURANG
    ];

    public function mahasiswas() {
        return $this->hasMany(Mahasiswa::class);
    }
}