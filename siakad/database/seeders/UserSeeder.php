<?php

namespace Database\Seeders;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
           ['username' => '31123019',
            'password' => Hash::make('hello12346'),
            'level' => 1,
            'firstlogin' => Carbon::now(),
            'lastlogin' => Carbon::now(),
            'aksesnilai' => 0,
            'aktif' => 0,
            'sks' => 110,
            'validasi' => 1,
            'pataum' => 'o',],

            ['username' => '31123012',
            'password' => Hash::make('hello12346'),
            'level' => 2,
            'firstlogin' => Carbon::now(),
            'lastlogin' => Carbon::now(),
            'aksesnilai' => 0,
            'aktif' => 0,
            'sks' => 110,
            'validasi' => 1,
            'pataum' => 'o',],

            ['username' => '31123003',
            'password' => Hash::make('hello12346'),
            'level' => 3,
            'firstlogin' => Carbon::now(),
            'lastlogin' => Carbon::now(),
            'aksesnilai' => 0,
            'aktif' => 0,
            'sks' => 110,
            'validasi' => 1,
            'pataum' => 'o',]
            
            ];

            foreach ($datas as $data){
                User::create($data);
            }
            

            
    }
    
    
}
