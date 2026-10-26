<?php

namespace Database\Factories;

use App\Models\Peminjaman;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Anggota;
use App\Models\Buku;
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
            'anggota_id' => fake()->randomElement(Anggota::pluck('id')->toArray()),
            'buku_id' => fake()->randomElement(Buku::pluck('id')->toArray()),
            'tanggal_pinjam' => fake()
                ->dateTimeBetween('-1 month', 'now')
                ->format('Y-m-d'),
            'tanggal_kembali' => null,
        ];
    }
}


