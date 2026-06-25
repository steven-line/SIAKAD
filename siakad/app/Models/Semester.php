<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Semester extends Model
{
    protected $table = 'semester';

    protected $fillable = [
        'periode_id',
        'jenis',
        'aktif'
    ];

    /**
     * Relasi ke Periode
     */
    public function periode()
    {
        return $this->belongsTo(Periode::class, 'periode_id');
    }
}