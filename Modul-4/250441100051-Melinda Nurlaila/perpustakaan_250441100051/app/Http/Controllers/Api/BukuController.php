<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\StoreBukuRequest;
use App\Http\Requests\UpdateBukuRequest;
use App\Http\Controllers\Controller;
use App\Models\Buku;
use App\Http\Resources\BukuResource;
use Illuminate\Http\Request;

class BukuController extends Controller
{
    
    public function index(Request $request)
    {
        $query = Buku::with('kategori')
            ->withCount('peminjamans');

        if ($request->filled('cari')) {
            $cari = $request->cari;

            $query->where(function ($q) use ($cari) {
                $q->where('judul', 'like', '%' . $cari . '%')
                    ->orWhere('penulis', 'like', '%' . $cari . '%')
                    ->orWhereHas('kategori', function ($kategori) use ($cari) {
                        $kategori->where('nama', 'like', '%' . $cari . '%');
                    });
            });
        }


        if ($request->filled('kategori')) {
            $query->where('kategori_id', $request->kategori);
        }

        if ($request->filled('tahun')) {
            $query->where('tahun_terbit', $request->tahun);
        }

        $buku = $query
            ->orderBy('id', 'desc')
            ->paginate(10)
            ->withQueryString();

        return response()->json([
            'message' => 'Data buku berhasil diambil.',
            'data' => BukuResource::collection(
                $buku->getCollection()
            )->resolve($request),
            'meta' => [
                'current_page' => $buku->currentPage(),
                'per_page' => $buku->perPage(),
                'total' => $buku->total(),
                'last_page' => $buku->lastPage(),
            ],
            'links' => [    
                'first' => $buku->url(1),
                'last' => $buku->url($buku->lastPage()),
                'prev' => $buku->previousPageUrl(),
                'next' => $buku->nextPageUrl(),
            ],
        ], 200);
    }


    public function store(StoreBukuRequest $request)
    {
        $buku = Buku::create($request->validated());

        $buku->load('kategori')->loadCount('peminjamans');

        return response()->json([
            'message' => 'Buku berhasil ditambahkan.',
            'data' => (new BukuResource($buku))->resolve($request),
        ], 201);
    }

    public function show(string $id)
    {
        $buku = Buku::with(['kategori', 'peminjamans'])
            ->withCount('peminjamans')
            ->find($id);

        if (!$buku) {
            return response()->json([
                'message' => 'Buku tidak ditemukan.',
            ], 404);
        }

        return response()->json([
            'message' => 'Detail buku berhasil diambil.',
            'data' => (new BukuResource($buku))->resolve(request()),
        ], 200);
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

        $buku->load('kategori')->loadCount('peminjamans');

        return response()->json([
            'message' => 'Buku berhasil diperbarui.',
            'data' => (new BukuResource($buku))->resolve($request),
        ], 200);
    }

    
    public function destroy(string $id)
    {
        $buku = Buku::find($id);

        if (!$buku) {
            return response()->json([
                'message' => 'Buku not found.',
            ], 404);
        }

        $buku->delete();

        return response()->json([
            'message' => 'Buku berhasil dihapus.',
        ], 200);
    }

}