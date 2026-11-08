
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\BukuController;
use App\Http\Controllers\Api\RekapController;

// Melihat daftar dan detail buku (publik)
Route::get('/buku', [BukuController::class, 'index'])
    ->name('api.buku.index');

Route::get('/buku/{id}', [BukuController::class, 'show'])
    ->name('api.buku.show');

// CRUD buku (khusus admin dan petugas)
Route::middleware([
    'web',
    'auth',
    'permission:kelola-data-buku'
])->group(function () {

    Route::post('/buku', [BukuController::class, 'store'])
        ->name('api.buku.store');

    Route::put('/buku/{id}', [BukuController::class, 'update'])
        ->name('api.buku.update');

    Route::patch('/buku/{id}', [BukuController::class, 'update'])
        ->name('api.buku.patch');

    Route::delete('/buku/{id}', [BukuController::class, 'destroy'])
        ->name('api.buku.destroy');
});

// API rekap (khusus pengguna yang memiliki permission laporan)
Route::middleware([
    'web',
    'auth',
    'permission:lihat-laporan'
])->group(function () {

    Route::get('/rekap/buku-per-kategori', [
        RekapController::class,
        'bukuPerKategori'
    ]);

    Route::get('/rekap/peminjaman-per-buku', [
        RekapController::class,
        'peminjamanPerBuku'
    ]);
});
