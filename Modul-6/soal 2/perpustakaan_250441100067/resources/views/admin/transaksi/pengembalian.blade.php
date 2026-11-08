@extends('layouts.app')

@section('title', 'Data Pengembalian')

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

    .tabel-pengembalian {
        width: 100%;
        border-collapse: collapse;
        min-width: 750px;
    }

    .tabel-pengembalian th {
        background: #dcdafa;
        color: #754b32;
        padding: 13px;
        text-align: left;
        font-size: 13px;
    }

    .tabel-pengembalian td {
        padding: 13px;
        font-size: 13px;
        color: #333;
        border-bottom: 1px solid #eee;
    }

    .tabel-pengembalian tr:hover {
        background: #faf9ff;
    }

    .status {
        display: inline-block;
        background: #d9efdc;
        color: #286536;
        padding: 5px 10px;
        border-radius: 12px;
        font-size: 11px;
    }

    .kosong {
        text-align: center;
        padding: 25px !important;
        color: #777 !important;
    }

    .pagination {
        margin-top: 20px;
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

    <h2 class="judul">Data Pengembalian</h2>

    <p class="deskripsi">
        Menampilkan seluruh riwayat transaksi buku yang sudah dikembalikan.
    </p>

    <div class="kartu">

        <h3>Riwayat Pengembalian Buku</h3>

        <div class="tabel-wrapper">

            <table class="tabel-pengembalian">

                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Anggota</th>
                        <th>Judul Buku</th>
                        <th>Tanggal Pinjam</th>
                        <th>Tanggal Kembali</th>
                        <th>Status</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse($pengembalians as $pengembalian)

                        <tr>
                            <td>
                                {{ $pengembalians->firstItem() + $loop->index }}
                            </td>

                            <td>
                                {{ $pengembalian->anggota->nama ?? '-' }}
                            </td>

                            <td>
                                {{ $pengembalian->buku->judul ?? '-' }}
                            </td>

                            <td>
                                {{ \Carbon\Carbon::parse($pengembalian->tanggal_pinjam)->format('d-m-Y') }}
                            </td>

                            <td>
                                {{ \Carbon\Carbon::parse($pengembalian->tanggal_kembali)->format('d-m-Y') }}
                            </td>

                            <td>
                                <span class="status">
                                    Sudah Dikembalikan
                                </span>
                            </td>
                        </tr>

                    @empty

                        <tr>
                            <td colspan="6" class="kosong">
                                Belum ada riwayat pengembalian buku.
                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

        <div class="pagination">
            {{ $pengembalians->links() }}
        </div>

    </div>

</div>

@endsection