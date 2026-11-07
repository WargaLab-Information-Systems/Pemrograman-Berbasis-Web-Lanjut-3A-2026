<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use App\Http\Resources\BukuResource;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class BukuController extends Controller
{

    public function index()
    {
        $bukus = Buku::all();
        return BukuResource::collection($bukus);
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'kategori_id'  => 'required|numeric|exists:kategoris,id',
            'judul'        => 'required|string|min:3|max:255|unique:bukus,judul',
            'penulis'      => 'required|string|min:3|max:255',
            'tahun_terbit' => 'required|integer|min:1900|max:' . date('Y'),
        ], [
            'kategori_id.required' => 'Kategori ID wajib diisi.',
            'kategori_id.exists'   => 'Kategori ID tidak ditemukan di basis data.',
            'judul.required'       => 'Judul buku wajib diisi.',
            'judul.min'            => 'Judul buku minimal harus 3 karakter.',
            'judul.unique'         => 'Judul buku sudah ada di basis data.',
            'penulis.required'     => 'Nama penulis wajib diisi.',
            'penulis.min'          => 'Nama penulis minimal harus 3 karakter.',
            'tahun_terbit.required'=> 'Tahun terbit wajib diisi.',
            'tahun_terbit.integer' => 'Tahun terbit harus berupa angka.',
            'tahun_terbit.min'     => 'Tahun terbit harus minimal tahun 1900.',
            'tahun_terbit.max'     => 'Tahun terbit tidak boleh melebihi tahun saat ini.',
        ]);

        $buku = Buku::create($validated);

        return response()->json([
            'message' => 'Buku berhasil ditambahkan',
            'data'    => new BukuResource($buku)
        ], 201);
    }

    
    public function show($id)
    {
        $buku = Buku::find($id);
        if (!$buku) {
            return response()->json(['message' => 'Buku tidak ditemukan'], 404);
        }
        return new BukuResource($buku);
    }

    
    public function update(Request $request, $id)
    {
        $buku = Buku::find($id);
        if (!$buku) {
            return response()->json(['message' => 'Buku tidak ditemukan'], 404);
        }

        $validated = $request->validate([
            'kategori_id'  => 'required|numeric|exists:kategoris,id',
            'judul'        => ['required', 'string', 'min:3', 'max:255', Rule::unique('bukus', 'judul')->ignore($id)],
            'penulis'      => 'required|string|min:3|max:255',
            'tahun_terbit' => 'required|integer|min:1900|max:' . date('Y'),
        ], [
            'kategori_id.required' => 'Kategori ID wajib diisi.',
            'kategori_id.exists'   => 'Kategori ID tidak ditemukan di basis data.',
            'judul.required'       => 'Judul buku wajib diisi.',
            'judul.min'            => 'Judul buku minimal harus 3 karakter.',
            'judul.unique'         => 'Judul buku sudah digunakan oleh buku lain.',
            'penulis.required'     => 'Nama penulis wajib diisi.',
            'penulis.min'          => 'Nama penulis minimal harus 3 karakter.',
            'tahun_terbit.required'=> 'Tahun terbit wajib diisi.',
            'tahun_terbit.integer' => 'Tahun terbit harus berupa angka.',
            'tahun_terbit.min'     => 'Tahun terbit harus minimal tahun 1900.',
            'tahun_terbit.max'     => 'Tahun terbit tidak boleh melebihi tahun saat ini.',
        ]);

        $buku->update($validated);

        return response()->json([
            'message' => 'Buku berhasil diperbarui',
            'data'    => new BukuResource($buku)
        ], 200);
    }


    public function destroy($id)
    {
        $buku = Buku::find($id);
        if (!$buku) {
            return response()->json(['message' => 'Buku tidak ditemukan'], 404);
        }

        $buku->delete();

        return response()->json(['message' => 'Buku berhasil dihapus'], 200);
    }
}