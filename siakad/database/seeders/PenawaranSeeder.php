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
                'kodemk' => 'IF101001',
                'semester_id' => 3,
                'dosen' => 'D001',
                'sesi' => 'A',
                'keterangan' => 'Kelas Reguler Pagi',
                'hari' => 'Senin',
                'mulaipukul' => '08:00:00',
                'selesaipukul' => '10:30:00',
                'jurusan' => 'TI1',
                'pagu' => '40',
                'pataum' => 'P',
                'MBKM' => false,
            ],

            [
                'kodemk' => 'IF101002',
                'semester_id' => 3,
                'dosen' => 'D001',
                'sesi' => 'A',
                'keterangan' => 'Kelas Reguler Pagi',
                'hari' => 'Selasa',
                'mulaipukul' => '08:00:00',
                'selesaipukul' => '10:30:00',
                'jurusan' => 'TI1',
                'pagu' => '35',
                'pataum' => 'P',
                'MBKM' => false,
            ],

            [
                'kodemk' => 'IF101003',
                'semester_id' => 3,
                'dosen' => 'D002',
                'sesi' => 'A',
                'keterangan' => 'Kelas Reguler Pagi',
                'hari' => 'Rabu',
                'mulaipukul' => '08:00:00',
                'selesaipukul' => '10:30:00',
                'jurusan' => 'TI1',
                'pagu' => '35',
                'pataum' => 'P',
                'MBKM' => false,
            ],

            [
                'kodemk' => 'IF101004',
                'semester_id' => 3,
                'dosen' => 'D003',
                'sesi' => 'A',
                'keterangan' => 'Kelas Reguler Sore',
                'hari' => 'Kamis',
                'mulaipukul' => '13:00:00',
                'selesaipukul' => '15:30:00',
                'jurusan' => 'TI1',
                'pagu' => '30',
                'pataum' => 'P',
                'MBKM' => false,
            ],

            [
                'kodemk' => 'IF101005',
                'semester_id' => 3,
                'dosen' => 'D003',
                'sesi' => 'A',
                'keterangan' => 'Kelas MBKM',
                'hari' => 'Jumat',
                'mulaipukul' => '09:00:00',
                'selesaipukul' => '11:30:00',
                'jurusan' => 'TI1',
                'pagu' => '25',
                'pataum' => 'M',
                'MBKM' => true,
            ],
        ]);
    }
}