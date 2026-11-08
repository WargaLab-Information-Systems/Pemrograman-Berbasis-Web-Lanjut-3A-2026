
@extends('layouts.buku')

@section('title', 'Pengelolaan Peminjaman')

@section('content')
    <h1><b>Pengelolaan Peminjaman</b></h1>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            {{ $errors->first() }}
        </div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No.</th>
                <th>Nama Anggota</th>
                <th>Judul Buku</th>
                <th>Tanggal Pengajuan</th>
                <th>Tanggal Kembali</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>

        <tbody>
            @forelse ($peminjamans as $peminjaman)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $peminjaman->anggota->nama ?? '-' }}</td>
                    <td>{{ $peminjaman->buku->judul ?? '-' }}</td>
                    <td>{{ $peminjaman->tanggal_pinjam?->format('d-m-Y') ?? '-' }}</td>
                    <td>{{ $peminjaman->tanggal_kembali?->format('d-m-Y') ?? '-' }}</td>
                    <td>{{ ucfirst($peminjaman->status) }}</td>
                    <td>
                        @if ($peminjaman->status === 'menunggu')
                            <form action="{{ route('peminjaman.setujui', $peminjaman->id) }}"
                                method="POST" class="d-inline">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-success btn-sm">
                                    Setujui
                                </button>
                            </form>

                            <form action="{{ route('peminjaman.tolak', $peminjaman->id) }}"
                                method="POST" class="d-inline">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-danger btn-sm">
                                    Tolak
                                </button>
                            </form>

                        @elseif ($peminjaman->status === 'disetujui')
                            <form action="{{ route('peminjaman.kembalikan', $peminjaman->id) }}"
                                method="POST" class="d-inline">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-primary btn-sm">
                                    Catat Pengembalian
                                </button>
                            </form>

                        @else
                            -
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center">
                        Belum ada pengajuan peminjaman.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
@endsection
