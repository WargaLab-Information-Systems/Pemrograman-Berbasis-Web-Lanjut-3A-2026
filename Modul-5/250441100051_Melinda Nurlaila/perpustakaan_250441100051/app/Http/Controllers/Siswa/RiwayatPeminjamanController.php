<?php

namespace App\Http\Controllers\Siswa;

use App\Models\Anggota;
use App\Http\Controllers\Controller;

class RiwayatPeminjamanController extends Controller
{
    public function index()
    {
        $anggota = auth()->user()->anggota;

        $peminjamans = $anggota
            ? $anggota->peminjamans()
                ->with(['buku.kategori'])
                ->latest()
                ->get()
            : collect();

        return view('siswa.riwayat.index', compact('peminjamans'));
    }

    public function show(Anggota $anggota)
    {
        abort_unless(
            auth()->user()->anggota?->id === $anggota->id,
            403,
            'Kamu hanya dapat melihat riwayat peminjaman milikmu sendiri.'
        );

        $peminjamans = $anggota->peminjamans()
            ->with(['buku.kategori'])
            ->latest()
            ->get();

        return view('siswa.riwayat.index', compact('peminjamans'));
    }
}
