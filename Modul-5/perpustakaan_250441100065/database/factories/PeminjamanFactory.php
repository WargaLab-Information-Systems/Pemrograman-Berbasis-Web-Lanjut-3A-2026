<?php

namespace Database\Factories;

use App\Models\Anggota;
use App\Models\Buku;
use App\Models\Peminjaman;
use Illuminate\Database\Eloquent\Factories\Factory;

class PeminjamanFactory extends Factory
{
    public function definition(): array
    {
        $pinjam = fake()->dateTimeBetween('-60 days', '-20 days');
        $kembali = fake()->optional()->dateTimeBetween($pinjam, '-1 days');

        return [
            'anggota_id' => Anggota::inRandomOrder()->first()->id,
            'buku_id' => Buku::inRandomOrder()->first()->id,
            'tanggal_pinjam' => $pinjam->format('Y-m-d'),
            'tanggal_kembali' => $kembali?->format('Y-m-d'),
            'status' => $kembali ? Peminjaman::DIKEMBALIKAN : Peminjaman::DIPINJAM,
        ];
    }
}
