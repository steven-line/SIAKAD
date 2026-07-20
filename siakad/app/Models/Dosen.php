<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Dosen extends Model
{
    protected $table = 'dosen';

    protected $primaryKey = 'nim_dosen';

    public $incrementing = false;

    protected $keyType = 'string';

    public $timestamps = false;

    protected $fillable = [
        'nim_dosen',
        'nama',
        'nip',
        'user_id',
        'prodi',
        'jabatan_struktural',
    ];

    public function mahasiswas()
    {
        return $this->hasMany(Mahasiswa::class, 'dosen_wali', 'nim_dosen');
    }

    public function user() {
        return $this->hasOne(User::class, 'username', 'user_id');
    }

    public function penawaran()
{
    return $this->hasMany(Penawaran::class, 'dosen', 'nim_dosen');
}   
    public function prodi() 
    {
        return $this->belongsTo(Prodi::class, 'kode_prodi', 'prodi');
    }

    public function pjmk() {
        return $this->hasMany(Pjmk::class, 'nim_dosen', 'nim_dosen');
    }
    
}