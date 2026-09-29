@extends('layouts.app')

@section('title', 'Daftar Buku')

@section('content')

    <h2>Daftar Buku</h2>

    <div class="book-list">

        @foreach($buku as $data)

            <x-buku-card
                :id="$data['id']"
                :judul="$data['judul']"
                :penulis="$data['penulis']"
                :tahun="$data['tahun']"
            >
                <p>Kategori: {{ $data['kategori'] }}</p>
            </x-buku-card>

        @endforeach

    </div>

@endsection