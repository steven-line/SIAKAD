<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Prodi;
use App\Models\Dosen;
use App\Models\Biodata;
use App\Models\Ips;

class Mahasiswa extends Model
{
    //
     public $timestamps = false;
     public $incrementing = false;
     protected $primaryKey = 'nrp';

     protected $fillable = [
      'nrp',
      'prodi',
      'dosen_wali',
      'status_blokir'
     ];
 

     public function dosenWali() {
        return $this->belongsTo(Dosen::class, 'dosen_wali', 'nim_dosen');
     }

     public function biodata() {
        return $this->hasOne(Biodata::class, 'nrp', 'nrp');
     }

     public function registrasi() {
         return $this->hasMany(Registrasi::class, 'nrp', 'nrp');
     }

    public function programStudi() {
         return $this->belongsTo(Prodi::class, 'prodi', 'kode_prodi');
     }

     public function ips()
    {
        return $this->hasOne(Ips::class, 'nrp', 'nrp');
    }

    public function prodi()
    {
        return $this->belongsTo(Prodi::class, 'prodi', 'kode_prodi');
    }


}
