<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use App\Models\Kategori;
use Illuminate\Http\JsonResponse;

class RekapController extends Controller
{
    public function bukuPerKategori(): JsonResponse
    {
        $data = Kategori::withCount('bukus')->get();

        return response()->json([
            'data' => $data,
        ], 200);
    }

    public function peminjamanPerBuku(): JsonResponse
    {
        $data = Buku::withCount('peminjaman')->get();

        return response()->json([
            'data' => $data,
        ], 200);
    }
}