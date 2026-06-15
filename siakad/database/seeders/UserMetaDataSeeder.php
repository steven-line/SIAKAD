<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\UserMetadata;

class UserMetaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        UserMetadata::insert([
            [
                'username'   => '31129999',
                'dosen_wali' => 'D001',
            ],
            [
                'username'   => '31128888',
                'dosen_wali' => 'D002',
            ],
            [
                'username'   => '31127777',
                'dosen_wali' => 'D003',
            ],
        ]);
    }
}