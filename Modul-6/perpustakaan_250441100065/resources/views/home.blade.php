@extends('layouts.perpus')

@section('content')

<div class="hero" style="background-image: linear-gradient(rgba(15, 23, 42, 0.75), rgba(15, 23, 42, 0.75)), url('{{ asset('images/background.jpg') }}');">

    <h2>Selamat Datang di Perpustakaan IT Digital</h2>

    <p>
        Pusat referensi dan literatur pemrograman, software engineering, kecerdasan buatan (AI),
        serta arsitektur sistem modern untuk menunjang kebutuhan belajar dan ngoding kamu.
    </p>

    @auth
        <a href="{{ route('buku.index') }}" class="btn">
            Jelajahi Daftar Buku IT
        </a>
    @else
        <div style="display:flex; gap:12px; flex-wrap:wrap; justify-content:center;">
            <a href="{{ route('login') }}" class="btn">Login</a>
            <a href="{{ route('register') }}" class="btn btn-green">Daftar Akun Siswa</a>
        </div>
    @endauth

</div>

@endsection
