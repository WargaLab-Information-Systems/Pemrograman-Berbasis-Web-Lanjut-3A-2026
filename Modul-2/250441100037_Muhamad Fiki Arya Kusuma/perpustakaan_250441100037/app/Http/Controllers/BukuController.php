<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use Illuminate\Http\Request;

class BukuController extends Controller
{
    // Method Halaman Beranda
    public function home()
    {
        return view('home');
    }

    // Method Halaman Daftar Buku (Mengambil data dari Database via Eloquent ORM)
    public function index()
    {
        // Ambil semua data buku dari database beserta relasi kategorinya
        $bukuList = Buku::with('kategori')->get()->map(function($buku) {
            return [
                'id' => $buku->id,
                'judul' => $buku->judul,
                'penulis' => $buku->penulis,
                'tahun_terbit' => $buku->tahun_terbit,
                'kategori' => $buku->kategori ? $buku->kategori->nama : 'Umum'
            ];
        });

        return view('buku.index', [
            'bukuList' => $bukuList
        ]);
    }

    // Method Halaman Detail Buku (Mengambil 1 data buku berdasarkan ID dari Database)
    public function show(string $id)
    {
        // Cari buku berdasarkan ID di database beserta relasi kategorinya
        $bukuData = Buku::with('kategori')->find($id);

        $buku = null;
        if ($bukuData) {
            $buku = [
                'id' => $bukuData->id,
                'judul' => $bukuData->judul,
                'penulis' => $bukuData->penulis,
                'tahun_terbit' => $bukuData->tahun_terbit,
                'kategori' => $bukuData->kategori ? $bukuData->kategori->nama : 'Umum'
            ];
        }

        return view('buku.show', [
            'buku' => $buku
        ]);
    }
}