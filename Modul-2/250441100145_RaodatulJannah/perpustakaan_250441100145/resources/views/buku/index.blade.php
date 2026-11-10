@extends('layouts.app')

@section('title', 'Daftar Buku')

@section('content')

    <div class="page-header">
        <h2>Daftar Buku</h2>

        <p>
            Berikut adalah koleksi buku yang tersedia
            di Perpustakaan Digital.
        </p>
    </div>

    <div class="book-grid">

        @foreach ($buku as $item)

            <x-buku-card :buku="$item">

                <x-slot name="action">
                    <a href="{{ route('buku.show', $item['id']) }}" class="btn">
                        Lihat Detail
                    </a>
                </x-slot>

            </x-buku-card>

        @endforeach

    </div>

@endsection