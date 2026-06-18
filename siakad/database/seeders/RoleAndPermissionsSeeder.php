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
        // CLEAR CACHE (WAJIB)
        // ======================
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // ======================
        // CLEAN ROLE & PERMISSION
        // (AMAN karena kita rebuild semua)
        // ======================
        Role::query()->delete();
        Permission::query()->delete();

        // ======================
        // ROLES
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
            // ADMIN MODULE
            'user.manage',
            'kurikulum.manage',
            'mk.manage',
            'dosen.manage',
            'prodi.manage',
            'fakultas.manage',
            'biodata.manage',
            'role.manage',
            'permission.manage',

            // PENAWARAN
            'penawaran.view',
            'penawaran.manage',

            // JADWAL
            'jadwal.view_sendiri',
            'jadwal.view_umum',
            'jadwal.manage',

            // MAHASISWA
            'biodata.view',
            'krs.view',
            'krs.submit',
            'nilai_krs.view',
            'khs.view',
            'transkrip.view',

            // DOSEN
            'nilai.input',

            // DOSEN WALI
            'perwalian.manage',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate([
                'name' => $permission,
                'guard_name' => 'web',
            ]);
        }

        // ======================
        // MAHASISWA
        // ======================
        $mahasiswaRole->syncPermissions([
            'biodata.view',
            'penawaran.view',
            'krs.view',
            'krs.submit',
            'nilai_krs.view',
            'khs.view',
            'transkrip.view',
        ]);

        // ======================
        // DOSEN
        // ======================
        $dosenRole->syncPermissions([
            'jadwal.view_sendiri',
            'nilai.input',
        ]);

        // ======================
        // KAPRODI
        // ======================
        $kaprodiRole->syncPermissions([
            'jadwal.view_sendiri',
            'jadwal.view_umum',
            'jadwal.manage',
            'nilai.input',
            'penawaran.view',
            'penawaran.manage',
        ]);

        // ======================
        // DOSEN WALI
        // ======================
        $dosenWaliRole->syncPermissions([
            'jadwal.view_sendiri',
            'nilai.input',
            'penawaran.view',
            'perwalian.manage',
        ]);

        // ======================
        // ADMIN (FULL ACCESS MODULE ADMIN)
        // ======================
        $adminRole->syncPermissions([
            'user.manage',
            'kurikulum.manage',
            'mk.manage',
            'dosen.manage',
            'prodi.manage',
            'fakultas.manage',
            'biodata.manage',
            'role.manage',
            'permission.manage',
        ]);

        // ======================
        // ASSIGN ADMIN USER
        // ======================
        $userAdmin = User::where('username', '31123019')->first();

        if ($userAdmin) {
            // lebih aman dari assignRole
            $userAdmin->syncRoles(['admin']);
        }

        // ======================
        // FINAL CACHE CLEAR
        // ======================
        app()[PermissionRegistrar::class]->forgetCachedPermissions();
    }
}