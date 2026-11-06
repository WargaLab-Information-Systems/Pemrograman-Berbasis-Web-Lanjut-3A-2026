<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\BukuController;
use App\Http\Controllers\Api\RekapController;


Route::middleware(['web', 'auth'])->group(function () {

    Route::apiResource('buku', BukuController::class)
        ->only(['index', 'show'])
        ->names('api.buku')
        ->middleware('permission:lihat daftar buku');

    Route::apiResource('buku', BukuController::class)
        ->only(['store', 'update', 'destroy'])
        ->names('api.buku')
        ->middleware('permission:kelola data buku');

    Route::middleware('permission:lihat laporan perpustakaan')->group(function () {
        Route::get('rekap/buku-per-kategori',   [RekapController::class, 'bukuPerKategori']);
        Route::get('rekap/peminjaman-per-buku', [RekapController::class, 'peminjamanPerBuku']);

        Route::get('rekap/pemminjaman-per-buku', [RekapController::class, 'peminjamanPerBuku']);
    });
});
