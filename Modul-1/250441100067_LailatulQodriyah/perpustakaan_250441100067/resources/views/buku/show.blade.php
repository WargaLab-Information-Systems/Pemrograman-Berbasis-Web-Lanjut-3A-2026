@extends('layouts.app')

@section('title', 'Detail Buku')

@section('content')

@if ($buku)

    <div class="detail-card">

        <div class="detail-content">

            <span class="category">
                {{ $buku['kategori'] }}
            </span>

            <h2>{{ $buku['judul'] }}</h2>

            <div class="detail-data">
                <p>
                    <strong>ID Buku</strong>
                    <span>{{ $buku['id'] }}</span>
                </p>

                <p>
                    <strong>Penulis</strong>
                    <span>{{ $buku['penulis'] }}</span>
                </p>

                <p>
                    <strong>Tahun Terbit</strong>
                    <span>{{ $buku['tahun'] }}</span>
                </p>

                <p>
                    <strong>Kategori</strong>
                    <span>{{ $buku['kategori'] }}</span>
                </p>
            </div>

            <a href="{{ route('buku.index') }}" class="btn">
                ← Kembali ke Daftar Buku
            </a>

        </div>

    </div>

@else

    <div class="not-found">
        <h2> Buku Tidak Ditemukan</h2>

        <p>
            Maaf, data buku yang kamu cari tidak tersedia.
        </p>

        <a href="{{ route('buku.index') }}" class="btn">
            Kembali ke Daftar Buku
        </a>
    </div>

@endif

@endsection