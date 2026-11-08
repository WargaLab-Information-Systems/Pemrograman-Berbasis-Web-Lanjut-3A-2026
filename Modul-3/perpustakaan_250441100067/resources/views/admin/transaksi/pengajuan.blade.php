@extends('layouts.app')

@section('title', 'Pengajuan Peminjaman')

@section('content')

<style>
    html, body {
        margin: 0;
        font-family: Arial, sans-serif;
    }

    .halaman-pengajuan {
        background-color: #dcdafa !important;
        min-height: 100vh;
        padding: 25px 20px;
        box-sizing: border-box;
    }

    .judul-halaman {
        color: #754b32;
        font-size: 24px;
        font-weight: bold;
        margin: 0 0 8px;
    }

    .deskripsi {
        color: #555;
        font-size: 13px;
        margin-bottom: 20px;
    }

    .kartu-pengajuan {
        background: #ffffff;
        padding: 22px;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.08);
    }

    .bagian-atas {
        margin-bottom: 18px;
    }

    .bagian-atas h3 {
        color: #754b32;
        margin: 0;
        font-size: 18px;
    }

    .pesan {
        padding: 12px;
        border-radius: 7px;
        margin-bottom: 15px;
        font-size: 13px;
    }

    .sukses {
        background: #e1f4e5;
        color: #226534;
    }

    .gagal {
        background: #fde5e5;
        color: #9a2525;
    }

    .tabel-wrapper {
        overflow-x: auto;
    }

    .tabel-pengajuan {
        width: 100%;
        min-width: 850px;
        border-collapse: collapse;
    }

    .tabel-pengajuan th {
        background: #dcdafa;
        color: #754b32;
        padding: 13px;
        font-size: 13px;
        text-align: center;
    }

    .tabel-pengajuan td {
        padding: 13px;
        font-size: 13px;
        color: #333;
        border-bottom: 1px solid #eee;
        text-align: center;
    }

    .tabel-pengajuan tr:hover {
        background: #faf9ff;
    }

    .badge-status {
        display: inline-block;
        background: #efdbc3;
        color: #76553b;
        padding: 5px 10px;
        border-radius: 12px;
        font-size: 11px;
    }

    .tombol {
        display: inline-block;
        border: none;
        border-radius: 6px;
        padding: 8px 11px;
        font-size: 12px;
        cursor: pointer;
        color: white;
    }

    .tombol-setujui {
        background: #91613f;
    }

    .tombol-setujui:hover {
        background: #70472e;
    }

    .tombol-tolak {
        background: #b84d4d;
    }

    .tombol-tolak:hover {
        background: #963838;
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
        .halaman-pengajuan {
            padding: 18px 12px;
        }

        .kartu-pengajuan {
            padding: 15px;
        }
    }
</style>

<div class="halaman-pengajuan">

    <h2 class="judul-halaman">Pengajuan Peminjaman</h2>

    <p class="deskripsi">
        Kelola dan periksa pengajuan peminjaman buku dari anggota perpustakaan.
    </p>

    @if(session('success'))
        <div class="pesan sukses">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="pesan gagal">
            {{ session('error') }}
        </div>
    @endif

    <div class="kartu-pengajuan">

        <div class="bagian-atas">
            <h3>Daftar Pengajuan Peminjaman</h3>
        </div>

        <div class="tabel-wrapper">

            <table class="tabel-pengajuan">

                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Anggota</th>
                        <th>Email</th>
                        <th>Judul Buku</th>
                        <th>Tanggal Pengajuan</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse($pengajuans as $pengajuan)

                        <tr>
                            <td>
                                {{ $loop->iteration + ($pengajuans->currentPage() - 1) * $pengajuans->perPage() }}
                            </td>

                            <td>
                                {{ $pengajuan->anggota->nama ?? '-' }}
                            </td>

                            <td>
                                {{ $pengajuan->anggota->email ?? '-' }}
                            </td>

                            <td>
                                {{ $pengajuan->buku->judul ?? '-' }}
                            </td>

                            <td>
                                {{ $pengajuan->tanggal_pinjam }}
                            </td>

                            <td>
                                <span class="badge-status">
                                    {{ ucfirst($pengajuan->status) }}
                                </span>
                            </td>

                            <td>
                                <form action="{{ route('admin.pengajuan.setujui', $pengajuan->id) }}"
                                      method="POST"
                                      style="display:inline;">
                                    @csrf

                                    <button type="submit" class="tombol tombol-setujui">
                                        Setujui
                                    </button>
                                </form>

                                <form action="{{ route('admin.pengajuan.tolak', $pengajuan->id) }}"
                                      method="POST"
                                      style="display:inline;"
                                      onsubmit="return confirm('Yakin ingin menolak pengajuan ini?')">
                                    @csrf

                                    <button type="submit" class="tombol tombol-tolak">
                                        Tolak
                                    </button>
                                </form>
                            </td>
                        </tr>

                    @empty

                        <tr>
                            <td colspan="7" class="kosong">
                                Belum ada pengajuan peminjaman.
                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

        <div class="pagination">
            {{ $pengajuans->links() }}
        </div>

    </div>

</div>

@endsection