<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-semibold text-gray-800">
                Data Peminjaman
            </h2>

            <a href="{{ route('petugas.peminjaman.create') }}"
                class="rounded-lg bg-pink-600 px-4 py-2 text-sm font-semibold text-white hover:bg-pink-700">
                + Tambah Peminjaman
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

            @if (session('success'))
                <div class="mb-5 rounded-lg bg-green-100 p-4 text-sm text-green-700">
                    {{ session('success') }}
                </div>
            @endif

            <div class="overflow-hidden rounded-xl bg-white shadow-sm">
                <div class="overflow-x-auto p-6">
                    <table class="w-full text-left text-sm">
                        <thead class="border-b bg-pink-50 text-gray-700">
                            <tr>
                                <th class="px-4 py-3">No</th>
                                <th class="px-4 py-3">Nama Anggota</th>
                                <th class="px-4 py-3">Judul Buku</th>
                                <th class="px-4 py-3">Tanggal Pinjam</th>
                                <th class="px-4 py-3">Tanggal Kembali</th>
                                <th class="px-4 py-3">Status</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y">
                            @forelse ($peminjamans as $peminjaman)
                                <tr>
                                    <td class="px-4 py-3">
                                        {{ $loop->iteration }}
                                    </td>
                                    <td class="px-4 py-3">
                                        {{ $peminjaman->anggota->nama ?? '-' }}
                                    </td>
                                    <td class="px-4 py-3">
                                        {{ $peminjaman->buku->judul ?? '-' }}
                                    </td>
                                    <td class="px-4 py-3">
                                        {{ $peminjaman->tanggal_pinjam }}
                                    </td>
                                    <td class="px-4 py-3">
                                        {{ $peminjaman->tanggal_kembali ?? '-' }}
                                    </td>
                                    <td class="px-4 py-3">
                                        @php
                                            if ($peminjaman->status === 'menunggu') {
                                                $status = 'Menunggu Persetujuan';
                                                $warna = 'bg-gray-100 text-gray-700';
                                            } elseif ($peminjaman->status === 'ditolak') {
                                                $status = 'Ditolak';
                                                $warna = 'bg-red-100 text-red-700';
                                            } elseif ($peminjaman->tanggal_kembali !== null) {
                                                $status = 'Dikembalikan';
                                                $warna = 'bg-green-100 text-green-700';
                                            } else {
                                                $status = 'Dipinjam';
                                                $warna = 'bg-yellow-100 text-yellow-700';
                                            }
                                        @endphp

                                        <span class="rounded-full {{ $warna }} px-3 py-1 text-xs font-semibold">
                                            {{ $status }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-4 py-8 text-center text-gray-500">
                                        Belum ada data peminjaman.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="mt-5">
                <a href="{{ route('dashboard.petugas') }}"
                    class="text-sm font-medium text-pink-600 hover:text-pink-800">
                    ← Kembali ke Dashboard
                </a>
            </div>

        </div>
    </div>
</x-app-layout>