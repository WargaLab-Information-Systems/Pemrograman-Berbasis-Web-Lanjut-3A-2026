<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use App\Models\Peminjaman;

class DashboardController extends Controller
{
    public function __invoke()
    {
        return view('petugas.dashboard', [
            'totalBuku' => Buku::count(),
            'menunggu'  => Peminjaman::where('status', Peminjaman::DIAJUKAN)->count(),
            'dipinjam'  => Peminjaman::where('status', Peminjaman::DIPINJAM)->count(),
            'pengajuan' => Peminjaman::with(['anggota', 'buku'])
                ->where('status', Peminjaman::DIAJUKAN)
                ->latest()->take(5)->get(),
        ]);
    }
}
