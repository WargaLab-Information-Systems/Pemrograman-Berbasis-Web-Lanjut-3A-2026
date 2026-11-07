<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BukuController extends Controller
{

    private $dataBuku = [
        [
            'id' => 1,
            'judul' => 'Laskar Pelangi',
            'penulis' => 'Andrea Hirata',
            'tahun_terbit' => 2005,
            'kategori' => 'Novel / Fiksi'
        ],
        [
            'id' => 2,
            'judul' => 'Bumi Manusia',
            'penulis' => 'Pramoedya Ananta Toer',
            'tahun_terbit' => 1980,
            'kategori' => 'Sejarah / Fiksi'
        ],
        [
            'id' => 3,
            'judul' => 'Filosofi Teras',
            'penulis' => 'Henry Manampiring',
            'tahun_terbit' => 2018,
            'kategori' => 'Pengembangan Diri'
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
            'judul' => 'Clean Code',
            'penulis' => 'Robert C. Martin',
            'tahun_terbit' => 2008,
            'kategori' => 'Teknologi / Pemrograman'
        ],
        [
            'id' => 6,
            'judul' => 'The Pragmatic Programmer ',
            'penulis' => 'Andrew Hunt dan David Thomas',
            'tahun_terbit' => 1999,
            'kategori' => 'Teknologi / Pemrograman'
        ],
    ];


    public function home()
    {
        return view('home');
    }

    public function index()
    {
        return view('buku.index', [
            'bukuList' => $this->dataBuku
        ]);
    }


    public function show($id)
    {

        $buku = collect($this->dataBuku)->firstWhere('id', $id);

        return view('buku.show', [
            'buku' => $buku
        ]);
    }
}