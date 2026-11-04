@extends('layouts.app')

@section('title', 'Beranda')

@section('content')
    <div class="hero">
        <h2>Selamat Datang di Perpustakaan Digital </h2>
        <p>Temukan koleksi buku pilihan dari berbagai kategori — novel, sejarah, filsafat, dan lainnya.</p>

        <a href="{{ route('buku.index') }}" class="tombol-utama">
            Lihat Daftar Buku →
        </a>
    </div>

    <div class="info-box">
        <h3>About This App</h3>
        <p>
            Aplikasi ini dibuat untuk memenuhi tugas praktikum Pemrograman Web Lanjut (PBWL).
            Dibangun menggunakan framework <strong>Laravel</strong> dengan konsep <strong>MVC</strong>
            dan <strong>Blade Templating</strong>.
        </p>
    </div>
@endsection