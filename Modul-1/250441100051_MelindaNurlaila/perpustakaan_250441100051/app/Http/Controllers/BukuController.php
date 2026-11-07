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
            'gambar' => 'laskar-pelangi.jpg'
        ],
        [
            'id' => 2,
            'judul' => 'Bumi Manusia',
            'penulis' => 'Pramoedya Ananta Toer',
            'tahun' => 1980,
            'kategori' => 'Sejarah',
            'gambar' => 'bumi-manusia.jpg'
        ],
        [
            'id' => 3,
            'judul' => 'Negeri 5 Menara',
            'penulis' => 'Ahmad Fuadi',
            'tahun' => 2009,
            'kategori' => 'Novel',
            'gambar' => 'negeri-5-menara.jpg'
        ],
        [
            'id' => 4,
            'judul' => 'Filosofi Teras',
            'penulis' => 'Henry Manampiring',
            'tahun' => 2018,
            'kategori' => 'Pengembangan Diri',
            'gambar' => 'filosofi-teras.jpg'
        ],
        [
            'id' => 5,
            'judul' => 'Atomic Habits',
            'penulis' => 'James Clear',
            'tahun' => 2018,
            'kategori' => 'Pengembangan Diri',
            'gambar' => 'atomic-habits.jpg'
        ]
    ];

    public function index(Request $request)
    {
        $keyword = $request->query('q');

        $buku = $this->buku;

        if ($keyword) {
            $buku = array_values(array_filter($buku, function ($item) use ($keyword) {
                return stripos($item['judul'], $keyword) !== false
                    || stripos($item['penulis'], $keyword) !== false
                    || stripos($item['kategori'], $keyword) !== false;
            }));
        }

        return view('buku.index', [
            'buku' => $buku,
            'keyword' => $keyword
        ]);
    }

    public function show($id)
    {
        $buku = null;

        foreach ($this->buku as $item) {
            if ($item['id'] == $id) {
                $buku = $item;
                break;
            }
        }

        return view('buku.show', [
            'buku' => $buku
        ]);
    }
}