<?php

use Illuminate\Support\Facades\DB;


use App\Http\Controllers\Admin\RoleController;

use App\Http\Controllers\BukuController;

use App\Http\Controllers\Admin\UserController;

use App\Http\Controllers\RiwayatPeminjamanController;

use App\Http\Controllers\PeminjamanController;

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Daftar dan Detail Buku
Route::middleware(['auth', 'permission:lihat daftar buku'])->group(function () {
    Route::get('/buku', [BukuController::class, 'daftarbuku'])
        ->name('buku.index');

    Route::get('/buku/{id}', [BukuController::class, 'show'])
        ->name('buku.show');
});

// adm
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');
});

// ptg
Route::middleware(['auth', 'role:petugas'])->group(function () {
    Route::get('/petugas/dashboard', function () {
        return view('petugas.dashboard');
    })->name('petugas.dashboard');
});

// ssw
Route::middleware(['auth', 'role:siswa'])->group(function () {
    Route::get('/siswa/dashboard', function () {
        return view('siswa.dashboard');
    })->name('siswa.dashboard');
});


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Melihat dan mengubah profil sendiri
Route::middleware(['auth', 'permission:lihat profil sendiri'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');
});

Route::middleware(['auth', 'permission:ubah profil sendiri'])->group(function () {
    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');
});

// Pengajuan peminjaman buku
Route::middleware(['auth', 'permission:mengajukan peminjaman buku'])->group(function () {
    Route::post('/peminjaman', [PeminjamanController::class, 'store'])
        ->name('peminjaman.store');
});

Route::middleware(['auth', 'permission:melihat riwayat peminjaman sendiri'])->group(function () {
    Route::get('/riwayat-peminjaman', [RiwayatPeminjamanController::class, 'index'])
        ->name('peminjaman.riwayat');
});


// Pengelolaan dan persetujuan peminjaman
Route::middleware([
    'auth',
    'permission:memproses persetujuan peminjaman'
])->group(function () {

    Route::get('/pengelolaan-peminjaman', [PeminjamanController::class, 'index'])
        ->name('peminjaman.index');

    Route::patch('/peminjaman/{id}/setujui', [PeminjamanController::class, 'setujui'])
        ->name('peminjaman.setujui');

    Route::patch('/peminjaman/{id}/tolak', [PeminjamanController::class, 'tolak'])
        ->name('peminjaman.tolak');
    
    Route::patch('/peminjaman/{id}/kembalikan', [PeminjamanController::class, 'kembalikan'])
        ->name('peminjaman.kembalikan');
});

Route::middleware([
    'auth',
    'role:admin',
    'permission:kelola data pengguna'
])->prefix('admin')->name('admin.')->group(function () {

    Route::resource('users', UserController::class)
        ->except(['show']);

});

Route::middleware([
    'auth',
    'role:admin',
    'permission:kelola role pengguna'
])->prefix('admin')->name('admin.')->group(function () {

    Route::get('/roles', [RoleController::class, 'index'])
        ->name('roles.index');

    Route::get('/roles/{role}/edit', [RoleController::class, 'edit'])
        ->name('roles.edit');

    Route::put('/roles/{role}', [RoleController::class, 'update'])
        ->name('roles.update');

});


require __DIR__.'/auth.php';


Route::get('/buku-cari', function () {
    $judul = request('judul');

    $hasil = DB::select(
        "SELECT * FROM bukus WHERE judul = '$judul'"
    );

    return response()->json($hasil);
})->middleware('auth');



Route::get('/buku/{id}/hapus', [BukuController::class, 'destroy'])
    ->name('buku.hapus');


Route::get('/peminjaman/{id}', [PeminjamanController::class, 'show'])
    ->name('peminjaman.show');

