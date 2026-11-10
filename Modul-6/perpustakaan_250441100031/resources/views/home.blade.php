@extends('layouts.app')

@section('content')
    <section class="hero-section">
        <div class="hero-text">
            <span class="hero-badge">✨ Selamat Datang di PustakaModern</span>
            <h1>Jelajahi Dunia Lewat Lembaran Buku Terbaik</h1>
            <p>Temukan ribuan bacaan menarik, inspiratif, dan edukatif untuk menemani harimu secara mudah dan cepat.</p>
            <div class="hero-buttons">
                <a href="{{ route('buku.index') }}" class="btn-primary">Lihat Koleksi Buku</a>
            </div>
        </div>
        <div class="hero-image">
            <img src="https://images.unsplash.com/photo-1524995997946-a1c2e315a42f?auto=format&fit=crop&w=800&q=80" alt="Perpustakaan">
        </div>
    </section>
@endsection