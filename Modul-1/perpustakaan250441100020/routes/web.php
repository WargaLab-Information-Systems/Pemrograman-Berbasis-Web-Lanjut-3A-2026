<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BukuController;

Route::get('/', function () {
    return view('home');
});

Route::get('/buku', [BukuController::class, 'daftarbuku']);

Route::get('/buku/{id}', [BukuController::class, 'show']);


