<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([

            // User & Role
            RoleAndPermissionsSeeder::class,
            UserSeeder::class,
           
            FakultasSeeder::class,
          
            DosenSeeder::class,
            JurusanSeeder::class,
            ProdiSeeder::class,
            KurikulumSeeder::class,
            MkSeeder::class,
            PeriodeSeeder::class,
            SemesterSeeder::class,
            PenawaranSeeder::class,
            MahasiswaSeeder::class,
            BiodataSeeder::class,
            RegistrasiSeeder::class,
            KrsSeeder::class,


        ]);
    }
}