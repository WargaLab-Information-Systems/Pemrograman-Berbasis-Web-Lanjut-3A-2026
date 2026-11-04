<?php

use App\Http\Controllers\BukuController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserManagementController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware('auth')->group(function () {
 
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::middleware(['role:admin|petugas|siswa'])->group(function () {
        Route::get('/buku', [BukuController::class, 'index'])->name('buku.index');
        Route::get('/buku/{id}', [BukuController::class, 'show'])->name('buku.show');
        Route::post('/buku/{id}/pinjam', [BukuController::class, 'pinjam'])->name('buku.pinjam');
    });

    Route::middleware('role:admin')->group(function () {
        Route::get('/admin/dashboard', function () {
            return view('admin.dashboard');
        })->name('admin.dashboard');

        Route::get('/admin/users', [UserManagementController::class, 'index'])->name('admin.users.index');
        Route::patch('/admin/users/{user}/role', [UserManagementController::class, 'updateRole'])->name('admin.users.update-role');

        Route::get('/admin/peminjaman', function () { return view('petugas.peminjaman'); })->name('admin.peminjaman');
        Route::get('/admin/pengembalian', function () { return view('petugas.pengembalian'); })->name('admin.pengembalian');
        Route::get('/admin/laporan', function () { return view('admin.laporan'); })->name('admin.laporan');
    });

    Route::middleware('role:petugas')->group(function () {
        Route::get('/petugas/dashboard', function () {
            return view('petugas.dashboard');
        })->name('petugas.dashboard');

        Route::get('/petugas/peminjaman', function () { 
            return view('petugas.peminjaman'); 
        })->name('petugas.peminjaman');

        Route::get('/petugas/pengembalian', function () { 
            return view('petugas.pengembalian'); 
        })->name('petugas.pengembalian');
    });

    Route::middleware('role:siswa')->group(function () {
        Route::get('/siswa/riwayat', function () {
            $user = auth()->user();
            $peminjaman = \App\Models\Peminjaman::with(['buku'])
                            ->whereHas('anggota', function($q) use ($user) {
                                $q->where('email', $user->email); 
                            })->latest()->get();
            
            return view('siswa.riwayat', compact('peminjaman'));
        })->name('siswa.riwayat');
    });

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
});

require __DIR__.'/auth.php';