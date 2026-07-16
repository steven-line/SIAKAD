<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KurikulumSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('kurikulum')->insert([
            [
                'kode_kurikulum' => 'KUR2018',
                'nama_kurikulum' => 'Kurikulum 2018',
                'aktif' => false,
                'deskripsi' => 'Kurikulum akademik yang berlaku mulai tahun 2018.',
                'tahun_mulai_berlaku' => 2018,
                'tahun_selesai_berlaku' => 2021,
                'kode_prodi' => 'I' // Teknik Informatika
            ],
            [
                'kode_kurikulum' => 'KUR2022',
                'nama_kurikulum' => 'Kurikulum Merdeka 2022',
                'aktif' => false,
                'deskripsi' => 'Kurikulum berbasis Merdeka Belajar.',
                'tahun_mulai_berlaku' => 2022,
                'tahun_selesai_berlaku' => 2024,
                'kode_prodi' => 'C' // Manajemen
            ],
            [
                'kode_kurikulum' => 'KUR2025',
                'nama_kurikulum' => 'Kurikulum 2025',
                'aktif' => true,
                'deskripsi' => 'Kurikulum terbaru yang saat ini digunakan.',
                'tahun_mulai_berlaku' => 2025,
                'tahun_selesai_berlaku' => 2030,
                'kode_prodi' => 'D' // Akuntansi
            ],
        ]);
    }
}