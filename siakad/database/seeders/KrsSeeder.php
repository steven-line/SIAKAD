<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KrsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('krs')->insert([

            [
                'registrasi_id' => 1,
                'kode' => 'IF101001',
                'bu' => 'B',
                'ttt1' => 80,
                'ttt2' => 85,
                'ttt3' => 90,
                'lain' => 88,
                'uts' => 84,
                'uas' => 87,
                'na' => 'A',
                'sks' => 3,
                'kelas' => 'A',
                'survey' => true,
            ],

        ]);
    }
}