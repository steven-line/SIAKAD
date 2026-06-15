<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Penawaran extends Model
{
    protected $table = 'penawaran';

    protected $primaryKey = 'recno';

    public $incrementing = true;

    protected $keyType = 'int';

    public $timestamps = false;

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
        'MBKM',
        
    ];

    protected $casts = [
        'mulaipukul' => 'datetime:H:i:s',
        'selesaipukul' => 'datetime:H:i:s',
        'MBKM' => 'boolean',
    ];

    public function mk()
    {
        return $this->belongsTo(Mk::class, 'kodemk', 'kodemk');
    }

    public function registrasis()
{
    return $this->hasMany(Registrasi::class, 'kodemk', 'kodemk');
}

}