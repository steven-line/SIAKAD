<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
        'user_id',
        'prodi'
    ];

    public function mahasiswas()
    {
        return $this->hasMany(Mahasiswa::class);
    }

    public function user() {
        return $this->hasOne(User::class, 'username');
    }
}