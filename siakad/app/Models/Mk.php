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

        /*
         * KURIKULUM
         */
        'kode_prodi_dikti',
        'kode_kurikulum',

        /*
         * PERIODE INPUT NILAI
         *
         * normal = mengikuti periode input nilai UTS/UAS
         * khusus = tidak mengikuti periode input nilai UTS/UAS
         */
        'periode_input',

        /*
         * JENIS MATA KULIAH
         *
         * mk_fakultas = PJMK Admin
         * mk_umum     = PJMK Admin
         * mk_prodi    = PJMK Kaprodi
         * mk_khusus   = PJMK Kaprodi
         */
        'jenis_mk',

        /*
         * PRASYARAT
         */
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

        /*
         * STATUS
         */
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
    | HELPER JENIS MATA KULIAH
    |--------------------------------------------------------------------------
    */

    /**
     * Mengecek apakah MK merupakan MK Khusus.
     *
     * mk_khusus = PJMK diatur Kaprodi
     */
    public function isKhusus(): bool
    {
        return $this->jenis_mk === 'mk_khusus';
    }


    /**
     * Mengecek apakah MK merupakan MK Prodi.
     */
    public function isProdi(): bool
    {
        return $this->jenis_mk === 'mk_prodi';
    }


    /**
     * Mengecek apakah MK merupakan MK Fakultas.
     */
    public function isFakultas(): bool
    {
        return $this->jenis_mk === 'mk_fakultas';
    }


    /**
     * Mengecek apakah MK merupakan MK Umum.
     */
    public function isUmum(): bool
    {
        return $this->jenis_mk === 'mk_umum';
    }


    /*
    |--------------------------------------------------------------------------
    | HELPER PERIODE INPUT
    |--------------------------------------------------------------------------
    */

    /**
     * Mengecek apakah MK mengikuti periode input normal.
     */
    public function isPeriodeNormal(): bool
    {
        return $this->periode_input === 'normal';
    }


    /**
     * Mengecek apakah MK menggunakan periode input khusus.
     */
    public function isPeriodeKhusus(): bool
    {
        return $this->periode_input === 'khusus';
    }
}
