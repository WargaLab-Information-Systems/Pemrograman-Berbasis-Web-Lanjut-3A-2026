<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{

    public function run(): void
    {
        $akun = [
            ['Administrator',   'admin@gmail.com',   'admin'],
            ['Petugas Perpus',  'petugas@gmail.com', 'petugas'],
            ['Siswa Teladan',   'siswa@gmail.com',   'siswa'],
            ['Siswa Kedua',     'siswa2@gmail.com',  'siswa'],
        ];

        foreach ($akun as [$nama, $email, $role]) {
            $user = User::firstOrCreate(
                ['email' => $email],
                ['name' => $nama, 'password' => Hash::make('password')]
            );

            $user->syncRoles([$role]);
            $user->ensureAnggota();
        }
    }
}








