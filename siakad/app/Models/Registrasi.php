<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Registrasi extends Model
{
    protected $table = 'registrasi';
    protected $primaryKey = 'regkrs';
    public $timestamps = false;

    protected $fillable = [
        'nrp',
        'penawaran_id',
        'status',
        'sesi',
        'tanggal',
        'jam',
        'validasi',
        'hari',
        'mulaipukul',
        'selesaipukul',
        'ip_address',
        'sks',
        'pataum',
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];

    /**
     * RELASI KE PENAWARAN
     */
    public function penawaran()
    {
        return $this->belongsTo(Penawaran::class, 'penawaran_id', 'recno');
    }

    /**
     * RELASI KE MAHASISWA
     */
    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class, 'nrp', 'nrp');
    }

    /**
     * RELASI MK (LEBIH AMAN LEWAT PENAWARAN)
     */
    public function mk()
    {
        return $this->hasOneThrough(
            Mk::class,
            Penawaran::class,
            'recno',   // Penawaran PK
            'kodemk',  // MK PK
            'penawaran_id',
            'kodemk'
        );
    }
}