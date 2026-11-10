<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $permissions = [
            'access admin dashboard',
            'access petugas dashboard',

            'view books',
            'manage books',

            'manage users',
            'manage user roles',

            'manage loans',
            'manage returns',

            'request book loans',
            'approve book loans',
            'record book returns',

            'view all loan history',
            'view own loan status',
            'view own loan history',

            'view library reports',

            'view own profile',
            'update own profile',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate([
                'name' => $permission,
                'guard_name' => 'web',
            ]);
        }

        $admin = Role::firstOrCreate([
            'name' => 'admin',
            'guard_name' => 'web',
        ]);

        $petugas = Role::firstOrCreate([
            'name' => 'petugas',
            'guard_name' => 'web',
        ]);

        $siswa = Role::firstOrCreate([
            'name' => 'siswa',
            'guard_name' => 'web',
        ]);

        // ADMIN
        $admin->syncPermissions($permissions);

        // PETUGAS
        $petugas->syncPermissions([
            'access petugas dashboard',
            'view books',
            'manage books',
            'manage loans',
            'manage returns',
            'request book loans',
            'approve book loans',
            'record book returns',
            'view all loan history',
            'view own loan status',
            'view own loan history',
            'view library reports',
            'view own profile',
            'update own profile',
        ]);

        // SISWA
        $siswa->syncPermissions([
            'view books',
            'request book loans',
            'view own loan status',
            'view own loan history',
            'view own profile',
            'update own profile',
        ]);

        app()[PermissionRegistrar::class]->forgetCachedPermissions();
    }
}
