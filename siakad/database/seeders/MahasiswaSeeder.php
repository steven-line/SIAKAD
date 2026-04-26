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
            'nrp' => '5026221001',
            'nama' => 'Budi Santoso',
            'dosen_wali' => '31123012', // ini harus ID dari tabel dosens
            'status_blokir' => 'KRS, Terkunci Sistem, Harus Ke Bakeu',
        ]);

        Mahasiswa::create([
            'nrp' => '5026221002',
            'nama' => 'Siti Aminah',
            'dosen_wali' => '31123012',
            'status_blokir' => 'Telah disetujui Dosen Wali',
        ]);

        Mahasiswa::create([
            'nrp' => '5026221003',
            'nama' => 'Andi Wijaya',
            'dosen_wali' => '31123012',
            'status_blokir' => 'Telah disetujui mahasiswa',
        ]);
    }
}
