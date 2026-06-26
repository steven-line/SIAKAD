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
                'kode_jurusan' => 'TI1',
                'kode_prodi_dikti' => '55201',
            ],

            [
                'kode_prodi' => 'SI',
                'nama_prodi' => 'Sistem Informasi',
                'kode_jurusan' => 'SI1',
                'kode_prodi_dikti' => '57201',
            ],

            [
                'kode_prodi' => 'SP',
                'nama_prodi' => 'Teknik Sipil',
                'kode_jurusan' => 'TK1',
                'kode_prodi_dikti' => '22201',
            ],

            [
                'kode_prodi' => 'MNJ',
                'nama_prodi' => 'Manajemen',
                'kode_jurusan' => 'MM1',
                'kode_prodi_dikti' => '61101',
            ],

            [
                'kode_prodi' => 'AK',
                'nama_prodi' => 'Akuntansi',
                'kode_jurusan' => 'AK1',
                'kode_prodi_dikti' => '62201',
            ],

        ]);
    }
}