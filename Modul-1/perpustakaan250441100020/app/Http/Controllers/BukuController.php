<?php

namespace App\Http\Controllers;

class BukuController extends Controller
{
    public function daftarbuku()
    {
        $buku = [
            [
                'id' => 1,
                'judul' => 'Laskar Pelangi',
                'penulis' => 'Andrea Hirata',
                'tahun' => 2005,
                'kategori' => 'Novel / Fiksi'
            ],
            [
                'id' => 2,
                'judul' => 'Bumi Manusia',
                'penulis' => 'Pramoedya Ananta Toer',
                'tahun' => 1980,
                'kategori' => 'Novel Sejarah / Fiksi'
            ],
            [
                'id' => 3,
                'judul' => 'Atomic Habits',
                'penulis' => 'James Clear',
                'tahun' => 2018,
                'kategori' => 'Nonfiksi / Pengembangan Diri'
            ],
            [
                'id' => 4,
                'judul' => 'Laut Bercerita',
                'penulis' => ' Leila S. Chudori',
                'tahun' => 2017,
                'kategori' => 'Fiksi / Novel Sejarah & Drama'
            ],
            [
                'id' => 5,
                'judul' => 'Jodoh Wasiat Bapak',
                'penulis' => 'Adam Malik',
                'tahun' => 2025,
                'kategori' => 'Sinetron'
            ]
        ];

        return view('buku.index', ['buku' => $buku]);
    }

    public function show($id)
    {
        $buku = [
            [
                'id' => 1,
                'judul' => 'Laskar Pelangi',
                'penulis' => 'Andrea Hirata',
                'tahun' => 2005,
                'kategori' => 'Novel / Fiksi'
            ],
            [
                'id' => 2,
                'judul' => 'Bumi Manusia',
                'penulis' => 'Pramoedya Ananta Toer',
                'tahun' => 1980,
                'kategori' => 'Novel Sejarah / Fiksi'
            ],
            [
                'id' => 3,
                'judul' => 'Atomic Habits',
                'penulis' => 'James Clear',
                'tahun' => 2018,
                'kategori' => 'Nonfiksi / Pengembangan Diri'
            ],
            [
                'id' => 4,
                'judul' => 'Laut Bercerita',
                'penulis' => ' Leila S. Chudori',
                'tahun' => 2017,
                'kategori' => 'Fiksi / Novel Sejarah & Drama'
            ],
            [
                'id' => 5,
                'judul' => 'Jodoh Wasiat Bapak',
                'penulis' => 'Adam Malik',
                'tahun' => 2025,
                'kategori' => 'Sinetron'
            ]
        ];

        foreach ($buku as $item) {
            if ($item['id'] == $id) {
                return view('buku.show', ['item' => $item]);
            }
        }

        return view('buku.show', ['item' => null]);
    }
}
