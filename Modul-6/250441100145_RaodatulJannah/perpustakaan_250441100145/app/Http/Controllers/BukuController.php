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
        $buku = Buku::with('kategori')->get();

        return view('buku.index', compact('kategori', 'buku'));
    }

    public function show(int $id)
    {
        $bukuDetail = Buku::with('kategori')->find($id);

        if ($bukuDetail) {
            $bukuDetail = [
                'id' => $bukuDetail->id,
                'judul' => $bukuDetail->judul,
                'penulis' => $bukuDetail->penulis,
                'tahun' => $bukuDetail->tahun_terbit,
                'kategori' => $bukuDetail->kategori->nama ?? '-',
            ];
        }

        return view('buku.show', compact('bukuDetail'));
    }

    public function cari(Request $request)
    {
        $judul = $request->query('judul');

        $hasil = DB::select(
            "SELECT * FROM bukus WHERE judul = ?",
            [$judul]
        );

        return response()->json($hasil);
    }
}
