@extends('layouts.app')

@section('title', 'Detail Buku')

@section('content')

<style>
    .detail-page {
        min-height: 85vh;
        background: #F3C1DE;
        padding: 45px 32px 35px;
    }

    .detail-card {
        max-width: 1250px;
        margin: 0 auto;
        background: #F45FB2;
        border-radius: 14px;
        padding: 65px 40px 39px;
        box-shadow: 0 5px 15px rgba(169, 54, 112, 0.12);
    }

    .detail-icon {
        font-size: 52px;
        margin-bottom: 20px;
    }

    .detail-card h2 {
        color: #28618A;
        font-size: 27px;
        font-weight: 700;
        margin-bottom: 28px;
    }

    .detail-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 20px;
        padding: 16px 0;
        border-bottom: 1px solid rgba(255, 255, 255, 0.85);
        color: #333333;
        font-size: 16px;
    }

    .detail-item strong {
        font-weight: 700;
    }

    .detail-item span {
        text-align: right;
        overflow-wrap: anywhere;
    }

    .detail-actions {
        margin-top: 28px;
    }

    .detail-btn {
        display: inline-block;
        background: #28618A;
        color: #ffffff;
        padding: 11px 20px;
        border-radius: 8px;
        text-decoration: none;
        font-size: 16px;
        font-weight: 500;
        transition: 0.2s ease;
    }

    .detail-btn:hover {
        background: #1E4D70;
    }

    .not-found {
        max-width: 1250px;
        margin: 0 auto;
        background: #F45FB2;
        border-radius: 14px;
        padding: 55px 40px;
        text-align: center;
        box-shadow: 0 5px 15px rgba(169, 54, 112, 0.12);
    }

    .not-found h2 {
        color: #28618A;
        font-size: 25px;
        font-weight: 700;
        margin-bottom: 12px;
    }

    .not-found p {
        color: #333333;
        margin-bottom: 25px;
    }

    @media (max-width: 600px) {
        .detail-page {
            padding: 25px 15px;
        }

        .detail-card {
            padding: 35px 22px;
        }

        .detail-card h2 {
            font-size: 23px;
        }

        .detail-item {
            font-size: 14px;
            gap: 12px;
        }

        .detail-btn {
            font-size: 14px;
        }
    }
</style>

<div class="detail-page">

    @if ($bukuDetail)

        <div class="detail-card">

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

            <div class="detail-actions">
                <a href="{{ route('buku.index') }}" class="detail-btn">
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

            <a href="{{ route('buku.index') }}" class="detail-btn">
                Kembali ke Daftar Buku
            </a>
        </div>

    @endif

</div>

@endsection
