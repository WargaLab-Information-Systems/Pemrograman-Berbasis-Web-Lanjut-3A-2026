@extends('layouts.app')

@section('title', 'Daftar Buku')

@section('content')

<section class="book-section">

    <div class="page-header">

        <span class="hero-label">
            KOLEKSI PERPUSTAKAAN
        </span>

        <h2>Daftar Buku</h2>

        <p>
            Berikut adalah koleksi buku yang tersedia
            di perpustakaan.
        </p>

    </div>

    <form action="{{ route('buku.index') }}" method="GET" class="search-form">
        <input
            type="text"
            name="q"
            value="{{ $keyword }}"
            placeholder="Cari judul, penulis, atau kategori..."
            class="search-input"
        >

        <button type="submit" class="primary-button">
            Cari
        </button>
    </form>

    @if (count($buku) > 0)

        <div class="book-grid">

            @foreach ($buku as $item)

                <x-buku-card
                    :judul="$item->judul"
                    :penulis="$item->penulis"
                    :tahun="$item->tahun_terbit"
                >

                    <p>
                        <strong>Kategori:</strong>
                        {{ $item->kategori->nama }}
                    </p>

                    <a
                        href="{{ route('buku.show', $item->id) }}"
                        class="primary-button"
                    >
                        Lihat Detail
                    </a>

                </x-buku-card>

            @endforeach

        </div>

    @else

        <p class="search-empty">
            Buku tidak ditemukan untuk pencarian "{{ $keyword }}".
        </p>

    @endif

</section>

@endsection