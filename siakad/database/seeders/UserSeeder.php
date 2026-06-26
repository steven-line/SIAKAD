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
                'username' => '31129999',
                'password' => Hash::make('hello12346'),
                'firstlogin' => Carbon::now(),
                'lastlogin' => Carbon::now(),
                'aksesnilai' => 0,
                'aktif' => 0,
                'sks' => 110,
                'validasi' => 1,
                'pataum' => 'P',
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
                'pataum' => 'P',
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
                'pataum' => 'P',
            ],
            [
                'username' => '31123019',
                'password' => Hash::make('hello12346'),
                'firstlogin' => Carbon::now(),
                'lastlogin' => Carbon::now(),
                'aksesnilai' => 0,
                'aktif' => 0,
                'sks' => 110,
                'validasi' => 1,
                'pataum' => 'P',
            ],
            [
                'username' => '31120000',
                'password' => Hash::make('hello12346'),
                'firstlogin' => Carbon::now(),
                'lastlogin' => Carbon::now(),
                'aksesnilai' => 0,
                'aktif' => 0,
                'sks' => 110,
                'validasi' => 1,
                'pataum' => 'P',
            ],
            [
                'username' => '31126666',
                'password' => Hash::make('hello12346'),
                'firstlogin' => Carbon::now(),
                'lastlogin' => Carbon::now(),
                'aksesnilai' => 0,
                'aktif' => 0,
                'sks' => 110,
                'validasi' => 1,
                'pataum' => 'P',
            ],
            [
                'username' => '31125555',
                'password' => Hash::make('hello12346'),
                'firstlogin' => Carbon::now(),
                'lastlogin' => Carbon::now(),
                'aksesnilai' => 0,
                'aktif' => 0,
                'sks' => 110,
                'validasi' => 1,
                'pataum' => 'P',
            ],
        ];

        foreach ($datas as $data) {
            // 1. Buat user
            $user = User::create($data);
        }
    }
}