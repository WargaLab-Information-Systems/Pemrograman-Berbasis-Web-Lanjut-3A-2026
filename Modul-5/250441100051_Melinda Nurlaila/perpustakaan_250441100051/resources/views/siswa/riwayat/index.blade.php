<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Riwayat Peminjaman
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white rounded-xl shadow-sm border border-pink-100 overflow-hidden">
                <div class="p-6 border-b border-pink-100">
                    <h3 class="text-lg font-semibold text-gray-800">
                        Riwayat Buku Saya
                    </h3>
                    <p class="text-sm text-gray-500 mt-1">
                        Daftar pengajuan dan peminjaman buku yang pernah kamu lakukan.
                    </p>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left">
                        <thead class="bg-pink-50 text-gray-600">
                            <tr>
                                <th class="px-6 py-3">No</th>
                                <th class="px-6 py-3">Judul Buku</th>
                                <th class="px-6 py-3">Kategori</th>
                                <th class="px-6 py-3">Tanggal Pinjam</th>
                                <th class="px-6 py-3">Tanggal Kembali</th>
                                <th class="px-6 py-3">Status</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($peminjamans as $peminjaman)
                                @php
                                    if ($peminjaman->status === 'menunggu') {
                                        $status = 'Menunggu Persetujuan';
                                        $warna = 'bg-yellow-100 text-yellow-700';
                                    } elseif ($peminjaman->status === 'ditolak') {
                                        $status = 'Ditolak';
                                        $warna = 'bg-red-100 text-red-700';
                                    } elseif ($peminjaman->tanggal_kembali !== null) {
                                        $status = 'Dikembalikan';
                                        $warna = 'bg-green-100 text-green-700';
                                    } else {
                                        $status = 'Dipinjam';
                                        $warna = 'bg-blue-100 text-blue-700';
                                    }
                                @endphp

                                <tr class="border-t border-gray-100">
                                    <td class="px-6 py-3">{{ $loop->iteration }}</td>

                                    <td class="px-6 py-3 font-medium text-gray-800">
                                        {{ $peminjaman->buku?->judul ?? '-' }}
                                    </td>

                                    <td class="px-6 py-3">
                                        {{ $peminjaman->buku?->kategori?->nama ?? '-' }}
                                    </td>

                                    <td class="px-6 py-3">
                                        {{ $peminjaman->tanggal_pinjam }}
                                    </td>

                                    <td class="px-6 py-3">
                                        {{ $peminjaman->tanggal_kembali ?? '-' }}
                                    </td>

                                    <td class="px-6 py-3">
                                        <span class="px-3 py-1 rounded-full {{ $warna }} text-xs font-semibold">
                                            {{ $status }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center px-6 py-8 text-gray-500">
                                        Belum ada riwayat peminjaman buku.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="flex justify-end mt-6">
                <a href="{{ route('dashboard.siswa') }}"
                   class="px-5 py-2 rounded-lg bg-pink-600 text-white hover:bg-pink-700 transition">
                    Kembali ke Dashboard
                </a>
            </div>

        </div>
    </div>
</x-app-layout>
