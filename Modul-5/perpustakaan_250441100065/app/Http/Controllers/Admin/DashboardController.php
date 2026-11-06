<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use App\Models\Peminjaman;
use App\Models\User;

class DashboardController extends Controller
{
    public function __invoke()
    {
        return view('admin.dashboard', [
            'totalBuku'    => Buku::count(),
            'totalUser'    => User::count(),
            'totalAdmin'   => User::role('admin')->count(),
            'totalPetugas' => User::role('petugas')->count(),
            'totalSiswa'   => User::role('siswa')->count(),
            'menunggu'     => Peminjaman::where('status', Peminjaman::DIAJUKAN)->count(),
            'dipinjam'     => Peminjaman::where('status', Peminjaman::DIPINJAM)->count(),
        ]);
    }
}
