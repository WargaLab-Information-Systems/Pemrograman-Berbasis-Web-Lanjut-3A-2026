<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Peminjaman;
use App\Models\User;
use App\Models\Buku;
use Spatie\Permission\Models\Role;

class PeminjamanSeeder extends Seeder
{
    public function run(): void
    {
        // Ambil user siswa, atau jika belum ada ambil user pertama di database
        $siswa = User::role('siswa')->first() ?? User::first();
        $buku  = Buku::first();

        if ($siswa && $buku) {
            Peminjaman::create([
                'user_id'         => $siswa->id,
                'buku_id'         => $buku->id,
                'tanggal_pinjam'  => '2026-10-25',
                'tanggal_kembali' => '2026-11-01',
                'status'          => 'dipinjam',
            ]);
        }
    }
}