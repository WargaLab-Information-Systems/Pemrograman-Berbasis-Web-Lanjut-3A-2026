<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use App\Models\Kategori;

class RekapController extends Controller
{
    // GET /api/rekap/buku-per-kategori
    public function bukuPerKategori()
    {
        $data = Kategori::withCount('bukus')->get();

        return response()->json([
            'message' => 'Rekap jumlah buku per kategori berhasil diambil',
            'data' => $data
        ], 200);
    }

    // GET /api/rekap/peminjaman-per-buku
    public function peminjamanPerBuku()
    {
        $data = Buku::withCount('peminjamans')->get();

        return response()->json([
            'message' => 'Rekap jumlah peminjaman per buku berhasil diambil',
            'data' => $data
        ], 200);
    }
}
