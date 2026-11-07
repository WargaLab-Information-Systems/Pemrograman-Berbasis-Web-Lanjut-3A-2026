<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function index()
    {
        // Pastikan variabel $laporans diambil dari database
        $laporans = Peminjaman::with(['user', 'buku'])->latest()->get();

        return view('laporan.index', compact('laporans'));
    }
}