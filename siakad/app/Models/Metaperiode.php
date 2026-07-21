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
        'batal_tambah_mulai',
        'batal_tambah_selesai',
        'input_nilai_mulai',
        'input_nilai_selesai',
        'khs_mulai',
        'khs_selesai'
    ];
}
