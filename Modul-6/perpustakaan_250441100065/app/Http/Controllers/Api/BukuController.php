<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBukuRequest;
use App\Http\Requests\UpdateBukuRequest;
use App\Http\Resources\BukuResource;
use App\Models\Buku;
use Illuminate\Http\Request;

class BukuController extends Controller
{
    // GET /api/buku
    public function index(Request $request)
    {
        $query = Buku::with('kategori');

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

        $buku = $query->orderByDesc('id')
                      ->paginate(5)
                      ->withQueryString();

        return BukuResource::collection($buku);
    }

    // POST /api/buku
    public function store(StoreBukuRequest $request)
    {
        $buku = Buku::create($request->validated());
        $buku->load('kategori');

        return (new BukuResource($buku))
            ->additional([
                'message' => 'Buku berhasil ditambahkan.'
            ])
            ->response()
            ->setStatusCode(201);
    }

    // GET /api/buku/{id}
    public function show(string $id)
    {
        $buku = Buku::with('kategori')->find($id);

        if (!$buku) {
            return response()->json([
                'message' => 'Buku tidak ditemukan.'
            ], 404);
        }

        return new BukuResource($buku);
    }

    // PUT /api/buku/{id}
    public function update(UpdateBukuRequest $request, string $id)
    {
        $buku = Buku::find($id);

        if (!$buku) {
            return response()->json([
                'message' => 'Buku tidak ditemukan.'
            ], 404);
        }

        $buku->update($request->validated());
        $buku->load('kategori');

        return (new BukuResource($buku))
            ->additional([
                'message' => 'Buku berhasil diperbarui.'
            ]);
    }

    // DELETE /api/buku/{id}
    public function destroy(string $id)
    {
        $buku = Buku::find($id);

        if (!$buku) {
            return response()->json([
                'message' => 'Buku tidak ditemukan.'
            ], 404);
        }

        $buku->delete();

        return response()->json([
            'message' => 'Buku berhasil dihapus.'
        ]);
    }
}