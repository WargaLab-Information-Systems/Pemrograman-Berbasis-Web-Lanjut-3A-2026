<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use Illuminate\Http\Request;

class BukuController extends Controller
{
    /**
     * Menampilkan daftar semua buku beserta relasi kategorinya.
     */
    public function index()
    {
        return response()->json(Buku::with('kategori')->get(), 200);
    }

    /**
     * Menyimpan data buku baru ke database.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'kategori_id' => 'required|exists:kategoris,id',
            'judul'       => 'required|string|max:255',
            'penulis'     => 'required|string|max:255',
            'tahun_terbit'=> 'required|integer',
            'deskripsi'   => 'nullable|string',
            'gambar'      => 'nullable|string',
        ]);

        $buku = Buku::create($validated);

        return response()->json([
            'message' => 'Buku berhasil ditambahkan!',
            'data'    => $buku->load('kategori')
        ], 201);
    }

    /**
     * Menampilkan detail buku tertentu berdasarkan ID.
     */
    public function show($id)
    {
        $buku = Buku::with('kategori')->find($id);

        if (!$buku) {
            return response()->json(['message' => 'Data buku tidak ditemukan.'], 404);
        }

        return response()->json($buku, 200);
    }

    /**
     * Memperbarui data buku yang sudah ada.
     */
    public function update(Request $request, $id)
    {
        $buku = Buku::find($id);

        if (!$buku) {
            return response()->json(['message' => 'Data buku tidak ditemukan.'], 404);
        }

        $validated = $request->validate([
            'kategori_id' => 'sometimes|exists:kategoris,id',
            'judul'       => 'sometimes|string|max:255',
            'penulis'     => 'sometimes|string|max:255',
            'tahun_terbit'=> 'sometimes|integer',
            'deskripsi'   => 'nullable|string',
            'gambar'      => 'nullable|string',
        ]);

        $buku->update($validated);

        return response()->json([
            'message' => 'Buku berhasil diperbarui!',
            'data'    => $buku->load('kategori')
        ], 200);
    }

    /**
     * Menghapus data buku dari database.
     */
    public function destroy($id)
    {
        $buku = Buku::find($id);

        if (!$buku) {
            return response()->json(['message' => 'Data buku tidak ditemukan.'], 404);
        }

        $buku->delete();

        return response()->json(['message' => 'Buku berhasil dihapus!'], 200);
    }
}