<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Periode extends Model
{
    use SoftDeletes;

    protected $table = 'periode';

    protected $fillable = [
        'tahun_ajaran',
        'tanggal_mulai',
        'tanggal_selesai',
        'aktif',
    ];

    protected $casts = [
        'aktif' => 'boolean',
        'tanggal_mulai' => 'date',
        'tanggal_selesai' => 'date',
    ];

    /**
     * Relasi ke semester
     */
    public function semesters()
    {
        return $this->hasMany(Semester::class, 'periode_id');
    }

    /**
     * Mengaktifkan semester berdasarkan jenis
     * dan menonaktifkan semester lainnya.
     */
    public function aktifkanSemester($jenis)
    {
        DB::transaction(function () use ($jenis) {

            // Nonaktifkan semua semester pada periode ini
            $this->semesters()->update([
                'aktif' => false
            ]);

            // Aktifkan semester yang dipilih
            $this->semesters()
                ->where('jenis', $jenis)
                ->update([
                    'aktif' => true
                ]);
        });
    }
}