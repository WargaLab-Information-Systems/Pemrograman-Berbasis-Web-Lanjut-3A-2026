<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Kategori;
use App\Models\Peminjaman;

class LaporanController extends Controller
{
    public function index()
    {
        return view('laporan.index', [
            'totalBuku'    => Buku::count(),
            'perStatus'    => Peminjaman::selectRaw('status, count(*) as total')->groupBy('status')->pluck('total', 'status'),
            'perKategori'  => Kategori::withCount('bukus')->orderBy('nama')->get(),
            'bukuPopuler'  => Buku::withCount('peminjamans')->orderByDesc('peminjamans_count')->take(5)->get(),
            'terbaru'      => Peminjaman::with(['anggota', 'buku'])->latest()->take(10)->get(),
        ]);
    }
}
