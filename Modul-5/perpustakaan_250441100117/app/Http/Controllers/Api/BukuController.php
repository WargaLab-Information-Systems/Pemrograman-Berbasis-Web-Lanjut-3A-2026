<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBukuRequest;
use App\Http\Requests\UpdateBukuRequest;
use App\Models\Buku;
use App\Http\Resources\BukuResource;
use Illuminate\Http\Request;

class BukuController extends Controller
{
    public function index(Request $request)
    {
        $query = Buku::with('kategori')->withCount('peminjaman');

        if ($request->filled('cari')) {
            $cari = $request->cari;
            $query->where(function ($q) use ($cari) {
                $q->where('judul', 'like', "%{$cari}%")
                  ->orWhere('penulis', 'like', "%{$cari}%");
            });
        }

        if ($request->filled('kategori')) {
            $query->where('kategori_id', $request->kategori);
        }

        if ($request->filled('tahun')) {
            $query->where('tahun_terbit', $request->tahun);
        }

        $buku = $query->orderBy('created_at', 'desc')->paginate(10);
        $buku->appends($request->query());

        return response()->json([
            'data' => BukuResource::collection($buku->items()),
            'meta' => [
                'current_page' => $buku->currentPage(),
                'per_page'     => $buku->perPage(),
                'total'        => $buku->total(),
                'last_page'    => $buku->lastPage(),
                'from'         => $buku->firstItem(),
                'to'           => $buku->lastItem(),
            ],
        ], 200);
    }

    public function store(StoreBukuRequest $request)
    {
        $buku = Buku::create($request->validated());
        $buku->load('kategori');
        $buku->loadCount('peminjaman');

        return response()->json([
            'message' => 'Buku berhasil ditambahkan.',
            'data'    => new BukuResource($buku),
        ], 201);
    }

    public function show(string $id)
    {
        $buku = Buku::with(['kategori', 'peminjaman'])->find($id);

        if (!$buku) {
            return response()->json(['message' => 'Buku tidak ditemukan.'], 404);
        }

        return response()->json(['data' => new BukuResource($buku)], 200);
    }

    public function update(UpdateBukuRequest $request, string $id)
    {
        $buku = Buku::find($id);

        if (!$buku) {
            return response()->json(['message' => 'Buku tidak ditemukan.'], 404);
        }

        $buku->update($request->validated());
        $buku->load('kategori');
        $buku->loadCount('peminjaman');

        return response()->json([
            'message' => 'Buku berhasil diperbarui.',
            'data'    => new BukuResource($buku),
        ], 200);
    }

    public function destroy(string $id)
    {
        $buku = Buku::find($id);

        if (!$buku) {
            return response()->json(['message' => 'Buku tidak ditemukan.'], 404);
        }

        $buku->delete();

        return response()->json(['message' => 'Buku berhasil dihapus.'], 200);
    }
}