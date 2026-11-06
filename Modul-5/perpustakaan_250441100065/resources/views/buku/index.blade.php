@extends('layouts.perpus')

@section('content')

<h2 class="page-title">Daftar Buku IT</h2>

<form method="GET" action="{{ route('buku.index') }}" class="filter-bar">
    <input type="text" name="q" value="{{ request('q') }}" class="mgmt-control" placeholder="Cari judul atau penulis...">

    <select name="kategori" class="mgmt-control">
        <option value="">Semua Kategori</option>
        @foreach ($kategoris as $k)
            <option value="{{ $k->id }}" @selected(request('kategori') == $k->id)>{{ $k->nama }}</option>
        @endforeach
    </select>

    <button type="submit" class="btn btn-sm">Cari</button>
</form>

<div class="book-grid">
    @forelse ($buku as $b)
        <x-card-buku
            :judul="$b->judul"
            :penulis="$b->penulis"
            :tahun="$b->tahun_terbit"
            :kategori="$b->kategori->nama ?? '-'">

            <x-slot:button>
                <a href="{{ route('buku.show', $b->id) }}" class="btn btn-sm">Detail</a>

                @can('mengajukan peminjaman buku')
                    <form method="POST" action="{{ route('peminjaman.ajukan', $b->id) }}">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-green">Ajukan Pinjam</button>
                    </form>
                @endcan
            </x-slot:button>
        </x-card-buku>
    @empty
        <p style="grid-column: 1 / -1; text-align:center; color:#64748b;">Belum ada buku yang cocok.</p>
    @endforelse
</div>

{{ $buku->links('pagination::bootstrap-4') }}

@endsection
