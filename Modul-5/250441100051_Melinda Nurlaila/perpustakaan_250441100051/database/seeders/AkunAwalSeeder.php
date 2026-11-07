<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AkunAwalSeeder extends Seeder
{
    public function run(): void
    {
        $akun = [
            ['Admin Perpustakaan', 'admin@perpustakaan.test', 'Admin'],
            ['Petugas Perpustakaan', 'petugas@perpustakaan.test', 'Petugas'],
        ];

        foreach ($akun as [$nama, $email, $role]) {
            $user = User::firstOrCreate(
                ['email' => $email],
                ['name' => $nama, 'password' => Hash::make('password123')]
            );

            $user->syncRoles([$role]);
        }
    }
}
