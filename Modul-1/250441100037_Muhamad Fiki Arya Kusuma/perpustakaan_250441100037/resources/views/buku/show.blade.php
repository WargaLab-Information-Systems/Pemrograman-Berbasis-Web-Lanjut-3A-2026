@extends('layouts.app')

@section('title', 'Detail Buku')

@section('content')
    @if(!$buku)
        <div class="alert alert-error">
            <h2> Data Buku Tidak Ditemukan!</h2>
            <p>Buku dengan ID tersebut tidak ada dalam sistem perpustakaan.</p>
            <a href="{{ route('buku.index') }}" class="btn">Kembali ke Daftar Buku</a>
        </div>
    @else
        <div class="detail-buku">
            <h2>{{ $buku['judul'] }}</h2>
            <hr><br>
            <p><strong>ID Buku:</strong> {{ $buku['id'] }}</p>
            <p><strong>Penulis:</strong> {{ $buku['penulis'] }}</p>
            <p><strong>Tahun Terbit:</strong> {{ $buku['tahun_terbit'] }}</p>
            <p><strong>Kategori:</strong> {{ $buku['kategori'] }}</p>
            <br>
            <a href="{{ route('buku.index') }}" class="btn btn-secondary">← Kembali ke Daftar Buku</a>
        </div>
    @endif
@endsection