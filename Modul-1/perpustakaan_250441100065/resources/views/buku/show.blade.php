@extends('layouts.app')

@section('content')

<div class="detail-card">

    <h2>Detail Buku</h2>

    @if($buku)

        <p>
            <strong>ID Buku:</strong>
            {{ $buku['id'] }}
        </p>

        <p>
            <strong>Judul:</strong>
            {{ $buku['judul'] }}
        </p>

        <p>
            <strong>Penulis:</strong>
            {{ $buku['penulis'] }}
        </p>

        <p>
            <strong>Tahun Terbit:</strong>
            {{ $buku['tahun'] }}
        </p>

        <p>
            <strong>Kategori:</strong>
            {{ $buku['kategori'] }}
        </p>

    @else

        <div class="not-found">
            Maaf, data buku tidak ditemukan!
        </div>

    @endif

    <a href="{{ route('buku.index') }}" class="btn">
        Kembali ke Daftar Buku
    </a>

</div>

@endsection
