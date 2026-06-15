<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Krs extends Model
{
    protected $table = 'krs';
    public $timestamps = false;
    protected $primaryKey = null; // tidak ada primary key tunggal
    public $incrementing = false;

    protected $fillable = [
        'NRP', 'KODE', 'BU', 'TTT1', 'TTT2', 'TTT3', 'LAIN', 'UTS', 'UAS', 'NA', 'SKS', 'PERIODE', 'KELAS', 'SURVEY'
    ];
}