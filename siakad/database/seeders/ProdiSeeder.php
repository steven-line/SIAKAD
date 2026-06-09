<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProdiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('prodi')->insert([

            [
                'kode_prodi' => 'IF',
                'nama_prodi' => 'Teknik Informatika',
                'kode_fakultas' => 'FTI',
            ],


            [
                'kode_prodi' => 'ARS',
                'nama_prodi' => 'Teknik Arsitektur',
                'kode_fakultas' => 'FEB',
            ],

            [
                'kode_prodi' => 'SP',
                'nama_prodi' => 'Teknik Sipil',
                'kode_fakultas' => 'FHU',
            ],

            [
                'kode_prodi' => 'EL',
                'nama_prodi' => 'Teknik Elektro',
                'kode_fakultas' => 'FTI',
            ],

            [
                'kode_prodi' => 'MNJ',
                'nama_prodi' => 'Manajemen Bisnis',
                'kode_fakultas' => 'FEB',
            ],

            [
                'kode_prodi' => 'AK',
                'nama_prodi' => 'Akuntansi',
                'kode_fakultas' => 'FEB',
            ],

            [
                'kode_prodi' => 'ING',
                'nama_prodi' => 'Sastra Inggris',
                'kode_fakultas' => 'FKP',
            ],

            [
                'kode_prodi' => 'MD',
                'nama_prodi' => 'Bahasa Mandarin',
                'kode_fakultas' => 'FKP',
            ],

        ]);
    }
}