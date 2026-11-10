@extends('layouts.app')

@section('title', 'Beranda')

@section('content')

    <div class="hero">
        <h2>Selamat Datang di Perpustakaan Digital</h2>

        <p>
            Temukan berbagai koleksi buku yang dapat membantu
            menambah pengetahuan dan wawasan Anda.
        </p>

        <a href="{{ route('buku.index') }}" class="btn">
            Lihat Daftar Buku
        </a>
    </div>

    <div class="info-section">
        <h2>Tentang Perpustakaan</h2>

        <p>
            Perpustakaan Digital merupakan aplikasi sederhana
            untuk menampilkan informasi koleksi buku.
        </p>
    </div>

@endsection