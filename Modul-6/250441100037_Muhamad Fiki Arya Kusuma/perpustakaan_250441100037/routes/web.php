<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BukuWebController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\ProfileCustomController;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware(['auth', 'verified'])->group(function () {
    // ROUTE CELAH KEAMANAN SOAL 1 (VULNERABLE STATE)
    Route::get('/buku-cari', [BukuWebController::class, 'cariRaw']);

    // DASHBOARD & PROFIL
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/profil-saya', [ProfileCustomController::class, 'edit'])->name('profil.edit');
    Route::put('/profil-saya', [ProfileCustomController::class, 'update'])->name('profil.update');

    Route::middleware('role:admin')->get('/dashboard/admin', [DashboardController::class, 'adminDashboard'])->name('admin.dashboard');
    Route::middleware('role:petugas')->get('/dashboard/petugas', [DashboardController::class, 'petugasDashboard'])->name('petugas.dashboard');
    Route::middleware('role:siswa')->get('/dashboard/siswa', [DashboardController::class, 'siswaDashboard'])->name('siswa.dashboard');

    // FITUR BUKU
    Route::get('/kelola-buku', [BukuWebController::class, 'index'])->name('buku.index');
    Route::get('/kelola-buku/{id}', [BukuWebController::class, 'show'])->name('buku.show');

    Route::middleware('role:admin|petugas')->group(function () {
        Route::post('/kelola-buku', [BukuWebController::class, 'store'])->name('buku.store');
        Route::get('/kelola-buku/{id}/edit', [BukuWebController::class, 'edit'])->name('buku.edit');
        Route::put('/kelola-buku/{id}', [BukuWebController::class, 'update'])->name('buku.update');
    });

    Route::middleware('role:admin')->group(function () {
        Route::delete('/kelola-buku/{id}', [BukuWebController::class, 'destroy'])->name('buku.destroy');
    });

    // FITUR PEMINJAMAN ADMIN & PETUGAS
    Route::middleware('role:admin|petugas')->group(function () {
        Route::get('/peminjaman', [PeminjamanController::class, 'index'])->name('peminjaman.index');
        Route::put('/peminjaman/{id}/validasi-pinjam', [PeminjamanController::class, 'validasiPinjam'])->name('peminjaman.validasiPinjam');
        Route::put('/peminjaman/{id}/validasi-kembali', [PeminjamanController::class, 'validasiKembali'])->name('peminjaman.validasiKembali');
        Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
    });

    // FITUR PEMINJAMAN SISWA
    Route::middleware('role:siswa')->group(function () {
        Route::post('/peminjaman/saja', [PeminjamanController::class, 'storeSiswa'])->name('peminjaman.storeSiswa');
        Route::put('/peminjaman/{id}/ajukan-kembali', [PeminjamanController::class, 'ajukanPengembalian'])->name('peminjaman.ajukanKembali');
        Route::get('/riwayat-peminjaman', [PeminjamanController::class, 'riwayatSaya'])->name('peminjaman.riwayat');
    });

    // FITUR USER ADMIN
    Route::middleware('role:admin')->group(function () {
        Route::get('/users', [UserController::class, 'index'])->name('users.index');
        Route::put('/users/{id}/role', [UserController::class, 'updateRole'])->name('users.updateRole');
    });

    // ROUTE CELAH SOAL 1 A4 (IDOR) - DITARUH DI PALING BAWAH KELOMPOK AUTH
    Route::get('/peminjaman/{id}', [PeminjamanController::class, 'show'])->name('peminjaman.show');
});

require __DIR__.'/auth.php';