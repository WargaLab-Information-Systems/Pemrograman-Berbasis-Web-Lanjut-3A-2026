<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Akun demo. Password petugas & siswa: password. Password admin: lihat ADMIN_PASSWORD.
     * Role ditetapkan di sini oleh seeder / admin, BUKAN lewat form registrasi.
     */
    public function run(): void
    {
        // [SOAL 5] Password admin TIDAK lagi "password".
        // Bisa diganti lewat ADMIN_PASSWORD di .env; kalau kosong dipakai nilai bawaan di bawah.
        $passwordAdmin = env('ADMIN_PASSWORD') ?: 'admin123';

        $akun = [
            ['Administrator',   'admin@gmail.com',   'admin'],
            ['Petugas Perpus',  'petugas@gmail.com', 'petugas'],
            ['Siswa Teladan',   'siswa@gmail.com',   'siswa'],
            ['Siswa Kedua',     'siswa2@gmail.com',  'siswa'],
        ];

        foreach ($akun as [$nama, $email, $role]) {
            $user = User::updateOrCreate(
                ['email' => $email],
                [
                    'name' => $nama,
                    'password' => Hash::make($role === 'admin' ? $passwordAdmin : 'password'),
                ]
            );

            $user->syncRoles([$role]);
            $user->ensureAnggota(); // data anggota untuk riwayat peminjaman
        }
    }
}
