<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use App\Models\Peminjaman;

class PengajuanPeminjamanController extends Controller
{
    public function index()
    {
        $bukus = Buku::with('kategori')
            ->orderBy('judul')
            ->get();

        return view('siswa.pengajuan.index', compact('bukus'));
    }

    public function store(\Illuminate\Http\Request $request)
    {
        $validated = $request->validate([
            'buku_id' => 'required|exists:bukus,id',
        ]);

        $anggota = auth()->user()->anggota;

        if (!$anggota) {
            return back()->withErrors([
                'anggota' => 'Data anggota belum terhubung dengan akun kamu.',
            ]);
        }

        $masihDipinjam = Peminjaman::where('buku_id', $validated['buku_id'])
            ->where('status', 'disetujui')
            ->whereNull('tanggal_kembali')
            ->exists();

        if ($masihDipinjam) {
            return back()->withErrors([
                'buku_id' => 'Buku sedang dipinjam dan belum dikembalikan.',
            ]);
        }

        $sudahMengajukan = Peminjaman::where('anggota_id', $anggota->id)
            ->where('buku_id', $validated['buku_id'])
            ->where('status', 'menunggu')
            ->exists();

        if ($sudahMengajukan) {
            return back()->withErrors([
                'buku_id' => 'Kamu sudah mengajukan buku ini dan masih menunggu persetujuan.',
            ]);
        }

        Peminjaman::create([
            'anggota_id' => $anggota->id,
            'buku_id' => $validated['buku_id'],
            'tanggal_pinjam' => now()->toDateString(),
            'status' => 'menunggu',
        ]);

        return redirect()
            ->route('siswa.status.index')
            ->with('success', 'Pengajuan peminjaman berhasil dikirim.');
    }
}