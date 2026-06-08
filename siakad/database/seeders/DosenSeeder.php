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
            ['nim_dosen' => 'D001'],
            [
                'nama' => 'Yonatan Widianto',
                'nip' => '19800101',
                'user_id' => '31123012',
                'prodi' => 'IF',
            ]
        );

        DB::table('dosen')->updateOrInsert(
            ['nim_dosen' => 'D002'],
            [
                'nama' => 'Darmanto',
                'nip' => '19800202',
                'user_id' => '31123019',
                'prodi' => 'ARS',
            ]
        );

        DB::table('dosen')->updateOrInsert(
            ['nim_dosen' => 'D003'],
            [
                'nama' => 'Erwin',
                'nip' => '19800303',
                'user_id' => '31123003',
                'prodi' => 'ING',
            ]
        );
    }
}