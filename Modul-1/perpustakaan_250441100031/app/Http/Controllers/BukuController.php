<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BukuController extends Controller
{
    private $buku = [
        [
            'id' => 1,
            'judul' => 'Laskar Pelangi',
            'penulis' => 'Andrea Hirata',
            'tahun' => 2005,
            'kategori' => 'Novel',
            'deskripsi' => 'Kisah perjuangan 10 anak Laskar Pelangi dalam mengejar mimpi di Belitung.',
            'gambar' => 'https://images.unsplash.com/photo-1544716278-ca5e3f4abd8c?auto=format&fit=crop&w=500&q=80'
        ],
        [
            'id' => 2,
            'judul' => 'Bumi',
            'penulis' => 'Tere Liye',
            'tahun' => 2014,
            'kategori' => 'Fiksi Fantasi',
            'deskripsi' => 'Petualangan Raib, Seli, dan Ali menelusuri dunia paralel yang penuh rahasia.',
            'gambar' => 'https://images.unsplash.com/photo-1512820790803-83ca734da794?auto=format&fit=crop&w=500&q=80'
        ],
        [
            'id' => 3,
            'judul' => 'Filosofi Teras',
            'penulis' => 'Henry Manampiring',
            'tahun' => 2018,
            'kategori' => 'Pengembangan Diri',
            'deskripsi' => 'Penerapan ilmu Stoikisme kuno untuk mengatasi mental cemas di era modern.',
            'gambar' => 'https://images.unsplash.com/photo-1497633762265-9d179a990aa6?auto=format&fit=crop&w=500&q=80'
        ],
        [
            'id' => 4,
            'judul' => 'Atomic Habits',
            'penulis' => 'James Clear',
            'tahun' => 2018,
            'kategori' => 'Self Improvement',
            'deskripsi' => 'Perubahan kecil 1% setiap hari yang memberikan hasil luar biasa jangka panjang.',
            'gambar' => 'https://images.unsplash.com/photo-1532012197267-da84d127e765?auto=format&fit=crop&w=500&q=80'
        ],
        [
            'id' => 5,
            'judul' => 'Cantik Itu Luka',
            'penulis' => 'Eka Kurniawan',
            'tahun' => 2002,
            'kategori' => 'Sastra',
            'deskripsi' => 'Kisah epik perpaduan sejarah, realisme magis, dan tragedi keluarga Dewi Ayu.',
            'gambar' => 'https://images.unsplash.com/photo-1495446815901-a7297e633e8d?auto=format&fit=crop&w=500&q=80'
        ],
    ];

    public function index()
    {
        return view('buku.index', ['daftarBuku' => $this->buku]);
    }

    public function show($id)
    {
        $bukuDetail = collect($this->buku)->firstWhere('id', $id);
        return view('buku.show', ['buku' => $bukuDetail]);
    }
}