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
        // FAKULTAS EKONOMI (B)
        [
            'kode_jurusan' => 'MN1',
            'nama_jurusan' => 'Manajemen',
            'program_pendidikan' => 'S1',
            'sk_ban' => '004/SK/BAN-PT/2024',
            'keterangan' => null,
            'kode_fakultas' => 'B',
        ],
        [
            'kode_jurusan' => 'AK1',
            'nama_jurusan' => 'Akuntansi',
            'program_pendidikan' => 'S1',
            'sk_ban' => '005/SK/BAN-PT/2024',
            'keterangan' => null,
            'kode_fakultas' => 'B',
        ],

        // FAKULTAS TEKNIK (E)
        [
            'kode_jurusan' => 'TS1',
            'nama_jurusan' => 'Teknik Sipil',
            'program_pendidikan' => 'S1',
            'sk_ban' => '003/SK/BAN-PT/2024',
            'keterangan' => null,
            'kode_fakultas' => 'E',
        ],
        [
            'kode_jurusan' => 'AR1',
            'nama_jurusan' => 'Arsitektur',
            'program_pendidikan' => 'S1',
            'sk_ban' => '006/SK/BAN-PT/2024',
            'keterangan' => null,
            'kode_fakultas' => 'E',
        ],
        [
            'kode_jurusan' => 'TE1',
            'nama_jurusan' => 'Teknik Elektro',
            'program_pendidikan' => 'S1',
            'sk_ban' => '007/SK/BAN-PT/2024',
            'keterangan' => null,
            'kode_fakultas' => 'E',
        ],
        [
            'kode_jurusan' => 'TI1',
            'nama_jurusan' => 'Teknik Informatika',
            'program_pendidikan' => 'S1',
            'sk_ban' => '001/SK/BAN-PT/2024',
            'keterangan' => null,
            'kode_fakultas' => 'E',
        ],

        // FAKULTAS SASTRA (J)
        [
            'kode_jurusan' => 'SI1',
            'nama_jurusan' => 'Sastra Inggris',
            'program_pendidikan' => 'S1',
            'sk_ban' => '008/SK/BAN-PT/2024',
            'keterangan' => null,
            'kode_fakultas' => 'J',
        ],
        [
            'kode_jurusan' => 'BM1',
            'nama_jurusan' => 'Pendidikan Bahasa Mandarin',
            'program_pendidikan' => 'S1',
            'sk_ban' => '009/SK/BAN-PT/2024',
            'keterangan' => null,
            'kode_fakultas' => 'J',
        ],
    ]);
}
}