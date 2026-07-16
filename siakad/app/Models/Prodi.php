<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Prodi extends Model
{
      public $incrementing = false;
      public $timestamps = false;
      protected $table = 'prodi';
      protected $primaryKey = 'kode_prodi';
      protected $fillable = [
          'kode_prodi',
          'nama_prodi',
          'kode_jurusan',
          'kode_prodi_dikti'
        ];

    public function dosens() {
      return $this->hasMany(Dosen::class, 'prodi', 'kode_prodi');
    }
    public function jurusan() {
        return $this->belongsTo(Jurusan::class, 'kode_jurusan', 'kode_jurusan');
    }
}
