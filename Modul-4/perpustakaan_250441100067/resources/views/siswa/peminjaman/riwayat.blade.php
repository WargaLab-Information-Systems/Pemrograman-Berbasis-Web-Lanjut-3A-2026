<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight" style="color: #754b32;">
            Status dan Riwayat Peminjaman
        </h2>
    </x-slot>

    <style>
        .halaman-riwayat {
            background: #dcdafa !important;
            min-height: 100vh;
            padding: 30px 20px;
            box-sizing: border-box;
        }

        .judul-halaman {
            color: #754b32;
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 8px;
        }

        .deskripsi {
            color: #555;
            margin-bottom: 25px;
        }

        .kartu-riwayat {
            background: white;
            padding: 22px;
            border-radius: 12px;
            margin-bottom: 18px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
        }

        .status {
            display: inline-block;
            padding: 6px 13px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: bold;
        }

        .menunggu {
            background: #fff3cd;
            color: #856404;
        }

        .disetujui {
            background: #d1fae5;
            color: #065f46;
        }

        .ditolak {
            background: #fee2e2;
            color: #991b1b;
        }

        .dikembalikan {
            background: #dbeafe;
            color: #1e40af;
        }

        .belum-ada {
            background: white;
            padding: 35px;
            text-align: center;
            border-radius: 12px;
            color: #777;
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
        }

        .btn-kembali {
            display: inline-block;
            background: #6b67a8;
            color: white;
            padding: 10px 18px;
            border-radius: 7px;
            text-decoration: none;
            margin-top: 20px;
        }

        .btn-kembali:hover {
            background: #514d8d;
        }

        @media (max-width: 450px) {
            .halaman-riwayat {
                padding: 20px 13px;
            }
        }
    </style>

    <div class="halaman-riwayat">
        <div class="max-w-7xl mx-auto">

            <h1 class="judul-halaman">
                Riwayat Peminjaman Saya
            </h1>

            <p class="deskripsi">
                Lihat status pengajuan dan riwayat peminjaman buku kamu.
            </p>

            @forelse ($peminjamans as $peminjaman)

                <div class="kartu-riwayat">

                    <h3 style="font-size:18px; font-weight:bold; color:#754b32; margin-bottom:12px;">
                        {{ $peminjaman->buku->judul ?? 'Buku tidak ditemukan' }}
                    </h3>

                    <p style="color:#555; margin-bottom:6px;">
                        Penulis:
                        {{ $peminjaman->buku->penulis ?? '-' }}
                    </p>

                    <p style="color:#555; margin-bottom:6px;">
                        Tanggal Pengajuan:
                        {{ \Carbon\Carbon::parse($peminjaman->tanggal_pinjam)->format('d-m-Y') }}
                    </p>

                    <p style="color:#555; margin-bottom:12px;">
                        Tanggal Pengembalian:
                        {{ $peminjaman->tanggal_kembali
                            ? \Carbon\Carbon::parse($peminjaman->tanggal_kembali)->format('d-m-Y')
                            : '-' }}
                    </p>

                    <p style="margin-bottom:10px;">
                        Status:

                        @php
                            $status = $peminjaman->status;
                        @endphp

                        <span class="status {{ $status }}">
                            {{ ucfirst($status) }}
                        </span>
                    </p>

                    @if ($status === 'menunggu')
                        <p style="color:#856404; font-size:13px;">
                            Pengajuan kamu sedang menunggu persetujuan petugas.
                        </p>

                    @elseif ($status === 'disetujui')
                        <p style="color:#065f46; font-size:13px;">
                            Pengajuan kamu telah disetujui oleh petugas.
                        </p>

                    @elseif ($status === 'ditolak')
                        <p style="color:#991b1b; font-size:13px;">
                            Maaf, pengajuan peminjaman kamu ditolak.
                        </p>

                    @elseif ($status === 'dikembalikan')
                        <p style="color:#1e40af; font-size:13px;">
                            Buku telah berhasil dikembalikan.
                        </p>
                    @endif

                </div>

            @empty

                <div class="belum-ada">

                    <h3 style="font-weight:bold; margin-bottom:8px; color:#754b32;">
                        Belum Ada Riwayat Peminjaman
                    </h3>

                    <p>
                        Kamu belum pernah mengajukan peminjaman buku.
                    </p>

                    <a href="{{ route('siswa.peminjaman.index') }}"
                       class="btn-kembali">
                        Ajukan Peminjaman
                    </a>

                </div>

            @endforelse

            <div style="margin-top:20px;">
                {{ $peminjamans->links() }}
            </div>

            <a href="{{ route('dashboard') }}" class="btn-kembali">
                Kembali ke Dashboard
            </a>

        </div>
    </div>

</x-app-layout>