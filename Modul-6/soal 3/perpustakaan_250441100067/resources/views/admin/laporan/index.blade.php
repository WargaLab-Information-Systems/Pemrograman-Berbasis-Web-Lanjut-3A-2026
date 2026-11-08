@extends('layouts.app')

@section('title', 'Laporan Perpustakaan')

@section('content')

<style>
    .halaman-laporan {
        background-color: #dcdafa !important;
        font-family: Arial, sans-serif;
        min-height: 100vh;
        padding: 25px 20px;
        box-sizing: border-box;
    }

    .judul {
        color: #754b32;
        margin-bottom: 8px;
        font-size: 24px;
        font-weight: bold;
    }

    .deskripsi {
        color: #555;
        margin-bottom: 22px;
    }

    .daftar-statistik {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 18px;
    }

    .kartu {
        background: #ffffff;
        padding: 22px;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        box-sizing: border-box;
    }

    .kartu h3 {
        color: #754b32;
        font-size: 14px;
        font-weight: bold;
        margin: 0 0 12px;
    }

    .angka {
        color: #6b67a8;
        font-size: 30px;
        font-weight: bold;
        margin: 0;
    }

    .bagian {
        margin-top: 25px;
    }

    .bagian p {
        color: #555;
        margin: 12px 0;
    }

    .status-belum {
        color: #b84d4d;
    }

    .status-sudah {
        color: #31834b;
    }

    @media (max-width: 700px) {
        .daftar-statistik {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
    }

    @media (max-width: 450px) {
        .daftar-statistik {
            grid-template-columns: 1fr;
        }

        .halaman-laporan {
            padding: 20px 13px;
        }
    }
</style>

<div class="halaman-laporan">

    <h2 class="judul">Laporan Perpustakaan</h2>

    <p class="deskripsi">
        Ringkasan informasi dan aktivitas sistem perpustakaan.
    </p>

    <div class="daftar-statistik">

        <div class="kartu">
            <h3>Total Buku</h3>
            <p class="angka">{{ $totalBuku }}</p>
        </div>

        <div class="kartu">
            <h3>Total Kategori</h3>
            <p class="angka">{{ $totalKategori }}</p>
        </div>

        <div class="kartu">
            <h3>Total Anggota</h3>
            <p class="angka">{{ $totalAnggota }}</p>
        </div>

        <div class="kartu">
            <h3>Total Pengguna</h3>
            <p class="angka">{{ $totalPengguna }}</p>
        </div>

        <div class="kartu">
            <h3>Total Peminjaman</h3>
            <p class="angka">{{ $totalPeminjaman }}</p>
        </div>

        <div class="kartu">
            <h3>Buku Belum Dikembalikan</h3>
            <p class="angka status-belum">
                {{ $belumKembali }}
            </p>
        </div>

        <div class="kartu">
            <h3>Buku Sudah Dikembalikan</h3>
            <p class="angka status-sudah">
                {{ $sudahKembali }}
            </p>
        </div>

    </div>

    <div class="kartu bagian">

        <h3>Ringkasan Transaksi</h3>

        <p>
            Total transaksi peminjaman:
            <strong>{{ $totalPeminjaman }}</strong>
        </p>

        <p>
            Belum dikembalikan:
            <strong class="status-belum">{{ $belumKembali }}</strong>
        </p>

        <p>
            Sudah dikembalikan:
            <strong class="status-sudah">{{ $sudahKembali }}</strong>
        </p>

    </div>

</div>

@endsection