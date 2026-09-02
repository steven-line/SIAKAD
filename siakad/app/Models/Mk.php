<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mk extends Model
{
    protected $table = 'mk';

    protected $primaryKey = 'kodemk';

    public $incrementing = false;

    protected $keyType = 'string';

    public $timestamps = false;


    /*
    |--------------------------------------------------------------------------
    | MASS ASSIGNMENT
    |--------------------------------------------------------------------------
    */

    protected $fillable = [
        'kodemk',
        'nama',
        'sks',
        'nm_jenj_didik',

        // Jenis MK:
        // normal = PJMK diinput Kaprodi
        // khusus = PJMK diinput Admin
        'jenis',

        'kode_prodi_dikti',
        'kode_kurikulum',

        'prasyaratsks',

        'prasyarat1',
        'prasyarat2',
        'prasyarat3',
        'prasyarat4',
        'prasyarat5',
        'prasyarat6',
        'prasyarat7',
        'prasyarat8',
        'prasyarat9',
        'prasyarat10',

        'prasyaratgrade',

        'aktif',
    ];


    /*
    |--------------------------------------------------------------------------
    | CASTS
    |--------------------------------------------------------------------------
    */

    protected $casts = [
        'aktif' => 'boolean',
    ];


    /*
    |--------------------------------------------------------------------------
    | RELATIONSHIPS
    |--------------------------------------------------------------------------
    */

    /**
     * Relasi ke Bobot Nilai.
     */
    public function bobotNilai()
    {
        return $this->hasOne(
            BobotNilai::class,
            'kodemk',
            'kodemk'
        );
    }


    /**
     * Relasi ke Penawaran.
     *
     * mk.kodemk
     *      ↓
     * penawaran.kodemk
     */
    public function penawarans()
    {
        return $this->hasMany(
            Penawaran::class,
            'kodemk',
            'kodemk'
        );
    }


    /**
     * Relasi ke Kurikulum.
     */
    public function kurikulum()
    {
        return $this->belongsTo(
            Kurikulum::class,
            'kode_kurikulum',
            'kode_kurikulum'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | HELPER
    |--------------------------------------------------------------------------
    */

    /**
     * Mengecek apakah MK merupakan MK khusus.
     *
     * true  = PJMK diatur Admin
     * false = PJMK diatur Kaprodi
     */
    public function isKhusus(): bool
    {
        return $this->jenis === 'khusus';
    }


    /**
     * Mengecek apakah MK merupakan MK normal.
     *
     * true = PJMK diatur Kaprodi
     * false = PJMK diatur Admin
     */
    public function isNormal(): bool
    {
        return $this->jenis === 'normal';
    }
}
