<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Penawaran extends Model
{
    protected $primaryKey = 'recno'; // 🔥 wajib

    public $incrementing = true;

    protected $keyType = 'int';

    protected $fillable = [
        'kodemk',
        'semester',
        'periode',
        'dosen',
        'sesi',
        'keterangan',
        'hari',
        'mulaipukul',
        'selesaipukul',
        'jurusan',
        'pagu',
        'pataum',
    ];
}
