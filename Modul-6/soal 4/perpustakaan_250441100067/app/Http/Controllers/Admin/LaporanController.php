<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use App\Models\Kategori;
use App\Models\Anggota;
use App\Models\User;
use App\Models\Peminjaman;

class LaporanController extends Controller
{
    public function index()
    {
        $totalBuku = Buku::count();

        $totalKategori = Kategori::count();

        $totalAnggota = Anggota::count();

        $totalPengguna = User::count();

        $totalPeminjaman = Peminjaman::count();

        $belumKembali = Peminjaman::whereNull('tanggal_kembali')
            ->count();

        $sudahKembali = Peminjaman::whereNotNull('tanggal_kembali')
            ->count();

        return view('admin.laporan.index', compact(
            'totalBuku',
            'totalKategori',
            'totalAnggota',
            'totalPengguna',
            'totalPeminjaman',
            'belumKembali',
            'sudahKembali'
        ));
    }
}
