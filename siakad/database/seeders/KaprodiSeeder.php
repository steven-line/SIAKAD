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
        User::create([
            'username' => 'kaprodi01',
            'password' => Hash::make('hello12346'),
            'level' => 2, // 🔥 ini penting (role kaprodi)
            'firstlogin' => Carbon::now(),
            'lastlogin' => Carbon::now(),
            'aksesnilai' => 1,
            'aktif' => 1,
            'sks' => 0,
            'validasi' => 1,
            'pataum' => 'o',
        ]);
    }
}