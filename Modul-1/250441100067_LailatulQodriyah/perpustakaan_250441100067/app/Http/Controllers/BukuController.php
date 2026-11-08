<?php

namespace App\Http\Controllers;

class BukuController extends Controller
{
    private $buku = [
        [
            'id' => 1,
            'judul' => 'Laskar Pelangi',
            'penulis' => 'Andrea Hirata',
            'tahun' => 2005,
            'kategori' => 'Novel'
        ],
        [

            'id' => 2,
            'judul' => 'Bumi Manusia',
            'penulis' => 'Pramoedya Ananta Toer',
            'tahun' => 1980,
            'kategori' => 'Sejarah'
        ],
        [
            'id' => 3,
            'judul' => '3726 mdpl',
            'penulis' => 'nurwina sari',
            'tahun' => 2024,
            'kategori' => 'Novel'
        ],
        [
            'id' => 4,
            'judul' => 'Filosofi Teras',
            'penulis' => 'Henry Manampiring',
            'tahun' => 2018,
            'kategori' => 'Pengembangan Diri'
        ],
        [
            'id' => 5,
            'judul' => 'Atomic Habits',
            'penulis' => 'James Clear',
            'tahun' => 2018,
            'kategori' => 'Pengembangan Diri'
        ]
    ];

    public function index()
    {
        return view('buku.index', [
            'buku' => $this->buku
        ]);
    }

    public function show($id)
    {
        $buku = collect($this->buku)->firstWhere('id', $id);

        return view('buku.show', [
            'buku' => $buku
        ]);
    }
}