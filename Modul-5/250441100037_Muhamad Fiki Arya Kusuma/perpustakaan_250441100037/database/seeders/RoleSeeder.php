<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // 1. Buat Semua Permission Sesuai Tabel Modul 5
        $permissions = [
            'Akses dashboard admin',
            'Akses dashboard petugas',
            'Lihat daftar buku',
            'Kelola data buku',
            'Kelola data pengguna',
            'Kelola role pengguna',
            'Kelola peminjaman',
            'Kelola pengembalian',
            'Mengajukan peminjaman buku',
            'Memproses persetujuan peminjaman',
            'Mencatat pengembalian buku',
            'Melihat status peminjaman sendiri',
            'Melihat riwayat peminjaman sendiri',
            'Lihat laporan perpustakaan',
            'Lihat profil sendiri',
            'Ubah profil sendiri'
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // 2. Buat Role (Admin, Petugas, Siswa)
        $adminRole   = Role::firstOrCreate(['name' => 'admin']);
        $petugasRole = Role::firstOrCreate(['name' => 'petugas']);
        $siswaRole   = Role::firstOrCreate(['name' => 'siswa']);

        // 3. Assign Permission ke Role
        $adminRole->givePermissionTo([
            'Akses dashboard admin', 'Lihat daftar buku', 'Kelola data buku',
            'Kelola data pengguna', 'Kelola role pengguna', 'Kelola peminjaman',
            'Kelola pengembalian', 'Memproses persetujuan peminjaman',
            'Mencatat pengembalian buku', 'Melihat status peminjaman sendiri',
            'Melihat riwayat peminjaman sendiri', 'Lihat laporan perpustakaan',
            'Lihat profil sendiri', 'Ubah profil sendiri'
        ]);

        $petugasRole->givePermissionTo([
            'Akses dashboard petugas', 'Lihat daftar buku', 'Kelola data buku',
            'Kelola peminjaman', 'Kelola pengembalian', 'Mengajukan peminjaman buku',
            'Memproses persetujuan peminjaman', 'Mencatat pengembalian buku',
            'Melihat status peminjaman sendiri', 'Melihat riwayat peminjaman sendiri',
            'Lihat laporan perpustakaan', 'Lihat profil sendiri', 'Ubah profil sendiri'
        ]);

        $siswaRole->givePermissionTo([
            'Lihat daftar buku', 'Melihat status peminjaman sendiri',
            'Melihat riwayat peminjaman sendiri', 'Lihat profil sendiri', 'Ubah profil sendiri'
        ]);

        // 4. Buat Akun Pengujian
        $admin = User::firstOrCreate(
            ['email' => 'admin@gmail.com'],
            ['name' => 'Admin Utama', 'password' => Hash::make('password123')]
        );
        $admin->syncRoles([$adminRole]);

        $petugas = User::firstOrCreate(
            ['email' => 'petugas@gmail.com'],
            ['name' => 'Petugas Perpustakaan', 'password' => Hash::make('password123')]
        );
        $petugas->syncRoles([$petugasRole]);

        $siswa = User::firstOrCreate(
            ['email' => 'siswa@gmail.com'],
            ['name' => 'Siswa Pengguna', 'password' => Hash::make('password123')]
        );
        $siswa->syncRoles([$siswaRole]);
    }
}