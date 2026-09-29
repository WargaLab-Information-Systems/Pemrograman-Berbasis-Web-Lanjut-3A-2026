@extends('layouts.main')

@section('title', 'Daftar Buku - Perpustakaan Digital')

@section('content')
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; flex-wrap: wrap; gap: 15px;">
        <h2 style="color: #4a2c11; margin: 0;">Daftar Koleksi Buku</h2>
   
        <form action="{{ route('buku.index') }}" method="GET" style="display: flex; gap: 8px;">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari buku..." style="padding: 8px 12px; border-radius: 6px; border: 1px solid #ccc;">
            <button type="submit" class="btn" style="padding: 8px 15px;">Cari</button>
        </form>
    </div>

    @if(!empty($keyword))
        <p style="margin-bottom: 20px; color: #666;">Menampilkan hasil pencarian untuk: <strong>"{{ $keyword }}"</strong></p>
    @endif

    @if(count($buku) > 0)
        <div class="grid-buku">
            @foreach ($buku as $item)
                <x-buku-card :buku="$item">
                    <a href="{{ route('buku.show', $item['id']) }}" class="btn" style="display: block; text-align: center;">Lihat Detail</a>
                </x-buku-card>
            @endforeach
        </div>
    @else
        <div class="card" style="text-align: center; padding: 40px; margin-top: 20px;">
            <h3 style="color: #8b5a2b; margin-bottom: 10px;">Buku Tidak Ditemukan</h3>
            <p style="color: #666;">Maaf, tidak ada buku yang cocok dengan kata kunci pencarianmu.</p>
            <a href="{{ route('buku.index') }}" class="btn" style="display: inline-block; margin-top: 15px;">Lihat Semua Buku</a>
        </div>
    @endif
@endsection