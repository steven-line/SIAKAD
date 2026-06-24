<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Penawaran;
use App\Models\Mahasiswa;
use App\Models\Mk;
use App\Models\Krs;

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
     * Relasi ke Penawaran
     */
    public function penawaran()
    {
        return $this->belongsTo(
            Penawaran::class,
            'penawaran_id',
            'recno'
        );
    }

    /**
     * Relasi ke Mahasiswa
     */
    public function mahasiswa()
    {
        return $this->belongsTo(
            Mahasiswa::class,
            'nrp',
            'nrp'
        );
    }

    /**
     * Relasi ke Mata Kuliah melalui Penawaran
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

    /**
     * Relasi ke KRS (nilai)
     */
    public function krs()
    {
        return $this->hasOne(Krs::class, 'registrasi_id', 'regkrs');
    }
}