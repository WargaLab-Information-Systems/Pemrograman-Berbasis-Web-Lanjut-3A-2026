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
            'tahun_terbit' => 2005,
            'kategori' => 'Novel'
        ],
        [
            'id' => 2,
            'judul' => 'Bumi Manusia',
            'penulis' => 'Pramoedya Ananta Toer',
            'tahun_terbit' => 1980,
            'kategori' => 'Sejarah'
        ],
        [
            'id' => 3,
            'judul' => 'Negeri 5 Menara',
            'penulis' => 'Ahmad Fuadi',
            'tahun_terbit' => 2009,
            'kategori' => 'Novel'
        ],
        [
            'id' => 4,
            'judul' => 'Atomic Habits',
            'penulis' => 'James Clear',
            'tahun_terbit' => 2018,
            'kategori' => 'Self Improvement'
        ],
        [
            'id' => 5,
            'judul' => 'Filosofi Teras',
            'penulis' => 'Henry Manampiring',
            'tahun_terbit' => 2018,
            'kategori' => 'Filsafat'
        ],
    ];

    public function index()
    {
        return view('buku.index', [
            'daftarBuku' => $this->buku
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