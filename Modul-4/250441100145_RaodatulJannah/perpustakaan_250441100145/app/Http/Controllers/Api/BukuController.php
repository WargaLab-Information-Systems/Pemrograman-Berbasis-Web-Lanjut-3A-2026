<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBukuRequest;
use App\Http\Requests\UpdateBukuRequest;
use App\Models\Buku;
use Illuminate\Http\Request;
use App\Http\Resources\BukuResource;

class BukuController extends Controller
{
    public function index(Request $request)
    {
        $buku = Buku::with('kategori')->withCount('peminjaman');

        if ($request->filled('cari')) {
            $cari = $request->cari;

            $buku->where(function ($query) use ($cari) {
                $query->where('judul', 'like', "%{$cari}%")
                    ->orWhere('penulis', 'like', "%{$cari}%");
            });
        }

        if ($request->filled('kategori')) {
            $buku->where('kategori_id', $request->kategori);
        }

        if ($request->filled('tahun')) {
            $buku->where('tahun_terbit', $request->tahun);
        }

        return BukuResource::collection(
            $buku->latest('id')
                ->paginate(10)
                ->appends($request->query())
        );
    }

    public function store(StoreBukuRequest $request)
    {
        $buku = Buku::create($request->validated());

        return response()->json([
            'message' => 'Buku berhasil ditambahkan.',
            'data' => $buku->load('kategori'),
        ], 201);
    }

    public function show(string $id)
    {
        $buku = Buku::with('kategori')
            ->withCount('peminjaman')
            ->find($id);

        if (!$buku) {
            return response()->json([
                'message' => 'Buku tidak ditemukan.',
            ], 404);
        }

        return response()->json($buku, 200);
    }

    public function update(UpdateBukuRequest $request, string $id)
    {
        $buku = Buku::find($id);

        if (!$buku) {
            return response()->json([
                'message' => 'Buku tidak ditemukan.',
            ], 404);
        }

        $buku->update($request->validated());

        return response()->json([
            'message' => 'Buku berhasil diperbarui.',
            'data' => $buku->load('kategori'),
        ], 200);
    }

    public function destroy(string $id)
    {
        $buku = Buku::find($id);

        if (!$buku) {
            return response()->json([
                'message' => 'Buku tidak ditemukan.',
            ], 404);
        }

        $buku->delete();

        return response()->json([
            'message' => 'Buku berhasil dihapus.',
        ], 200);
    }
}
