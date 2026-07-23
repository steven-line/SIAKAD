<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Metaperiode extends Model
{
    //
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
        'khs_mulai',
        'khs_selesai'
    ];
    protected $casts = ['krs_mulai' => 'datetime',
                        'krs_selesai' => 'datetime',  
                        'input_nilai_uts_mulai' => 'datetime',
                        'input_nilai_uts_selesai' => 'datetime',
                        'input_nilai_uas_mulai' => 'datetime',
                        'input_nilai_uas_selesai' => 'datetime',
                        'khs_mulai' => 'datetime',
                        'khs_selesai' => 'datetime'];
}
