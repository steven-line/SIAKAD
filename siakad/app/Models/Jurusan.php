<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jurusan extends Model
{
    //
    protected $table = 'jurusan';
    protected $primaryKey = 'kode_jurusan';
    public $incrementing = false;

    protected $fillable = [
        'kode_jurusan',
        'nama_jurusan',
        'program_pendidikan',
        'status-prodi',
        'keterangan',
        'fakultas'
    ];
    public function fakultas()
    {
        return $this->belongsTo(
            Fakultas::class,
            'fakultas',
            'kode_fakultas'
        );
    }
}
