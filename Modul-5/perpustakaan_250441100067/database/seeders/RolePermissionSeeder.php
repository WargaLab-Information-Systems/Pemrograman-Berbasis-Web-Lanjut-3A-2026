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

        // Daftar seluruh permission
        $permissions = [
            'dashboard-admin',
            'dashboard-petugas',
            'lihat-daftar-buku',
            'kelola-data-buku',
            'kelola-data-pengguna',
            'kelola-role-pengguna',
            'kelola-peminjaman',
            'kelola-pengembalian',
            'mengajukan-peminjaman',
            'memproses-persetujuan-peminjaman',
            'mencatat-pengembalian',
            'lihat-status-peminjaman-sendiri',
            'lihat-riwayat-peminjaman-sendiri',
            'lihat-laporan',
            'lihat-profil-sendiri',
            'ubah-profil-sendiri',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate([
                'name' => $permission,
                'guard_name' => 'web',
            ]);
        }

        // Membuat role
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

        // HAK AKSES ADMIN
        $admin->syncPermissions([
            'dashboard-admin',
            'lihat-daftar-buku',
            'kelola-data-buku',
            'kelola-data-pengguna',
            'kelola-role-pengguna',
            'kelola-peminjaman',
            'kelola-pengembalian',
            'memproses-persetujuan-peminjaman',
            'mencatat-pengembalian',
            'lihat-laporan',
            'lihat-profil-sendiri',
            'ubah-profil-sendiri',
        ]);

        // HAK AKSES PETUGAS
        $petugas->syncPermissions([
            'dashboard-petugas',
            'lihat-daftar-buku',
            'kelola-data-buku',
            'kelola-peminjaman',
            'kelola-pengembalian',
            'memproses-persetujuan-peminjaman',
            'mencatat-pengembalian',
            'lihat-laporan',
            'lihat-profil-sendiri',
            'ubah-profil-sendiri',
        ]);

        // HAK AKSES SISWA / PENGGUNA
        $siswa->syncPermissions([
            'lihat-daftar-buku',
            'mengajukan-peminjaman',
            'lihat-status-peminjaman-sendiri',
            'lihat-riwayat-peminjaman-sendiri',
            'lihat-profil-sendiri',
            'ubah-profil-sendiri',
        ]);

        app()[PermissionRegistrar::class]->forgetCachedPermissions();
    }
}
