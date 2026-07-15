<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Periode extends Model
{
    //
    protected $table = 'periode';
    protected $fillable = [
        'tahun_ajaran',
        'tanggal_mulai',
        'aktif',
        'tanggal_selesai'
    ];
 protected $casts = [
        'aktif' => 'boolean',
    ];
    // App\Models\Periode.php

public function semesters(){
    return $this->hasMany(Semester::class, 'periode_id');
}
public function aktifkanSemester($jenis)
{
    DB::transaction(function () use ($jenis) {
        $this->semesters()->update(['aktif' => false]);

        $this->semesters()
            ->where('jenis', $jenis)
            ->update(['aktif' => true]);
    });
}
}
