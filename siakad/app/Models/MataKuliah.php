<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MataKuliah extends Model
{
    protected $primaryKey = 'kodemk';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'kodemk',
        'nama',
        'sks',
        'nm_jenj_didik',
        'kode_prodi_dikti',
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
    ];
}