@extends('layouts.app')

@section('title', 'Detail Buku')

@section('content')

    @if ($bukuDetail)

        <div class="detail-card">

            <div class="detail-icon">
                📖
            </div>

            <div class="detail-content">

                <h2>{{ $bukuDetail['judul'] }}</h2>

                <div class="detail-item">
                    <strong>ID Buku</strong>
                    <span>{{ $bukuDetail['id'] }}</span>
                </div>

                <div class="detail-item">
                    <strong>Judul</strong>
                    <span>{{ $bukuDetail['judul'] }}</span>
                </div>

                <div class="detail-item">
                    <strong>Penulis</strong>
                    <span>{{ $bukuDetail['penulis'] }}</span>
                </div>

                <div class="detail-item">
                    <strong>Tahun Terbit</strong>
                    <span>{{ $bukuDetail['tahun'] }}</span>
                </div>

                <div class="detail-item">
                    <strong>Kategori</strong>
                    <span>{{ $bukuDetail['kategori'] }}</span>
                </div>

                <a href="{{ route('buku.index') }}" class="btn">
                    Kembali ke Daftar Buku
                </a>

            </div>

        </div>

    @else

        <div class="not-found">
            <h2>Buku Tidak Ditemukan</h2>

            <p>
                Maaf, data buku yang Anda cari tidak tersedia.
            </p>

            <a href="{{ route('buku.index') }}" class="btn">
                Kembali ke Daftar Buku
            </a>
        </div>

    @endif

@endsection