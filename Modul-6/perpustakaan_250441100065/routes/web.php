<?php

use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\PengembalianController;
use App\Http\Controllers\Petugas\DashboardController as PetugasDashboardController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Halaman publik (boleh dibuka tanpa login)
|--------------------------------------------------------------------------
*/
Route::get('/', [BukuController::class, 'home'])->name('home');

/*
|--------------------------------------------------------------------------
| Halaman yang WAJIB login  (middleware: auth)
| Setiap route di bawah juga dijaga permission Spatie (middleware: permission:...)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    // Tujuan setelah login -> diarahkan sesuai role
    Route::get('/dashboard', DashboardController::class)->name('dashboard');

    // ---- Dashboard per role ----
    Route::get('/admin/dashboard', AdminDashboardController::class)
        ->middleware('permission:akses dashboard admin')->name('admin.dashboard');

    Route::get('/petugas/dashboard', PetugasDashboardController::class)
        ->middleware('permission:akses dashboard petugas')->name('petugas.dashboard');

    // ---- Profil milik sendiri (selalu memakai $request->user(), tidak ada ID di URL) ----
    Route::get('/profile', [ProfileController::class, 'edit'])
        ->middleware('permission:lihat profil sendiri')->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])
        ->middleware('permission:ubah profil sendiri')->name('profile.update');

    // ---- Celah Soal 1 yang sudah ditambal ----
    // A2 (SQL Injection) -> query memakai binding
    Route::get('/buku-cari', [BukuController::class, 'cari'])->name('buku.cari');
    // A3 (CSRF) -> route GET /buku/{buku}/hapus DIHAPUS; penghapusan kini lewat DELETE (lihat di bawah)
    // A4 (IDOR) -> lihat Soal 4 (Policy)
    Route::get('/peminjaman/{id}', [PeminjamanController::class, 'show'])->name('peminjaman.show');

    // ---- Kelola buku lewat form web (tambah, ubah, hapus) ----
    Route::middleware('permission:kelola data buku')->group(function () {
        Route::get('/buku/create', [BukuController::class, 'create'])->name('buku.create');
        Route::post('/buku', [BukuController::class, 'store'])->name('buku.store');
        Route::get('/buku/{buku}/edit', [BukuController::class, 'edit'])->whereNumber('buku')->name('buku.edit');
        Route::put('/buku/{buku}', [BukuController::class, 'update'])->whereNumber('buku')->name('buku.update');
        Route::delete('/buku/{buku}', [BukuController::class, 'destroy'])->whereNumber('buku')->name('buku.destroy');
    });

    // ---- Buku (baca) : semua role ----
    Route::get('/buku', [BukuController::class, 'index'])
        ->middleware('permission:lihat daftar buku')->name('buku.index');
    Route::get('/buku/{id}', [BukuController::class, 'show'])->whereNumber('id')
        ->middleware('permission:lihat daftar buku')->name('buku.show');

    // ---- Peminjaman milik sendiri : semua role ----
    Route::post('/buku/{buku}/pinjam', [PeminjamanController::class, 'ajukan'])->whereNumber('buku')
        ->middleware('permission:mengajukan peminjaman buku')->name('peminjaman.ajukan');

    Route::get('/peminjaman-saya', [PeminjamanController::class, 'saya'])
        ->middleware('permission:melihat status peminjaman sendiri')->name('peminjaman.saya');

    Route::get('/riwayat-peminjaman', [PeminjamanController::class, 'riwayatSaya'])
        ->middleware('permission:melihat riwayat peminjaman sendiri')->name('riwayat.saya');
    Route::get('/riwayat-peminjaman/{user}', [PeminjamanController::class, 'riwayat'])->whereNumber('user')
        ->middleware('permission:melihat riwayat peminjaman sendiri')->name('riwayat.show');

    // ---- Operasional perpustakaan : admin & petugas ----
    Route::prefix('kelola')->group(function () {
        Route::get('/buku', [BukuController::class, 'kelola'])
            ->middleware('permission:kelola data buku')->name('buku.kelola');

        Route::get('/peminjaman', [PeminjamanController::class, 'index'])
            ->middleware('permission:kelola peminjaman')->name('kelola.peminjaman');
        Route::post('/peminjaman/{peminjaman}/setujui', [PeminjamanController::class, 'setujui'])
            ->middleware('permission:memproses persetujuan peminjaman')->name('kelola.peminjaman.setujui');
        Route::post('/peminjaman/{peminjaman}/tolak', [PeminjamanController::class, 'tolak'])
            ->middleware('permission:memproses persetujuan peminjaman')->name('kelola.peminjaman.tolak');

        Route::get('/pengembalian', [PengembalianController::class, 'index'])
            ->middleware('permission:kelola pengembalian')->name('kelola.pengembalian');
        Route::post('/pengembalian/{peminjaman}', [PengembalianController::class, 'store'])
            ->middleware('permission:mencatat pengembalian buku')->name('kelola.pengembalian.store');
    });

    Route::get('/laporan', [LaporanController::class, 'index'])
        ->middleware('permission:lihat laporan perpustakaan')->name('laporan.index');

    // ---- Kelola pengguna & role : HANYA admin ----
    Route::prefix('admin')->group(function () {
        Route::resource('users', UserController::class)
            ->except('show')
            ->middleware('permission:kelola data pengguna')
            ->names('admin.users');

        Route::patch('/users/{user}/role', [UserController::class, 'updateRole'])
            ->middleware('permission:kelola role pengguna')->name('admin.users.role');
    });
});

// Route login, register, logout, dll. dari Laravel Breeze
// (di dalamnya sudah dipasang middleware "guest" untuk login/register dan "auth" untuk logout)
require __DIR__.'/auth.php';
