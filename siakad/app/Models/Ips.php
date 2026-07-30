<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ips extends Model
{
    protected $table = 'ips';

    protected $primaryKey = 'nrp';

    public $incrementing = false;

    protected $keyType = 'string';

    public $timestamps = false;

    protected $fillable = [
        'nrp',
        'maksimal_sks',
        'ips',
        'toleransi',
    ];

    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class, 'nrp', 'nrp');
    }
}