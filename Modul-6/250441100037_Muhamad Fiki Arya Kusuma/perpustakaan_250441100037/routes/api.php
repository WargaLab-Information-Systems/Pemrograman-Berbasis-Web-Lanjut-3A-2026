<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\BukuController;

// Rute Publik Auth API (Modul 5)
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Endpoint Rekap Data (Soal No. 7)
Route::get('/rekap/buku-per-kategori', [BukuController::class, 'rekapBukuPerKategori']);
Route::get('/rekap/peminjaman-per-buku', [BukuController::class, 'rekapPeminjamanPerBuku']);

// Resource API diberi nama prefix khusus agar TIDAK bentrok dengan route Web Blade
Route::apiResource('buku-api', BukuController::class);