<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pjmk extends Model
{
    protected $table = 'pjmk';

    public $incrementing = false;

    public $timestamps = false;

    protected $fillable = [
        'kodemk',
        'nim_dosen',
        'periode_id',
        'jenis',
    ];


    public function dosen()
    {
        return $this->belongsTo(
            Dosen::class,
            'nim_dosen',
            'nim_dosen'
        );
    }


    public function mk()
    {
        return $this->belongsTo(
            Mk::class,
            'kodemk',
            'kodemk'
        );
    }


    public function periode()
    {
        return $this->belongsTo(
            Periode::class,
            'periode_id'
        );
    }
}