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
<<<<<<< HEAD
=======
               
>>>>>>> 9830e8b0dd12445de582382663d9bed2ea21f49e
                'penawaran_id' => 1,
                'status' => 'BARU',
                'sesi' => 'A',
                'tanggal' => now()->toDateString(),
                'jam' => now()->toTimeString(),
                'validasi' => 1,
                'hari' => 'Senin',
                'mulaipukul' => '08:00:00',
                'selesaipukul' => '10:30:00',
                'ip_address' => '127.0.0.1',
                'sks' => 3,
                'pataum' => 'P',
            ],

            [
                'nrp' => '31129999',
<<<<<<< HEAD
=======
              
>>>>>>> 9830e8b0dd12445de582382663d9bed2ea21f49e
                'penawaran_id' => 2,
                'status' => 'BARU',
                'sesi' => 'A',
                'tanggal' => now()->toDateString(),
                'jam' => now()->toTimeString(),
                'validasi' => 1,
                'hari' => 'Selasa',
                'mulaipukul' => '08:00:00',
                'selesaipukul' => '10:30:00',
                'ip_address' => '127.0.0.1',
                'sks' => 3,
                'pataum' => 'P',
            ],

            [
                'nrp' => '31128888',
<<<<<<< HEAD
=======
   
>>>>>>> 9830e8b0dd12445de582382663d9bed2ea21f49e
                'penawaran_id' => 1,
                'status' => 'BARU',
                'sesi' => 'A',
                'tanggal' => now()->toDateString(),
                'jam' => now()->toTimeString(),
                'validasi' => 0,
                'hari' => 'Senin',
                'mulaipukul' => '08:00:00',
                'selesaipukul' => '10:30:00',
                'ip_address' => '127.0.0.1',
                'sks' => 3,
                'pataum' => 'P',
            ],

            [
                'nrp' => '31127777',
<<<<<<< HEAD
=======
         
>>>>>>> 9830e8b0dd12445de582382663d9bed2ea21f49e
                'penawaran_id' => 5,
                'status' => 'AMBIL',
                'sesi' => 'A',
                'tanggal' => now()->toDateString(),
                'jam' => now()->toTimeString(),
                'validasi' => 1,
                'hari' => 'Jumat',
                'mulaipukul' => '09:00:00',
                'selesaipukul' => '11:30:00',
                'ip_address' => '127.0.0.1',
                'sks' => 3,
                'pataum' => 'M',
            ],

        ]);
    }
}