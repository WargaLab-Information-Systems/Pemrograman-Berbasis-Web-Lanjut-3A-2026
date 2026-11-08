
<x-app-layout>

    <x-slot name="header">
        <h2 class="font-bold text-xl text-pink-900">
            Laporan Perpustakaan
        </h2>
    </x-slot>

    <div class="min-h-screen py-10" style="background-color: #fce7f3;">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="rounded-2xl shadow-lg p-6 md:p-8"
                 style="background-color: #fff1f7; border: 1px solid #f3b5d0;">

                <a href="{{ route($dashboardRoute) }}"
                    class="inline-block px-5 py-2 mb-6 rounded-lg text-white font-semibold"
                    style="background-color: #be185d;">
                    Kembali ke Dashboard
                </a>

                <h3 class="text-xl font-bold text-pink-900 mb-2">
                    Ringkasan Data Perpustakaan
                </h3>

                <p class="text-sm text-gray-600 mb-6">
                    Informasi statistik dan aktivitas perpustakaan.
                </p>

                <!-- Statistik -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-8">

                    <div class="p-5 rounded-xl shadow-sm"
                         style="background-color: #fbcfe8;">
                        <p class="text-sm text-pink-900">Total Buku</p>
                        <h3 class="text-3xl font-bold text-pink-950 mt-2">
                            {{ $totalBuku }}
                        </h3>
                    </div>

                    <div class="p-5 rounded-xl shadow-sm"
                         style="background-color: #f9a8d4;">
                        <p class="text-sm text-pink-900">Total Anggota</p>
                        <h3 class="text-3xl font-bold text-pink-950 mt-2">
                            {{ $totalAnggota }}
                        </h3>
                    </div>

                    <div class="p-5 rounded-xl shadow-sm"
                         style="background-color: #fbcfe8;">
                        <p class="text-sm text-pink-900">Total Peminjaman</p>
                        <h3 class="text-3xl font-bold text-pink-950 mt-2">
                            {{ $totalPeminjaman }}
                        </h3>
                    </div>

                    <div class="p-5 rounded-xl shadow-sm"
                         style="background-color: #f9a8d4;">
                        <p class="text-sm text-pink-900">Buku Dikembalikan</p>
                        <h3 class="text-3xl font-bold text-pink-950 mt-2">
                            {{ $dikembalikan }}
                        </h3>
                    </div>

                </div>

                <!-- Status Peminjaman -->
                <h3 class="text-lg font-bold text-pink-900 mb-4">
                    Rekap Status Peminjaman
                </h3>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-8">

                    <div class="bg-yellow-100 p-5 rounded-xl">
                        <p class="text-yellow-800 font-semibold">
                            Menunggu
                        </p>
                        <p class="text-2xl font-bold text-yellow-900">
                            {{ $menunggu }}
                        </p>
                    </div>

                    <div class="bg-green-100 p-5 rounded-xl">
                        <p class="text-green-800 font-semibold">
                            Disetujui
                        </p>
                        <p class="text-2xl font-bold text-green-900">
                            {{ $disetujui }}
                        </p>
                    </div>

                    <div class="bg-red-100 p-5 rounded-xl">
                        <p class="text-red-800 font-semibold">
                            Ditolak
                        </p>
                        <p class="text-2xl font-bold text-red-900">
                            {{ $ditolak }}
                        </p>
                    </div>

                </div>

                <!-- Tabel Riwayat -->
                <h3 class="text-lg font-bold text-pink-900 mb-4">
                    Data Aktivitas Peminjaman
                </h3>

                <div class="overflow-x-auto rounded-xl border border-pink-200">

                    <table class="w-full text-sm text-left">

                        <thead style="background-color: #f9a8d4;">
                            <tr>
                                <th class="p-3">No.</th>
                                <th class="p-3">Nama Anggota</th>
                                <th class="p-3">Judul Buku</th>
                                <th class="p-3">Tanggal Pinjam</th>
                                <th class="p-3">Tanggal Kembali</th>
                                <th class="p-3">Status</th>
                            </tr>
                        </thead>

                        <tbody>

                            @forelse($peminjamans as $item)
                                <tr class="border-b border-pink-200 hover:bg-pink-50">

                                    <td class="p-3">
                                        {{ $loop->iteration }}
                                    </td>

                                    <td class="p-3">
                                        {{ $item->anggota->nama ?? '-' }}
                                    </td>

                                    <td class="p-3">
                                        {{ $item->buku->judul ?? '-' }}
                                    </td>

                                    <td class="p-3">
                                        {{ $item->tanggal_pinjam ?? '-' }}
                                    </td>

                                    <td class="p-3">
                                        {{ $item->tanggal_kembali ?? '-' }}
                                    </td>

                                    <td class="p-3">

                                        @if($item->status === 'menunggu')
                                            <span class="px-3 py-1 rounded-full bg-yellow-100 text-yellow-800">
                                                Menunggu
                                            </span>

                                        @elseif($item->status === 'disetujui')
                                            <span class="px-3 py-1 rounded-full bg-green-100 text-green-800">
                                                Disetujui
                                            </span>

                                        @elseif($item->status === 'ditolak')
                                            <span class="px-3 py-1 rounded-full bg-red-100 text-red-800">
                                                Ditolak
                                            </span>

                                        @elseif($item->status === 'dikembalikan')
                                            <span class="px-3 py-1 rounded-full bg-blue-100 text-blue-800">
                                                Dikembalikan
                                            </span>

                                        @else
                                            {{ ucfirst($item->status ?? '-') }}
                                        @endif

                                    </td>

                                </tr>

                            @empty

                                <tr>
                                    <td colspan="6"
                                        class="p-6 text-center text-gray-500">
                                        Belum ada data peminjaman.
                                    </td>
                                </tr>

                            @endforelse

                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>

</x-app-layout>
