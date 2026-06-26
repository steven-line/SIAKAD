<?php

namespace Database\Seeders;

use App\Models\Mahasiswa;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MahasiswaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        
        Mahasiswa::create([
            'nrp' => '31128888',
            'dosen_wali' => '12345678',
            'status_blokir' => 'BELUM_KRS',
            'prodi' => 'IF'
        ]);

        Mahasiswa::create([
            'nrp' => '31126666',
            'dosen_wali' => '12345678',
            'status_blokir' => 'BELUM_KRS',
            'prodi' => 'IF'
        ]);

        Mahasiswa::create([
            'nrp' => '31125555',
            'dosen_wali' => '12345678',
            'status_blokir' => 'BELUM_KRS',
            'prodi' => 'SI'
        ]);
    }
}
