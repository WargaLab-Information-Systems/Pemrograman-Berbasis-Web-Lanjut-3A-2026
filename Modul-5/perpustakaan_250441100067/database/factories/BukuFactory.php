<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Kategori;

class BukuFactory extends Factory
{
    public function definition(): array
    {
        return [
            'kategori_id' => Kategori::inRandomOrder()->value('id'),
            'judul' => fake()->sentence(3),
            'penulis' => fake()->name(),
            'tahun_terbit' => fake()->numberBetween(2015, 2026),
        ];
    }
}