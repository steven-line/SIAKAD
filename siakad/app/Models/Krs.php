<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Krs extends Model
{
    protected $table = 'krs';

    protected $fillable = [
        'registrasi_id',
        'kode',
        'bu',
        'ttt1',
        'ttt2',
        'ttt3',
        'lain',
        'uts',
        'uas',
        'na',
        'sks',
        'kelas',
        'survey',
    ];

    /**
     * RELASI WAJIB
     */
    public function registrasi()
    {
        return $this->belongsTo(Registrasi::class, 'registrasi_id', 'regkrs');
    }

    public function mk()
    {
        return $this->belongsTo(Mk::class, 'kode', 'kodemk');
    }
}