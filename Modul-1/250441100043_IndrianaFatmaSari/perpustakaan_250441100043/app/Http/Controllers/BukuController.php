<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BukuController extends Controller
{
    private $buku = [
        [
            'id' => 1,
            'judul' => 'Ayah',
            'penulis' => 'Andrea Hirata',
            'tahun' => 2015,
            'kategori' => 'Keluarga'
        ],
        [
            'id' => 2,
            'judul' => 'Pulang',
            'penulis' => 'Tere Liye',
            'tahun' => 2015,
            'kategori' => 'Keluarga'
        ],
        [
            'id' => 3,
            'judul' => 'Hujan',
            'penulis' => 'Tere Liye',
            'tahun' => 2016,
            'kategori' => 'Drama'
        ],
        [
            'id' => 4,
            'judul' => 'Rumah Tanpa Jendela',
            'penulis' => 'Asma Nadia',
            'tahun' => 2011,
            'kategori' => 'Keluarga'
        ],
        [
            'id' => 5,
            'judul' => 'Daun yang Jatuh Tak Pernah Membenci Angin',
            'penulis' => 'Tere Liye',
            'tahun' => 2010,
            'kategori' => 'Drama'
        ]
    ];

    public function index()
    {
        $buku = $this->buku;

        return view('buku.index', compact('buku'));
    }

    public function show($id)
    {
        $buku = null;

        foreach ($this->buku as $data) {
            if ($data['id'] == $id) {
                $buku = $data;
                break;
            }
        }

        return view('buku.show', compact('buku'));
    }
}
