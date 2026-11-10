<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use App\Models\Buku;
use Illuminate\Http\Request;

class PetugasController extends Controller
{
    public function dashboard()
    {
        $pendingPeminjaman = Peminjaman::where('status', 'diproses')->count();
        $bukuDipinjam = Peminjaman::where('status', 'dipinjam')->count();

        return view('petugas.dashboard', compact('pendingPeminjaman', 'bukuDipinjam'));
    }

    // Kelola Transaksi Peminjaman
    public function peminjamanIndex()
    {
        $peminjamans = Peminjaman::with(['user', 'buku'])->latest()->get();
        return view('petugas.peminjaman', compact('peminjamans'));
    }

    // Memproses Persetujuan Peminjaman (Setuju / Tolak)
    public function updateStatusPeminjaman(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:dipinjam,ditolak,dikembalikan'
        ]);

        $peminjaman = Peminjaman::findOrFail($id);
        
        if ($request->status === 'dikembalikan') {
            $peminjaman->tanggal_kembali = now();
        }

        $peminjaman->status = $request->status;
        $peminjaman->save();

        return redirect()->back()->with('success', 'Status peminjaman berhasil diperbarui!');
    }
}