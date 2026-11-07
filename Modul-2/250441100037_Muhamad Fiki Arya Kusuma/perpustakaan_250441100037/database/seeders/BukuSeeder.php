<?php

namespace Database\Seeders;

use App\Models\Buku;
use App\Models\Kategori;
use Illuminate\Database\Seeder;

class BukuSeeder extends Seeder
{
    public function run(): void
    {
        // Data buku beserta kategorinya masing-masing
        $dataAwal = [
            [
                'judul' => 'Laskar Pelangi',
                'penulis' => 'Andrea Hirata',
                'tahun_terbit' => 2005,
                'kategori' => 'Novel / Fiksi'
            ],
            [
                'judul' => 'Bumi Manusia',
                'penulis' => 'Pramoedya Ananta Toer',
                'tahun_terbit' => 1980,
                'kategori' => 'Sejarah / Fiksi'
            ],
            [
                'judul' => 'Filosofi Teras',
                'penulis' => 'Henry Manampiring',
                'tahun_terbit' => 2018,
                'kategori' => 'Pengembangan Diri'
            ],
            [
                'judul' => 'Atomic Habits',
                'penulis' => 'James Clear',
                'tahun_terbit' => 2018,
                'kategori' => 'Self Improvement'
            ],
            [
                'judul' => 'Clean Code',
                'penulis' => 'Robert C. Martin',
                'tahun_terbit' => 2008,
                'kategori' => 'Teknologi / Pemrograman'
            ],
            [
                'judul' => 'The Pragmatic Programmer',
                'penulis' => 'Andrew Hunt dan David Thomas',
                'tahun_terbit' => 1999,
                'kategori' => 'Teknologi / Pemrograman'
            ],
        ];

        foreach ($dataAwal as $buku) {
            $kategori = Kategori::firstOrCreate(['nama' => $buku['kategori']]);


            Buku::create([
                'kategori_id' => $kategori->id,
                'judul' => $buku['judul'],
                'penulis' => $buku['penulis'],
                'tahun_terbit' => $buku['tahun_terbit'],
            ]);
        }
    }
}
