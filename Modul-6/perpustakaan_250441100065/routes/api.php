<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\BukuController;
use App\Http\Controllers\Api\RekapController;

/*
|--------------------------------------------------------------------------
| API (sekarang DIPROTEKSI)
|--------------------------------------------------------------------------
| 'web'  -> menyalakan session & CSRF, supaya middleware 'auth' bisa membaca login dari cookie
| 'auth' -> wajib login (kalau belum: 401 untuk request JSON)
| 'permission:...' -> dicek per aksi (kalau tidak berhak: 403)
*/
Route::middleware(['web', 'auth'])->group(function () {

    // Baca data buku: semua role yang punya "lihat daftar buku"
    Route::apiResource('buku', BukuController::class)
        ->only(['index', 'show'])
        ->names('api.buku')
        ->middleware('permission:lihat daftar buku');

    // Tambah / ubah / hapus buku: dijaga Gate "kelola-buku" (admin & petugas)
    Route::apiResource('buku', BukuController::class)
        ->only(['store', 'update', 'destroy'])
        ->names('api.buku')
        ->middleware('can:kelola-buku');

    // Rekap = bagian dari laporan perpustakaan
    Route::middleware('permission:lihat laporan perpustakaan')->group(function () {
        Route::get('rekap/buku-per-kategori',   [RekapController::class, 'bukuPerKategori']);
        Route::get('rekap/peminjaman-per-buku', [RekapController::class, 'peminjamanPerBuku']);

        Route::get('rekap/pemminjaman-per-buku', [RekapController::class, 'peminjamanPerBuku']);
    });
});
