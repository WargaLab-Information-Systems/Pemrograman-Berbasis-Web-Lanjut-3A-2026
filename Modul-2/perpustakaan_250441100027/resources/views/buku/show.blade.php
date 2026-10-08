@extends('layouts.main')

@section('title', isset($buku) && $buku ? $buku['judul'] : 'Buku Tidak Ditemukan')

@section('content')
    @if ($buku)
        <div class="card" style="max-width: 650px; margin: 0 auto; padding: 25px;">
            @if(isset($buku['gambar']))
                <img src="{{ $buku['gambar'] }}" alt="{{ $buku['judul'] }}" style="width: 100%; max-height: 380px; object-fit: cover; border-radius: 8px; margin-bottom: 20px;">
            @endif

            <span class="badge">{{ $buku['kategori'] }}</span>
            <h2 style="margin-top: 12px; color: #4a2c11; font-size: 1.6rem;">{{ $buku['judul'] }}</h2>
            <hr style="margin: 1rem 0; border: 0; border-top: 1px solid #e8e2dc;">
            
            <p style="margin-bottom: 6px;"><strong>Penulis:</strong> {{ $buku['penulis'] }}</p>
            <p style="margin-bottom: 12px;"><strong>Tahun Terbit:</strong> {{ $buku['tahun_terbit'] }}</p>
            
            <p style="margin-top: 1rem; font-weight: bold; color: #4a2c11;">Deskripsi:</p>
            <p style="background: #fcf8f2; padding: 12px 15px; border-left: 4px solid #8b5a2b; margin-top: 6px; border-radius: 0 6px 6px 0; color: #555;">
                {{ $buku['deskripsi'] }}
            </p>

            <div style="margin-top: 25px;">
                <a href="{{ route('buku.index') }}" class="btn" style="width: 100%; text-align: center;">&larr; Kembali ke Daftar Buku</a>
            </div>
        </div>
    @else
        <div class="card" style="text-align: center; max-width: 500px; margin: 0 auto; padding: 30px;">
            <h2 style="color: #c0392b; margin-bottom: 10px;">⚠️ Buku Tidak Ditemukan</h2>
            <p style="margin-bottom: 20px; color: #666;">Buku dengan ID tersebut tidak ada di dalam sistem.</p>
            <a href="{{ route('buku.index') }}" class="btn">&larr; Kembali ke Daftar Buku</a>
        </div>
    @endif
@endsection