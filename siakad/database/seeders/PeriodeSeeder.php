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
                'created_at'      => now(),
                'updated_at'      => now(),
            ],
            [
                'tahun_ajaran'    => '2025/2026',
                'tanggal_mulai'   => '2025-02-01',
                'tanggal_selesai' => '2025-07-31',
                'created_at'      => now(),
                'updated_at'      => now(),
            ],
            [
                'tahun_ajaran'    => '2025/2026',
                'tanggal_mulai'   => '2025-08-01',
                'tanggal_selesai' => '2026-01-31',
                'created_at'      => now(),
                'updated_at'      => now(),
            ],
            [
                'tahun_ajaran'    => '2026/2027',
                'tanggal_mulai'   => '2026-02-01',
                'tanggal_selesai' => '2026-07-31',
                'created_at'      => now(),
                'updated_at'      => now(),
            ],
        ]);
    }
}