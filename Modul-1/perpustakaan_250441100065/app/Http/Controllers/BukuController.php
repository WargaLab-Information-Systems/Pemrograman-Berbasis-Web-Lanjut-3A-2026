<?php

namespace App\Http\Controllers;

class BukuController extends Controller
{
    private $bukuList = [
        [
            'id' => 1,
            'judul' => 'Clean Code: A Handbook of Agile Software Craftsmanship',
            'penulis' => 'Robert C. Martin',
            'tahun' => 2008,
            'kategori' => 'Software Engineering'
        ],
        [
            'id' => 2,
            'judul' => 'The Pragmatic Programmer',
            'penulis' => 'Andrew Hunt & David Thomas',
            'tahun' => 2019,
            'kategori' => 'Software Engineering'
        ],
        [
            'id' => 3,
            'judul' => 'Designing Data-Intensive Applications',
            'penulis' => 'Martin Kleppmann',
            'tahun' => 2017,
            'kategori' => 'Database & System Design'
        ],
        [
            'id' => 4,
            'judul' => 'You Don’t Know JS Yet: Scope & Closures',
            'penulis' => 'Kyle Simpson',
            'tahun' => 2020,
            'kategori' => 'JavaScript'
        ],
        [
            'id' => 5,
            'judul' => 'Laravel Up & Running',
            'penulis' => 'Matt Stauffer',
            'tahun' => 2023,
            'kategori' => 'Web Development'
        ],
        [
            'id' => 6,
            'judul' => 'Python Crash Course',
            'penulis' => 'Eric Matthes',
            'tahun' => 2023,
            'kategori' => 'Python & AI'
        ],
        [
            'id' => 7,
            'judul' => 'Atomic Habits',
            'penulis' => 'James Clear',
            'tahun' => 2018,
            'kategori' => 'Productivity & Self-Improvement'
        ],
        [
            'id' => 8,
            'judul' => 'AI Engineering: Building Applications with Foundation Models',
            'penulis' => 'Chip Huyen',
            'tahun' => 2024,
            'kategori' => 'Artificial Intelligence'
        ],
        [
            'id' => 9,
            'judul' => 'The Phoenix Project: A Novel About IT, DevOps, and Helping Your Business Win',
            'penulis' => 'Gene Kim, Kevin Behr, & George Spafford',
            'tahun' => 2013,
            'kategori' => 'DevOps & IT Management'
        ],
    ];

    public function home()
    {
        return view('home');
    }

    public function index()
    {
        $buku = $this->bukuList;

        return view('buku.index', compact('buku'));
    }

    public function show($id)
    {
        $buku = collect($this->bukuList)->firstWhere('id', $id);

        return view('buku.show', compact('buku'));
    }
}
