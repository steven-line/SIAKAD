<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fakultas extends Model
{
      public $timestamps = false;
      protected $primaryKey = 'kode_fakultas';
      public $incrementing = false;
      protected $table = 'fakultas';
           protected $fillable = [
          'kode_fakultas',
          'nama_fakultas'
        ];
      public function jurusans()
        {
        return $this->hasMany(
            Jurusan::class
        );
    }
    //
}
