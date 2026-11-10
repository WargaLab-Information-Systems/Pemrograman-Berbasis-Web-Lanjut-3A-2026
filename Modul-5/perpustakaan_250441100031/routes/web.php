<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PetugasController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\BukuWebController; // Controller web untuk manajemen buku admin/petugas
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware(['auth', 'verified'])->group(function () {

    // Redirect Dashboard Otomatis Sesuai Role
    Route::get('/dashboard', function () {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        if ($user->hasRole('admin')) {
            return redirect()->route('admin.dashboard');
        } elseif ($user->hasRole('petugas')) {
            return redirect()->route('petugas.dashboard');
        }
        return redirect()->route('siswa.dashboard');
    })->name('dashboard');

    // ==================== FITUR ADMIN & PETUGAS (CRUD BUKU) ====================
    Route::middleware(['role:admin|petugas'])->prefix('kelola')->name('kelola.')->group(function () {
        Route::resource('buku', BukuWebController::class);
    });

    // ==================== FITUR ADMIN ====================
    Route::middleware(['role:admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
        Route::get('/users', [AdminController::class, 'users'])->name('users.index');
        Route::put('/users/{id}/role', [AdminController::class, 'updateUserRole'])->name('users.updateRole');
        Route::delete('/users/{id}', [AdminController::class, 'destroyUser'])->name('users.destroy');
    });

    // ==================== FITUR PETUGAS ====================
    Route::middleware(['role:admin|petugas'])->prefix('petugas')->name('petugas.')->group(function () {
        Route::get('/dashboard', [PetugasController::class, 'dashboard'])->name('dashboard');
        Route::get('/peminjaman', [PetugasController::class, 'peminjamanIndex'])->name('peminjaman.index');
        Route::patch('/peminjaman/{id}', [PetugasController::class, 'updateStatusPeminjaman'])->name('peminjaman.updateStatus');
    });

    // ==================== FITUR SISWA (PINJAM BUKU) ====================
    Route::middleware(['role:siswa'])->prefix('siswa')->name('siswa.')->group(function () {
        Route::get('/dashboard', [SiswaController::class, 'dashboard'])->name('dashboard');
        Route::post('/peminjaman/ajukan/{buku_id}', [SiswaController::class, 'ajukanPeminjaman'])->name('peminjaman.ajukan');
        Route::get('/riwayat', [SiswaController::class, 'riwayatPeminjaman'])->name('riwayat');
    });

    // ==================== LIHAT BUKU & DETAIL BERDASARKAN ID (SEMUA ROLE) ====================
    Route::get('/buku', function () {
        return view('buku.index'); // Halaman daftar buku fetch API
    })->name('buku.index');

    Route::get('/buku/{id}', function ($id) {
        $buku = \App\Models\Buku::with('kategori')->findOrFail($id);
        return view('buku.show', compact('buku'));
    })->name('buku.show');

    // Profile Management
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';