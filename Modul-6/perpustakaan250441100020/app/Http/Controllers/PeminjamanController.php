<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Gate;
use App\Models\Peminjaman;
use Illuminate\Http\Request;

class PeminjamanController extends Controller
{
    // Mengajukan peminjaman buku
    public function store(Request $request)
    {
        $request->validate([
            'buku_id' => ['required', 'exists:bukus,id'],
        ]);

        $anggota = $request->user()->anggota;

        if (!$anggota) {
            return back()->withErrors([
                'peminjaman' => 'Data anggota tidak ditemukan.'
            ]);
        }

        $sudahMengajukan = Peminjaman::where('anggota_id', $anggota->id)
            ->where('buku_id', $request->buku_id)
            ->whereIn('status', ['menunggu', 'disetujui'])
            ->exists();

        if ($sudahMengajukan) {
            return back()->withErrors([
                'peminjaman' => 'Kamu masih memiliki pengajuan atau peminjaman aktif untuk buku ini.'
            ]);
        }

        Peminjaman::create([
            'anggota_id' => $anggota->id,
            'buku_id' => $request->buku_id,
            'tanggal_pinjam' => now()->toDateString(),
            'status' => 'menunggu',
        ]);

        return back()->with('success', 'Pengajuan peminjaman berhasil dikirim.');
    }

    // Menampilkan daftar pengajuan peminjaman
    public function index()
    {
        $peminjamans = Peminjaman::with(['anggota', 'buku'])
            ->latest()
            ->get();

        return view('peminjaman.index', [
            'peminjamans' => $peminjamans
        ]);
    }

    // Menyetujui pengajuan peminjaman
    public function setujui($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);

        if ($peminjaman->status !== 'menunggu') {
            return back()->withErrors([
                'peminjaman' => 'Pengajuan ini sudah diproses.'
            ]);
        }

        $peminjaman->update([
            'status' => 'disetujui',
            'disetujui_oleh' => auth()->id(),
            'tanggal_disetujui' => now()->toDateString(),
        ]);

        return back()->with('success', 'Pengajuan peminjaman berhasil disetujui.');
    }

    // Menolak pengajuan peminjaman
    public function tolak($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);

        if ($peminjaman->status !== 'menunggu') {
            return back()->withErrors([
                'peminjaman' => 'Pengajuan ini sudah diproses.'
            ]);
        }

        $peminjaman->update([
            'status' => 'ditolak',
        ]);

        return back()->with('success', 'Pengajuan peminjaman berhasil ditolak.');
    }

    public function kembalikan($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);

        if ($peminjaman->status !== 'disetujui') {
            return back()->withErrors([
                'peminjaman' => 'Hanya peminjaman yang sudah disetujui yang dapat dikembalikan.'
            ]);
        }

        $peminjaman->update([
            'status' => 'dikembalikan',
            'tanggal_kembali' => now()->toDateString(),
        ]);

        return back()->with(
            'success',
            'Pengembalian buku berhasil dicatat.'
        );
    }

    //-----
    public function show($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);

        Gate::authorize('view', $peminjaman);

        return view('peminjaman.show', [
            'peminjaman' => $peminjaman
        ]);
    }
}
