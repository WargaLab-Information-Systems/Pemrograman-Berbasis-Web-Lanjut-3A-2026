<?php

namespace Database\Factories;

use App\Models\Anggota;
use App\Models\Buku;
use Illuminate\Database\Eloquent\Factories\Factory;

class PeminjamanFactory extends Factory
{
    public function definition(): array
    {
        $tanggalPinjam = fake()->dateTimeBetween('-1 month', 'now');

        return [
            'anggota_id' => Anggota::factory(),
            'buku_id' => Buku::inRandomOrder()->first()->id,
            'tanggal_pinjam' => $tanggalPinjam->format('Y-m-d'),
            'tanggal_kembali' => fake()->boolean(70)
                ? fake()->dateTimeBetween($tanggalPinjam, 'now')->format('Y-m-d')
                : null,
        ];
    }
}