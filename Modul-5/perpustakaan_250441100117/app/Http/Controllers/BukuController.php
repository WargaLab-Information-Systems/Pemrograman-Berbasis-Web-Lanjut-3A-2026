<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Anggota;
use App\Models\Peminjaman;
use Illuminate\Http\Request;

class BukuController extends Controller
{
    public function index()
    {
        $buku = Buku::with('kategori')->get();
        return view('buku.index', ['buku' => $buku]);
    }

    public function show($id)
    {
        $buku = Buku::with('kategori')->find($id);
        return view('buku.show', ['buku' => $buku]);
    }

    public function pinjam($id)
    {
        $buku = Buku::findOrFail($id);
        $user = auth()->user();
        
        $anggota = Anggota::where('email', $user->email)->first();

        if (!$anggota) {
            return redirect()->back()->with('error', 'Akun Anda tidak terdaftar sebagai anggota perpustakaan.');
        }

        Peminjaman::create([
            'anggota_id' => $anggota->id,
            'buku_id' => $buku->id,
            'tanggal_pinjam' => now(),
            'tanggal_kembali' => now()->addDays(7), 
        ]);

        return redirect()->back()->with('success', 'Buku "' . $buku->judul . '" berhasil diajukan untuk dipinjam!');
    }
}