<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Semester extends Model
{
    protected $table = 'semester';

    protected $primaryKey = 'id';

    public $timestamps = false; // kalau tabel kamu tidak punya created_at & updated_at

    protected $fillable = [
        'periode_id',
        'jenis',
        'aktif',
    ];
}