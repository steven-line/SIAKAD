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
        $semesterAktif = DB::table('semester')
            ->where('aktif', true)
            ->value('id');

        DB::table('penawaran')->insert([
            [
                'kodemk' => 'IF101001',
                'semester_id' => $semesterAktif,
                'dosen' => '31120000',
                'sesi' => '1',
                'keterangan' => 'Kelas Reguler Pagi',
                'hari' => 'Senin',
                'mulaipukul' => '08:00:00',
                'selesaipukul' => '10:30:00',
                'prodi' => 'IF',
                'pagu' => 40,
                'pataum' => 'P',
                'MBKM' => false,
            ],

            [
                'kodemk' => 'IF101002',
                'semester_id' => $semesterAktif,
                'dosen' => '31120000',
                'sesi' => '1',
                'keterangan' => 'Kelas Reguler Pagi',
                'hari' => 'Selasa',
                'mulaipukul' => '08:00:00',
                'selesaipukul' => '10:30:00',
                'prodi' => 'IF',
                'pagu' => 35,
                'pataum' => 'P',
                'MBKM' => false,
            ],

            [
                'kodemk' => 'IF101003',
                'semester_id' => $semesterAktif,
                'dosen' => '31121111',
                'sesi' => '1',
                'keterangan' => 'Kelas Reguler Pagi',
                'hari' => 'Rabu',
                'mulaipukul' => '08:00:00',
                'selesaipukul' => '10:30:00',
                'prodi' => 'IF',
                'pagu' => 35,
                'pataum' => 'P',
                'MBKM' => false,
            ],

            [
                'kodemk' => 'IF101004',
                'semester_id' => $semesterAktif,
                'dosen' => '31123333',
                'sesi' => '1',
                'keterangan' => 'Kelas Reguler Siang',
                'hari' => 'Kamis',
                'mulaipukul' => '13:00:00',
                'selesaipukul' => '15:30:00',
                'prodi' => 'SI',
                'pagu' => 30,
                'pataum' => 'P',
                'MBKM' => false,
            ],

            [
                'kodemk' => 'IF101005',
                'semester_id' => $semesterAktif,
                'dosen' => '31123333',
                'sesi' => '1',
                'keterangan' => 'Kelas MBKM',
                'hari' => 'Jumat',
                'mulaipukul' => '09:00:00',
                'selesaipukul' => '11:30:00',
                'prodi' => 'AK',
                'pagu' => 25,
                'pataum' => 'M',
                'MBKM' => true,
            ],
        ]);
    }
}