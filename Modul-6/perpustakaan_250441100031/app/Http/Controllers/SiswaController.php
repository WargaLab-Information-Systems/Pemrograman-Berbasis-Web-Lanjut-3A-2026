<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Peminjaman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SiswaController extends Controller
{
    public function dashboard()
    {
        $myPeminjamanCount = Peminjaman::where('user_id', Auth::id())->count();
        return view('siswa.dashboard', compact('myPeminjamanCount'));
    }

    // Mengajukan Peminjaman Buku Berdasarkan ID Buku dari URL
    public function ajukanPeminjaman(Request $request, $buku_id)
    {
        // Validasi apakah buku benar-benar ada di database
        $buku = Buku::findOrFail($buku_id);

        // Cek jika siswa sedang meminjam buku yang sama dan belum dikembalikan
        $existing = Peminjaman::where('user_id', Auth::id())
            ->where('buku_id', $buku_id)
            ->whereIn('status', ['diproses', 'dipinjam', 'Pending'])
            ->first();

        if ($existing) {
            return redirect()->back()->with('error', 'Anda sudah mengajukan peminjaman untuk buku ini!');
        }

        // Simpan data peminjaman baru ke database
        Peminjaman::create([
            'user_id'        => Auth::id(),
            'buku_id'        => $buku->id,
            'tanggal_pinjam' => now(),
            'status'         => 'diproses',
        ]);

        return redirect()->route('siswa.riwayat')->with('success', 'Pengajuan peminjaman berhasil dikirim!');
    }

    // Riwayat Peminjaman Milik Sendiri
    public function riwayatPeminjaman()
    {
        $riwayats = Peminjaman::with('buku')
            ->where('user_id', Auth::id()) // Memastikan hanya mengambil data milik pengguna yang login
            ->latest()
            ->get();

        return view('siswa.riwayat', compact('riwayats'));
    }
}