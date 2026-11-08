<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use App\Models\Kategori;


class RekapController extends Controller
{
    
    public function bukuPerKategori()
    {
        $rekap = Kategori::withCount('bukus')->get();

        return response()->json($rekap, 200);
    }

   
    public function peminjamanPerBuku()
    {
        $rekap = Buku::withCount('peminjamans')->get();

        return response()->json($rekap, 200);
    }
}
