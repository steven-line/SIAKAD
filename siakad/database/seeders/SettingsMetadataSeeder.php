<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SettingsMetadata;

class SettingsMetadataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        SettingsMetadata::insert([
            [
                'meta_settings' => 'PERIODE_AKTIF',
                'id_meta_settings' => 1,
                'meta_key' => 'tahun_ajaran',
                'meta_value' => '2025/2026',
            ],
            [
                'meta_settings' => 'PERIODE_AKTIF',
                'id_meta_settings' => 1,
                'meta_key' => 'semester',
                'meta_value' => 'GENAP',
            ],
            [
                'meta_settings' => 'KRS',
                'id_meta_settings' => 2,
                'meta_key' => 'max_sks',
                'meta_value' => '24',
            ],
            [
                'meta_settings' => 'KRS',
                'id_meta_settings' => 2,
                'meta_key' => 'status_pengisian',
                'meta_value' => 'AKTIF',
            ],
            [
                'meta_settings' => 'PERWALIAN',
                'id_meta_settings' => 3,
                'meta_key' => 'status_perwalian',
                'meta_value' => 'AKTIF',
            ],
        ]);
    }
}