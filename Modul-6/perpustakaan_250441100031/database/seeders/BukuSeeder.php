<?php

namespace Database\Seeders;

use App\Models\Buku;
use App\Models\Kategori;
use Illuminate\Database\Seeder;

class BukuSeeder extends Seeder
{
    public function run(): void
    {
        $dataBuku = [
            [
                'judul' => 'Laskar Pelangi',
                'penulis' => 'Andrea Hirata',
                'tahun_terbit' => 2005,
                'kategori_nama' => 'Novel',
                'deskripsi' => 'Kisah perjuangan 10 anak Laskar Pelangi dalam mengejar mimpi.',
                'gambar' => 'https://images.unsplash.com/photo-1544716278-ca5e3f4abd8c?auto=format&fit=crop&w=500&q=80'
            ],
            [
                'judul' => 'Bumi',
                'penulis' => 'Tere Liye',
                'tahun_terbit' => 2014,
                'kategori_nama' => 'Fiksi Fantasi',
                'deskripsi' => 'Petualangan Raib, Seli, dan Ali menelusuri dunia paralel.',
                'gambar' => 'https://images.unsplash.com/photo-1512820790803-83ca734da794?auto=format&fit=crop&w=500&q=80'
            ],
            [
                'judul' => 'Filosofi Teras',
                'penulis' => 'Henry Manampiring',
                'tahun_terbit' => 2018,
                'kategori_nama' => 'Pengembangan Diri',
                'deskripsi' => 'Penerapan ilmu Stoikisme kuno untuk mental cemas.',
                'gambar' => 'https://images.unsplash.com/photo-1497633762265-9d179a990aa6?auto=format&fit=crop&w=500&q=80'
            ],
            [
                'judul' => 'Atomic Habits',
                'penulis' => 'James Clear',
                'tahun_terbit' => 2018,
                'kategori_nama' => 'Self Improvement',
                'deskripsi' => 'Perubahan kecil 1% setiap hari yang berdampak besar.',
                'gambar' => 'https://images.unsplash.com/photo-1532012197267-da84d127e765?auto=format&fit=crop&w=500&q=80'
            ],
            [
                'judul' => 'Cantik Itu Luka',
                'penulis' => 'Eka Kurniawan',
                'tahun_terbit' => 2002,
                'kategori_nama' => 'Sastra',
                'deskripsi' => 'Kisah epik perpaduan sejarah dan realisme magis.',
                'gambar' => 'https://images.unsplash.com/photo-1495446815901-a7297e633e8d?auto=format&fit=crop&w=500&q=80'
            ],
        ];

        foreach ($dataBuku as $item) {
            $kategori = Kategori::firstOrCreate(['nama' => $item['kategori_nama']]);
            
            Buku::factory()->create([
                'kategori_id' => $kategori->id,
                'judul' => $item['judul'],
                'penulis' => $item['penulis'],
                'tahun_terbit' => $item['tahun_terbit'],
                'deskripsi' => $item['deskripsi'],
                'gambar' => $item['gambar'],
            ]);
        }
    }
}