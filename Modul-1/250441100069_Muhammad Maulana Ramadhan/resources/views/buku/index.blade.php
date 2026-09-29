@extends('layouts.app')

@section('title', 'Daftar Buku')

@section('content')

    <h2>📚 Daftar Buku</h2>

    <div class="buku-container">

        @foreach ($buku as $item)

            <x-buku-card :buku="$item">

                <a href="{{ route('buku.show', $item['id']) }}">
                    Lihat Detail
                </a>

            </x-buku-card>

        @endforeach

    </div>

@endsection