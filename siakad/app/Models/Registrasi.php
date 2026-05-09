<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Registrasi extends Model
{
    protected $table = 'registrasi';

    protected $primaryKey = 'regkrs';

    public $timestamps = false;

    protected $fillable = [
        'nrp',
        'kodemk',
        'periode',
        'status',
        'sesi',
        'tanggal',
        'jam',
        'validasi',
        'hari',
        'mulaipukul',
        'selesaipukul',
        'ip_address',
        'sks',
        'pataum',
    ];

    // relasi ke matkul
    public function matkul()
    {
        return $this->belongsTo(Mk::class, 'kodemk', 'kodemk');
    }
}