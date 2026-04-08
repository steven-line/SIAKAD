<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class JadwalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Jadwal::create([
            'kode_mk' => 'MK001',
            'nama_mk' => 'Matematika Diskrit',
            'kelas' => 'A',
            'hari' => 'Senin',
            'jam_mulai' => '08:00:00',
            'jam_selesai' => '10:00:00',
        ]);

        \App\Models\Jadwal::create([
            'kode_mk' => 'MK002',
            'nama_mk' => 'Algoritma dan Pemrograman',
            'kelas' => 'B',
            'hari' => 'Selasa',
            'jam_mulai' => '10:00:00',
            'jam_selesai' => '12:00:00',
        ]);

        \App\Models\Jadwal::create([
            'kode_mk' => 'MK003',
            'nama_mk' => 'Basis Data',
            'kelas' => 'C',
            'hari' => 'Rabu',
            'jam_mulai' => '13:00:00',
            'jam_selesai' => '15:00:00',
        ]);
    }
}
