<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PeriodeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('periode')->insert([
            [
                'tahun_ajaran'    => '2024/2025',
                'tanggal_mulai'   => '2024-08-01',
                'tanggal_selesai' => '2025-01-31',
                'aktif' => false,
                'created_at'      => now(),
                'updated_at'      => now(),
            ],
           
        ]);
    }
}