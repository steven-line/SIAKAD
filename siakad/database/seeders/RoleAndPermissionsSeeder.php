<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RoleAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        // ======================
        // CLEAR CACHE SPATIE
        // ======================
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // ======================
        // RESET (full reset)
        // ======================
        Role::query()->delete();
        Permission::query()->delete();

        // ======================
        // ROLE
        // ======================
        $adminRole     = Role::firstOrCreate(['name' => 'admin']);
        $dosenRole     = Role::firstOrCreate(['name' => 'dosen']);
        $mahasiswaRole = Role::firstOrCreate(['name' => 'mahasiswa']);
        $kaprodiRole   = Role::firstOrCreate(['name' => 'kaprodi']);
        $dosenWaliRole = Role::firstOrCreate(['name' => 'dosen-wali']);

        // ======================
        // PERMISSIONS
        // ======================
        $permissions = [
            // Mahasiswa
            'biodata.view',
            'penawaran.view',
            'penawaran.daftar',
            'krs.view',
            'krs.submit',
            'nilai_krs.view',
            'khs.view',
            'transkrip.view',

            // Dosen (base, diwarisi kaprodi & dosen-wali)
            'jadwal.view_sendiri',
            'nilai.input',

            // Kaprodi (tambahan)
            'penawaran.manage',
            'jadwal.view_umum',

            // Dosen Wali (tambahan)
            'perwalian.manage',
            'biodata_mahasiswa.view',
            'nilai_anak_wali.view',
            'khs_anak_wali.view',
            'tawaran_mk.view',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate([
                'name' => $permission,
                'guard_name' => 'web',
            ]);
        }

        // ======================
        // ASSIGN PER ROLE
        // ======================

        // MAHASISWA
        $mahasiswaPermissions = [
            'biodata.view',
            'penawaran.view',
            'penawaran.daftar',
            'krs.view',
            'krs.submit',
            'nilai_krs.view',
            'khs.view',
            'transkrip.view',
        ];
        $mahasiswaRole->syncPermissions($mahasiswaPermissions);

        // DOSEN (base permissions)
        $dosenPermissions = [
            'jadwal.view_sendiri',
            'nilai.input',
            'penawaran.view',
        ];
        $dosenRole->syncPermissions($dosenPermissions);

        // KAPRODI = warisan DOSEN + permission tambahan
        $kaprodiPermissions = array_merge($dosenPermissions, [
            'penawaran.manage',
            'jadwal.view_umum',
        ]);
        $kaprodiRole->syncPermissions($kaprodiPermissions);

        // DOSEN WALI = warisan DOSEN + permission tambahan
        $dosenWaliPermissions = array_merge($dosenPermissions, [
            'perwalian.manage',
            'biodata_mahasiswa.view',
            'nilai_anak_wali.view',
            'khs_anak_wali.view',
            'tawaran_mk.view',
        ]);
        $dosenWaliRole->syncPermissions($dosenWaliPermissions);

        // ADMIN FULL ACCESS
        $adminRole->syncPermissions(Permission::all());

        // ======================
        // ASSIGN ADMIN USER
        // ======================
        $userAdmin = User::where('username', '31123019')->first();
        if ($userAdmin) {
            $userAdmin->assignRole('admin');
        }
    }
}