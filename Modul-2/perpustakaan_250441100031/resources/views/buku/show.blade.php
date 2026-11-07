@extends('layouts.app')

@section('content')
    @if ($buku)
        <div class="detail-container">
            <div class="detail-card">
                <div class="detail-img-box">
                    <img src="{{ $buku['gambar'] }}" alt="{{ $buku['judul'] }}">
                </div>
                <div class="detail-info">
                    <span class="badge-kategori-lg">{{ $buku['kategori'] }}</span>
                    <h1>{{ $buku['judul'] }}</h1>
                    <p class="detail-author">Penulis: <strong>{{ $buku['penulis'] }}</strong></p>
                    
                    <div class="detail-meta">
                        <div class="meta-item">
                            <span>ID Buku</span>
                            <strong>#{{ $buku['id'] }}</strong>
                        </div>
                        <div class="meta-item">
                            <span>Tahun Terbit</span>
                            <strong>{{ $buku['tahun'] }}</strong>
                        </div>
                    </div>

                    <div class="detail-desc">
                        <h3>Ringkasan Buku</h3>
                        <p>{{ $buku['deskripsi'] }}</p>
                    </div>

                    <a href="{{ route('buku.index') }}" class="btn-back">&larr; Kembali ke Daftar Buku</a>
                </div>
            </div>
        </div>
    @else
        <div class="error-container">
            <div class="error-card">
                <h2>⚠️ Data Tidak Ditemukan</h2>
                <p>Maaf, buku dengan ID tersebut tidak tersedia di perpustakaan kami.</p>
                <a href="{{ route('buku.index') }}" class="btn-primary">&larr; Kembali ke Daftar Buku</a>
            </div>
        </div>
    @endif
@endsection