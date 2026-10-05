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
            'kategori' => 'Sastra'
        ],
        [
            'id' => 3,
            'judul' => 'Negeri 5 Menara',
            'penulis' => 'Ahmad Fuadi',
            'tahun' => 2009,
            'kategori' => 'Novel'
        ],
        [
            'id' => 4,
            'judul' => 'Filosofi Teras',
            'penulis' => 'Henry Manampiring',
            'tahun' => 2018,
            'kategori' => 'Filsafat'
        ],
        [
            'id' => 5,
            'judul' => 'Ayat-Ayat Cinta',
            'penulis' => 'Habiburrahman El Shirazy',
            'tahun' => 2004,
            'kategori' => 'Religi'
        ],
        [
            'id' => 6,
            'judul' => 'Sang Pemimpi',
            'penulis' => 'Andrea Hirata',
            'tahun' => 2006,
            'kategori' => 'Novel'
        ],
    ];

    public function index()
    {
        return view('buku.index', [
            'buku' => $this->buku
        ]);
    }
    public function show($id)
    {
        $buku = collect($this->buku)->firstWhere('id', (int) $id);

        return view('buku.show', [
            'buku' => $buku
        ]);
    }
}