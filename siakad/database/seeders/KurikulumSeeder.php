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
                'kode_kurikulum' => 'KUR2025C',
                'nama_kurikulum' => 'Kurikulum 2025',
                'aktif' => true,
                'deskripsi' => 'Kurikulum terbaru yang saat ini digunakan.',
                'tahun_mulai_berlaku' => 2025,
                'tahun_selesai_berlaku' => 2030,
                'kode_prodi' => 'C' // Manajemen
            ],
            [
                'kode_kurikulum' => 'KUR2025D',
                'nama_kurikulum' => 'Kurikulum 2025',
                'aktif' => true,
                'deskripsi' => 'Kurikulum terbaru yang saat ini digunakan.',
                'tahun_mulai_berlaku' => 2025,
                'tahun_selesai_berlaku' => 2030,
                'kode_prodi' => 'D' // Akuntansi
            ],
            [
                'kode_kurikulum' => 'KUR2025F',
                'nama_kurikulum' => 'Kurikulum 2025',
                'aktif' => true,
                'deskripsi' => 'Kurikulum terbaru yang saat ini digunakan.',
                'tahun_mulai_berlaku' => 2025,
                'tahun_selesai_berlaku' => 2030,
                'kode_prodi' => 'F' // Teknik Sipil
            ],
                        [
                'kode_kurikulum' => 'KUR2025G',
                'nama_kurikulum' => 'Kurikulum 2025',
                'aktif' => true,
                'deskripsi' => 'Kurikulum terbaru yang saat ini digunakan.',
                'tahun_mulai_berlaku' => 2025,
                'tahun_selesai_berlaku' => 2030,
                'kode_prodi' => 'G' // Teknik Arsitektur
            ],
            [
                'kode_kurikulum' => 'KUR2025H',
                'nama_kurikulum' => 'Kurikulum 2025',
                'aktif' => true,
                'deskripsi' => 'Kurikulum terbaru yang saat ini digunakan.',
                'tahun_mulai_berlaku' => 2025,
                'tahun_selesai_berlaku' => 2030,
                'kode_prodi' => 'H' // Teknik Elektro
            ],
            [
                'kode_kurikulum' => 'KUR2025I',
                'nama_kurikulum' => 'Kurikulum 2025',
                'aktif' => true,
                'deskripsi' => 'Kurikulum terbaru yang saat ini digunakan.',
                'tahun_mulai_berlaku' => 2025,
                'tahun_selesai_berlaku' => 2030,
                'kode_prodi' => 'I' // Teknik Informatika
            ],
                        [
                'kode_kurikulum' => 'KUR2025K',
                'nama_kurikulum' => 'Kurikulum 2025',
                'aktif' => true,
                'deskripsi' => 'Kurikulum terbaru yang saat ini digunakan.',
                'tahun_mulai_berlaku' => 2025,
                'tahun_selesai_berlaku' => 2030,
                'kode_prodi' => 'K' // Inggris
            ],
            [
                'kode_kurikulum' => 'KUR2025L',
                'nama_kurikulum' => 'Kurikulum 2025',
                'aktif' => true,
                'deskripsi' => 'Kurikulum terbaru yang saat ini digunakan.',
                'tahun_mulai_berlaku' => 2025,
                'tahun_selesai_berlaku' => 2030,
                'kode_prodi' => 'L' // Mandarin
            ],
        ]);
    }
}