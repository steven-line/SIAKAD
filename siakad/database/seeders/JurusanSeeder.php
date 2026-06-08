<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JurusanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('jurusan')->insert([

            [
                'kode_jurusan'        => 'IF',
                'nama_jurusan'        => 'Teknik Informatika',
                'program_pendidikan'  => 'Sarjana',
                'status_prodi'        => 'Aktif',
                'sk_ban'              => 'BAN-PT-IF-001',
                'kaprodi'             => 'Yonatan',
                'keterangan'          => 'Program Studi Teknik Informatika',
                'fakultas'            => 'FT',
            ],  

            [
                'kode_jurusan'        => 'ARS',
                'nama_jurusan'        => 'Arsitektur',
                'program_pendidikan'  => 'Sarjana',
                'status_prodi'        => 'Aktif',
                'sk_ban'              => 'BAN-PT-ARS-001',
                'kaprodi'             => 'Darmanto',
                'keterangan'          => 'Program Studi Arsitektur',
                'fakultas'            => 'FT',
            ],

            [
                'kode_jurusan'        => 'ING',
                'nama_jurusan'        => 'Sastra Inggris',
                'program_pendidikan'  => 'Sarjana',
                'status_prodi'        => 'Aktif',
                'sk_ban'              => 'BAN-PT-ING-001',
                'kaprodi'             => 'Erwin',
                'keterangan'          => 'Program Studi Sastra Inggris',
                'fakultas'            => 'FB',
            ],

        ]);
    }
}