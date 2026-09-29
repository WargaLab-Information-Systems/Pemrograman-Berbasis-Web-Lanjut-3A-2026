@extends('layouts.app')

@section('title', 'Detail Buku')

@section('content')
    @if ($buku)
        <div class="detail-wrapper">
            <a href="{{ route('buku.index') }}" class="link-kembali">← Kembali ke Daftar Buku</a>

            <div class="detail-card">
                <div class="detail-header">
                    <h2>{{ $buku['judul'] }}</h2>
                    <span class="badge-kategori">{{ $buku['kategori'] }}</span>
                </div>

                <div class="detail-body">
                    <div class="detail-item">
                        <span class="label">> Penulis</span>
                        <span class="nilai">{{ $buku['penulis'] }}</span>
                    </div>
                    <div class="detail-item">
                        <span class="label">> Tahun Terbit</span>
                        <span class="nilai">{{ $buku['tahun'] }}</span>
                    </div>
                    <div class="detail-item">
                        <span class="label">> ID Buku</span>
                        <span class="nilai">{{ $buku['id'] }}</span>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="not-found">
            <h2>Buku Tidak Ditemukan</h2>
            <p>Maaf, buku dengan ID tersebut tidak ada dalam koleksi kami.</p>
            <a href="{{ route('buku.index') }}" class="tombol-utama">
                ← Kembali ke Daftar Buku
            </a>
        </div>
    @endif
@endsection