<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BukuController extends Controller
{
    public function index()
    {
        $kategori = Kategori::all();

        // Data buku untuk pengujian XSS
        $buku = Buku::with('kategori')->get();

        return view('buku.index', compact('kategori', 'buku'));
    }

    public function show($id)
    {
        $buku = Buku::with('kategori')->findOrFail($id);

        return view('buku.show', compact('buku'));
    }

    // A2: SQL Injection
    public function cari(Request $request)
{
    $judul = $request->query('judul', '');

    $hasil = DB::select(
        "SELECT * FROM bukus WHERE judul = ?",
        [$judul]
    );

    return response()->json($hasil);
}
}
