@extends('layouts.app')

@section('title', 'Daftar Buku')

@section('content')

    <h2>Daftar Buku</h2>

    <p>
        Berikut adalah koleksi buku yang tersedia di perpustakaan.
    </p>

    <div class="book-grid">

        @foreach ($bukus as $buku)

            <x-buku-card
                :judul="$buku['judul']"
                :penulis="$buku['penulis']"
                :tahun="$buku['tahun']"
            >
                <x-slot:action>
                    <a
                        href="{{ route('buku.show', $buku['id']) }}"
                        class="btn"
                    >
                        Lihat Detail
                    </a>
                </x-slot:action>
            </x-buku-card>

        @endforeach

    </div>

@endsection