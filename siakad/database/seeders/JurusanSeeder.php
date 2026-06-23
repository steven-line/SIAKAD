<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JurusanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('jurusan')->insert([
            [
                'kode_jurusan' => 'TI1',
                'nama_jurusan' => 'Teknik Informatika',
                'program_pendidikan' => 'S1',
                'sk_ban' => '001/SK/BAN-PT/2024',
                'keterangan' => null,
                'fakultas' => 'FTI',
            ],
            [
                'kode_jurusan' => 'SI1',
                'nama_jurusan' => 'Sistem Informasi',
                'program_pendidikan' => 'S1',
                'sk_ban' => '002/SK/BAN-PT/2024',
                'keterangan' => null,
                'fakultas' => 'FTI',
            ],
            [
                'kode_jurusan' => 'TK1',
                'nama_jurusan' => 'Teknik Sipil',
                'program_pendidikan' => 'S1',
                'sk_ban' => '003/SK/BAN-PT/2024',
                'keterangan' => null,
                'fakultas' => 'FTE',
            ],
            [
                'kode_jurusan' => 'MM1',
                'nama_jurusan' => 'Manajemen',
                'program_pendidikan' => 'S1',
                'sk_ban' => '004/SK/BAN-PT/2024',
                'keterangan' => null,
                'fakultas' => 'FEB',
            ],
            [
                'kode_jurusan' => 'AK1',
                'nama_jurusan' => 'Akuntansi',
                'program_pendidikan' => 'S1',
                'sk_ban' => '005/SK/BAN-PT/2024',
                'keterangan' => null,
                'fakultas' => 'FEB',
            ],
        ]);
    }
}