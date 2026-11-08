
@extends('layouts.app')

@section('title', 'Beranda')

@section('content')

    <section class="hero">
        <div class="hero-text">
            <span class="eyebrow">SELAMAT DATANG</span>

            <h2>Temukan Dunia Baru Melalui Buku</h2>

            <p>
                Jelajahi berbagai koleksi buku pilihan untuk
                menambah pengetahuan, menemukan inspirasi,
                dan mengembangkan diri.
            </p>
            
        </div>

        <div class="hero-image">
            <img
                src="https://images.unsplash.com/photo-1507842217343-583bb7270b66?auto=format&fit=crop&w=900&q=85"
                alt="Rak buku di perpustakaan"
            >
        </div>
    </section>

    <section class="welcome-section">
        <div>
            <span class="eyebrow">KENALI KAMI</span>
            <h2>Perpustakaan Digital</h2>
            <p>
                Tempat sederhana untuk menemukan informasi
                dari berbagai buku. Baca, pelajari, dan
                temukan inspirasi baru setiap hari.
            </p>
        </div>

    </section>

    <section class="home-cta">
        <h2>Siap menemukan buku favoritmu?</h2>
        <p>Lihat koleksi buku yang tersedia di perpustakaan kami.</p>

        <a href="{{ route('buku.index') }}" class="btn btn-light">
            Lihat Semua Buku →
        </a>
    </section>

@endsection
