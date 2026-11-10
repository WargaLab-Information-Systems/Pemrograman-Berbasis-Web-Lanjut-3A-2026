<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use Illuminate\Http\Request;

class BukuController extends Controller
{
    public function index()
    {
        $daftarBuku = Buku::with('kategori')->get()->map(function ($buku) {
            return [
                'id' => $buku->id,
                'judul' => $buku->judul,
                'penulis' => $buku->penulis,
                'tahun' => $buku->tahun_terbit,
                'kategori' => $buku->kategori ? $buku->kategori->nama : 'Umum',
                'deskripsi' => $buku->deskripsi,
                'gambar' => $buku->gambar,
            ];
        });

        return view('buku.index', ['daftarBuku' => $daftarBuku]);
    }

    public function show($id)
    {
        $buku = Buku::with('kategori')->find($id);

        $bukuDetail = null;
        if ($buku) {
            $bukuDetail = [
                'id' => $buku->id,
                'judul' => $buku->judul,
                'penulis' => $buku->penulis,
                'tahun' => $buku->tahun_terbit,
                'kategori' => $buku->kategori ? $buku->kategori->nama : 'Umum',
                'deskripsi' => $buku->deskripsi,
                'gambar' => $buku->gambar,
            ];
        }

        return view('buku.show', ['buku' => $bukuDetail]);
    }
}