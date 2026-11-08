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
                'name' => 'Admin Perpustakaan',
                'email' => 'admin@gmail.com',
                'password' => Hash::make('passwordela'),
                'role' => 'admin',
            ],
            [
                'name' => 'Petugas Perpustakaan',
                'email' => 'petugas@gmail.com',
                'password' => Hash::make('password123'),
                'role' => 'petugas',
            ],
            [
                'name' => 'Siswa Perpustakaan',
                'email' => 'siswa@gmail.com',
                'password' => Hash::make('password123'),
                'role' => 'siswa',
            ],
        ];

        foreach ($users as $data) {
            $role = $data['role'];
            unset($data['role']);

            if ($role === 'admin') {
                $user = User::updateOrCreate(
                    ['email' => $data['email']],
                    $data
                );
            } else {
                $user = User::firstOrCreate(
                    ['email' => $data['email']],
                    $data
                );
            }

            $user->syncRoles([$role]);
        }
    }
}
