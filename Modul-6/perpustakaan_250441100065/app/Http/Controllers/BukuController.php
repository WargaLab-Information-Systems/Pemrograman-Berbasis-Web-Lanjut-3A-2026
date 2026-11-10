<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BukuController extends Controller
{
    /** Beranda (publik). */
    public function home()
    {
        return view('home');
    }

    /** Daftar buku (hanya baca) - untuk semua role yang punya "lihat daftar buku". */
    public function index(Request $request)
    {
        $query = Buku::with('kategori');

        if ($request->filled('q')) {
            $q = $request->q;
            $query->where(function ($w) use ($q) {
                $w->where('judul', 'like', "%{$q}%")->orWhere('penulis', 'like', "%{$q}%");
            });
        }

        if ($request->filled('kategori')) {
            $query->where('kategori_id', $request->kategori);
        }

        return view('buku.index', [
            'buku' => $query->orderBy('judul')->paginate(9)->withQueryString(),
            'kategoris' => Kategori::orderBy('nama')->get(),
        ]);
    }

    /** Detail buku. */
    public function show($id)
    {
        $buku = Buku::with('kategori')->find($id);

        return view('buku.show', compact('buku'));
    }

    /** Halaman kelola buku (tambah/ubah/hapus lewat API) - admin & petugas. */
    public function kelola()
    {
        $kategoris = Kategori::all();

        return view('buku.kelola', compact('kategoris'));
    }

    /**
     * [SOAL 1 - CELAH A2] SQL Injection.
     * Nilai "judul" dari query string digabung LANGSUNG ke string SQL.
     */
    public function cari(Request $request)
    {
        $judul = $request->query('judul');

        $hasil = DB::select("SELECT * FROM bukus WHERE judul = '$judul'");

        return response()->json($hasil);
    }
}
