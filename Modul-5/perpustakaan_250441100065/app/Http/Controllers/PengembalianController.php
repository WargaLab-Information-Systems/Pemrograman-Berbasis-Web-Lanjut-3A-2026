<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;

class PengembalianController extends Controller
{
    /** Daftar buku yang sedang dipinjam + yang sudah dikembalikan. */
    public function index()
    {
        return view('pengembalian.index', [
            'dipinjam' => Peminjaman::with(['anggota', 'buku'])
                ->where('status', Peminjaman::DIPINJAM)->oldest('tanggal_pinjam')->get(),
            'selesai' => Peminjaman::with(['anggota', 'buku'])
                ->where('status', Peminjaman::DIKEMBALIKAN)->latest('tanggal_kembali')->take(10)->get(),
        ]);
    }

    /** Mencatat pengembalian buku. */
    public function store(Peminjaman $peminjaman)
    {
        if ($peminjaman->status !== Peminjaman::DIPINJAM) {
            return back()->with('error', 'Hanya buku berstatus "dipinjam" yang bisa dicatat pengembaliannya.');
        }

        $peminjaman->update([
            'status' => Peminjaman::DIKEMBALIKAN,
            'tanggal_kembali' => now()->toDateString(),
        ]);

        return back()->with('status', 'Pengembalian buku berhasil dicatat.');
    }
}
