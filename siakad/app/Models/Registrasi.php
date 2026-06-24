<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Registrasi extends Model
{
    protected $table = 'registrasi';
    protected $primaryKey = 'regkrs';
    public $timestamps = false;
        public $incrementing = true;
    protected $fillable = [
        'nrp',
        'penawaran_id',
        'status',
     
        'tanggal',
        'jam',
    
     
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

            'kodemk',  // MK PK
            'penawaran_id',
            'kodemk'
        );
    }
}