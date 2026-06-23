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

            [
                'registrasi_id' => 2,
                'kode' => 'IF101002',
                'bu' => 'B',
                'ttt1' => 78,
                'ttt2' => 82,
                'ttt3' => 85,
                'lain' => 80,
                'uts' => 79,
                'uas' => 83,
                'na' => 'B',
                'sks' => 3,
                'kelas' => 'A',
                'survey' => true,
            ],

            [
                'registrasi_id' => 3,
                'kode' => 'IF101001',
                'bu' => 'B',
                'ttt1' => null,
                'ttt2' => null,
                'ttt3' => null,
                'lain' => null,
                'uts' => null,
                'uas' => null,
                'na' => null,
                'sks' => 3,
                'kelas' => 'A',
                'survey' => false,
            ],

            [
                'registrasi_id' => 4,
                'kode' => 'IF101005',
                'bu' => 'B',
                'ttt1' => 88,
                'ttt2' => 90,
                'ttt3' => 92,
                'lain' => 89,
                'uts' => 91,
                'uas' => 93,
                'na' => 'A',
                'sks' => 3,
                'kelas' => 'A',
                'survey' => true,
            ],

        ]);
    }
}