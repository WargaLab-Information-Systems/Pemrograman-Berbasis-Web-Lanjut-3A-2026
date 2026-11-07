<?php

use App\Http\Controllers\Petugas\PersetujuanPeminjamanController;
use App\Http\Controllers\Siswa\StatusPeminjamanController;
use App\Http\Controllers\Siswa\PengajuanPeminjamanController;
use App\Http\Controllers\Siswa\RiwayatPeminjamanController;
use App\Http\Controllers\Petugas\PengembalianController;
use App\Http\Controllers\Petugas\PeminjamanController;
use App\Http\Controllers\Admin\LaporanController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
});

Route::get('/dashboard', function () {
    $user = auth()->user();

    if ($user->hasRole('Petugas')) {
        return redirect()->route('dashboard.petugas');
    }

    if ($user->hasRole('Admin')) {
        return redirect()->route('dashboard.admin');
    }

    if ($user->hasRole('Siswa')) {
        return redirect()->route('dashboard.siswa');
    }

    return abort(403, 'Akun belum memiliki role.');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard/admin', function () {
        return view('dashboard.admin');
    })->middleware('role:Admin')->name('dashboard.admin');

    Route::get('/dashboard/petugas', function () {
        return view('dashboard.petugas');
    })->middleware('role:Petugas')->name('dashboard.petugas');

    Route::get('/dashboard/siswa', function () {
        return view('dashboard.siswa');
    })->middleware('role:Siswa')->name('dashboard.siswa');
});

Route::get('/buku', function () {
    $kategoris = \App\Models\Kategori::all();

    return view('buku.index', compact('kategoris'));
})->middleware(['auth', 'permission:lihat daftar buku'])
    ->name('buku.index');

Route::get('/kelola-buku', function () {
    $kategoris = \App\Models\Kategori::all();
    $kelola = true;

    return view('buku.index', compact('kategoris', 'kelola'));
})->middleware(['auth', 'permission:kelola data buku'])
    ->name('buku.kelola');

Route::get('/buku/{id}', function ($id) {
    $buku = \App\Models\Buku::with('kategori')->find($id);

    return view('buku.show', compact('buku'));
})->middleware(['auth', 'permission:lihat daftar buku'])
    ->name('buku.detail');

Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])
        ->middleware('permission:lihat profil sendiri')
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->middleware('permission:ubah profil sendiri')
        ->name('profile.update');
});

Route::middleware(['auth', 'permission:kelola data pengguna'])->group(function () {
    Route::get('/admin/users', [UserController::class, 'index'])
        ->name('admin.users.index');

    Route::delete('/admin/users/{user}', [UserController::class, 'destroy'])
        ->name('admin.users.destroy');
});

Route::patch('/admin/users/{user}/role', [UserController::class, 'updateRole'])
    ->middleware(['auth', 'permission:kelola role pengguna'])
    ->name('admin.users.updateRole');

Route::get('/admin/laporan', [LaporanController::class, 'index'])
    ->middleware(['auth', 'role:Admin', 'permission:lihat laporan perpustakaan'])
    ->name('admin.laporan.index');

Route::get('/petugas/laporan', [LaporanController::class, 'index'])
    ->middleware(['auth', 'permission:lihat laporan perpustakaan'])
    ->name('petugas.laporan.index');

Route::middleware(['auth', 'permission:kelola peminjaman'])->group(function () {
    Route::get('/petugas/peminjaman', [PeminjamanController::class, 'index'])
        ->name('petugas.peminjaman.index');

    Route::get('/petugas/peminjaman/create', [PeminjamanController::class, 'create'])
        ->name('petugas.peminjaman.create');

    Route::post('/petugas/peminjaman', [PeminjamanController::class, 'store'])
        ->name('petugas.peminjaman.store');
});

Route::middleware(['auth', 'permission:kelola pengembalian'])->group(function () {
    Route::get('/petugas/pengembalian', [PengembalianController::class, 'index'])
        ->name('petugas.pengembalian.index');

    Route::patch('/petugas/pengembalian/{peminjaman}', [PengembalianController::class, 'kembalikan'])
        ->name('petugas.pengembalian.update');
});

Route::get('/siswa/riwayat-peminjaman', [RiwayatPeminjamanController::class, 'index'])
    ->middleware(['auth', 'role:Siswa', 'permission:melihat riwayat peminjaman sendiri'])
    ->name('siswa.riwayat.index');

Route::middleware([
    'auth',
    'role:Siswa',
    'permission:mengajukan peminjaman buku'
])->group(function () {
    Route::get('/siswa/pengajuan-peminjaman', [PengajuanPeminjamanController::class, 'index'])
        ->name('siswa.pengajuan.index');

    Route::post('/siswa/pengajuan-peminjaman', [PengajuanPeminjamanController::class, 'store'])
        ->name('siswa.pengajuan.store');
});

Route::get('/siswa/status-peminjaman', [StatusPeminjamanController::class, 'index'])
    ->middleware(['auth', 'role:Siswa', 'permission:melihat status peminjaman sendiri'])
    ->name('siswa.status.index');

Route::middleware([
    'auth',
    'permission:memproses persetujuan peminjaman'
])->group(function () {
    Route::get('/petugas/persetujuan-peminjaman', [PersetujuanPeminjamanController::class, 'index'])
        ->name('petugas.persetujuan.index');

    Route::patch('/petugas/persetujuan-peminjaman/{peminjaman}', [PersetujuanPeminjamanController::class, 'proses'])
        ->name('petugas.persetujuan.proses');
});

Route::get('/siswa/riwayat-peminjaman/{anggota}', [RiwayatPeminjamanController::class, 'show'])
    ->middleware(['auth', 'permission:melihat riwayat peminjaman sendiri'])
    ->name('siswa.riwayat.show');

require __DIR__.'/auth.php';