<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\BukuController;
use App\Http\Controllers\Api\RekapController;


Route::middleware(['web', 'auth', 'permission:lihat daftar buku'])->group(function () {
    Route::get('/buku', [BukuController::class, 'index'])
        ->name('api.buku.index');

    Route::get('/buku/{buku}', [BukuController::class, 'show'])
        ->name('api.buku.show');
});


Route::middleware(['web', 'auth', 'permission:kelola data buku'])->group(function () {
    Route::post('/buku', [BukuController::class, 'store'])
        ->name('api.buku.store');

    Route::put('/buku/{buku}', [BukuController::class, 'update'])
        ->name('api.buku.update');

    Route::patch('/buku/{buku}', [BukuController::class, 'update'])
        ->name('api.buku.patch');

    Route::delete('/buku/{buku}', [BukuController::class, 'destroy'])
        ->name('api.buku.destroy');
});


Route::middleware(['web', 'auth', 'permission:lihat laporan perpustakaan'])->group(function () {
    Route::get('/rekap/buku-per-kategori', [RekapController::class, 'bukuPerKategori']);
    Route::get('/rekap/peminjaman-per-buku', [RekapController::class, 'peminjamanPerBuku']);
});
