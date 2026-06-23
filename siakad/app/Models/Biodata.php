<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Dosen;

class Biodata extends Model
{
    protected $table = 'biodata';
    public $incrementing = false;
    public $timestamps = false;

    protected $guarded = [];

    //

    // Relasi ke Mahasiswa (opsional)
    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class, 'nrp', 'nrp');
    }
}