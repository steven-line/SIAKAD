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
            ],


            [
                'kode_prodi' => 'ARS',
                'nama_prodi' => 'Teknik Arsitektur',
            ],

            [
                'kode_prodi' => 'SP',
                'nama_prodi' => 'Teknik Sipil',
            ],

            [
                'kode_prodi' => 'EL',
                'nama_prodi' => 'Teknik Elektro',
            ],

            [
                'kode_prodi' => 'MNJ',
                'nama_prodi' => 'Manajemen Bisnis',
            ],

            [
                'kode_prodi' => 'AK',
                'nama_prodi' => 'Akuntansi',
            ],

            [
                'kode_prodi' => 'ING',
                'nama_prodi' => 'Sastra Inggris',
            ],

            [
                'kode_prodi' => 'MD',
                'nama_prodi' => 'Bahasa Mandarin',
            ],

        ]);
    }
}