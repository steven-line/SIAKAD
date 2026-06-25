<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Krs extends Model
{
    public $timestamps = false;

    protected $table = 'krs';

    protected $fillable = [
        'registrasi_id',
        'kode',
        'semester_id',
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

    public function semester()
    {
        return $this->belongsTo(Semester::class, 'semester_id');
    }

    public function penawaran()
    {
        return $this->hasOne(Penawaran::class, 'id', 'penawaran_id'); 
    }
    
}