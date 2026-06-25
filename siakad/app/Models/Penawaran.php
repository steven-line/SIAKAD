<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Mk;
use App\Models\Dosen;
use App\Models\Prodi;
use App\Models\Semester;

class Penawaran extends Model
{
    protected $table = 'penawaran';
    protected $primaryKey = 'recno';
    public $timestamps = false;

    protected $fillable = [
        'kodemk',
        'semester_id',
        'dosen',
        'hari',
        'mulaipukul',
        'selesaipukul',
        'pataum',
        'prodi',
        'sesi',
        'keterangan',
        'pagu',
        'MBKM'
    ];

    public function mk()
    {
        return $this->belongsTo(Mk::class, 'kodemk', 'kodemk');
    }

    public function dosenRelasi()
    {
        return $this->belongsTo(Dosen::class, 'dosen', 'nim_dosen');
    }

    public function semesterRelasi()
    {
        return $this->belongsTo(Semester::class, 'semester_id', 'id');
    }

    public function prodiRelasi()
    {
        return $this->belongsTo(Prodi::class, 'prodi', 'kode_prodi');
    }
    public function getMulaipukulAttribute($value)
    {
        return $value ? \Carbon\Carbon::parse($value) : null;
    }

    public function getSelesaipukulAttribute($value)
    {
        return $value ? \Carbon\Carbon::parse($value) : null;
    }

    public function semester()
    {
        return $this->belongsTo(Semester::class, 'semester_id');
    }
}