<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FakultasSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('fakultas')->insert([
            [
                'kode_fakultas' => 'A',
                'nama_fakultas' => 'UNIVERSITAS (MKU)',
            ],
            [
                'kode_fakultas' => 'B',
                'nama_fakultas' => 'FAKULTAS EKONOMI',
            ],
            [
                'kode_fakultas' => 'E',
                'nama_fakultas' => 'FAKULTAS TEKNIK',
            ],
            [
                'kode_fakultas' => 'J',
                'nama_fakultas' => 'FAKULTAS SASTRA DAN PENDIDIKAN BAHASA',
            ],
        ]);
    }
}