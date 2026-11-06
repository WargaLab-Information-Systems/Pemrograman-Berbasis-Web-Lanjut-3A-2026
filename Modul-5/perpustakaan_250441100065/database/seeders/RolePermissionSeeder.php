<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Daftar Permission
        $permissions = [
            'akses dashboard admin',
            'akses dashboard petugas',
            'lihat daftar buku',
            'kelola data buku',
            'kelola data pengguna',
            'kelola role pengguna',
            'kelola peminjaman',
            'kelola pengembalian',
            'mengajukan peminjaman buku',
            'memproses persetujuan peminjaman',
            'mencatat pengembalian buku',
            'melihat status peminjaman sendiri',
            'melihat riwayat peminjaman sendiri',
            'lihat laporan perpustakaan',
            'lihat profil sendiri',
            'ubah profil sendiri',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // 2. Role Admin
        $admin = Role::create(['name' => 'admin']);
        $admin->givePermissionTo([
            'akses dashboard admin',
            'lihat daftar buku', 'kelola data buku',
            'kelola data pengguna', 'kelola role pengguna',
            'kelola peminjaman', 'kelola pengembalian',
            'mengajukan peminjaman buku', 'memproses persetujuan peminjaman',
            'mencatat pengembalian buku',
            'melihat status peminjaman sendiri', 'melihat riwayat peminjaman sendiri',
            'lihat laporan perpustakaan',
            'lihat profil sendiri', 'ubah profil sendiri',
        ]);

        // 3. Role Petugas
        $petugas = Role::create(['name' => 'petugas']);
        $petugas->givePermissionTo([
            'akses dashboard petugas',
            'lihat daftar buku', 'kelola data buku',
            'kelola peminjaman', 'kelola pengembalian',
            'mengajukan peminjaman buku', 'memproses persetujuan peminjaman',
            'mencatat pengembalian buku',
            'melihat status peminjaman sendiri', 'melihat riwayat peminjaman sendiri',
            'lihat laporan perpustakaan',
            'lihat profil sendiri', 'ubah profil sendiri',
        ]);

        // 4. Role Siswa
        $siswa = Role::create(['name' => 'siswa']);
        $siswa->givePermissionTo([
            'lihat daftar buku',
            'mengajukan peminjaman buku',
            'melihat status peminjaman sendiri', 'melihat riwayat peminjaman sendiri',
            'lihat profil sendiri', 'ubah profil sendiri',
        ]);
    }
}
