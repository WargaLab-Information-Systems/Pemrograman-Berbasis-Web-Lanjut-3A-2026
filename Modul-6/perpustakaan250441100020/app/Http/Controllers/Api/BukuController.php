<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\BukuResource;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBukuRequest;
use App\Http\Requests\UpdateBukuRequest;
use App\Models\Buku;
use Illuminate\Http\Request;

class BukuController extends Controller
{
    
    public function index(Request $request)
    {
        $query = Buku::with('kategori')
            ->withCount('peminjamans')
            ->latest();

        
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

        
        $buku = $query->paginate(10)->withQueryString();

        return BukuResource::collection($buku);
    }

    
    public function store(StoreBukuRequest $request)
    {
        $buku = Buku::create($request->validated());

        $buku->load('kategori');
        $buku->loadCount('peminjamans');

        return response()->json([
            'message' => 'Buku berhasil ditambahkan.',
            'data' => $buku,
        ], 201);
    }

   
    public function show(string $id)
    {
        $buku = Buku::with(['kategori', 'peminjamans'])
            ->withCount('peminjamans')
            ->find($id);

        if (!$buku) {
            return response()->json([
                'message' => 'not found',
            ], 404);
        }

        return response()->json([
            'data' => $buku,
        ], 200);
    }


    public function update(UpdateBukuRequest $request, string $id)
    {
        $buku = Buku::find($id);

        if (!$buku) {
            return response()->json([
                'message' => 'not found',
            ], 404);
        }

        $buku->update($request->validated());

        $buku->load('kategori');
        $buku->loadCount('peminjamans');

        return response()->json([
            'message' => 'Buku berhasil diperbarui.',
            'data' => $buku,
        ], 200);
    }

   
    public function destroy(string $id)
    {
        $buku = Buku::find($id);

        if (!$buku) {
            return response()->json([
                'message' => 'not found',
            ], 404);
        }

        $buku->delete();

        return response()->json([
            'message' => 'Buku berhasil dihapus',
        ], 200);
    }
}
