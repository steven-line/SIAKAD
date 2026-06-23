<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Registrasi extends Model
{
    protected $table = 'registrasi';

    protected $primaryKey = 'regkrs';

    public $timestamps = false;

    /**
     * Kolom-kolom yang dapat diisi secara massal.
     * Disesuaikan dengan struktur tabel registrasi terbaru.
     */
    protected $fillable = [
        'nrp',
        'penawaran_id',    // foreign key ke penawaran.recno
        'status',
        'sesi',
        'tanggal',
        'jam',
        'validasi',
        'hari',
        'mulaipukul',
        'selesaipukul',
        'ip_address',
        'sks',
        'pataum',
        // 'kodemk', 'periode', 'dosen' TIDAK ADA di tabel, jangan dimasukkan
    ];

    protected $casts = [
        'tanggal'    => 'date',
        'mulaipukul' => 'datetime:H:i:s',
        'selesaipukul' => 'datetime:H:i:s',
    ];

    /**
     * Relasi ke tabel penawaran.
     * Registrasi terikat pada satu penawaran.
     */
    public function penawaran()
    {
        return $this->belongsTo(Penawaran::class, 'penawaran_id', 'recno');
    }

    /**
     * Relasi ke tabel mahasiswa (melalui nrp).
     * Jika model Mahasiswa berbeda, sesuaikan.
     */
    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class, 'nrp', 'nrp');
    }

    /**
     * (Opsional) Relasi tidak langsung ke Mk melalui penawaran.
     * Digunakan untuk kemudahan akses $registrasi->matkul.
     */
    public function matkul()
    {
        // Melalui penawaran ke Mk
        return $this->hasOneThrough(
            Mk::class,
            Penawaran::class,
            'recno',        // foreign key pada penawaran (primary key)
            'kodemk',       // foreign key pada mk (primary key)
            'penawaran_id', // local key pada registrasi
            'kodemk'        // local key pada penawaran yang merujuk ke mk.kodemk
        );
    }
}