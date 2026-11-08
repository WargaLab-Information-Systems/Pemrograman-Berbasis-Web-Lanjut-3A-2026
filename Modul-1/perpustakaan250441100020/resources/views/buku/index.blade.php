@extends('layouts/app')

@section('title', 'Daftar Buku')

@section('content')

    <h1><b>Daftar Buku</b></h1>

    @foreach ($buku as $item)

        <x-kartu-buku
            judul="{{ $item['judul'] }}"
            penulis="{{ $item['penulis'] }}"
            tahun="{{ $item['tahun'] }}"
            id="{{ $item['id'] }}"
        >
            <p>Kategori: {{ $item['kategori'] }}</p>
        </x-kartu-buku>

    @endforeach

@endsection