@extends('layouts.app')

@section('title', 'Detail Buku')

@section('content')

@if ($buku)

<h2>{{ $buku['judul'] }}</h2>

<p>ID Buku: {{ $buku['id'] }}</p>
<p>Penulis: {{ $buku['penulis'] }}</p>
<p>Tahun Terbit: {{ $buku['tahun'] }}</p>
<p>Kategori: {{ $buku['kategori'] }}</p>

<a href="{{ route('buku.index') }}">
    Kembali ke Daftar Buku
</a>

@else

<h2>Buku Tidak Ditemukan</h2>

<p>Data buku yang kamu cari tidak tersedia.</p>

<a href="{{ route('buku.index') }}">
    Kembali ke Daftar Buku
</a>

@endif

@endsection