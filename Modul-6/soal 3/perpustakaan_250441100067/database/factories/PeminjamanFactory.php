<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Anggota;
use App\Models\Buku;

class PeminjamanFactory extends Factory
{
    public function definition(): array
    {
        $tanggalPinjam = fake()->dateTimeBetween('-1 year', 'now');

        return [
            'anggota_id' => Anggota::inRandomOrder()->value('id'),
            'buku_id' => Buku::inRandomOrder()->value('id'),
            'tanggal_pinjam' => $tanggalPinjam->format('Y-m-d'),
            'tanggal_kembali' => fake()->optional()->dateTimeBetween(
                $tanggalPinjam,
                'now'
            )?->format('Y-m-d'),
        ];
    }
}