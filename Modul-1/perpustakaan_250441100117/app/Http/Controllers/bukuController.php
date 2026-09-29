<?php

namespace App\Http\Controllers;

class BukuController extends Controller
{
 
    private function dataBuku()
    {
        return [
            [
                'id' => 1,
                'judul' => 'Laskar Pelangi',
                'penulis' => 'Andrea Hirata',
                'tahun' => 2005,
                'kategori' => 'Novel',
            ],
            [
                'id' => 2,
                'judul' => 'Bumi Manusia',
                'penulis' => 'Pramoedya Ananta Toer',
                'tahun' => 1980,
                'kategori' => 'Sejarah',
            ],
            [
                'id' => 3,
                'judul' => 'Negeri 5 Menara',
                'penulis' => 'Ahmad Fuadi',
                'tahun' => 2009,
                'kategori' => 'Novel',
            ],
            [
                'id' => 4,
                'judul' => 'Filosofi Teras',
                'penulis' => 'Henry Manampiring',
                'tahun' => 2018,
                'kategori' => 'Filsafat',
            ],
            [
                'id' => 5,
                'judul' => 'Cantik Itu Luka',
                'penulis' => 'Yuval Noah Harari',
                'tahun' => 2011,
                'kategori' => 'Sejarah',
            ],
        ];
    }

    public function index()
    {
        $buku = $this->dataBuku();
        return view('buku.index', ['buku' => $buku]);
    }

    public function show($id)
    {
        $semuaBuku = $this->dataBuku();
        $buku = null;

        foreach ($semuaBuku as $item) {
            if ($item['id'] == $id) {
                $buku = $item;
                break;
            }
        }

        return view('buku.show', ['buku' => $buku]);
    }
}