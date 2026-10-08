@extends('layouts.main')

@section('title', 'Beranda - Perpustakaan Digital')

@section('content')
    <div style="background: #6e431f; color: white; padding: 60px 30px; border-radius: 16px; text-align: center; box-shadow: 0 4px 15px rgba(0,0,0,0.1); margin-top: 20px;">
        <h1 style="font-size: 2.3rem; margin-bottom: 15px; font-weight: 700;">Selamat Datang di Perpustakaan Digital</h1>
        <p style="font-size: 1.05rem; opacity: 0.9; max-width: 650px; margin: 0 auto 30px auto; line-height: 1.6;">
            Temukan berbagai koleksi novel fiksi, sastra, petualangan, hingga cerita inspiratif untuk menemani waktu luang Anda.
        </p>

        <form action="{{ route('buku.index') }}" method="GET" style="max-width: 550px; margin: 0 auto; display: flex; gap: 10px;">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari judul buku, penulis, atau kategori..." style="flex: 1; padding: 12px 18px; border-radius: 8px; border: none; outline: none; font-size: 0.95rem;">
            <button type="submit" style="background-color: #f39c12; color: white; padding: 12px 22px; font-weight: bold; border-radius: 8px; border: none; cursor: pointer; white-space: nowrap; font-size: 0.95rem; display: flex; align-items: center; gap: 6px;">
                Cari Buku
            </button>
        </form>
    </div>
@endsection