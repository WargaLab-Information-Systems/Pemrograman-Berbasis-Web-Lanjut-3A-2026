<?php

namespace App\Http\Controllers;

class BukuController extends Controller
{
    private function getBuku()
    {
        return [
            [
                'id' => 1,
                'judul' => 'Laskar Pelangi',
                'penulis' => 'Andrea Hirata',
                'tahun' => 2005,
                'kategori' => 'Novel'
            ],
            [
                'id' => 2,
                'judul' => 'Bumi',
                'penulis' => 'Tere Liye',
                'tahun' => 2014,
                'kategori' => 'Fiksi'
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
    }

    public function index()
    {
        $buku = $this->getBuku();

        return view('buku.index', compact('buku'));
    }

    public function show($id)
    {
        $buku = $this->getBuku();

        $bukuDetail = null;

        foreach ($buku as $item) {
            if ($item['id'] == $id) {
                $bukuDetail = $item;
            }
        }

        return view('buku.show', compact('bukuDetail'));
    }
}
