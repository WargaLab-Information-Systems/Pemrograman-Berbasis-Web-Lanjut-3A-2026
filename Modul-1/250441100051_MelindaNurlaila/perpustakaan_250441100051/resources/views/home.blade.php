@extends('layouts.app')

@section('title', 'Beranda')

@section('content')

<section class="hero">

    <div class="hero-content">

        <span class="hero-label">
            PERPUSTAKAAN
        </span>

        <h2>Selamat Datang di Perpustakaan</h2>

        <p>
            Temukan berbagai koleksi buku menarik, mulai dari novel,
            sejarah, hingga pengembangan diri.
        </p>

        <a href="{{ route('buku.index') }}" class="primary-button">Lihat Daftar Buku</a>

    </div>

    <div class="hero-decoration">

        <svg class="hero-icon" viewBox="0 0 200 220" role="img" aria-label="Rak buku perpustakaan">
            <rect x="10" y="10" width="180" height="200" rx="12" fill="#fbe4ea" stroke="#d9738a" stroke-width="6"/>

            <rect x="24" y="35" width="18" height="70" rx="2" fill="#d9738a"/>
            <rect x="44" y="50" width="14" height="55" rx="2" fill="#f0a3b5"/>
            <rect x="60" y="30" width="20" height="75" rx="2" fill="#b85a70"/>
            <rect x="82" y="45" width="16" height="60" rx="2" fill="#f7c6d2"/>
            <rect x="100" y="37" width="18" height="68" rx="2" fill="#d9738a"/>
            <rect x="128" y="42" width="16" height="63" rx="2" fill="#f0a3b5" transform="rotate(12 136 105)"/>
            <rect x="150" y="33" width="20" height="72" rx="2" fill="#b85a70"/>
            <rect x="13" y="105" width="174" height="8" fill="#d9738a"/>

            <rect x="24" y="142" width="16" height="58" rx="2" fill="#f0a3b5"/>
            <rect x="42" y="130" width="20" height="70" rx="2" fill="#b85a70"/>
            <rect x="64" y="148" width="14" height="52" rx="2" fill="#d9738a"/>
            <rect x="80" y="136" width="18" height="64" rx="2" fill="#f7c6d2"/>
            <rect x="100" y="144" width="16" height="56" rx="2" fill="#d9738a"/>
            <rect x="118" y="128" width="20" height="72" rx="2" fill="#f0a3b5"/>
            <rect x="140" y="140" width="16" height="60" rx="2" fill="#b85a70"/>
            <rect x="158" y="150" width="16" height="50" rx="2" fill="#f7c6d2"/>
            <rect x="13" y="200" width="174" height="8" fill="#d9738a"/>
        </svg>

    </div>

</section>

@endsection