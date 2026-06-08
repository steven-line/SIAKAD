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
                'dosen'        => 'Yonatan Widianto',
                'sesi'         => '1',
                'keterangan'   => 'Kelas Reguler',
                'hari'         => 'Senin',
                'mulaipukul'   => '08:00:00',
                'selesaipukul' => '10:30:00',
                'jurusan'      => 'IF',
                'pagu'         => '40',
                'pataum'       => 'P',
            ],

            [
                'kodemk'       => 'TF3202',
                'semester'     => '3',
                'periode'      => '2025/2026',
                'dosen'        => 'Yonatan Widianto',
                'sesi'         => '1',
                'keterangan'   => 'Kelas Reguler',
                'hari'         => 'Selasa',
                'mulaipukul'   => '10:30:00',
                'selesaipukul' => '13:00:00',
                'jurusan'      => 'IF',
                'pagu'         => '35',
                'pataum'       => 'P',
            ],

            [
                'kodemk'       => 'TF4602',
                'semester'     => '5',
                'periode'      => '2025/2026',
                'dosen'        => 'Yonatan Widianto',
                'sesi'         => '2',
                'keterangan'   => 'Kelas Malam',
                'hari'         => 'Rabu',
                'mulaipukul'   => '18:00:00',
                'selesaipukul' => '19:40:00',
                'jurusan'      => 'IF',
                'pagu'         => '30',
                'pataum'       => 'M',
            ],

            [
                'kodemk'       => 'FT1006',
                'semester'     => '1',
                'periode'      => '2025/2026',
                'dosen'        => 'Darmanto',
                'sesi'         => '1',
                'keterangan'   => 'Kelas Reguler',
                'hari'         => 'Kamis',
                'mulaipukul'   => '08:00:00',
                'selesaipukul' => '10:30:00',
                'jurusan'      => 'ARS',
                'pagu'         => '40',
                'pataum'       => 'P',
            ],

            [
                'kodemk'       => 'TF3202',
                'semester'     => '3',
                'periode'      => '2025/2026',
                'dosen'        => 'Erwin',
                'sesi'         => '1',
                'keterangan'   => 'Kelas Reguler',
                'hari'         => 'Jumat',
                'mulaipukul'   => '08:00:00',
                'selesaipukul' => '10:30:00',
                'jurusan'      => 'ING',
                'pagu'         => '25',
                'pataum'       => 'P',
            ],

        ]);
    }
}