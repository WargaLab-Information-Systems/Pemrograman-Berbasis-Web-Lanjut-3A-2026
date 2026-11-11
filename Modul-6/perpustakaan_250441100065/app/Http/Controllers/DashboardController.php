<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * /dashboard dipakai Breeze sebagai tujuan setelah login.
     * Admin & petugas diarahkan ke dashboard masing-masing, siswa melihat dashboard siswa.
     */
    public function __invoke(Request $request)
    {
        $user = $request->user();

        if ($user->can('akses dashboard admin')) {
            return redirect()->route('admin.dashboard');
        }

        if ($user->can('akses dashboard petugas')) {
            return redirect()->route('petugas.dashboard');
        }

        $milik = Peminjaman::milikUser($user->id);

        return view('dashboard', [
            'menunggu' => (clone $milik)->where('status', Peminjaman::DIAJUKAN)->count(),
            'dipinjam' => (clone $milik)->where('status', Peminjaman::DIPINJAM)->count(),
            'selesai'  => (clone $milik)->where('status', Peminjaman::DIKEMBALIKAN)->count(),
        ]);
    }
}
