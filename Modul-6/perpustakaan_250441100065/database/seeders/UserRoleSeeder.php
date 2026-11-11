<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserRoleSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            [
                'name' => 'Administrator',
                'email' => 'admin@gmail.com',
                'password' => 'password',
                'role' => 'admin',
            ],
            [
                'name' => 'Petugas Perpustakaan',
                'email' => 'petugas@gmail.com',
                'password' => 'password',
                'role' => 'petugas',
            ],
            [
                'name' => 'Siswa',
                'email' => 'siswa@gmail.com',
                'password' => 'password',
                'role' => 'siswa',
            ],
        ];

        foreach ($users as $data) {
            $user = User::firstOrCreate(
                ['email' => $data['email']],
                [
                    'name' => $data['name'],
                    'password' => Hash::make($data['password']),
                ]
            );

            $user->syncRoles([$data['role']]);
        }
    }
}
