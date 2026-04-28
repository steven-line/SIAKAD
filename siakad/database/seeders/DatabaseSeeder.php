<?php

namespace Database\Seeders;

use App\Models\User;
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
        // User::factory(10)->create();

        //User::factory()->create([
            //'username' => '31123019',
            //'password' => 'hello12345',
            //'level' => '1',
            
        //]);
        // ✅ TAMBAHAN (Seeder lain biar kepanggil)
        $this->call([
            UserSeeder::class,
            KaprodiSeeder::class,
        ]);
    }
}