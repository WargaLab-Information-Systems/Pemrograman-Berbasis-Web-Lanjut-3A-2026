<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Kategori;
use Illuminate\Http\Request;

class BukuWebController extends Controller
{
    // Menampilkan halaman Kelola Data Buku
    public function index(Request $request)
    {
        $query = Buku::with('kategori')->latest();

        if ($request->filled('cari')) {
            $cari = $request->cari;
            $query->where(function ($q) use ($cari) {
                $q->where('judul', 'like', "%{$cari}%")
                  ->orWhere('penulis', 'like', "%{$cari}%");
            });
        }

        $bukus = $query->get(); // Mengambil data buku langsung dari DB
        $kategoris = Kategori::all(); // Mengambil kategori dari DB

        return view('buku.index', compact('bukus', 'kategoris'));
    }

    // Simpan Data Buku Baru
    public function store(Request $request)
    {
        $validated = $request->validate([
            'kategori_id'  => 'required|exists:kategoris,id',
            'judul'        => 'required|string|min:3|max:150|unique:bukus,judul',
            'penulis'      => 'required|string|min:3|max:100',
            'tahun_terbit' => 'required|integer|between:1900,' . date('Y'),
        ], [
            'kategori_id.required' => 'Pilih kategori buku terlebih dahulu!',
            'kategori_id.exists'   => 'Kategori tidak valid.',
            'judul.required'       => 'Judul buku wajib diisi!',
            'judul.min'            => 'Judul buku minimal 3 karakter!',
            'judul.unique'         => 'Buku dengan judul ini sudah terdaftar!',
            'penulis.required'     => 'Nama penulis wajib diisi!',
            'penulis.min'          => 'Nama penulis minimal 3 karakter!',
            'tahun_terbit.required' => 'Tahun terbit wajib diisi!',
            'tahun_terbit.between'  => 'Tahun terbit harus antara tahun 1900 hingga tahun ' . date('Y') . '!',
        ]);

        Buku::create($validated);

        return redirect()->route('buku.index')->with('success', 'Buku berhasil ditambahkan!');
    }

    // Detail Buku
    public function show(int $id)
    {
        $buku = Buku::with('kategori')->findOrFail($id);
        return view('buku.show', compact('buku'));
    }

    // Form Edit Buku
    public function edit(int $id)
    {
        $bukuEdit = Buku::findOrFail($id);
        $bukus = Buku::with('kategori')->latest()->get();
        $kategoris = Kategori::all();

        return view('buku.index', compact('bukus', 'kategoris', 'bukuEdit'));
    }

    // Update Data Buku
    public function update(Request $request, int $id)
    {
        $buku = Buku::findOrFail($id);

        $validated = $request->validate([
            'kategori_id'  => 'required|exists:kategoris,id',
            'judul'        => 'required|string|min:3|max:150|unique:bukus,judul,' . $id,
            'penulis'      => 'required|string|min:3|max:100',
            'tahun_terbit' => 'required|integer|between:1900,' . date('Y'),
        ], [
            'kategori_id.required' => 'Pilih kategori buku terlebih dahulu!',
            'judul.required'       => 'Judul buku wajib diisi!',
            'judul.unique'         => 'Judul buku sudah digunakan oleh buku lain!',
            'penulis.required'     => 'Nama penulis wajib diisi!',
            'tahun_terbit.required' => 'Tahun terbit wajib diisi!',
            'tahun_terbit.between'  => 'Tahun terbit harus antara tahun 1900 hingga tahun ' . date('Y') . '!',
        ]);

        $buku->update($validated);

        return redirect()->route('buku.index')->with('success', 'Buku berhasil diperbarui!');
    }

    // Hapus Buku
    public function destroy(int $id)
    {
        $buku = Buku::findOrFail($id);
        $buku->delete();

        return redirect()->route('buku.index')->with('success', 'Buku berhasil dihapus!');
    }
}