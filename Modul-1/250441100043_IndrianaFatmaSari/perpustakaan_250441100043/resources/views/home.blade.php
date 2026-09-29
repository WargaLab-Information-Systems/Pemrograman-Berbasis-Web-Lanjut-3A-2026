@extends('layouts.app')

@section('title', 'Beranda')

@section('content')

    <section>
        <h2>Selamat Datang di Perpustakaan</h2>

        <p>
            Temukan berbagai cerita dan bacaan menarik
            yang bisa menemani waktu luangmu.
        </p>

        <a href="{{ route('buku.index') }}">
            Lihat Daftar Buku
        </a>
    </section>

@endsection