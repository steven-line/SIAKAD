<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
            $dosenRole = Role::firstOrCreate(['name' => 'dosen']);
            $mahasiswaRole = Role::firstOrCreate(['name' => 'mahasiswa']);
            $kaprodiRole = Role::firstOrCreate(['name' => 'kaprodi']);
            $dosenWaliRole = Role::firstOrCreate(['name' => 'dosen-wali']);

            // 2. Buat Permission (Sudah saya bersihkan duplikatnya)
            $permissions = [
              'penawaran.view',
              'krs.create',
              'krs.validate',
              'krs.view',
              'jadwal.manage',
              'penawaran.manage',
              'mk.view'
            ];

            foreach ($permissions as $permission) {
                Permission::firstOrCreate(['name' => $permission]);
            }

            // 3. ASSIGN PERMISSION (Ini yang kurang di kode Anda)
           

            $mahasiswaRole->givePermissionTo(['krs.view', 'krs.create', 'penawaran.view']);
            $kaprodiRole->givePermissionTo(['penawaran.manage', 'jadwal.manage', 'mk.view']);
            $dosenWaliRole->givePermissionTo(['krs.view', 'krs.validate', 'penawaran.view']);
            $dosenRole->givePermissionTo([
                'mk.view'
            ]);

        

        
        
    }   
}
