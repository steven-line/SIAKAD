<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RegistrasiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('registrasi')->insert([

            [
                'nrp' => '31128888',
               
                'penawaran_id' => 1,
                'status' => 'BARU',
                'tanggal' => now()->toDateString(),
                'jam' => now()->toTimeString(),
       

              
            ],

        ]);
    }
}