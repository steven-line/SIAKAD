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
                'nrp' => '31129999',
               
                'penawaran_id' => 1,
                'status' => 'AMBIL',
                'tanggal' => now()->toDateString(),
                'jam' => now()->toTimeString(),
       

              
            ],

            [
                'nrp' => '31129999',
              
                'penawaran_id' => 2,
                'status' => 'AMBIL',
  
                'tanggal' => now()->toDateString(),
                'jam' => now()->toTimeString(),
               
              
            ],

            [
                'nrp' => '31128888',
   
                'penawaran_id' => 1,
                'status' => 'AMBIL',
          
                'tanggal' => now()->toDateString(),
                'jam' => now()->toTimeString(),
        
              
            ],

            [
                'nrp' => '31127777',
         
                'penawaran_id' => 5,
                'status' => 'AMBIL',
              
                'tanggal' => now()->toDateString(),
                'jam' => now()->toTimeString(),
               
            ],

        ]);
    }
}