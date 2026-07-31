<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Semester extends Model
{
    protected $table = 'semester';

    protected $fillable = [
        'periode_id',
        'jenis',
        'aktif',
        'nama'
    ];
    public function penawarans(){
        return $this->hasMany(Penawaran::class);
    }
    /**
     * Relasi ke Periode
     */
    public function periode()
    {
        return $this->belongsTo(Periode::class, 'periode_id');
    }
}