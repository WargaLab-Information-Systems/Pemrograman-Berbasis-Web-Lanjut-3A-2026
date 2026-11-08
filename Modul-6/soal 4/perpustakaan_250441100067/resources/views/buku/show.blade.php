@extends('layouts.app')

@section('title', 'Detail Buku')

@section('content')

<style>
    .halaman-detail {
        background-color: #dcdafa;
        min-height: 100vh;
        padding: 1px 20px 40px;
        font-family: Arial, sans-serif;
        box-sizing: border-box;
    }

    .judul-halaman {
        color: #91613f;
        font-size: 18px;
        font-weight: bold;
        margin: 20px auto;
        max-width: 900px;
    }

    .detail-card {
        background-color: #ffffff;
        max-width: 900px;
        margin: 20px auto;
        padding: 25px;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        box-sizing: border-box;
    }

    .detail-content h2 {
        color: #91613f;
        font-size: 20px;
        font-weight: bold;
        margin-top: 0;
        margin-bottom: 20px;
    }

    .detail-data {
        margin-bottom: 25px;
    }

    .detail-data p {
        display: flex;
        align-items: center;
        padding: 12px 0;
        margin: 0;
        border-bottom: 1px solid #eeeeee;
        color: #444444;
        font-size: 14px;
    }

    .detail-data strong {
        color: #754b32;
        width: 130px;
        flex-shrink: 0;
    }

    .btn {
        display: inline-block;
        background-color: #91613f;
        color: white;
        padding: 10px 15px;
        border-radius: 6px;
        text-decoration: none;
        font-size: 13px;
        border: none;
    }

    .btn:hover {
        background-color: #754b32;
        color: white;
    }

    .not-found {
        background-color: #ffffff;
        max-width: 900px;
        margin: 20px auto;
        padding: 30px;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        text-align: center;
    }

    .not-found h2 {
        color: #91613f;
    }

    .not-found p {
        color: #444444;
        font-size: 14px;
    }

    @media (max-width: 600px) {
        .detail-card,
        .not-found {
            padding: 20px;
        }

        .detail-data p {
            flex-direction: column;
            align-items: flex-start;
            gap: 5px;
        }
    }
</style>

<div class="halaman-detail">

    <h2 class="judul-halaman">Detail Buku</h2>

    @if (!$buku)

        <div class="not-found">
            <h2>Buku Tidak Ditemukan</h2>

            <p>
                Maaf, buku yang kamu cari tidak tersedia.
            </p>

            <a href="{{ route('buku.index') }}" class="btn">
                Kembali ke Daftar Buku
            </a>
        </div>

    @else

        <div class="detail-card">

            <div class="detail-content">

                <h2>{{ $buku->judul }}</h2>

                <div class="detail-data">

                    <p>
                        <strong>Penulis:</strong>
                        <span>{{ $buku->penulis }}</span>
                    </p>

                    <p>
                        <strong>Tahun Terbit:</strong>
                        <span>{{ $buku->tahun_terbit }}</span>
                    </p>

                    <p>
                        <strong>Kategori:</strong>
                        <span>{{ $buku->kategori->nama ?? 'Tanpa Kategori' }}</span>
                    </p>

                </div>

                <a href="{{ route('buku.index') }}" class="btn">
                    Kembali ke Daftar Buku
                </a>

            </div>

        </div>

    @endif

</div>

@endsection