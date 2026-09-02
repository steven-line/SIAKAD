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
        $keuanganRole  = Role::firstOrCreate(['name' => 'keuangan']);
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
            'mahasiswa.manage',
            'penawaranumum.manage',

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
            'changepassword.manage',
            'mahasiswa_transfer.manage',

            // DOSEN
            'nilai.input',

            // DOSEN WALI
            'perwalian.manage',

            // PERIODE
            'periode.manage',
            'semester.manage',
            'jurusan.manage',

            // BLOKIR KEUANGAN
            'blokir.keuangan',

            // PJMK
            'pjmk.manage',

            'settings.manage',

            'sks.manage',
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
            'changepassword.manage',
        ]);

        // ======================
        // DOSEN
        // ======================
        $dosenRole->syncPermissions([
            'jadwal.view_sendiri',
            'nilai.input',
            'changepassword.manage',
        ]);

        // ======================
        // KEUANGAN
        // ======================
        $keuanganRole->syncPermissions([
            'blokir.keuangan',
            'changepassword.manage',
        ]);

        // ======================
        // KAPRODI
        // ======================
        $kaprodiRole->syncPermissions([
            'jadwal.view_sendiri',
            'jadwal.view_umum',
            'jadwal.manage',
            'nilai.input',
            'penawaran.manage',
            'pjmk.manage',
            'changepassword.manage',
        ]);

        // ======================
        // DOSEN WALI
        // ======================
        $dosenWaliRole->syncPermissions([
            'jadwal.view_sendiri',
            'nilai.input',
            'perwalian.manage',
            'changepassword.manage',
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
            'mahasiswa.manage',
            'semester.manage',
            'periode.manage',
            'jurusan.manage',
            'settings.manage',
            'sks.manage',
            'penawaranumum.manage',
            'changepassword.manage',
            'mahasiswa_transfer.manage'
        ]);

        // ======================
        // ASSIGN ADMIN USER
        // ======================
        $userAdmin = User::where('username', '31123019')->first();
        for ($i = 1; $i <= 81; $i++) {

            $username = '31123' . str_pad($i, 3, '0', STR_PAD_LEFT);
            $user = User::where('username', $username)->first();

            if (!$user) {
                continue;
            }

            // 🎓 Mahasiswa (1 - 40)
            if ($i >= 1 && $i <= 40 && $i != 19) {
                $user->syncRoles(['mahasiswa']);
            }

            // 👨‍🏫 Dosen (41 - 72)
            elseif ($i >= 41 && $i <= 72) {
                $user->syncRoles(['dosen']);
            }

            // 🏫 Kaprodi (73 - 80)
            elseif ($i >= 73 && $i <= 80) {
                $user->syncRoles(['kaprodi']);
            }

            // 💰 Keuangan (81)
            elseif ($i == 81) {
                $user->syncRoles(['keuangan']);
            }
        }
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