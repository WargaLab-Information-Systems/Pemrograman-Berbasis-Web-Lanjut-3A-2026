<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use Illuminate\Http\Request;

class PengembalianController extends Controller
{
    public function index(Request $request)
    {
        $peminjamans = Peminjaman::with(['buku', 'anggota'])
            ->where('status', 'disetujui')
            ->orderByDesc('id')
            ->get();

        if ($request->user()->hasRole('admin')) {
            return view('admin.pengembalian.index', compact('peminjamans'));
        }

        return view('petugas.pengembalian.index', compact('peminjamans'));
    }

    public function update(Request $request, Peminjaman $peminjaman)
    {
        if ($peminjaman->status !== 'disetujui') {
            return back()->with(
                'error',
                'Peminjaman ini tidak dapat dikembalikan.'
            );
        }

        $peminjaman->update([
            'status' => 'dikembalikan',
            'tanggal_kembali' => now()->toDateString(),
        ]);

        if ($request->user()->hasRole('admin')) {
            return redirect()
                ->route('admin.pengembalian.index')
                ->with('success', 'Buku berhasil dikembalikan.');
        }

        return redirect()
            ->route('petugas.pengembalian.index')
            ->with('success', 'Buku berhasil dikembalikan.');
    }
}