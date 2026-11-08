<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use Illuminate\Http\Request;

class RiwayatPeminjamanController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        // Admin dan Petugas boleh melihat seluruh riwayat.
        if ($user->hasAnyRole(['admin', 'petugas'])) {

            abort_unless(
                $user->can('view all loan history'),
                403,
                'Anda tidak memiliki izin melihat seluruh riwayat peminjaman.'
            );

            $riwayat = Peminjaman::with(['buku', 'anggota'])
                ->orderByDesc('tanggal_pinjam')
                ->get();

        }

        // Siswa hanya boleh melihat riwayat miliknya sendiri.
        elseif ($user->hasRole('siswa')) {

            abort_unless(
                $user->can('view own loan history'),
                403,
                'Anda tidak memiliki izin melihat riwayat peminjaman sendiri.'
            );

            $anggota = $user->anggota;

            if (!$anggota) {
                $riwayat = collect();
            } else {
                $riwayat = Peminjaman::with(['buku', 'anggota'])
                    ->where('anggota_id', $anggota->id)
                    ->orderByDesc('tanggal_pinjam')
                    ->get();
            }

        } else {
            abort(403, 'Role pengguna tidak diizinkan.');
        }

        return view('peminjaman.riwayat', compact('riwayat'));
    }
}
