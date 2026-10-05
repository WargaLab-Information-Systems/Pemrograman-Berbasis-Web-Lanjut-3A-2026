@extends('layouts.app')

@section('title', 'Daftar Buku')

@section('content')

<h2>Daftar Buku</h2>

<div class="book-container">

    @foreach ($buku as $item)

    <x-book-card :buku="$item">
        <p>Kategori: {{ $item['kategori'] }}</p>
    </x-book-card>

    @endforeach

</div>

@endsection