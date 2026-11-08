@extends('layouts.app')

@section('title', 'Detail Peminjaman')

@section('content')

<div style="max-width: 900px; margin: 40px auto; padding: 25px; background: white; border-radius: 12px;">

    <h2 style="font-size: 25px; font-weight: bold; margin-bottom: 25px;">
        Detail Peminjaman
    </h2>

    <p><strong>ID Peminjaman:</strong> {{ $peminjaman->id }}</p>

    <p><strong>Nama Anggota:</strong>
        {{ $peminjaman->anggota->nama ?? '-' }}
    </p>

    <p><strong>Email Anggota:</strong>
        {{ $peminjaman->anggota->email ?? '-' }}
    </p>

    <p><strong>Judul Buku:</strong>
        {{ $peminjaman->buku->judul ?? '-' }}
    </p>

    <p><strong>Tanggal Pinjam:</strong>
        {{ $peminjaman->tanggal_pinjam }}
    </p>

    <p><strong>Tanggal Kembali:</strong>
        {{ $peminjaman->tanggal_kembali ?? '-' }}
    </p>

    <p><strong>Status:</strong>
        {{ $peminjaman->status }}
    </p>

    <a href="{{ route('peminjaman.riwayat') }}"
       style="display: inline-block; margin-top: 20px; padding: 10px 18px; background: #ed56a7; color: white; border-radius: 7px; text-decoration: none;">
        Kembali
    </a>

</div>

@endsection