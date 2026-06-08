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

    protected $casts = [
    'tanggal' => 'date',
    'mulaipukul' => 'datetime:H:i:s',
    'selesaipukul' => 'datetime:H:i:s',
];

    // relasi ke matkul
    public function matkul()
    {
        return $this->belongsTo(Mk::class, 'kodemk', 'kodemk');
    }

    public function mahasiswa()
    {
    return $this->belongsTo(Biodata::class, 'nrp', 'nrp');
    }
}