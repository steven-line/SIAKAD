<?php

namespace Database\Seeders;

use App\Models\MataKuliah;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MataKuliahSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $datas = [
            ['kode_mk' => 'FT1006', 'nama_mk' => 'ALJABAR LINEAR & MATRIKS'],
            ['kode_mk' => 'TF3202', 'nama_mk' => 'PEMROGRAMAN BERORIENTASI OBYEK'],
            ['kode_mk' => 'TF4602', 'nama_mk' => 'MACHINE LEARNING'],

            ['kode_mk' => 'TF3506', 'nama_mk' => 'TEKNIK KOMPILASI DAN AUTOMATA'],
            ['kode_mk' => 'FT1005', 'nama_mk' => 'STATISTIKA'],
            ['kode_mk' => 'TF6202', 'nama_mk' => 'ARSITEKTUR DAN ORGANISASI KOMPUTER'],
            ['kode_mk' => 'TF6303', 'nama_mk' => 'SISTEM OPERASI'],

            ['kode_mk' => 'TF3203', 'nama_mk' => 'STRUKTUR DATA DAN ALGORITMA'],
            ['kode_mk' => 'TF5403', 'nama_mk' => 'INTERAKSI MANUSIA & KOMPUTER'],
            ['kode_mk' => 'TF8603', 'nama_mk' => 'PENGOLAHAN CITRA DIGITAL'],
            ['kode_mk' => 'TF5504', 'nama_mk' => 'REKAYASA PERANGKAT LUNAK'],
            ['kode_mk' => 'TF6604', 'nama_mk' => 'PENGAMANAN SISTEM KOMPUTER'],
            ['kode_mk' => 'TF9810', 'nama_mk' => 'TEKNOLOGI PEMBELAJARAN'],
            ['kode_mk' => 'KM1004', 'nama_mk' => 'PENGANTAR ENTERPRENEURSHIP'],

            ['kode_mk' => 'FT1004', 'nama_mk' => 'KALKULUS II'],
            ['kode_mk' => 'TF7402', 'nama_mk' => 'JARINGAN KOMPUTER'],
            ['kode_mk' => 'TF9501', 'nama_mk' => 'METODOLOGI PENELITIAN'],
            ['kode_mk' => 'FT1012', 'nama_mk' => 'PEMROGRAMAN BERBASIS WEB'],
            ['kode_mk' => 'TF9706', 'nama_mk' => 'PERENCANAAN SUMBER DAYA PERUSAHAAN'],
            ['kode_mk' => 'EA4606', 'nama_mk' => 'ACCOUNTINGPRENEURSHIP'],

            ['kode_mk' => 'KM1002', 'nama_mk' => 'BAHASA INDONESIA'],
            ['kode_mk' => 'TF5605', 'nama_mk' => 'E-BUSINESS'],
            ['kode_mk' => 'KM1014', 'nama_mk' => 'PENDIDIKAN KEWARGANEGARAAN'],
            ['kode_mk' => 'TF8602', 'nama_mk' => 'LOKAKARYA FOTOGRAFI'],
            ['kode_mk' => 'KM1016', 'nama_mk' => 'BAHASA MANDARIN'],

            ['kode_mk' => 'KM5001', 'nama_mk' => 'KULIAH KERJA NYATA'],
            ['kode_mk' => 'TF9808', 'nama_mk' => 'TUGAS AKHIR'],
            ['kode_mk' => 'TF9809', 'nama_mk' => 'SEMINAR'],
            ['kode_mk' => 'TF9705', 'nama_mk' => 'PROPOSAL TUGAS AKHIR'],
            ['kode_mk' => 'TF9708', 'nama_mk' => 'MAGANG'],
        ];

        foreach($datas as $data) {
             MataKuliah::create($data);
        }
       
    }
}
