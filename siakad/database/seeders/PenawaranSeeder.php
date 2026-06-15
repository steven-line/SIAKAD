<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PenawaranSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('penawaran')->insert([

            [
                'kodemk'       => 'FT1006',
                'semester'     => '1',
                'periode'      => '2025/2026',
                'dosen'        => '311231234',   
                'sesi'         => '1',
                'keterangan'   => 'Kelas Reguler',
                'hari'         => 'Senin',
                'mulaipukul'   => '08:00:00',
                'selesaipukul' => '10:30:00',
                'jurusan'      => 'IF',
                'pagu'         => '40',
                'pataum'       => 'P',
            ],

        ]);
    }
}