@extends('layouts.app')

@section('title', 'Beranda - Perpustakaan')

@section('content')
    <h2>Selamat Datang di Perpustakaan Digital</h2>
    <p>Temukan berbagai koleksi buku terbaik di sini.</p>
    <a href="{{ route('buku.index') }}">Lihat Daftar Buku</a>
@endsection