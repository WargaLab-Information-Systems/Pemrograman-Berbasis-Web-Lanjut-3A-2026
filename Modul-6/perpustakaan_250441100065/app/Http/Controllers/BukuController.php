<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBukuRequest;
use App\Http\Requests\UpdateBukuRequest;
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
     * [SOAL 2b - DITAMBAL] Pencarian memakai query binding.
     * Nilai "judul" dikirim sebagai parameter (?), bukan digabung ke string SQL.
     */
    public function cari(Request $request)
    {
        $judul = $request->query('judul');

        $hasil = DB::select('SELECT * FROM bukus WHERE judul = ?', [$judul]);

        return response()->json($hasil);
    }

    /* ---------- [SOAL 2c] CRUD buku lewat form web (dilindungi CSRF) ---------- */

    public function create()
    {
        return view('buku.form', ['buku' => new Buku(), 'kategoris' => Kategori::orderBy('nama')->get()]);
    }

    public function store(StoreBukuRequest $request)
    {
        Buku::create($request->validated());

        return redirect()->route('buku.index')->with('status', 'Buku berhasil ditambahkan.');
    }

    public function edit(Buku $buku)
    {
        return view('buku.form', ['buku' => $buku, 'kategoris' => Kategori::orderBy('nama')->get()]);
    }

    public function update(UpdateBukuRequest $request, Buku $buku)
    {
        $buku->update($request->validated());

        return redirect()->route('buku.index')->with('status', 'Buku berhasil diperbarui.');
    }

    /** Penghapusan HANYA lewat method DELETE (form dengan @csrf dan @method('DELETE')). */
    public function destroy(Buku $buku)
    {
        $buku->delete();

        return redirect()->route('buku.index')->with('status', 'Buku berhasil dihapus.');
    }
}
