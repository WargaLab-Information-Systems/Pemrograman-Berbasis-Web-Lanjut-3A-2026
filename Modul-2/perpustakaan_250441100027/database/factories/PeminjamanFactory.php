<?php

namespace Database\Factories;

use App\Models\Buku;
use App\Models\Anggota;
use App\Models\Peminjaman;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Peminjaman>
 */
class PeminjamanFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
    return [
        'anggota_id' => Anggota::inRandomOrder()->value('id'),
        'buku_id' => Buku::inRandomOrder()->value('id'),
        'tanggal_pinjam' => fake()->dateTimeBetween('-1 month', 'now'),
        'tanggal_kembali' => fake()->dateTimeBetween('now', '+1 month'),
    ];
    }
}
