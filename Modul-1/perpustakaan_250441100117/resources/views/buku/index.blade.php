@extends('layouts.app')

@section('title', 'Daftar Buku')

@section('content')
    <div class="page-header">
        <h2>Daftar Buku</h2>
        <p>Total: {{ count($buku) }} buku tersedia</p>
    </div>

    <div class="grid-buku">
        @foreach ($buku as $item)
            <x-buku-card :buku="$item">
                <small>- Kategori: {{ $item['kategori'] }}</small>
            </x-buku-card>
        @endforeach
    </div>
@endsection