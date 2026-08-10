<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DosenSeeder extends Seeder
{
    public function run(): void
    {
        $namas = [
        'Ahmad Fauzi',
        'Budi Santoso',
        'Citra Lestari',
        'Dewi Anggraini',
        'Eko Prasetyo',
        'Fajar Hidayat',
        'Gita Permata',
        'Hadi Saputra',
        'Indra Gunawan',
        'Joko Susilo',
        'Kartika Sari',
        'Lukman Hakim',
        'Maya Sari',
        'Nanda Putri',
        'Oki Setiawan',
        'Putri Ayu',
        'Qori Rahma',
        'Rudi Hartono',
        'Siti Aminah',
        'Tono Wijaya',
        'Umar Faruq',
        'Vina Oktavia',
        'Wahyu Nugroho',
        'Xaverius Bima',
        'Yuni Kartika',
        'Zainal Abidin',
        'Agus Salim',
        'Bella Novita',
        'Chandra Wijaya',
        'Dian Puspita',
        'Erwin Saputra',
        'Farah Nabila',
        'Galih Pratama',
        'Hendra Kurniawan',
        'Intan Permatasari',
        'Jihan Safira',
        'Kevin Pranata',
        'Lina Marlina',
        'Muhammad Rizki',
        'Nadia Rahmawati',
    ];
        
         for ($i = 41; $i <= 80; $i++) {
            if ($i == 19) {
                continue;
            }
            if ($i >= 41 && $i <= 45) {
                 $datas[] = 
                    ['nim_dosen' => '123456' . str_pad($i, 3, '0', STR_PAD_LEFT),
                    'nama' => $namas[$i - 41],
                    'nip' => '123456' . str_pad($i, 3, '0', STR_PAD_LEFT),
                    'user_id' => '31123' . str_pad($i, 3, '0', STR_PAD_LEFT),
                    'prodi' => 'C', // Teknik Informatika
                    'jabatan_struktural' => 'rektor',
            ];
            }
            if ($i >= 46 && $i <= 50) {
                 $datas[] = 
                    ['nim_dosen' => '12345678'  . str_pad($i, 3, '0', STR_PAD_LEFT),
                    'nama' => $namas[$i - 41],
                    'nip' => '123456' . str_pad($i, 3, '0', STR_PAD_LEFT),
                    'user_id' => '31123' . str_pad($i, 3, '0', STR_PAD_LEFT),
                    'prodi' => 'D', // Teknik Informatika
                    'jabatan_struktural' => 'rektor',
            ];
            }
            if ($i >= 51 && $i <= 55) {
                 $datas[] = 
                    ['nim_dosen' => '12345678'  . str_pad($i, 3, '0', STR_PAD_LEFT),
                    'nama' => $namas[$i - 41],
                    'nip' => '123456' . str_pad($i, 3, '0', STR_PAD_LEFT),
                    'user_id' => '31123' . str_pad($i, 3, '0', STR_PAD_LEFT),
                    'prodi' => 'F', // Teknik Informatika
                    'jabatan_struktural' => 'rektor',
            ];
            }
            if ($i >= 56 && $i <= 60) {
                 $datas[] = 
                    ['nim_dosen' => '12345678'  . str_pad($i, 3, '0', STR_PAD_LEFT),
                    'nama' => $namas[$i - 41],
                    'nip' => '123456' . str_pad($i, 3, '0', STR_PAD_LEFT),
                    'user_id' => '31123' . str_pad($i, 3, '0', STR_PAD_LEFT),
                    'prodi' => 'G', // Teknik Informatika
                    'jabatan_struktural' => 'rektor',
            ];
            }
            if ($i >= 61 && $i <= 65) {
                 $datas[] = 
                    ['nim_dosen' => '12345678'  . str_pad($i, 3, '0', STR_PAD_LEFT),
                    'nama' => $namas[$i - 41],
                    'nip' => '123456' . str_pad($i, 3, '0', STR_PAD_LEFT),
                    'user_id' => '31123' . str_pad($i, 3, '0', STR_PAD_LEFT),
                    'prodi' => 'H', // Teknik Informatika
                    'jabatan_struktural' => 'rektor',
            ];
            }
            if ($i >= 66 && $i <= 70) {
                 $datas[] = 
                    ['nim_dosen' => '12345678'  . str_pad($i, 3, '0', STR_PAD_LEFT),
                    'nama' => $namas[$i - 41],
                    'nip' => '123456' . str_pad($i, 3, '0', STR_PAD_LEFT),
                    'user_id' => '31123' . str_pad($i, 3, '0', STR_PAD_LEFT),
                    'prodi' => 'I', // Teknik Informatika
                    'jabatan_struktural' => 'rektor',
            ];
            }
            if ($i >= 71 && $i <= 75) {
                 $datas[] = 
                    ['nim_dosen' => '12345678'  . str_pad($i, 3, '0', STR_PAD_LEFT),
                    'nama' => $namas[$i - 41],
                    'nip' => '123456' . str_pad($i, 3, '0', STR_PAD_LEFT),
                    'user_id' => '31123' . str_pad($i, 3, '0', STR_PAD_LEFT),
                    'prodi' => 'K', // Teknik Informatika
                    'jabatan_struktural' => 'rektor',
            ];
            }
            if ($i >= 76 && $i <= 80) {
                 $datas[] = 
                    ['nim_dosen' => '12345678'  . str_pad($i, 3, '0', STR_PAD_LEFT),
                    'nama' => $namas[$i - 41],
                    'nip' => '123456' . str_pad($i, 3, '0', STR_PAD_LEFT),
                    'user_id' => '31123' . str_pad($i, 3, '0', STR_PAD_LEFT),
                    'prodi' => 'L', // Teknik Informatika
                    'jabatan_struktural' => 'rektor',
            ];
            }
 
         }
         foreach ($datas as $data) {
            DB::table('dosen')->insert($data);
         }   
    }
}