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
                'nama_fakultas' => 'Fakultas Teknologi Informasi',
            ],
            [
                'nama_fakultas' => 'Fakultas Teknik',
            ],
            [
                'nama_fakultas' => 'Fakultas Ekonomi dan Bisnis',
            ],
            [
                'nama_fakultas' => 'Fakultas Hukum',
            ],
            [
                'nama_fakultas' => 'Fakultas Ilmu Sosial',
            ],
            [
                'nama_fakultas' => 'Fakultas Keguruan dan Pendidikan',
            ],
            [
                'nama_fakultas' => 'Fakultas Kesehatan Masyarakat',
            ],
            [
                'nama_fakultas' => 'Fakultas Sains dan Pertanian',
            ],
        ]);
    }
}