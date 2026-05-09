<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dosen extends Model
{
    protected $table = 'dosen';

    protected $primaryKey = 'nim_dosen';

    public $incrementing = false;

    protected $keyType = 'string';

    public $timestamps = false;

    protected $fillable = [
        'nim_dosen',
        'nama',
        'nip',
    ];

    public function mahasiswas()
    {
        return $this->hasMany(Mahasiswa::class);
    }
}