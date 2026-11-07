<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use App\Models\Kategori;
use App\Models\Peminjaman;
use App\Models\User;

class LaporanController extends Controller
{
    public function index()
    {
        $totalBuku = Buku::count();
        $totalPengguna = User::count();
        $totalPeminjaman = Peminjaman::where('status', 'disetujui')->count();
        $totalPengembalian = Peminjaman::where('status', 'disetujui')
            ->whereNotNull('tanggal_kembali')
            ->count();
        $totalDipinjam = Peminjaman::where('status', 'disetujui')
            ->whereNull('tanggal_kembali')
            ->count();

        $bukuPerKategori = Kategori::withCount('bukus')
            ->orderBy('nama')
            ->get();

        $peminjamanPerBuku = Buku::withCount([
            'peminjamans' => fn ($q) => $q->where('status', 'disetujui'),
            ])
            ->with('kategori')
            ->orderBy('judul')
            ->get();

        return view('admin.laporan.index', compact(
            'totalBuku',
            'totalPengguna',
            'totalPeminjaman',
            'totalPengembalian',
            'totalDipinjam',
            'bukuPerKategori',
            'peminjamanPerBuku'
        ));
    }
}
