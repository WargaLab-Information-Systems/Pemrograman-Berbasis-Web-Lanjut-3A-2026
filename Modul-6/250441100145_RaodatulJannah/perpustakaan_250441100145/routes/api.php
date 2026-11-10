<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\BukuController;
use App\Http\Controllers\Api\RekapController;

Route::apiResource('buku', BukuController::class)
    ->names('api.buku')
    ->middleware('auth:sanctum')
    ->middlewareFor(['index', 'show'], 'permission:view books')
    ->middlewareFor(['store', 'update', 'destroy'], 'can:kelola-buku');

Route::get('/rekap/buku-per-kategori', [RekapController::class, 'bukuPerKategori'])
    ->middleware(['auth:sanctum', 'permission:view library reports']);

Route::get('/rekap/peminjaman-per-buku', [RekapController::class, 'peminjamanPerBuku'])
    ->middleware(['auth:sanctum', 'permission:view library reports']);
