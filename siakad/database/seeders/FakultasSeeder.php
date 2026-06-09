<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FakultasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('fakultas')->insert([
            [
                'kode_fakultas' => 'FTI',
                'nama_fakultas' => 'Fakultas Teknologi Informasi',
            ],
            [
                'kode_fakultas' => 'FTE',
                'nama_fakultas' => 'Fakultas Teknik',
            ],
            [
                'kode_fakultas' => 'FEB',
                'nama_fakultas' => 'Fakultas Ekonomi dan Bisnis',
            ],
            [
                'kode_fakultas' => 'FHU',
                'nama_fakultas' => 'Fakultas Hukum',
            ],
            [
                'kode_fakultas' => 'FIS',
                'nama_fakultas' => 'Fakultas Ilmu Sosial',
            ],
            [
                'kode_fakultas' => 'FKP',
                'nama_fakultas' => 'Fakultas Keguruan dan Pendidikan',
            ],
            [
                'kode_fakultas' => 'FKM',
                'nama_fakultas' => 'Fakultas Kesehatan Masyarakat',
            ],
            [
                'kode_fakultas' => 'FSP',
                'nama_fakultas' => 'Fakultas Sains dan Pertanian',
            ],
        ]);
    }
}