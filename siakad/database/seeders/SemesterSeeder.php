<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SemesterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('semester')->insert([
            [
                'periode_id' => 1,
                'jenis' => 'Ganjil',
                'aktif' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'periode_id' => 2,
                'jenis' => 'Genap',
                'aktif' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'periode_id' => 3,
                'jenis' => 'Ganjil',
                'aktif' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'periode_id' => 4,
                'jenis' => 'Genap',
                'aktif' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}