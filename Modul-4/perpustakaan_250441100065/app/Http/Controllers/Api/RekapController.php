<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use App\Models\Kategori;

class RekapController extends Controller
{
    public function bukuPerKategori()
    {
        $data = Kategori::withCount('bukus')->get();
        return response()->json(['data' => $data], 200);
    }

    public function peminjamanPerBuku()
    {
        $data = Buku::withCount('peminjamans')->get(['id', 'judul']);
        return response()->json(['data' => $data], 200);
    }
}
