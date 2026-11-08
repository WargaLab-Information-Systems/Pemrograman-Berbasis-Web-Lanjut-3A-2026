@extends('layouts.app')

@section('title', 'Daftar Buku')

@section('content')

<div class="page-header">
    <h2>Daftar Buku</h2>
    <p>Berikut koleksi buku yang tersedia di perpustakaan.</p>
</div>

<div class="book-grid">

    @foreach ($buku as $item)

        <x-kartu-buku
            :id="$item['id']"
            :judul="$item['judul']"
            :penulis="$item['penulis']"
            :tahun="$item['tahun']"
        >
            <span class="category">
                {{ $item['kategori'] }}
            </span>
        </x-kartu-buku>

    @endforeach

</div>

@endsection
