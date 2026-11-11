<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $permissions = [
            'akses dashboard admin',               // 1
            'akses dashboard petugas',             // 2
            'lihat daftar buku',                   // 3
            'kelola data buku',                    // 4
            'kelola data pengguna',                // 5
            'kelola role pengguna',                // 6
            'kelola peminjaman',                   // 7
            'kelola pengembalian',                 // 8
            'mengajukan peminjaman buku',          // 9
            'memproses persetujuan peminjaman',    // 10
            'mencatat pengembalian buku',          // 11
            'melihat status peminjaman sendiri',   // 12
            'melihat riwayat peminjaman sendiri',  // 13
            'lihat laporan perpustakaan',          // 14
            'lihat profil sendiri',                // 15
            'ubah profil sendiri',                 // 16
        ];

        foreach ($permissions as $nama) {
            Permission::firstOrCreate(['name' => $nama, 'guard_name' => 'web']);
        }

        // Tiga role
        $admin   = Role::firstOrCreate(['name' => 'admin',   'guard_name' => 'web']);
        $petugas = Role::firstOrCreate(['name' => 'petugas', 'guard_name' => 'web']);
        $siswa   = Role::firstOrCreate(['name' => 'siswa',   'guard_name' => 'web']);

        // Hak akses yang dimiliki semua role
        $umum = [
            'lihat daftar buku',
            'mengajukan peminjaman buku',
            'melihat status peminjaman sendiri',
            'melihat riwayat peminjaman sendiri',
            'lihat profil sendiri',
            'ubah profil sendiri',
        ];

        // Hak akses staf (admin & petugas)
        $staf = [
            'kelola data buku',
            'kelola peminjaman',
            'kelola pengembalian',
            'memproses persetujuan peminjaman',
            'mencatat pengembalian buku',
            'lihat laporan perpustakaan',
        ];

        $admin->syncPermissions(array_merge($umum, $staf, [
            'akses dashboard admin',
            'kelola data pengguna',
            'kelola role pengguna',
        ]));

        $petugas->syncPermissions(array_merge($umum, $staf, [
            'akses dashboard petugas',
        ]));

        $siswa->syncPermissions($umum);
    }
}
