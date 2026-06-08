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
                'kodemk' => 'FT1006',
                'nama' => 'ALJABAR LINEAR & MATRIKS',
                'sks' => 3,
                'nm_jenj_didik' => 'S1',
                'kode_prodi_dikti' => '55201',
                'kode_kurikulum' => 'KUR2024'
            ],

            [
                'kodemk' => 'TF3202',
                'nama' => 'PEMROGRAMAN BERORIENTASI OBYEK',
                'sks' => 3,
                'nm_jenj_didik' => 'S1',
                'kode_prodi_dikti' => '55201',
                'kode_kurikulum' => 'KUR2024'
            ],

            [
                'kodemk' => 'TF4602',
                'nama' => 'MACHINE LEARNING',
                'sks' => 3,
                'nm_jenj_didik' => 'S1',
                'kode_prodi_dikti' => '55201',
                'kode_kurikulum' => 'KUR2024'
            ],

        ]);
    }
}