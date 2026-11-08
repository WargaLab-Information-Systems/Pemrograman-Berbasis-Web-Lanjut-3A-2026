@extends('layouts.app')

@section('title', 'Ajukan Peminjaman Buku')

@section('content')

<style>
    .halaman-peminjaman {
        background: #dcdafa !important;
        min-height: 100vh;
        padding: 25px 20px;
        font-family: Arial, sans-serif;
        box-sizing: border-box;
    }

    .judul-halaman {
        color: #754b32;
        font-size: 24px;
        font-weight: bold;
        margin-bottom: 20px;
    }

    .daftar-buku {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
        gap: 20px;
    }

    .kartu-buku {
        background: #fff;
        padding: 20px;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.08);
    }

    .kartu-buku h3 {
        color: #754b32;
        font-size: 18px;
        font-weight: bold;
        margin-bottom: 12px;
    }

    .kartu-buku p {
        color: #555;
        margin-bottom: 8px;
        font-size: 14px;
    }

    .tombol {
        display: inline-block;
        background: #91613f;
        color: white;
        padding: 9px 15px;
        border: none;
        border-radius: 7px;
        cursor: pointer;
        text-decoration: none;
        font-size: 13px;
    }

    .tombol:hover {
        background: #754b32;
    }

    .tombol-detail {
        background: #6b67a8;
    }

    .tombol-detail:hover {
        background: #514d8d;
    }

    .pesan {
        padding: 12px;
        border-radius: 8px;
        margin-bottom: 15px;
        background: #e4f5e7;
        color: #236b35;
    }

    .pesan-error {
        background: #ffe5e5;
        color: #a52a2a;
    }

    .bagian-riwayat {
        margin-top: 25px;
    }

    @media (max-width: 450px) {
        .halaman-peminjaman {
            padding: 20px 13px;
        }
    }
</style>

<div class="halaman-peminjaman">

    <h2 class="judul-halaman">Ajukan Peminjaman Buku</h2>

    @if (session('success'))
        <div class="pesan">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="pesan pesan-error">
            {{ session('error') }}
        </div>
    @endif

    <div class="daftar-buku">

        @forelse ($bukus as $buku)

            <div class="kartu-buku">

                <h3>{{ $buku->judul }}</h3>

                <p><strong>Penulis:</strong> {{ $buku->penulis }}</p>

                <p><strong>Tahun:</strong> {{ $buku->tahun_terbit }}</p>

                <p>
                    <strong>Kategori:</strong>
                    {{ $buku->kategori->nama_kategori ?? '-' }}
                </p>

                <a href="{{ route('buku.show', $buku->id) }}"
                   class="tombol tombol-detail">
                    Detail Buku
                </a>

                <form action="{{ route('siswa.peminjaman.store', $buku->id) }}"
                      method="POST"
                      onsubmit="return confirm('Yakin ingin mengajukan peminjaman buku ini?')"
                      style="margin-top: 12px;">

                    @csrf

                    <button type="submit" class="tombol">
                        Ajukan Peminjaman
                    </button>

                </form>

            </div>

        @empty

            <p>Belum ada buku yang tersedia.</p>

        @endforelse

    </div>

    <div style="margin-top: 20px;">
        {{ $bukus->links() }}
    </div>

    <div class="bagian-riwayat">
        <a href="{{ route('siswa.peminjaman.riwayat') }}" class="tombol">
            Lihat Riwayat Peminjaman
        </a>
    </div>

</div>

@endsection