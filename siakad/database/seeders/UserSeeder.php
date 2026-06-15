<?php

namespace Database\Seeders;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $datas = [
            [
                'username' => '3112999',
                'password' => Hash::make('hello12346'),
                'firstlogin' => Carbon::now(),
                'lastlogin' => Carbon::now(),
                'aksesnilai' => 0,
                'aktif' => 0,
                'sks' => 110,
                'validasi' => 1,
                'pataum' => 'o',
            ],
            [
                'username' => '31128888',
                'password' => Hash::make('hello12346'),
                'firstlogin' => Carbon::now(),
                'lastlogin' => Carbon::now(),
                'aksesnilai' => 0,
                'aktif' => 0,
                'sks' => 110,
                'validasi' => 1,
                'pataum' => 'o',
            ],
            [
                'username' => '31127777',
                'password' => Hash::make('hello12346'),
                'firstlogin' => Carbon::now(),
                'lastlogin' => Carbon::now(),
                'aksesnilai' => 0,
                'aktif' => 0,
                'sks' => 110,
                'validasi' => 1,
                'pataum' => 'o',
            ]
        ];

        foreach ($datas as $data) {
            // 1. Buat user
            $user = User::create($data);
            
            // 2. Assign role mahasiswa menggunakan Spatie
            // Pastikan role 'mahasiswa' sudah ada di database/seeder role Anda
            $user->assignRole('admin');
        }
    }
}