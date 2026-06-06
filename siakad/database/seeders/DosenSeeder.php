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
                'nama' => 'Dr. Budi Santoso',
                'nip' => '19800101'
            ]
        );

        DB::table('dosen')->updateOrInsert(
            ['nim_dosen' => 'D002'],
            [
                'nama' => 'Ir. Andi Pratama',
                'nip' => '19800202'
            ]
        );

        DB::table('dosen')->updateOrInsert(
            ['nim_dosen' => 'D003'],
            [
                'nama' => 'Siti Rahmawati, S.Kom., M.Kom',
                'nip' => '19800303',
                'user_id' => '31123019'
            ]
        );
    }
}