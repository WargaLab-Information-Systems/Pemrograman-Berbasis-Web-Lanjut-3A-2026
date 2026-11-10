<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Kategori;
use App\Models\Buku;

class RekapController extends Controller
{
    public function bukuPerKategori()
    {
        $rekap = Kategori::withCount('bukus')->get();

        return response()->json([
            'status' => 'success',
            'message' => 'Rekap jumlah buku per kategori',
            'data' => $rekap
        ], 200);
    }

    public function peminjamanPerBuku()
    {
        $rekap = Buku::withCount('peminjamans')->get();

        return response()->json([
            'status' => 'success',
            'message' => 'Rekap total peminjaman per buku',
            'data' => $rekap
        ], 200);
    }
}