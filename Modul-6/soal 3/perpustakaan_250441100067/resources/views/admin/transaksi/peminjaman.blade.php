@extends('layouts.app')

@section('title', 'Data Peminjaman')

@section('content')

<style>
    html, body {
        margin: 0;
        font-family: Arial, sans-serif;
    }

    .halaman {
        background-color: #dcdafa !important;
        min-height: 100vh;
        padding: 25px 20px;
        box-sizing: border-box;
    }

    .judul {
        color: #754b32;
        margin: 0 0 8px;
        font-size: 24px;
        font-weight: bold;
    }

    .deskripsi {
        color: #555;
        font-size: 13px;
        margin-bottom: 20px;
    }

    .kartu {
        background: #ffffff;
        padding: 22px;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.08);
    }

    .kartu h3 {
        color: #754b32;
        margin-top: 0;
        margin-bottom: 18px;
        font-size: 18px;
    }

    .tabel-wrapper {
        overflow-x: auto;
    }

    .tabel-peminjaman {
        width: 100%;
        border-collapse: collapse;
        min-width: 800px;
    }

    .tabel-peminjaman th {
        background: #dcdafa;
        color: #754b32;
        padding: 13px;
        text-align: left;
        font-size: 13px;
    }

    .tabel-peminjaman td {
        padding: 13px;
        font-size: 13px;
        color: #333;
        border-bottom: 1px solid #eee;
    }

    .tabel-peminjaman tr:hover {
        background: #faf9ff;
    }

    .status {
        display: inline-block;
        background: #efdbc3;
        color: #76553b;
        padding: 5px 10px;
        border-radius: 12px;
        font-size: 11px;
    }

    .btn-kembali {
        background: #91613f;
        color: white;
        padding: 8px 12px;
        border: none;
        border-radius: 6px;
        font-size: 12px;
        cursor: pointer;
    }

    .btn-kembali:hover {
        background: #70472e;
    }

    .kosong {
        text-align: center;
        padding: 25px !important;
        color: #777 !important;
    }

    .pagination {
        margin-top: 20px;
    }

    .pesan {
        padding: 12px;
        border-radius: 8px;
        margin-bottom: 15px;
        font-size: 13px;
    }

    .sukses {
        background: #e1f4e5;
        color: #226534;
    }

    .error {
        background: #fde5e5;
        color: #9a2525;
    }

    @media (max-width: 600px) {
        .halaman {
            padding: 18px 12px;
        }

        .kartu {
            padding: 15px;
        }
    }
</style>

<div class="halaman">

    <h2 class="judul">Data Peminjaman</h2>

    <p class="deskripsi">
        Menampilkan transaksi buku yang sudah disetujui dan belum dikembalikan.
    </p>

    @if(session('success'))
        <div class="pesan sukses">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="pesan error">
            {{ session('error') }}
        </div>
    @endif

    <div class="kartu">

        <h3>Daftar Peminjaman Buku</h3>

        <div class="tabel-wrapper">

            <table class="tabel-peminjaman">

                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Anggota</th>
                        <th>Judul Buku</th>
                        <th>Tanggal Pinjam</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse($peminjamans as $peminjaman)

                        <tr>
                            <td>
                                {{ $peminjamans->firstItem() + $loop->index }}
                            </td>

                            <td>
                                {{ $peminjaman->anggota->nama ?? '-' }}
                            </td>

                            <td>
                                {{ $peminjaman->buku->judul ?? '-' }}
                            </td>

                            <td>
                                {{ \Carbon\Carbon::parse($peminjaman->tanggal_pinjam)->format('d-m-Y') }}
                            </td>

                            <td>
                                <span class="status">
                                    Disetujui
                                </span>
                            </td>

                            <td>
                                <form action="{{ route('admin.pengembalian.catat', $peminjaman->id) }}"
                                      method="POST"
                                      onsubmit="return confirm('Apakah buku ini benar-benar sudah dikembalikan?')">

                                    @csrf

                                    <button type="submit" class="btn-kembali">
                                        Catat Pengembalian
                                    </button>

                                </form>
                            </td>
                        </tr>

                    @empty

                        <tr>
                            <td colspan="6" class="kosong">
                                Belum ada transaksi peminjaman aktif.
                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

        <div class="pagination">
            {{ $peminjamans->links() }}
        </div>

    </div>

</div>

@endsection