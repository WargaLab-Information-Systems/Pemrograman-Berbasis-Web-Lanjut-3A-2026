<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RoleAndPermissionSeeder extends Seeder
{
    public function run(): void
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $permissions = [
            'akses dashboard admin', 'akses dashboard petugas',
            'lihat daftar buku', 'kelola data buku', 'kelola data pengguna',
            'kelola role pengguna', 'kelola peminjaman', 'kelola pengembalian',
            'mengajukan peminjaman buku', 'memproses persetujuan peminjaman',
            'mencatat pengembalian buku', 'melihat status peminjaman sendiri',
            'melihat riwayat peminjaman sendiri', 'lihat laporan perpustakaan',
            'lihat profil sendiri', 'ubah profil sendiri',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        $admin = Role::firstOrCreate(['name' => 'admin']);
        $admin->givePermissionTo(Permission::all()); 

        $petugas = Role::firstOrCreate(['name' => 'petugas']);
        $petugas->givePermissionTo([
            'akses dashboard petugas', 'lihat daftar buku', 'kelola data buku',
            'kelola peminjaman', 'kelola pengembalian', 'memproses persetujuan peminjaman',
            'mencatat pengembalian buku', 'lihat laporan perpustakaan',
            'lihat profil sendiri', 'ubah profil sendiri'
        ]);

        $siswa = Role::firstOrCreate(['name' => 'siswa']);
        $siswa->givePermissionTo([
            'lihat daftar buku', 'mengajukan peminjaman buku', 'melihat status peminjaman sendiri',
            'melihat riwayat peminjaman sendiri', 'lihat profil sendiri', 'ubah profil sendiri'
        ]);

        $adminUser = User::firstOrCreate(
            ['email' => 'admin@gmail.com'],
            ['name' => 'Admin Perpus', 'password' => Hash::make('password123')]
        );
        $adminUser->assignRole('admin');

        $petugasUser = User::firstOrCreate(
            ['email' => 'petugas@gmail.com'],
            ['name' => 'Petugas Perpus', 'password' => Hash::make('password123')]
        );
        $petugasUser->assignRole('petugas');

        $siswaUser = User::firstOrCreate(
            ['email' => 'siswa@gmail.com'],
            ['name' => 'Siswa Perpus', 'password' => Hash::make('password123')]
        );
        $siswaUser->assignRole('siswa');
    }
}