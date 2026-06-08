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
            ProdiSeeder::class,
            RoleAndPermissionsSeeder::class,
            UserSeeder::class,
            KurikulumSeeder::class,
            // Master Data
            DosenSeeder::class,
            MkSeeder::class,

            // Data Akademik
            JurusanSeeder::class,
            PenawaranSeeder::class,



        ]);
    }
}