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
            'nrp' => '31123001',
            'nama' => 'Budi Santoso',
            'dosen_wali' => 'D001', // ini harus ID dari tabel dosens
            'status_blokir' => 'KRS, Terkunci Sistem, Harus Ke Bakeu',
        ]);

        Mahasiswa::create([
            'nrp' => '31123002',
            'nama' => 'Siti Aminah',
            'dosen_wali' => 'D002',
            'status_blokir' => 'Telah disetujui Dosen Wali',
        ]);

        Mahasiswa::create([
            'nrp' => '31123003',
            'nama' => 'Andi Wijaya',
            'dosen_wali' => 'D003',
            'status_blokir' => 'Telah disetujui mahasiswa',
        ]);
    }
}
