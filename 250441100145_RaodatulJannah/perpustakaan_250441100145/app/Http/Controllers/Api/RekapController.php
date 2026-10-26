<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Kategori;
use App\Models\Buku;
use App\Models\Peminjaman;
use Illuminate\Http\JsonResponse;

class RekapController extends Controller
{
    public function bukuPerKategori(): JsonResponse
    {
        $data = Kategori::withCount('buku')->get();

        return response()->json([
            'message' => 'Rekap jumlah buku per kategori berhasil diambil',
            'data' => $data
        ], 200);
    }

    public function peminjamanPerBuku(): JsonResponse
    {
        $data = Buku::withCount('peminjaman')->get();

        return response()->json([
            'message' => 'Rekap jumlah peminjaman per buku berhasil diambil',
            'data' => $data
        ], 200);
    }
}
