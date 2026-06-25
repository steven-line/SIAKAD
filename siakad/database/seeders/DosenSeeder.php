<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DosenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('dosen')->updateOrInsert(
            ['nim_dosen' => '12345678'],
            [
                'nama' => 'Yonatan Widianto',
                'nip' => '19800101',
                'user_id' => '31127777',
                'prodi' => 'IF', // Ada di ProdiSeeder (Teknik Informatika)
                'jabatan_struktural' => 'rektor',
            ]
        );

        DB::table('dosen')->updateOrInsert(
            ['nim_dosen' => '87654321'],
            [
                'nama' => 'Darmanto',
                'nip' => '19800202',
                'user_id' => '31129999',
                'prodi' => 'SI', // DISAMAKAN: Berubah dari ARS ke SI
                'jabatan_struktural' => 'dosen biasa',
            ]
        );

        DB::table('dosen')->updateOrInsert(
            ['nim_dosen' => '13524679'],
            [
                'nama' => 'Erwin',
                'nip' => '19800303',
                'user_id' => '31120000',
                'prodi' => 'MNJ', // DISAMAKAN: Berubah dari ING ke MNJ
                'jabatan_struktural' => 'yayasan',
            ]
        );
    }
}
