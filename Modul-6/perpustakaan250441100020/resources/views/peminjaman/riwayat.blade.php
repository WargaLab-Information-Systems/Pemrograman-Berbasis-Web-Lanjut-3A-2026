@extends('layouts.buku')

@section('title', 'Riwayat Peminjaman')

@section('content')
    <h1><b>Riwayat Peminjaman Saya</b></h1>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No.</th>
                <th>Judul Buku</th>
                <th>Tanggal Pengajuan</th>
                <th>Tanggal Kembali</th>
                <th>Status</th>
            </tr>
        </thead>

        <tbody>
            @forelse ($peminjamans as $peminjaman)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $peminjaman->buku->judul ?? '-' }}</td>
                    <td>{{ $peminjaman->tanggal_pinjam?->format('d-m-Y') ?? '-' }}</td>
                    <td>{{ $peminjaman->tanggal_kembali?->format('d-m-Y') ?? '-' }}</td>
                    <td>{{ ucfirst($peminjaman->status) }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center">
                        Belum ada riwayat peminjaman.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
@endsection