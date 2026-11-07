@extends('layouts.app')

@section('title', 'Daftar Buku - Perpustakaan Digital')

@section('content')
    <h2>Daftar Koleksi Buku</h2>

    <div class="buku-grid">
        @foreach($bukuList as $buku)
            <x-kartu-buku 
                :id="$buku['id']"
                :judul="$buku['judul']"
                :penulis="$buku['penulis']"
                :tahunTerbit="$buku['tahun_terbit']"
            >
                <x-slot:badge>
                    <span class="badge">{{ $buku['kategori'] }}</span>
                </x-slot:badge>
            </x-kartu-buku>
        @endforeach
    </div>
@endsection