<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Metaperiode extends Model
{
    protected $table = 'metaperiode';

    protected $fillable = [
        'periode_id',

        // Periode Input Penawaran
        'input_penawaran_mulai',
        'input_penawaran_selesai',

        // Periode KRS
        'krs_mulai',
        'krs_selesai',

        // Periode Input Nilai UTS
        'input_nilai_uts_mulai',
        'input_nilai_uts_selesai',

        // Periode Input Nilai UAS
        'input_nilai_uas_mulai',
        'input_nilai_uas_selesai',

        // Mata Kuliah Khusus
        'mk_khusus',

        // Pengumuman Nilai Final
        'pengumuman_nilai_final_mulai',
        'pengumuman_nilai_final_selesai',
    ];

    protected $casts = [
        'input_penawaran_mulai' => 'datetime',
        'input_penawaran_selesai' => 'datetime',

        'krs_mulai' => 'datetime',
        'krs_selesai' => 'datetime',

        'input_nilai_uts_mulai' => 'datetime',
        'input_nilai_uts_selesai' => 'datetime',

        'input_nilai_uas_mulai' => 'datetime',
        'input_nilai_uas_selesai' => 'datetime',

        /*
        |--------------------------------------------------------------------------
        | MK Khusus
        |--------------------------------------------------------------------------
        |
        | Disimpan sebagai array ID MK.
        |
        | Contoh:
        | [15, 18, 21]
        |
        */
        'mk_khusus' => 'array',

        'pengumuman_nilai_final_mulai' => 'datetime',
        'pengumuman_nilai_final_selesai' => 'datetime',
    ];

    public function periode()
    {
        return $this->belongsTo(Periode::class, 'periode_id');
    }
}
