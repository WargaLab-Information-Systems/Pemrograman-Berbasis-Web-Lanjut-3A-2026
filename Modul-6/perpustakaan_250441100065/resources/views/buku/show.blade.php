@extends('layouts.perpus')

@section('content')

<div class="detail-card">

    <h2>Detail Buku</h2>

    @if($buku)

        <p>
            <strong>ID Buku:</strong>
            {{ $buku->id }}
        </p>

        <p>
            <strong>Judul:</strong>
            {{ $buku->judul }}
        </p>

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
            {{ $buku->kategori->nama ?? '-' }}
        </p>

    @else

        <div class="not-found">
            Maaf, data buku tidak ditemukan!
        </div>

    @endif

    <div style="display:flex; gap:10px; flex-wrap:wrap; margin-top:20px;">
        <a href="{{ route('buku.index') }}" class="btn">
            Kembali ke Daftar Buku
        </a>

        @if($buku)
            @can('mengajukan peminjaman buku')
                <form method="POST" action="{{ route('peminjaman.ajukan', $buku->id) }}">
                    @csrf
                    <button type="submit" class="btn btn-green">Ajukan Pinjam</button>
                </form>
            @endcan
        @endif
    </div>

</div>

@endsection
