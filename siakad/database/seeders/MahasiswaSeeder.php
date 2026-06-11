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
            'dosen_wali' => '12345678', // ini harus ID dari tabel dosens
            'status_blokir' => 'KRS, Terkunci Sistem, Harus Ke Bakeu',
            'prodi' => 'IF'
        ]);

        Mahasiswa::create([
            'nrp' => '31128888',
            'dosen_wali' => '12345678',
            'status_blokir' => 'Telah disetujui Dosen Wali',
            'prodi' => 'IF'
        ]);

        Mahasiswa::create([
            'nrp' => '31127777',
            'dosen_wali' => '87654321',
            'status_blokir' => 'Telah disetujui mahasiswa',
            'prodi' => 'ING'
        ]);
    }
}
