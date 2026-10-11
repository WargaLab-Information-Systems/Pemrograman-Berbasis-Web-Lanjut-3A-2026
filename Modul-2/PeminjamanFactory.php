<?php

namespace Database\Factories;

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
        $tanggalPinjam = fake()->dateTimeBetween('-1 year', 'now');
        return [
            'anggota_id' => Anggota::inRandomOrder()->first()?->id ?? Anggota::factory(),
            'buku_id' => Buku::inRandomOrder()->first()?->id ?? Buku::factory(),
            'tanggal_pinjam' => $tanggalPinjam,
            'tanggal_kembali' => fake()->optional(0.6)->dateTimeBetween($tanggalPinjam, 'now'),   
        ];
    }
}
