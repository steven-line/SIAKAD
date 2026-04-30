<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class KaprodiSeeder extends Seeder
{
    public function run(): void
    {
        $kaprodis = [
            ['username' => 'kaprodi_if', 'prodi' => 'Informatika'],
            ['username' => 'kaprodi_ars', 'prodi' => 'Arsitektur'],
            ['username' => 'kaprodi_el', 'prodi' => 'Elektro'],
            ['username' => 'kaprodi_sp', 'prodi' => 'Sipil'],
            ['username' => 'kaprodi_mnj', 'prodi' => 'Manajemen'],
            ['username' => 'kaprodi_ak', 'prodi' => 'Akuntansi'],
            ['username' => 'kaprodi_md', 'prodi' => 'Mandarin'],
            ['username' => 'kaprodi_ing', 'prodi' => 'Inggris'],
        ];

        foreach ($kaprodis as $kp) {
            User::updateOrCreate(
                ['username' => $kp['username']],
                [
                    'password' => Hash::make('hello123'),
                    'level' => 2,
                    'prodi' => $kp['prodi'],
                    'firstlogin' => Carbon::now(),
                    'lastlogin' => Carbon::now(),
                    'aksesnilai' => 1,
                    'aktif' => 1,
                    'sks' => 0,
                    'validasi' => 1,
                    'pataum' => 'o',
                ]
            );
        }
    }
}