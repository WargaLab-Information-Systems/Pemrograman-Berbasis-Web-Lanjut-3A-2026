<?php

namespace Database\Seeders;

use App\Models\Buku;
use App\Models\Kategori;
use Illuminate\Database\Seeder;

class BukuSeeder extends Seeder
{
    public function run(): void
    {
        $buku = [
            [
                'judul' => 'Laskar Pelangi',
                'penulis' => 'Andrea Hirata',
                'tahun_terbit' => 2005,
                'kategori' => 'Novel',
            ],
            [
                'judul' => 'Bumi Manusia',
                'penulis' => 'Pramoedya Ananta Toer',
                'tahun_terbit' => 1980,
                'kategori' => 'Sejarah',
            ],
            [
                'judul' => 'Negeri 5 Menara',
                'penulis' => 'Ahmad Fuadi',
                'tahun_terbit' => 2009,
                'kategori' => 'Novel',
            ],
            [
                'judul' => 'Filosofi Teras',
                'penulis' => 'Henry Manampiring',
                'tahun_terbit' => 2018,
                'kategori' => 'Pengembangan Diri',
            ],
            [
                'judul' => 'Atomic Habits',
                'penulis' => 'James Clear',
                'tahun_terbit' => 2018,
                'kategori' => 'Pengembangan Diri',
            ],
            [
                'judul' => 'Seporsi Mie Ayam Sebelum Mati',
                'penulis' => 'Brian Khrisna',
                'tahun_terbit' => 2025,
                'kategori' => 'Novel',
            ],
            [
                'judul' => 'Cantik Itu Luka',
                'penulis' => 'Eka Kurniawan',
                'tahun_terbit' => 2002,
                'kategori' => 'Sejarah',
            ],
            [
                'judul' => 'Laut Bercerita',
                'penulis' => 'Leila S. Chudori',
                'tahun_terbit' => 2017,
                'kategori' => 'Sejarah',
            ],
            [
                'judul' => 'Pulang',
                'penulis' => 'Leila S. Chudori',
                'tahun_terbit' => 2012,
                'kategori' => 'Novel',
            ],
            [
                'judul' => 'Belajar Pemrograman Dasar',
                'penulis' => 'Rosa A.S. dan M. Shalahuddin',
                'tahun_terbit' => 2020,
                'kategori' => 'Teknologi',
            ],
        ];

        foreach ($buku as $data) {
            Buku::factory()->create([
                'kategori_id' => Kategori::where('nama', $data['kategori'])->first()->id,
                'judul' => $data['judul'],
                'penulis' => $data['penulis'],
                'tahun_terbit' => $data['tahun_terbit'],
            ]);
        }
    }
}