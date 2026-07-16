<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jurusan extends Model
{
    //
    protected $table = 'jurusan';
    protected $primaryKey = 'kode_jurusan';
    public $incrementing = false;
     public $timestamps = false;
    protected $fillable = [
        'kode_jurusan',
        'nama_jurusan',
        'program_pendidikan',
        'sk_ban',
        'keterangan',
        'kode_fakultas'
    ];
    public function fakultas()
    {
        return $this->belongsTo(
            Fakultas::class,
            'kode_fakultas',
            'kode_fakultas'
        );
    }
    public function prodi() {
        return $this->hasOne(Prodi::class, 'kode_jurusan', 'kode_jurusan');
    }
}
