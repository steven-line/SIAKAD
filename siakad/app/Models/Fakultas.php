<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fakultas extends Model
{
      public $incrementing = false;
      public $timestamps = false;
      protected $table = 'fakultas';
      protected $primaryKey = 'kode_fakultas';
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
