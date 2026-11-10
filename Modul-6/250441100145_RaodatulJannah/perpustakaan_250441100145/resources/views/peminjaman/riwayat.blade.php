@extends('layouts.app')

@section('content')
<style>
    .history-container {
        padding: 30px;
    }

    .history-title {
        color: #d63384;
        font-weight: bold;
        margin-bottom: 25px;
    }

    .history-table {
        width: 100%;
        border-collapse: collapse;
        background: white;
        border-radius: 10px;
        overflow: hidden;
    }

    .history-table th {
        background: #f8d7e8;
        color: #84204f;
        padding: 12px;
        text-align: left;
    }

    .history-table td {
        padding: 12px;
        border-bottom: 1px solid #f1d5e3;
    }

    .history-table tr:hover {
        background: #fff5fa;
    }

    .history-status {
        display: inline-block;
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 13px;
        font-weight: bold;
    }

    .status-menunggu {
        background: #fff3cd;
        color: #856404;
    }

    .status-disetujui {
        background: #d4edda;
        color: #155724;
    }

    .status-ditolak {
        background: #f8d7da;
        color: #721c24;
    }

    .status-dikembalikan {
        background: #dbeafe;
        color: #1d4ed8;
    }

    .empty-message {
        text-align: center;
        padding: 25px;
        color: #888;
    }
</style>

<div class="history-container">
    <h2 class="history-title">Riwayat Peminjaman Buku</h2>

    <table class="history-table">
        <thead>
            <tr>
                <th>No</th>
                <th>Judul Buku</th>
                <th>Tanggal Pinjam</th>
                <th>Tanggal Kembali</th>
                <th>Status</th>
            </tr>
        </thead>

        <tbody>
            @forelse ($riwayat as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>

                    <td>
                        {{ $item->buku->judul ?? '-' }}
                    </td>

                    <td>
                        {{ $item->tanggal_pinjam ?? '-' }}
                    </td>

                    <td>
                        @if ($item->status === 'ditolak')
                            Tidak jadi dipinjam

                        @elseif ($item->status === 'menunggu')
                            Belum disetujui

                        @elseif ($item->status === 'dikembalikan')
                            {{ $item->tanggal_kembali ?? '-' }}

                        @elseif ($item->status === 'disetujui')
                            Belum dikembalikan

                        @else
                            -
                        @endif
                    </td>

                    <td>
                        @if ($item->status === 'menunggu')
                            <span class="history-status status-menunggu">
                                Menunggu
                            </span>

                        @elseif ($item->status === 'disetujui')
                            <span class="history-status status-disetujui">
                                Disetujui
                            </span>

                        @elseif ($item->status === 'ditolak')
                            <span class="history-status status-ditolak">
                                Ditolak
                            </span>

                        @elseif ($item->status === 'dikembalikan')
                            <span class="history-status status-dikembalikan">
                                Dikembalikan
                            </span>

                        @else
                            -
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="empty-message">
                        Belum ada riwayat peminjaman buku.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection