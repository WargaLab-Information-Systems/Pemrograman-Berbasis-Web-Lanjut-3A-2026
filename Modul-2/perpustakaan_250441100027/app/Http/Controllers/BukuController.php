<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Buku;

class BukuController extends Controller
{
    private function getDataBuku()
    {
        return Buku::with('kategori')->get()->map(function ($b) {
        return [
            'id'           => $b->id,
            'judul'        => $b->judul,
            'penulis'      => $b->penulis,
            'tahun_terbit' => $b->tahun_terbit,
            'kategori'     => $b->kategori->nama,
            'deskripsi'    => $b->deskripsi,
            'gambar'       => asset($b->gambar),
        ];
        })->all();
        
    }

    public function index(Request $request)
    {
        $buku = $this->getDataBuku();
        $keyword = $request->query('search');

        if ($keyword) {
            $buku = collect($buku)->filter(function ($item) use ($keyword) {
                return stripos($item['judul'], $keyword) !== false ||
                       stripos($item['penulis'], $keyword) !== false ||
                       stripos($item['kategori'], $keyword) !== false;
            })->all();
        }

        return view('buku.index', compact('buku', 'keyword'));
    }

    public function show($id)
    {
        $allBuku = $this->getDataBuku();
        $buku = collect($allBuku)->firstWhere('id', (int) $id);

        return view('buku.show', compact('buku'));
    }
}