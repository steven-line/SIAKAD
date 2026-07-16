<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProdiSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('prodi')->insert([

            [
                'kode_prodi' => 'C',
                'nama_prodi' => 'S1 Manajemen',
                'kode_jurusan' => 'MN1',
                'kode_prodi_dikti' => '61101',
            ],

            [
                'kode_prodi' => 'D',
                'nama_prodi' => 'S1 Akuntansi',
                'kode_jurusan' => 'AK1',
                'kode_prodi_dikti' => '62201',
            ],

            [
                'kode_prodi' => 'F',
                'nama_prodi' => 'S1 Teknik Sipil',
                'kode_jurusan' => 'TS1',
                'kode_prodi_dikti' => '22201',
            ],

            [
                'kode_prodi' => 'G',
                'nama_prodi' => 'S1 Arsitektur',
                'kode_jurusan' => 'AR1',
                'kode_prodi_dikti' => '55202',
            ],

            [
                'kode_prodi' => 'H',
                'nama_prodi' => 'S1 Teknik Elektro',
                'kode_jurusan' => 'TE1',
                'kode_prodi_dikti' => '20201',
            ],

            [
                'kode_prodi' => 'I',
                'nama_prodi' => 'S1 Teknik Informatika',
                'kode_jurusan' => 'TI1',
                'kode_prodi_dikti' => '55201',
            ],

            [
                'kode_prodi' => 'K',
                'nama_prodi' => 'S1 Sastra Inggris',
                'kode_jurusan' => 'SI1',
                'kode_prodi_dikti' => '79201',
            ],

            [
                'kode_prodi' => 'L',
                'nama_prodi' => 'S1 Pendidikan Bahasa Mandarin',
                'kode_jurusan' => 'BM1',
                'kode_prodi_dikti' => '88201',
            ],

        ]);
    }
}