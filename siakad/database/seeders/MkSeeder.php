<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MkSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('mk')->insert([
            [
                'kodemk' => 'IF101001',
                'nama' => 'Algoritma dan Pemrograman',
                'sks' => '3',
                'nm_jenj_didik' => 'S1',
                'prasyaratsks' => '0',
                'prasyarat1' => '',
                'prasyarat2' => '',
                'prasyarat3' => '',
                'prasyarat4' => '',
                'prasyarat5' => '',
                'prasyarat6' => '',
                'prasyarat7' => '',
                'prasyarat8' => '',
                'prasyarat9' => '',
                'prasyarat10' => '',
                'prasyaratgrade' => '',
                'kode_kurikulum' => 'KUR2025',
                'aktif' => true,
            ],
            [
                'kodemk' => 'IF101002',
                'nama' => 'Struktur Data',
                'sks' => '3',
                'nm_jenj_didik' => 'S1',
                'prasyaratsks' => '20',
                'prasyarat1' => 'IF101001',
                'prasyarat2' => '',
                'prasyarat3' => '',
                'prasyarat4' => '',
                'prasyarat5' => '',
                'prasyarat6' => '',
                'prasyarat7' => '',
                'prasyarat8' => '',
                'prasyarat9' => '',
                'prasyarat10' => '',
                'prasyaratgrade' => 'C',
                'kode_kurikulum' => 'KUR2025',
                'aktif' => true,
            ],
            [
                'kodemk' => 'IF101003',
                'nama' => 'Basis Data',
                'sks' => '3',
                'nm_jenj_didik' => 'S1',
                'prasyaratsks' => '20',
                'prasyarat1' => 'IF101001',
                'prasyarat2' => '',
                'prasyarat3' => '',
                'prasyarat4' => '',
                'prasyarat5' => '',
                'prasyarat6' => '',
                'prasyarat7' => '',
                'prasyarat8' => '',
                'prasyarat9' => '',
                'prasyarat10' => '',
                'prasyaratgrade' => 'C',
                'kode_kurikulum' => 'KUR2025',
                'aktif' => true,
            ],
            [
                'kodemk' => 'IF101004',
                'nama' => 'Pemrograman Web',
                'sks' => '3',
                'nm_jenj_didik' => 'S1',
                'prasyaratsks' => '40',
                'prasyarat1' => 'IF101001',
                'prasyarat2' => 'IF101003',
                'prasyarat3' => '',
                'prasyarat4' => '',
                'prasyarat5' => '',
                'prasyarat6' => '',
                'prasyarat7' => '',
                'prasyarat8' => '',
                'prasyarat9' => '',
                'prasyarat10' => '',
                'prasyaratgrade' => 'C',
                'kode_kurikulum' => 'KUR2025',
                'aktif' => true,
            ],
            [
                'kodemk' => 'AF101005',
                'nama' => 'Kecerdasan Buatan',
                'sks' => '3',
                'nm_jenj_didik' => 'S1',
                'prasyaratsks' => '80',
                'prasyarat1' => 'IF101002',
                'prasyarat2' => 'IF101003',
                'prasyarat3' => '',
                'prasyarat4' => '',
                'prasyarat5' => '',
                'prasyarat6' => '',
                'prasyarat7' => '',
                'prasyarat8' => '',
                'prasyarat9' => '',
                'prasyarat10' => '',
                'prasyaratgrade' => 'C',
                'kode_kurikulum' => 'KUR2025',
                'aktif' => true,
            ],
        ]);
    }
}