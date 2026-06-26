<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kurikulum extends Model
{
    //
    public $incrementing = false;
    public $timestamps = false;
    protected $table = 'kurikulum';
    protected $primaryKey = 'kode_kurikulum';
    protected $fillable = [
          'kode_kurikulum',
          'nama_kurikulum',
          'aktif',
          'deskripsi',
          'tahun_mulai_berlaku',
          'tahun_selesai_berlaku',
          'kode_prodi'
        ];

    protected $casts = [
        'aktif' => 'boolean',
    ];
}
