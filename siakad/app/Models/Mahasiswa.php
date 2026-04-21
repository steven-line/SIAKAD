<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mahasiswa extends Model
{
    //
     public $timestamps = false;


     public function dosenWali() {
        return $this->belongsTo(Dosen::class, 'dosen_wali', 'nim_dosen');
     }
}
