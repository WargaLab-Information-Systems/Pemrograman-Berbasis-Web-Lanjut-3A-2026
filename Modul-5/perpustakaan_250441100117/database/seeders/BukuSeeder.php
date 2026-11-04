<?php

namespace Database\Seeders;

use App\Models\Buku;
use App\Models\Kategori;
use Illuminate\Database\Seeder;

class BukuSeeder extends Seeder
{
    public function run(): void
    {
        $novel = Kategori::where('nama', 'Novel')->value('id');
        $sejarah = Kategori::where('nama', 'Sejarah')->value('id');
        $filsafat = Kategori::where('nama', 'Filsafat')->value('id');

        Buku::factory()->create([
            'kategori_id' => $novel,
            'judul' => 'Laskar Pelangi',
            'penulis' => 'Andrea Hirata',
            'tahun_terbit' => 2005,
        ]);

        Buku::factory()->create([
            'kategori_id' => $sejarah,
            'judul' => 'Bumi Manusia',
            'penulis' => 'Pramoedya Ananta Toer',
            'tahun_terbit' => 1980,
        ]);

        Buku::factory()->create([
            'kategori_id' => $novel,
            'judul' => 'Negeri 5 Menara',
            'penulis' => 'Ahmad Fuadi',
            'tahun_terbit' => 2009,
        ]);

        Buku::factory()->create([
            'kategori_id' => $filsafat,
            'judul' => 'Filosofi Teras',
            'penulis' => 'Henry Manampiring',
            'tahun_terbit' => 2018,
        ]);

        Buku::factory()->create([
            'kategori_id' => $sejarah,
            'judul' => 'Sapiens',
            'penulis' => 'Yuval Noah Harari',
            'tahun_terbit' => 2011,
        ]);
    }
}