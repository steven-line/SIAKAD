<?php

namespace Database\Seeders;

use App\Models\Dosen;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DosenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Dosen::create(['nim_dosen' => '31123012', 
                       'nip' => '31123012', 
                       'nama' => 'Robby Kurniawan']);
    }
}
