@extends('layouts.app')

@section('title', 'Beranda')

@section('content')

<h2>Selamat Datang di Perpustakaan</h2>

<p>
    Selamat datang di Perpustakaan.
</p>

<a href="{{ route('buku.index') }}">
    Lihat Daftar Buku
</a>

@endsection