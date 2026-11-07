<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use Illuminate\Http\Request;

class BukuController extends Controller
{
    public function index(Request $request)
    {
        $keyword = $request->query('q');

        $buku = Buku::with('kategori')
            ->when($keyword, function ($query) use ($keyword) {
                $query->where('judul', 'like', '%' . $keyword . '%')
                    ->orWhere('penulis', 'like', '%' . $keyword . '%')
                    ->orWhereHas('kategori', function ($query) use ($keyword) {
                        $query->where('nama', 'like', '%' . $keyword . '%');
                    });
            })
            ->get();

        return view('buku.index', [
            'buku' => $buku,
            'keyword' => $keyword
        ]);
    }

    public function show($id)
    {
        $buku = Buku::with('kategori')->find($id);

        return view('buku.show', [
            'buku' => $buku
        ]);
    }
}