<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Penawaran extends Model
{
    //
    protected $fillable = [
    'kode_mk',
    'nama_mk',
    'sks',
    'kelas',
    'dosen',
    'semester',
    'hari',
    'jam_mulai',
    'jam_selesai',
];
}
