@extends('layouts.app')

@section('title', 'Home')

@section('content')

    <h2>Selamat Datang di Perpustakaan</h2>

    <p>
        Silakan melihat koleksi buku yang tersedia di perpustakaan.
    </p>

    <a href="{{ route('buku.index') }}">
        Lihat Daftar Buku
    </a>

@endsection