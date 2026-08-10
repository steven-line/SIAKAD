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
        $datas = [];

        // Generate username 31123001 - 31123080
        for ($i = 1; $i <= 81; $i++) {
            $datas[] = [
                'username' => '31123' . str_pad($i, 3, '0', STR_PAD_LEFT),
                'password' => Hash::make('hello12346'),
                'firstlogin' => Carbon::now(),
                'lastlogin' => Carbon::now(),
                'aksesnilai' => 0,
                'aktif' => 1,
                'sks' => 110,
                'validasi' => 1,
                'pataum' => 'P',
            ];
        }

        foreach ($datas as $data) {
            User::create($data);
        }
    }
}

/** 
 * Prodi = 
 * C = Manajemen  
 * D = Akuntansi  
 * F = Teknik Sipil  
 * G = Teknil Arsitektur  
 * H = Teknil Elektro 
 * I = Teknik Informatika 
 * K = Sastra Inggris 
 * L = Pendidikan Bahasa Mandarin 
 * Mahasiswa = 40
 * Dosen = 40 
 * Kaprodi = 8
 * kodeMK = 
 * A : UNIVERSITAS (MKU)
 * B : FAKULTAS EKONOMI
 * C : PRODI S1 MANAJEMEN
 * D : PRODI S1 AKUNTANSI
 * E : FAKULTAS TEKNIK
 * F : PRODI S1 TEKMK SIPL 
 * G : PRODI S1 ARSITEKTUR 
 * H : PRODI S1 TEKNIK ELEKTRO 
 * I : PRODI S1 TEKNIK INFORMATIKA 
 * J : FAKULTAS SASTRA DAN PENDIDIKAN BAHASA 
 * K : PRODI S1 SASTRA INGGRIS 
 * L : PRODI S1 PENDIDIKAN BAHASA MANDARIN 
 * MK = 48
 * Kurkulum = 7
 * 
*/