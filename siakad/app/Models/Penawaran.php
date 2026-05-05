<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Penawaran extends Model
{
    protected $table = 'penawarans';

    protected $primaryKey = 'recno';

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

    // 🔥 FIX: gunakan format time, bukan datetime
    protected $casts = [
        'mulaipukul' => 'datetime:H:i:s',
        'selesaipukul' => 'datetime:H:i:s',
    ];

    /**
     * 🔥 RELASI KE MATA KULIAH
     */
    public function matkul()
    {
        return $this->belongsTo(MataKuliah::class, 'kodemk', 'kodemk');
    }
}