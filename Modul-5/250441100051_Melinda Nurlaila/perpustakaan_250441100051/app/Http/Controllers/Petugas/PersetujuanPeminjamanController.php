<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
use Illuminate\Http\Request;

class PersetujuanPeminjamanController extends Controller
{
    public function index()
    {
        $peminjamans = Peminjaman::with(['anggota', 'buku'])
            ->where('status', 'menunggu')
            ->latest()
            ->get();

        return view('petugas.persetujuan.index', compact('peminjamans'));
    }

    public function proses(Request $request, Peminjaman $peminjaman)
    {
        $validated = $request->validate([
            'status' => 'required|in:disetujui,ditolak',
        ]);

        if ($peminjaman->status !== 'menunggu') {
            return back()->with('error', 'Pengajuan ini sudah diproses.');
        }

        if ($validated['status'] === 'disetujui') {
            $sedangDipinjam = Peminjaman::where('buku_id', $peminjaman->buku_id)
                ->where('status', 'disetujui')
                ->whereNull('tanggal_kembali')
                ->exists();

            if ($sedangDipinjam) {
                return back()->with('error', 'Buku sedang dipinjam oleh anggota lain.');
            }
        }

        $peminjaman->update([
            'status' => $validated['status'],
        ]);

        return redirect()
            ->route('petugas.persetujuan.index')
            ->with('success', 'Pengajuan peminjaman berhasil diproses.');
    }
}
