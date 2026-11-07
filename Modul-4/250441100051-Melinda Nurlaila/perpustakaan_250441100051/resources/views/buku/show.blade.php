@extends('layouts.app')

@section('title', $buku ? $buku->judul : 'Buku Tidak Ditemukan')

@section('content')

@php
    $folder = 'images/buku/';
    $file = null;

    if ($buku) {
        if (!empty($buku->gambar) && file_exists(public_path($folder . $buku->gambar))) {
            $file = $buku->gambar;
        } else {
            $slug = \Illuminate\Support\Str::slug($buku->judul);

            foreach (['jpg', 'jpeg', 'png', 'webp'] as $ext) {
                if (file_exists(public_path($folder . $slug . '.' . $ext))) {
                    $file = $slug . '.' . $ext;
                    break;
                }
            }
        }
    }
@endphp

<section class="detail-section">

    @if ($buku)

        <div class="detail-card">

            <span class="hero-label">
                {{ $buku->kategori->nama }}
            </span>

            @if ($file)
                <img
                    src="{{ asset($folder . $file) }}"
                    alt="Sampul buku {{ $buku->judul }}"
                    class="detail-cover"
                >
            @else
                <div class="detail-cover book-cover-placeholder">
                    {{ mb_substr($buku->judul, 0, 1) }}
                </div>
            @endif

            <h2>{{ $buku->judul }}</h2>

            <div class="detail-info">
                <p>
                    <strong>Penulis</strong>
                    <span>{{ $buku->penulis }}</span>
                </p>

                <p>
                    <strong>Tahun Terbit</strong>
                    <span>{{ $buku->tahun_terbit }}</span>
                </p>

                <p>
                    <strong>Kategori</strong>
                    <span>{{ $buku->kategori->nama }}</span>
                </p>
            </div>

            <a href="{{ route('buku.index') }}" class="primary-button">
                Kembali ke Daftar
            </a>

        </div>

    @else

        <div class="detail-card not-found">
            <h2>Buku tidak ditemukan</h2>

            <p>
                Buku yang kamu cari tidak ada di koleksi.
            </p>

            <a href="{{ route('buku.index') }}" class="primary-button">
                Kembali ke Daftar
            </a>
        </div>

    @endif

</section>

@endsection