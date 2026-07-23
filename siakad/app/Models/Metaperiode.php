<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Metaperiode extends Model
{
    protected $table = 'metaperiode';
    public $timestamps = false;

    protected $fillable = [
        'periode_id',
        'krs_mulai',
        'krs_selesai',
        'batal_tambah_mulai',
        'batal_tambah_selesai',
        'input_nilai_mulai',
        'input_nilai_selesai',
        'pengumuman_nilai_final_mulai',
        'pengumuman_nilai_final_selesai'
    ];

    protected $casts = [
        'krs_mulai' => 'datetime',
        'krs_selesai' => 'datetime',
        'batal_tambah_mulai' => 'datetime',
        'batal_tambah_selesai' => 'datetime',
        'input_nilai_mulai' => 'datetime',
        'input_nilai_selesai' => 'datetime',
        'pengumuman_nilai_final_mulai' => 'datetime',
        'pengumuman_nilai_final_selesai' => 'datetime',
    ];

    public function periode()
    {
        return $this->belongsTo(Periode::class, 'periode_id');
    }
}