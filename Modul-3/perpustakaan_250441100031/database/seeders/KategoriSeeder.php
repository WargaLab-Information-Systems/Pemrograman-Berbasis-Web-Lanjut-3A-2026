<?php

namespace Database\Seeders;

use App\Models\Kategori;
use Illuminate\Database\Seeder;

class KategoriSeeder extends Seeder
{
    public function run(): void
    {
        $categories = ['Novel', 'Fiksi Fantasi', 'Pengembangan Diri', 'Self Improvement', 'Sastra'];
        foreach ($categories as $cat) {
            Kategori::create(['nama' => $cat]);
        }
    }
}