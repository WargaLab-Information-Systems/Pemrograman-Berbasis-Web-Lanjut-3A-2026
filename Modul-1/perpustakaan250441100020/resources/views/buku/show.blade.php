@extends('layouts.app')

@section('title', 'Detail Buku')

@section('content')

    <h1>Detail Buku</h1>

    @if ($item)

        <p>ID: {{ $item['id'] }}</p>
        <p><b>Judul : </b> {{ $item['judul'] }}</p>
        <p><b>Penulis : </b> {{ $item['penulis'] }}</p>
        <p><b>Tahun Terbit : </b> {{ $item['tahun'] }}</p>
        <p><b>Kategori : </b> {{ $item['kategori'] }}</p>

    @else

        <p>Buku tidak ditemukan.</p>

    @endif

@endsection