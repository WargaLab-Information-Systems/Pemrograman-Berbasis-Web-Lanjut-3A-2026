<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Buku;
use App\Models\User;
use App\Models\Peminjaman;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        if ($user->hasRole('admin')) {
            return redirect()->route('admin.dashboard');
        } elseif ($user->hasRole('petugas')) {
            return redirect()->route('petugas.dashboard');
        } else {
            return redirect()->route('siswa.dashboard');
        }
    }

    public function adminDashboard()
    {
        $totalBuku = Buku::count();
        $totalUser = User::count();
        return view('dashboard.admin', compact('totalBuku', 'totalUser'));
    }

    public function petugasDashboard()
    {
        $totalBuku = Buku::count();
        return view('dashboard.petugas', compact('totalBuku'));
    }

    public function siswaDashboard()
    {
        // Mengambil data buku beserta relasi kategori dan peminjaman aktif
        $bukus = Buku::with(['kategori', 'peminjamans' => function($q) {
            $q->whereIn('status', ['diajukan', 'dipinjam', 'menunggu_kembali']);
        }])->paginate(6);

        return view('dashboard.siswa', compact('bukus'));
    }
}