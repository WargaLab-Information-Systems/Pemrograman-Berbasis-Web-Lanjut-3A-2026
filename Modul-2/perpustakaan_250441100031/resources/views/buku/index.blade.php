@extends('layouts.app')

@section('content')
    <div class="page-header">
        <h2>📚 Koleksi Buku Terbaru</h2>
        <p>Pilih dan temukan informasi lengkap dari buku favoritmu!</p>
    </div>

    <div class="grid-buku">
        @foreach ($daftarBuku as $buku)
            <x-buku-card 
                :judul="$buku['judul']" 
                :penulis="$buku['penulis']" 
                :tahun="$buku['tahun']"
                :id="$buku['id']"
                :gambar="$buku['gambar']"
                :kategori="$buku['kategori']"
            >
                <p class="deskripsi-singkat">{{ Str::limit($buku['deskripsi'], 60) }}</p>
            </x-buku-card>
        @endforeach
    </div>
@endsection