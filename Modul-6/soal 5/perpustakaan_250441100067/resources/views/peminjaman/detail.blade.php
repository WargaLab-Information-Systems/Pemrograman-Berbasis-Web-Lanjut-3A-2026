@extends('layouts.app')

@section('title', 'Detail Peminjaman')

@section('content')

<style>
    body {
        background: #dcdafa;
        font-family: Arial, sans-serif;
    }

    .halaman {
        min-height: 100vh;
        padding: 25px;
        background: #dcdafa;
    }

    .kartu {
        max-width: 600px;
        margin: auto;
        padding: 25px;
        background: white;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.08);
    }

    h2 {
        color: #754b32;
    }

    p {
        color: #333;
        margin: 12px 0;
    }
</style>

<div class="halaman">
    <div class="kartu">

        <h2>Detail Peminjaman</h2>

        <p>
            <strong>ID Peminjaman:</strong>
            {{ $peminjaman->id }}
        </p>

        <p>
            <strong>Nama Anggota:</strong>
            {{ $peminjaman->anggota->nama ?? '-' }}
        </p>

        <p>
            <strong>Judul Buku:</strong>
            {{ $peminjaman->buku->judul ?? '-' }}
        </p>

        <p>
            <strong>Tanggal Pinjam:</strong>
            {{ $peminjaman->tanggal_pinjam }}
        </p>

        <p>
            <strong>Tanggal Kembali:</strong>
            {{ $peminjaman->tanggal_kembali ?? '-' }}
        </p>

        <p>
            <strong>Status:</strong>
            {{ $peminjaman->status }}
        </p>

    </div>
</div>

@endsection
