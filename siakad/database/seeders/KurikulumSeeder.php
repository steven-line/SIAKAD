<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KurikulumSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('kurikulum')->insert([

            [
                'kode_kurikulum' => 'KUR2020',
                'nama_kurikulum' => 'Kurikulum Merdeka 2020',
            ],

            [
                'kode_kurikulum' => 'KUR2024',
                'nama_kurikulum' => 'Kurikulum OBE 2024',
            ],

        ]);
    }
}