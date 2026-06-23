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
            'nrp' => '31129999',
            'dosen_wali' => 'D002', // ini harus ID dari tabel dosens
            'status_blokir' => 'MENUNGGU_VALIDASI',
            'prodi' => 'IF'
        ]);

        Mahasiswa::create([
            'nrp' => '31128888',
            'dosen_wali' => 'D002',
            'status_blokir' => 'BELUM_KRS',
            'prodi' => 'IF'
        ]);
        
        Mahasiswa::create([
            'nrp' => '31127777',
            'dosen_wali' => 'D002',
            'status_blokir' => 'BELUM_KRS',
            'prodi' => 'IF'
        ]);

    }
}
