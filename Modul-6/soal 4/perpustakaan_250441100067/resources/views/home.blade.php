@extends('layouts.app')

@section('title', 'Beranda')

@section('content')

<div class="hero">
    <h2>Selamat Datang di Perpustakaan ela</h2>

    <p>
        Temukan berbagai koleksi buku menarik untuk menambah
        pengetahuan dan wawasan.
    </p>

    <a href="{{ route('buku.index') }}" class="btn">
        Lihat Daftar Buku
    </a>
</div>

@endsection
