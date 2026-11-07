<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,       // Wajib dipanggil PERTAMA agar Role 'siswa' & User terbuat
            KategoriSeeder::class,
            AnggotaSeeder::class,
            BukuSeeder::class,
            PeminjamanSeeder::class, // Dipanggil TERAKHIR setelah role & user siswa tersedia
        ]);
    }
}