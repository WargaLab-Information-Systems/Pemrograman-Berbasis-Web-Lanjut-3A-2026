<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Status Peminjaman
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="mb-6">
                <h3 class="text-xl font-bold text-gray-800">
                    Status Peminjaman Saya
                </h3>
                <p class="text-sm text-gray-600 mt-2">
                    Pantau status pengajuan dan peminjaman buku kamu.
                </p>
            </div>

            @if (session('success'))
                <div class="mb-5 rounded-lg bg-green-100 p-4 text-green-700">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white rounded-xl shadow-sm border border-pink-100 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left">
                        <thead class="bg-pink-50 text-gray-600">
                            <tr>
                                <th class="px-6 py-3">No</th>
                                <th class="px-6 py-3">Judul Buku</th>
                                <th class="px-6 py-3">Tanggal Pengajuan</th>
                                <th class="px-6 py-3">Status</th>
                                <th class="px-6 py-3">Tanggal Kembali</th>
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
                                        $status = 'Sudah Dikembalikan';
                                        $warna = 'bg-green-100 text-green-700';
                                    } else {
                                        $status = 'Disetujui';
                                        $warna = 'bg-blue-100 text-blue-700';
                                    }
                                @endphp

                                <tr class="border-t border-gray-100">
                                    <td class="px-6 py-3">
                                        {{ $loop->iteration }}
                                    </td>

                                    <td class="px-6 py-3 font-medium text-gray-800">
                                        {{ $peminjaman->buku?->judul ?? '-' }}
                                    </td>

                                    <td class="px-6 py-3">
                                        {{ $peminjaman->tanggal_pinjam }}
                                    </td>

                                    <td class="px-6 py-3">
                                        <span class="px-3 py-1 rounded-full {{ $warna }} text-xs font-semibold">
                                            {{ $status }}
                                        </span>
                                    </td>

                                    <td class="px-6 py-3">
                                        {{ $peminjaman->tanggal_kembali ?? '-' }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center px-6 py-8 text-gray-500">
                                        Kamu belum memiliki pengajuan peminjaman buku.
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
