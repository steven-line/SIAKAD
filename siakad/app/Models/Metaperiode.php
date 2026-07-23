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
        'input_nilai_uts_mulai',
        'input_nilai_uts_selesai',
        'input_nilai_uas_mulai',
        'input_nilai_uas_selesai',
        'pengumuman_nilai_final_mulai',
        'pengumuman_nilai_final_selesai'

    ];
    protected $casts = ['krs_mulai' => 'datetime',
                        'krs_selesai' => 'datetime',  
                        'input_nilai_uts_mulai' => 'datetime',
                        'input_nilai_uts_selesai' => 'datetime',
                        'input_nilai_uas_mulai' => 'datetime',
                        'input_nilai_uas_selesai' => 'datetime',
                        'pengumuman_nilai_final_mulai' => 'datetime',
                        'pengumuman_nilai_final_selesai' => 'datetime',

    ];

    public function periode()
    {
        return $this->belongsTo(Periode::class, 'periode_id');
    }
}
