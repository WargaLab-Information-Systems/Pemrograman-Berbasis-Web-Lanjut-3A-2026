<?php

namespace App\Http\Controllers;

class BukuController extends Controller
{
    private $bukus = [
        [
            'id' => 1,
            'judul' => 'Pemrograman Web dengan Laravel',
            'penulis' => 'Rava Aji Utomo',
            'tahun' => 2024,
            'kategori' => 'Pemrograman'
        ],
        [
            'id' => 2,
            'judul' => 'Belajar PHP untuk Pemula',
            'penulis' => 'Akbar Imam Maulana',
            'tahun' => 2023,
            'kategori' => 'Pemrograman'
        ],
        [
            'id' => 3,
            'judul' => 'Dasar-Dasar Basis Data',
            'penulis' => 'Mustofa',
            'tahun' => 2022,
            'kategori' => 'Basis Data'
        ],
        [
            'id' => 4,
            'judul' => 'Algoritma dan Struktur Data',
            'penulis' => 'Muhamad Fiki Arya Kusuma',
            'tahun' => 2023,
            'kategori' => 'Informatika'
        ],
        [
            'id' => 5,
            'judul' => 'Pengembangan Aplikasi Web',
            'penulis' => 'Eko Wijaya',
            'tahun' => 2024,
            'kategori' => 'Web Development'
        ],
    ];

    public function index()
    {
        return view('buku.index', [
            'bukus' => $this->bukus
        ]);
    }

    public function show($id)
    {
        $buku = collect($this->bukus)->firstWhere('id', $id);

        return view('buku.detail', [
            'buku' => $buku
        ]);
    }
}