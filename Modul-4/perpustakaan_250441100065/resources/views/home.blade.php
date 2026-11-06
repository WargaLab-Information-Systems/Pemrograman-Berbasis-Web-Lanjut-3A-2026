@extends('layouts.app')

@section('content')

<div class="hero" style="background-image: linear-gradient(rgba(15, 23, 42, 0.75), rgba(15, 23, 42, 0.75)), url('{{ asset('images/background.jpg') }}');">

    <h2>Selamat Datang di Perpustakaan IT Digital</h2>

    <p>
        Pusat referensi dan literatur pemrograman, software engineering, kecerdasan buatan (AI),
        serta arsitektur sistem modern untuk menunjang kebutuhan belajar dan ngoding kamu.
    </p>

    <a href="{{ route('buku.index') }}" class="btn">
        Jelajahi Daftar Buku IT
    </a>

</div>

@endsection
