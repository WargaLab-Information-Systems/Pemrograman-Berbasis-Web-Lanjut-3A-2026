@extends('layouts.app')

@section('title', 'Detail Buku')

@section('content')

    @if($buku)

        <div class="book-detail">

            <h2>{{ $buku['judul'] }}</h2>

            <p>Penulis: {{ $buku['penulis'] }}</p>

            <p>Tahun Terbit: {{ $buku['tahun'] }}</p>

            <p>Kategori: {{ $buku['kategori'] }}</p>

            <a href="{{ route('buku.index') }}">
                Kembali ke Daftar Buku
            </a>

        </div>

    @else

        <div class="book-detail">

            <h2>Buku Tidak Ditemukan</h2>

            <p>Maaf, buku dengan ID tersebut tidak tersedia.</p>

            <a href="{{ route('buku.index') }}">
                Kembali ke Daftar Buku
            </a>

        </div>

    @endif

@endsection