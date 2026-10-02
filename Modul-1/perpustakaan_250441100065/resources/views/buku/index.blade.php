@extends('layouts.app')

@section('content')

<h2 class="page-title">
    Daftar Buku Perpustakaan
</h2>

<div class="book-grid">

    @foreach($buku as $item)

        <x-card-buku
            :judul="$item['judul']"
            :penulis="$item['penulis']"
            :tahun="$item['tahun']"
        >

            <x-slot:kategori>
                Kategori: {{ $item['kategori'] }}
            </x-slot:kategori>

            <x-slot:button>
                <a
                    href="{{ route('buku.show', $item['id']) }}"
                    class="btn"
                >
                    Detail Buku
                </a>
            </x-slot:button>

        </x-card-buku>

    @endforeach

</div>

@endsection
