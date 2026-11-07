@extends('layouts.app')

@section('title', 'Beranda - Perpustakaan Digital')

@section('content')
    <div class="hero">
        <h2>Selamat Datang di Perpustakaan Digital</h2>
        <p>Sistem Katalog Informasi Buku Perpustakaan Digital</p>
        <br>
        <a href="{{ route('buku.index') }}" class="btn">Jelajahi Daftar Buku</a>
    </div>
@endsection