<?php

namespace Database\Seeders;

use App\Models\Mahasiswa;
use Illuminate\Database\Seeder;

class MahasiswaSeeder extends Seeder
{
    public function run(): void
    {
        Mahasiswa::create([
            'nrp' => '31128888',
            'dosen_wali' => '12345678',
            'status_blokir' => 'BELUM_KRS',
            'prodi' => 'I' // Teknik Informatika
        ]);

        Mahasiswa::create([
            'nrp' => '31126666',
            'dosen_wali' => '12345678',
            'status_blokir' => 'BELUM_KRS',
            'prodi' => 'I' // Teknik Informatika
        ]);

        Mahasiswa::create([
            'nrp' => '31125555',
            'dosen_wali' => '12345678',
            'status_blokir' => 'BELUM_KRS',
            'prodi' => 'K' // Sastra Inggris (pengganti SI yang sudah tidak ada)
        ]);
    }
}