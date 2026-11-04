<?php

namespace Database\Seeders;

use App\Models\Kategori;
use Illuminate\Database\Seeder;

class KategoriSeeder extends Seeder
{
    public function run(): void
    {
        Kategori::factory()->create([
            'nama' => 'Novel',
        ]);

        Kategori::factory()->create([
            'nama' => 'Sejarah',
        ]);

        Kategori::factory()->create([
            'nama' => 'Filsafat',
        ]);
    }
}