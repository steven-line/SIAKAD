<?php

namespace Database\Seeders;

use App\Models\Mahasiswa;
use Illuminate\Database\Seeder;

class MahasiswaSeeder extends Seeder
{
    public function run(): void
    {
        $prodis = ['C', 'D', 'F', 'G', 'H', 'I', 'K', 'L'];

        $counter = 0;

        for ($i = 1; $i <= 40; $i++) {

            if ($i == 19) {
                continue;
            }

            if ($counter >= 39) {
                break;
            }

            $nrp = '31123' . str_pad($i, 3, '0', STR_PAD_LEFT);

            $prodiIndex = floor($counter / 5);

            if ($prodiIndex >= 7) {
                $prodiIndex = 7; // L
            }

            $prodi = $prodis[$prodiIndex];

            Mahasiswa::create([
                'nrp' => $nrp,
                'dosen_wali' => '123456' . str_pad(41, 3, '0', STR_PAD_LEFT),
                'tahun_masuk' => 2023,
                'status_blokir' => 'BELUM_KRS',
                'prodi' => $prodi,
            ]);

            $counter++;
        }
    }
}