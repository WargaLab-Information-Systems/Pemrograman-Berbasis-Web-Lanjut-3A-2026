
@extends('layouts.app')

@section('title', 'Detail Peminjaman')

@section('content')
<style>
    .detail-peminjaman {
        background: #dcdafa;
        min-height: 80vh;
        padding: 30px;
    }

    .kotak-detail {
        background: white;
        max-width: 700px;
        margin: auto;
        padding: 25px;
        border-radius: 15px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.08);
    }

    .kotak-detail h2 {
        color: #754b32;
        margin-bottom: 20px;
    }

    .baris-detail {
        padding: 12px 0;
        border-bottom: 1px solid #eee;
        color: #754b32;
    }

    .tombol-kembali {
        display: inline-block;
        margin-top: 20px;
        padding: 10px 18px;
        background: #91613f;
        color: white;
        text-decoration: none;
        border-radius: 8px;
    }
</style>

<div class="detail-peminjaman">
    <div class="kotak-detail">
        <h2>Detail Peminjaman</h2>

        <div class="baris-detail">
            <strong>ID Peminjaman:</strong>
            {{ $peminjaman->id }}
        </div>

        <div class="baris-detail">
            <strong>Nama Anggota:</strong>
            {{ $peminjaman->anggota->nama ?? '-' }}
        </div>

        <div class="baris-detail">
            <strong>Judul Buku:</strong>
            {{ $peminjaman->buku->judul ?? '-' }}
        </div>

        <div class="baris-detail">
            <strong>Tanggal Pinjam:</strong>
            {{ $peminjaman->tanggal_pinjam }}
        </div>

        <div class="baris-detail">
            <strong>Tanggal Kembali:</strong>
            {{ $peminjaman->tanggal_kembali ?? 'Belum dikembalikan' }}
        </div>

        <div class="baris-detail">
            <strong>Status:</strong>
            {{ $peminjaman->status }}
        </div>

        <a href="{{ url('/dashboard') }}" class="tombol-kembali">
            Kembali
        </a>
    </div>
</div>
@endsection
