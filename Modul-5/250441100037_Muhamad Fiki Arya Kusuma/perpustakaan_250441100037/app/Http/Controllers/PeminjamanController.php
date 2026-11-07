<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Peminjaman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class PeminjamanController extends Controller
{
    // SISWA: Ajukan Peminjaman Buku
    public function storeSiswa(Request $request)
    {
        $request->validate([
            'buku_id' => 'required|exists:bukus,id',
            'tanggal_pinjam' => 'required|date',
            'tanggal_kembali' => 'required|date|after_or_equal:tanggal_pinjam',
        ], [
            'tanggal_kembali.after_or_equal' => 'Tanggal rencana kembali tidak boleh kurang dari tanggal peminjaman!',
        ]);

        // CEK APAKAH SISWA MEMILIKI PINJAMAN BUKU YANG TERLAMBAT (OVERDUE)
        $adaTerlambat = Peminjaman::where('user_id', Auth::id())
            ->where('status', 'dipinjam')
            ->whereNotNull('tanggal_kembali')
            ->where('tanggal_kembali', '<', Carbon::today()->toDateString())
            ->exists();

        if ($adaTerlambat) {
            return redirect()->back()->with('error', 'Pengajuan ditolak! Anda memiliki peminjaman buku yang sudah melewati batas tanggal kembali. Harap kembalikan buku tersebut terlebih dahulu.');
        }

        Peminjaman::create([
            'user_id' => Auth::id(),
            'buku_id' => $request->buku_id,
            'tanggal_pinjam' => $request->tanggal_pinjam,
            'tanggal_kembali' => $request->tanggal_kembali,
            'status' => 'diajukan',
        ]);

        return redirect()->back()->with('success', 'Pengajuan peminjaman berhasil dikirim!');
    }

    // SISWA: Ajukan Pengembalian Buku (SESUAI ROUTE: ajukanPengembalian)
    public function ajukanPengembalian($id)
    {
        $peminjaman = Peminjaman::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        if ($peminjaman->status !== 'dipinjam') {
            return redirect()->back()->with('error', 'Buku ini tidak dalam status sedang dipinjam.');
        }

        $peminjaman->update(['status' => 'menunggu_kembali']);

        return redirect()->back()->with('success', 'Pengajuan pengembalian berhasil dikirim! Menunggu konfirmasi petugas.');
    }

    // SISWA: Riwayat Saya (SESUAI ROUTE: riwayatSaya)
    public function riwayatSaya()
    {
        $riwayats = Peminjaman::with('buku')
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('peminjaman.riwayat', compact('riwayats'));
    }

    // ADMIN & PETUGAS: Lihat Semua Data Peminjaman
    public function index()
    {
        $peminjamans = Peminjaman::with(['user', 'buku'])->latest()->get();
        return view('peminjaman.index', compact('peminjamans'));
    }

    // ADMIN & PETUGAS: Validasi Pengajuan Pinjam
    public function validasiPinjam(Request $request, $id)
    {
        $peminjaman = Peminjaman::findOrFail($id);
        $status = $request->action === 'setuju' ? 'dipinjam' : 'ditolak';
        
        $peminjaman->update(['status' => $status]);

        return redirect()->back()->with('success', 'Status peminjaman berhasil diperbarui!');
    }

    // ADMIN & PETUGAS: Validasi Pengembalian Buku
    public function validasiKembali($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);

        if ($peminjaman->status !== 'menunggu_kembali') {
            return redirect()->back()->with('error', 'Siswa belum mengajukan pengembalian untuk buku ini!');
        }

        $peminjaman->update([
            'status' => 'dikembalikan',
            'tanggal_dikembalikan' => now(),
        ]);

        return redirect()->back()->with('success', 'Pengembalian buku berhasil divalidasi!');
    }
}