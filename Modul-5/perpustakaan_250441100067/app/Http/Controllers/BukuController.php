<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Kategori;

class BukuController extends Controller
{
    public function index()
    {
        $kategori = Kategori::all();

        return view('buku.index', compact('kategori'));
    }

    public function show($id)
    {
        $buku = Buku::with('kategori')->findOrFail($id);

        return view('buku.show', compact('buku'));
    }
}
