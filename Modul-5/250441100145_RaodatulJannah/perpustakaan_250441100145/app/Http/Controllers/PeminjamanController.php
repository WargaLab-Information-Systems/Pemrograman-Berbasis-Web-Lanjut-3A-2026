<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use Illuminate\Http\Request;

class PeminjamanController extends Controller
{
    // Pengajuan peminjaman oleh siswa
    public function store(Request $request)
    {
        $request->validate([
            'buku_id' => 'required|exists:bukus,id',
        ]);

        $anggota = $request->user()->anggota;

        if (!$anggota) {
            abort(403, 'Data anggota belum terhubung dengan akun.');
        }

        Peminjaman::create([
            'anggota_id' => $anggota->id,
            'buku_id' => $request->buku_id,
            'tanggal_pinjam' => now()->toDateString(),
            'status' => 'menunggu',
            'tanggal_kembali' => null,
        ]);

        return redirect()
            ->route('peminjaman.riwayat')
            ->with('success', 'Pengajuan peminjaman berhasil dikirim.');
    }


    // Daftar peminjaman untuk Admin dan Petugas
    public function index()
    {
        $peminjamans = Peminjaman::with(['buku', 'anggota'])
            ->orderByDesc('id')
            ->get();

        // Halaman khusus Admin
        if (request()->user()->hasRole('admin')) {
            return view('admin.peminjaman.index', compact('peminjamans'));
        }

        // Halaman khusus Petugas
        return view('petugas.peminjaman.index', compact('peminjamans'));
    }


    // Persetujuan atau penolakan pengajuan
    public function updateStatus(Request $request, Peminjaman $peminjaman)
    {
        $request->validate([
            'status' => 'required|in:disetujui,ditolak',
        ]);

        if ($peminjaman->status !== 'menunggu') {
            return back()->with('error', 'Pengajuan ini sudah diproses.');
        }

        $peminjaman->update([
            'status' => $request->status,
        ]);

        // Kembali ke halaman sesuai role
        if ($request->user()->hasRole('admin')) {
            return redirect()
                ->route('admin.peminjaman.index')
                ->with('success', 'Status peminjaman berhasil diperbarui.');
        }

        return redirect()
            ->route('petugas.peminjaman.index')
            ->with('success', 'Status peminjaman berhasil diperbarui.');
    }
}