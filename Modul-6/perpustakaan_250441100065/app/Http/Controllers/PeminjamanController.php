<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Peminjaman;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class PeminjamanController extends Controller
{
    /**
     * [SOAL 4 - DITAMBAL] IDOR ditutup dengan Policy.
     * Gate::authorize('view', ...) memanggil PeminjamanPolicy@view -> 403 jika bukan haknya.
     */
    public function show($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);

        Gate::authorize('view', $peminjaman);

        return view('peminjaman.show', compact('peminjaman'));
    }

    /* =====================  SISI PENGGUNA (milik sendiri)  =====================

    /** Mengajukan peminjaman buku (semua role). */
    public function ajukan(Request $request, Buku $buku)
    {
        $anggota = $request->user()->ensureAnggota();

        $sudahAda = Peminjaman::where('anggota_id', $anggota->id)
            ->where('buku_id', $buku->id)
            ->whereIn('status', [Peminjaman::DIAJUKAN, Peminjaman::DIPINJAM])
            ->exists();

        if ($sudahAda) {
            return back()->with('error', 'Kamu sudah mengajukan atau sedang meminjam buku "'.$buku->judul.'".');
        }

        Peminjaman::create([
            'anggota_id' => $anggota->id,
            'buku_id' => $buku->id,
            'tanggal_pinjam' => null,
            'tanggal_kembali' => null,
            'status' => Peminjaman::DIAJUKAN,
        ]);

        return back()->with('status', 'Pengajuan peminjaman buku "'.$buku->judul.'" terkirim. Menunggu persetujuan petugas.');
    }

    /** Status peminjaman milik sendiri (yang masih berjalan). */
    public function saya(Request $request)
    {
        $data = Peminjaman::with('buku.kategori')
            ->milikUser($request->user()->id)
            ->whereIn('status', [Peminjaman::DIAJUKAN, Peminjaman::DIPINJAM])
            ->latest()
            ->get();

        return view('peminjaman.saya', compact('data'));
    }

    /** /riwayat-peminjaman -> selalu diarahkan ke riwayat milik sendiri. */
    public function riwayatSaya(Request $request)
    {
        return redirect()->route('riwayat.show', $request->user());
    }

    /** Riwayat peminjaman seorang user. Dibatasi berdasarkan IDENTITAS (lihat UserPolicy). */
    public function riwayat(Request $request, User $user)
    {
        Gate::authorize('viewRiwayat', $user); // 403 kalau bukan miliknya (dan bukan staf)

        $data = Peminjaman::with('buku.kategori')
            ->milikUser($user->id)
            ->latest()
            ->paginate(10);

        return view('peminjaman.riwayat', ['data' => $data, 'pemilik' => $user]);
    }

    /* =====================  SISI STAF (admin & petugas)  ===================== */

    /** Semua data peminjaman + pengajuan yang menunggu persetujuan. */
    public function index(Request $request)
    {
        $query = Peminjaman::with(['anggota', 'buku'])->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        return view('peminjaman.index', [
            'data' => $query->paginate(10)->withQueryString(),
            'status' => $request->status,
        ]);
    }

    public function setujui(Peminjaman $peminjaman)
    {
        if ($peminjaman->status !== Peminjaman::DIAJUKAN) {
            return back()->with('error', 'Hanya pengajuan berstatus "diajukan" yang bisa disetujui.');
        }

        $masihDipinjam = Peminjaman::where('buku_id', $peminjaman->buku_id)
            ->where('status', Peminjaman::DIPINJAM)
            ->exists();

        if ($masihDipinjam) {
            return back()->with('error', 'Buku ini sedang dipinjam orang lain. Tunggu sampai dikembalikan.');
        }

        $peminjaman->update([
            'status' => Peminjaman::DIPINJAM,
            'tanggal_pinjam' => now()->toDateString(),
        ]);

        return back()->with('status', 'Pengajuan disetujui. Buku tercatat sedang dipinjam.');
    }

    public function tolak(Peminjaman $peminjaman)
    {
        if ($peminjaman->status !== Peminjaman::DIAJUKAN) {
            return back()->with('error', 'Hanya pengajuan berstatus "diajukan" yang bisa ditolak.');
        }

        $peminjaman->update(['status' => Peminjaman::DITOLAK]);

        return back()->with('status', 'Pengajuan ditolak.');
    }
}
