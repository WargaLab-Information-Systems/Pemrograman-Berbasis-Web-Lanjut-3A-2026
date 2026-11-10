
<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\PengembalianController;
use App\Http\Controllers\RiwayatPeminjamanController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\Api\BukuController as ApiBukuController;

/*
|--------------------------------------------------------------------------
| HALAMAN UTAMA
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
})->name('home');

/*
|--------------------------------------------------------------------------
| DASHBOARD BERDASARKAN ROLE
|--------------------------------------------------------------------------
*/

Route::get('/dashboard', function (Request $request) {
    $user = $request->user();

    if ($user->hasRole('admin')) {
        return redirect()->route('admin.dashboard');
    }

    if ($user->hasRole('petugas')) {
        return redirect()->route('petugas.dashboard');
    }

    if ($user->hasRole('siswa')) {
        return redirect()->route('buku.index');
    }

    abort(403, 'Akun belum memiliki role.');

})->middleware(['auth', 'verified'])->name('dashboard');

/*
|--------------------------------------------------------------------------
| ADMIN
|--------------------------------------------------------------------------
*/

Route::middleware([
    'auth',
    'role:admin',
    'permission:access admin dashboard'
])->prefix('admin')->name('admin.')->group(function () {

    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');

    // Kelola pengguna
    Route::middleware([
        'permission:manage users',
        'permission:manage user roles'
    ])->group(function () {

        Route::resource(
            'users',
            \App\Http\Controllers\Admin\UserController::class
        )->except(['show']);

    });

    // Peminjaman
    Route::middleware('permission:manage loans')->group(function () {

        Route::get('/peminjaman', [
            PeminjamanController::class,
            'index'
        ])->name('peminjaman.index');

        Route::patch('/peminjaman/{peminjaman}/status', [
            PeminjamanController::class,
            'updateStatus'
        ])->middleware('permission:approve book loans')
          ->name('peminjaman.status');
    });

    // Pengembalian
    Route::middleware('permission:manage returns')->group(function () {

        Route::get('/pengembalian', [
            PengembalianController::class,
            'index'
        ])->name('pengembalian.index');

        Route::patch('/pengembalian/{peminjaman}', [
            PengembalianController::class,
            'update'
        ])->middleware('permission:record book returns')
          ->name('pengembalian.update');
    });

    // Laporan Perpustakaan Admin
    Route::get('/laporan', [
        LaporanController::class,
        'index'
    ])
    ->middleware('permission:view library reports')
    ->name('laporan.index');   
    
});

/*
|--------------------------------------------------------------------------
| PETUGAS
|--------------------------------------------------------------------------
*/

Route::middleware([
    'auth',
    'role:petugas',
    'permission:access petugas dashboard'
])->prefix('petugas')->name('petugas.')->group(function () {

    // Dashboard petugas
    Route::get('/dashboard', function () {
        return view('petugas.dashboard');
    })->name('dashboard');

    // Peminjaman
    Route::middleware('permission:manage loans')->group(function () {

        Route::get('/peminjaman', [
            PeminjamanController::class,
            'index'
        ])->name('peminjaman.index');

        Route::patch('/peminjaman/{peminjaman}/status', [
            PeminjamanController::class,
            'updateStatus'
        ])->middleware('permission:approve book loans')
          ->name('peminjaman.status');
    });

    // Pengembalian
    Route::middleware('permission:manage returns')->group(function () {

        Route::get('/pengembalian', [
            PengembalianController::class,
            'index'
        ])->name('pengembalian.index');

        Route::patch('/pengembalian/{peminjaman}', [
            PengembalianController::class,
            'update'
        ])->middleware('permission:record book returns')
          ->name('pengembalian.update');
    });

    // Laporan perpustakaan
    Route::get('/laporan', [
        LaporanController::class,
        'index'
    ])->middleware('permission:view library reports')
      ->name('laporan.index');

    /*
    |--------------------------------------------------------------------------
    | RIWAYAT PEMINJAMAN SEMUA ROLE
    |--------------------------------------------------------------------------
    */

    Route::middleware('auth')->group(function () {

        Route::get('/riwayat-peminjaman', [
            RiwayatPeminjamanController::class,
            'index'
        ])->name('peminjaman.riwayat');

    });
});

/*
|--------------------------------------------------------------------------
| BUKU
|--------------------------------------------------------------------------
*/

Route::middleware([
    'auth',
    'permission:view books'
])->group(function () {

    Route::get('/buku', [
        BukuController::class,
        'index'
    ])->name('buku.index');

    // Form tambah buku hanya untuk Admin dan Petugas
    Route::get('/buku/create', function () {
        return redirect()->route('buku.index');
    })->middleware([
        'auth',
        'can:kelola-buku'
    ])->name('buku.create');

    Route::get('/buku/{id}', [
        BukuController::class,
        'show'
    ])->name('buku.show');

});

// Route pencarian buku (pengujian SQL Injection A2)
Route::get('/buku-cari', [
    BukuController::class,
    'cari'
])->middleware('auth')->name('buku.cari');

Route::delete('/buku/{buku}', [
    ApiBukuController::class,
    'destroy'
])->middleware([
    'auth',
    'can:kelola-buku'
])->name('buku.destroy');

// A4 - Detail peminjaman
Route::get('/peminjaman/{id}', [
    PeminjamanController::class,
    'show'
])->middleware('auth')->name('peminjaman.show');

/*
|--------------------------------------------------------------------------
| PROFIL
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    Route::get('/profile', [
        ProfileController::class,
        'edit'
    ])->middleware('permission:view own profile')
      ->name('profile.edit');

    Route::patch('/profile', [
        ProfileController::class,
        'update'
    ])->middleware('permission:update own profile')
      ->name('profile.update');

    Route::delete('/profile', [
        ProfileController::class,
        'destroy'
    ])->name('profile.destroy');

});

/*
|--------------------------------------------------------------------------
| RIWAYAT PEMINJAMAN SEMUA ROLE
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    Route::get('/riwayat-peminjaman', [
        RiwayatPeminjamanController::class,
        'index'
    ])->name('peminjaman.riwayat');

});
/*
|--------------------------------------------------------------------------
| PENGAJUAN PEMINJAMAN SISWA
|--------------------------------------------------------------------------
*/

Route::middleware([
    'auth',
    'role:siswa',
    'permission:request book loans'
])->group(function () {

    Route::post('/peminjaman', [
        PeminjamanController::class,
        'store'
    ])->name('peminjaman.store');

});

/*
|--------------------------------------------------------------------------
| AUTHENTICATION BREEZE
|--------------------------------------------------------------------------
*/

require __DIR__.'/auth.php';
