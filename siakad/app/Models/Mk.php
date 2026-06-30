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

    protected $fillable = [
        'kodemk',
        'nama',
        'sks',
        'nm_jenj_didik',
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

        protected $casts = [
        'aktif' => 'boolean',
    ];

    public function kurikulum()
    {
        return $this->belongsTo(
            Kurikulum::class,
            'kode_kurikulum',
            'kode_kurikulum'
        );
    }
}