<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mahasiswa extends Model
{
    //
     public $timestamps = false;
     public $incrementing = false;
     protected $primaryKey = 'nrp';

 

     public function dosenWali() {
        return $this->belongsTo(Dosen::class, 'dosen_wali', 'nim_dosen');
     }

     public function biodata() {
        return $this->hasOne(Biodata::class, 'nrp', 'nrp');
     }

     public function registrasi() {
         return $this->hasMany(Registrasi::class, 'nrp', 'nrp');
     }
}
