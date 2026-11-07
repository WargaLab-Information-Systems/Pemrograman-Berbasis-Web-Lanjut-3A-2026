<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\Anggota;
use App\Models\Buku;
use App\Models\Peminjaman;
use Illuminate\Http\Request;

class PeminjamanController extends Controller
{
    public function index()
    {
        $peminjamans = Peminjaman::with(['anggota', 'buku'])
            ->latest()
            ->get();

        return view('petugas.peminjaman.index', compact('peminjamans'));
    }

    public function create()
    {
        $anggotas = Anggota::orderBy('nama')->get();
        $bukus = Buku::orderBy('judul')->get();

        return view('petugas.peminjaman.create', compact('anggotas', 'bukus'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'anggota_id' => 'required|exists:anggotas,id',
            'buku_id' => 'required|exists:bukus,id',
            'tanggal_pinjam' => 'required|date',
        ]);

        $sedangDipinjam = Peminjaman::where('buku_id', $validated['buku_id'])
            ->where('status', 'disetujui')
            ->whereNull('tanggal_kembali')
            ->exists();

        if ($sedangDipinjam) {
            return back()
                ->withInput()
                ->withErrors([
                    'buku_id' => 'Buku ini masih dipinjam dan belum dikembalikan.',
                ]);
        }

        Peminjaman::create([
            'anggota_id' => $validated['anggota_id'],
            'buku_id' => $validated['buku_id'],
            'tanggal_pinjam' => $validated['tanggal_pinjam'],
            'status' => 'disetujui',
        ]);

        return redirect()
            ->route('petugas.peminjaman.index')
            ->with('success', 'Data peminjaman berhasil ditambahkan.');
    }
}
