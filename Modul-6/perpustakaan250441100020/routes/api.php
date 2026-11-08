
<?php

use App\Models\Kategori;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\BukuController;
use App\Http\Controllers\Api\RekapController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::middleware(['auth:sanctum', 'permission:lihat laporan perpustakaan'])->group(function () {
    Route::get('/rekap/buku-per-kategori', [
        RekapController::class,
        'bukuPerKategori'
    ]);

    Route::get('/rekap/peminjaman-per-buku', [
        RekapController::class,
        'peminjamanPerBuku'
    ]);

});

Route::middleware(['auth:sanctum', 'permission:kelola data buku'])->group(function () {
    Route::get('/kategori', function () {
        return response()->json(
            Kategori::select('id', 'nama')->get()
        );
    });
});


// Melihat daftar dan detail buku
Route::middleware(['auth:sanctum', 'permission:lihat daftar buku'])->group(function () {
    Route::get('/buku', [BukuController::class, 'index']);
    Route::get('/buku/{buku}', [BukuController::class, 'show']);
});

// Mengelola data buku
Route::middleware(['auth:sanctum', 'permission:kelola data buku'])->group(function () {
    Route::post('/buku', [BukuController::class, 'store']);
    Route::put('/buku/{buku}', [BukuController::class, 'update']);
    Route::patch('/buku/{buku}', [BukuController::class, 'update']);
    Route::delete('/buku/{buku}', [BukuController::class, 'destroy']);
});
