<?php

use App\Models\Kategori;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BukuController;

Route::get('/', [BukuController::class, 'home'])
    ->name('home');

Route::get('/buku', function () {
    $kategoris = Kategori::all(); 
    return view('buku.index', compact('kategoris'));
});

Route::get('/buku/{id}', [BukuController::class, 'show'])
    ->name('buku.show');
