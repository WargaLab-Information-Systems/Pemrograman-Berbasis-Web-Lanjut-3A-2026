<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
use Illuminate\Http\Request;

class PengembalianController extends Controller
{
    public function index()
    {
        $peminjamans = Peminjaman::with(['anggota', 'buku'])
            ->where('status', 'disetujui')
            ->whereNull('tanggal_kembali')
            ->latest()
            ->get();

        return view('petugas.pengembalian.index', compact('peminjamans'));
    }

    public function kembalikan(Request $request, Peminjaman $peminjaman)
    {
        if ($peminjaman->status !== 'disetujui') {
            return back()->with('error', 'Peminjaman ini belum disetujui.');
        }

        if ($peminjaman->tanggal_kembali !== null) {
            return back()->with('error', 'Buku ini sudah dikembalikan.');
        }

        $validated = $request->validate([
            'tanggal_kembali' => 'required|date|after_or_equal:' . $peminjaman->tanggal_pinjam,
        ]);

        $peminjaman->update([
            'tanggal_kembali' => $validated['tanggal_kembali'],
        ]);

        return redirect()
            ->route('petugas.pengembalian.index')
            ->with('success', 'Buku berhasil dikembalikan.');
    }
}
