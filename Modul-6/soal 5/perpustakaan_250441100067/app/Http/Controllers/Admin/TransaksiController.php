<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
use Illuminate\Support\Facades\Gate;

class TransaksiController extends Controller
{
    // Menampilkan seluruh transaksi peminjaman
    public function peminjaman()
    {
        $peminjamans = Peminjaman::with(['anggota', 'buku'])
            ->where('status', 'disetujui')
            ->whereNull('tanggal_kembali')
            ->latest()
            ->paginate(10);

        return view(
            'admin.transaksi.peminjaman',
            compact('peminjamans')
        );
    }

    // Menampilkan seluruh transaksi pengembalian
    public function pengembalian()
    {
        $pengembalians = Peminjaman::with(['anggota', 'buku'])
            ->whereNotNull('tanggal_kembali')
            ->latest()
            ->paginate(10);

        return view(
            'admin.transaksi.pengembalian',
            compact('pengembalians')
        );
    }

    // Menampilkan pengajuan peminjaman
    public function pengajuan()
    {
        $pengajuans = Peminjaman::with(['anggota', 'buku'])
            ->where('status', 'menunggu')
            ->latest()
            ->paginate(10);

        return view(
            'admin.transaksi.pengajuan',
            compact('pengajuans')
        );
    }

    // Menyetujui pengajuan peminjaman
    public function setujui($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);

        if ($peminjaman->status !== 'menunggu') {
            return back()->with(
                'error',
                'Pengajuan ini sudah diproses.'
            );
        }

        $peminjaman->update([
            'status' => 'disetujui'
        ]);

        return back()->with(
            'success',
            'Pengajuan berhasil disetujui.'
        );
    }

    // Menolak pengajuan peminjaman
    public function tolak($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);

        if ($peminjaman->status !== 'menunggu') {
            return back()->with(
                'error',
                'Pengajuan ini sudah diproses.'
            );
        }

        $peminjaman->update([
            'status' => 'ditolak'
        ]);

        return back()->with(
            'success',
            'Pengajuan berhasil ditolak.'
        );
    }

    // Mencatat pengembalian buku
    public function catatPengembalian($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);

        if ($peminjaman->status !== 'disetujui') {
            return back()->with(
                'error',
                'Peminjaman belum disetujui atau sudah dikembalikan.'
            );
        }

        $peminjaman->update([
            'tanggal_kembali' => now()->toDateString(),
            'status' => 'dikembalikan'
        ]);

        return back()->with(
            'success',
            'Pengembalian buku berhasil dicatat.'
        );
    }

    // A4: Menampilkan detail peminjaman menggunakan Policy
    public function show($id)
    {
        $peminjaman = Peminjaman::with(['anggota', 'buku'])
            ->findOrFail($id);

        // Memeriksa hak akses melalui PeminjamanPolicy
        Gate::authorize('view', $peminjaman);

        // Menampilkan detail peminjaman
        return view(
            'admin.transaksi.detail',
            compact('peminjaman')
        );
    }
}
