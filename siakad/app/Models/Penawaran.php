<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Penawaran extends Model
{
    protected $table = 'penawaran';

    protected $primaryKey = 'recno';

    public $incrementing = true;

    protected $keyType = 'int';

    public $timestamps = false;

    protected $fillable = [
        'kodemk',
        'semester_id',
        'dosen',
        'sesi',
        'keterangan',
        'hari',
        'mulaipukul',
        'selesaipukul',
        'jurusan',
        'pagu',
        'pataum',
        'MBKM',
    ];

    protected $casts = [
        'MBKM' => 'boolean',
    ];

    /*
    |--------------------------------------------------------------------------
    | Mata Kuliah
    |--------------------------------------------------------------------------
    */
    public function mk()
    {
        return $this->belongsTo(Mk::class, 'kodemk', 'kodemk');
    }

    /*
    |--------------------------------------------------------------------------
    | Dosen
    |--------------------------------------------------------------------------
    | FIX: pastikan foreign key sesuai field di tabel penawaran
    */
    public function dosenRelasi()
    {
        return $this->belongsTo(Dosen::class, 'dosen', 'nim_dosen');
    }

    /*
    |--------------------------------------------------------------------------
    | Jurusan
    |--------------------------------------------------------------------------
    */
    public function jurusanRelasi()
    {
        return $this->belongsTo(Jurusan::class, 'jurusan', 'kode_jurusan');
    }

    /*
    |--------------------------------------------------------------------------
    | Semester
    |--------------------------------------------------------------------------
    */
    public function semester()
    {
        return $this->belongsTo(Semester::class, 'semester_id', 'id');
    }

    /*
    |--------------------------------------------------------------------------
    | Registrasi
    |--------------------------------------------------------------------------
    */
    public function registrasis()
    {
        return $this->hasMany(Registrasi::class, 'kodemk', 'kodemk');
    }
}   