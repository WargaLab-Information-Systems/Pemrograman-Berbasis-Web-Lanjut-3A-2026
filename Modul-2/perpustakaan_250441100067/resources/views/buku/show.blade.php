@extends('layouts.app')

@section('title', 'Detail Buku')

@section('content')

@if (!$buku)

    <div class="page-header">
        <h2>Buku Tidak Ditemukan</h2>
        <p>Maaf, buku yang kamu cari tidak tersedia.</p>

        <a href="{{ route('buku.index') }}" class="btn-detail">
            Kembali ke Daftar Buku
        </a>
    </div>

@else

    <div class="detail-card">
        <h2>{{ $buku->judul }}</h2>

        <p>
            <strong>Penulis:</strong>
            {{ $buku->penulis }}
        </p>

        <p>
            <strong>Tahun Terbit:</strong>
            {{ $buku->tahun_terbit }}
        </p>

        <p>
            <strong>Kategori:</strong>
            {{ $buku->kategori->nama ?? 'Tanpa Kategori' }}
        </p>

        <a href="{{ route('buku.index') }}" class="btn-detail">
            Kembali ke Daftar Buku
        </a>
    </div>

@endif

@endsection