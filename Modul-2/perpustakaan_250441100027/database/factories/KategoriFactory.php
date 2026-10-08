<?php

namespace Database\Factories;

use App\Models\Kategori;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Kategori>
 */
class KategoriFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    private static int $i = 0;

    public function definition(): array
    {
    $daftar = [
        'Fiksi & Petualangan', 'Inspiratif & Pendidikan', 'Serial Dunia Paralel',
        'Sastra & Sejarah', 'Romansa & Drama', 'Sastra Klasik', 'Inspiratif & Pembelajaran',
    ];

    return ['nama' => $daftar[self::$i++ % count($daftar)]];
    }
}
