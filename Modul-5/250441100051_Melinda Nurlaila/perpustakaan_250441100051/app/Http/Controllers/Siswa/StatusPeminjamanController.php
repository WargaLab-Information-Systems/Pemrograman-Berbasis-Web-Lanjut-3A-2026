<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;

class StatusPeminjamanController extends Controller
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

        return view('siswa.status.index', compact('peminjamans'));
    }
}
