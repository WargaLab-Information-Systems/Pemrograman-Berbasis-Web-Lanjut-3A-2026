<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use App\Models\Peminjaman;
use Illuminate\Http\Request;

class PeminjamanController extends Controller
{
    // Menampilkan daftar buku untuk dipinjam
    public function index()
    {
        $bukus = Buku::with('kategori')->paginate(10);

        return view('siswa.peminjaman.index', compact('bukus'));
    }

    // Mengajukan peminjaman buku
    public function store(Request $request, $id)
    {
        $anggota = $request->user()->anggota;

        if (!$anggota) {
            return back()->with('error', 'Data anggota belum terhubung dengan akun kamu.');
        }

        $buku = Buku::findOrFail($id);

        $sudahMengajukan = Peminjaman::where('anggota_id', $anggota->id)
            ->where('buku_id', $buku->id)
            ->whereIn('status', ['menunggu', 'disetujui'])
            ->exists();

        if ($sudahMengajukan) {
            return back()->with('error', 'Kamu masih memiliki pengajuan atau peminjaman buku ini.');
        }

        Peminjaman::create([
            'anggota_id' => $anggota->id,
            'buku_id' => $buku->id,
            'tanggal_pinjam' => now()->toDateString(),
            'status' => 'menunggu',
        ]);

        return back()->with('success', 'Pengajuan peminjaman berhasil dikirim.');
    }

    // Melihat status dan riwayat peminjaman sendiri
    public function riwayat(Request $request)
    {
        $anggota = $request->user()->anggota;

        if (!$anggota) {
            abort(403, 'Data anggota belum terhubung.');
        }

        $peminjamans = Peminjaman::with('buku')
            ->where('anggota_id', $anggota->id)
            ->latest()
            ->paginate(10);

        return view('siswa.peminjaman.riwayat', compact('peminjamans'));
    }
}