<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Anggota;
use App\Models\Peminjaman;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        // Mengambil statistik perpustakaan
        $totalBuku = Buku::count();
        $totalAnggota = Anggota::count();
        $totalPeminjaman = Peminjaman::count();

        // Statistik berdasarkan status peminjaman
        $menunggu = Peminjaman::where('status', 'menunggu')->count();
        $disetujui = Peminjaman::where('status', 'disetujui')->count();
        $ditolak = Peminjaman::where('status', 'ditolak')->count();
        $dikembalikan = Peminjaman::where('status', 'dikembalikan')->count();

        // Mengambil seluruh aktivitas peminjaman
        $peminjamans = Peminjaman::with(['buku', 'anggota'])
            ->orderByDesc('id')
            ->get();

        // Mengambil pengguna yang sedang login
        $user = $request->user();

        // Menentukan dashboard berdasarkan role
        if ($user->hasRole('admin')) {
            $dashboardRoute = 'admin.dashboard';
        } elseif ($user->hasRole('petugas')) {
            $dashboardRoute = 'petugas.dashboard';
        } else {
            abort(403, 'Anda tidak memiliki akses melihat laporan.');
        }

        return view('laporan.index', compact(
            'totalBuku',
            'totalAnggota',
            'totalPeminjaman',
            'menunggu',
            'disetujui',
            'ditolak',
            'dikembalikan',
            'peminjamans',
            'dashboardRoute'
        ));
    }
}
