<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RiwayatPeminjamanController extends Controller
{
    public function index(Request $request)
    {
        $anggota = $request->user()->anggota;

        if (!$anggota) {
            abort(404, 'Data anggota tidak ditemukan.');
        }

        $peminjamans = $anggota->peminjamans()
            ->with('buku')
            ->latest()
            ->get();

        return view('peminjaman.riwayat', [
            'peminjamans' => $peminjamans
        ]);
    }
}
