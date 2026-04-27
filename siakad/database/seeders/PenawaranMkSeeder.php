<?php

namespace Database\Seeders;

use App\Models\PenawaranMk;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PenawaranMkSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
{
    $datas = [
        // SENIN
        [
            'kode_mk' => 'FT1006',
            'nama_mk' => 'ALJABAR LINEAR & MATRIKS',
            'hari' => 'SENIN',
            'jam_mulai' => '08:00:01',
            'jam_selesai' => '10:30:00',
            'sks' => 3,
        ],
        [
            'kode_mk' => 'TF3202',
            'nama_mk' => 'PEMROGRAMAN BERORIENTASI OBYEK',
            'hari' => 'SENIN',
            'jam_mulai' => '10:30:01',
            'jam_selesai' => '13:50:00',
            'sks' => 4,
        ],
        [
            'kode_mk' => 'TF4602',
            'nama_mk' => 'MACHINE LEARNING',
            'hari' => 'SENIN',
            'jam_mulai' => '13:50:01',
            'jam_selesai' => '16:20:00',
            'sks' => 3,
        ],

        // SELASA
        [
            'kode_mk' => 'TF3506',
            'nama_mk' => 'TEKNIK KOMPILASI DAN AUTOMATA',
            'hari' => 'SELASA',
            'jam_mulai' => '08:00:01',
            'jam_selesai' => '10:30:00',
            'sks' => 3,
        ],
        [
            'kode_mk' => 'FT1005',
            'nama_mk' => 'STATISTIKA',
            'hari' => 'SELASA',
            'jam_mulai' => '08:50:01',
            'jam_selesai' => '11:20:00',
            'sks' => 3,
        ],
        [
            'kode_mk' => 'TF6202',
            'nama_mk' => 'ARSITEKTUR DAN ORGANISASI KOMPUTER',
            'hari' => 'SELASA',
            'jam_mulai' => '13:00:01',
            'jam_selesai' => '15:30:00',
            'sks' => 3,
        ],
        [
            'kode_mk' => 'TF6303',
            'nama_mk' => 'SISTEM OPERASI',
            'hari' => 'SELASA',
            'jam_mulai' => '13:00:01',
            'jam_selesai' => '13:50:00',
            'sks' => 4,
        ],

        // RABU
        [
            'kode_mk' => 'TF3203',
            'nama_mk' => 'STRUKTUR DATA DAN ALGORITMA',
            'hari' => 'RABU',
            'jam_mulai' => '08:00:01',
            'jam_selesai' => '10:30:00',
            'sks' => 3,
        ],
        [
            'kode_mk' => 'TF5504',
            'nama_mk' => 'REKAYASA PERANGKAT LUNAK',
            'hari' => 'RABU',
            'jam_mulai' => '10:30:01',
            'jam_selesai' => '13:00:00',
            'sks' => 3,
        ],
        [
            'kode_mk' => 'KM1004',
            'nama_mk' => 'PENGANTAR ENTERPRENEURSHIP',
            'hari' => 'RABU',
            'jam_mulai' => '13:00:01',
            'jam_selesai' => '15:30:00',
            'sks' => 3,
        ],

        // KAMIS
        [
            'kode_mk' => 'FT1004',
            'nama_mk' => 'KALKULUS II',
            'hari' => 'KAMIS',
            'jam_mulai' => '08:00:01',
            'jam_selesai' => '10:30:00',
            'sks' => 3,
        ],
        [
            'kode_mk' => 'TF7402',
            'nama_mk' => 'JARINGAN KOMPUTER',
            'hari' => 'KAMIS',
            'jam_mulai' => '08:00:01',
            'jam_selesai' => '10:30:00',
            'sks' => 3,
        ],
        [
            'kode_mk' => 'FT1012',
            'nama_mk' => 'PEMROGRAMAN BERBASIS WEB',
            'hari' => 'KAMIS',
            'jam_mulai' => '13:00:01',
            'jam_selesai' => '16:20:00',
            'sks' => 4,
        ],

        // JUMAT
        [
            'kode_mk' => 'KM1002',
            'nama_mk' => 'BAHASA INDONESIA',
            'hari' => 'JUMAT',
            'jam_mulai' => '08:00:01',
            'jam_selesai' => '10:30:00',
            'sks' => 3,
        ],
        [
            'kode_mk' => 'TF5605',
            'nama_mk' => 'E-BUSINESS',
            'hari' => 'JUMAT',
            'jam_mulai' => '12:10:01',
            'jam_selesai' => '14:40:00',
            'sks' => 3,
        ],

        // SABTU
        [
            'kode_mk' => 'KM5001',
            'nama_mk' => 'KULIAH KERJA NYATA',
            'hari' => 'SABTU',
            'jam_mulai' => '10:30:01',
            'jam_selesai' => '13:00:00',
            'sks' => 3,
        ],
        [
            'kode_mk' => 'TF9808',
            'nama_mk' => 'TUGAS AKHIR',
            'hari' => 'SABTU',
            'jam_mulai' => '13:00:01',
            'jam_selesai' => '13:50:00',
            'sks' => 8,
        ],
    ];

    foreach ($datas as $data) {
        PenawaranMk::create($data);
    }
}
}
