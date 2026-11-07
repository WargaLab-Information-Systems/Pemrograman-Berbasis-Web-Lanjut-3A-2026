<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Laporan Perpustakaan
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">

                <div class="bg-white rounded-xl shadow-sm p-6 border border-pink-100">
                    <p class="text-sm text-gray-500">Total Buku</p>
                    <h3 class="text-3xl font-bold text-pink-600 mt-2">{{ $totalBuku }}</h3>
                </div>

                <div class="bg-white rounded-xl shadow-sm p-6 border border-pink-100">
                    <p class="text-sm text-gray-500">Total Pengguna</p>
                    <h3 class="text-3xl font-bold text-pink-600 mt-2">{{ $totalPengguna }}</h3>
                </div>

                <div class="bg-white rounded-xl shadow-sm p-6 border border-pink-100">
                    <p class="text-sm text-gray-500">Total Peminjaman</p>
                    <h3 class="text-3xl font-bold text-pink-600 mt-2">{{ $totalPeminjaman }}</h3>
                </div>

                <div class="bg-white rounded-xl shadow-sm p-6 border border-pink-100">
                    <p class="text-sm text-gray-500">Sudah Dikembalikan</p>
                    <h3 class="text-3xl font-bold text-green-600 mt-2">{{ $totalPengembalian }}</h3>
                </div>

                <div class="bg-white rounded-xl shadow-sm p-6 border border-pink-100">
                    <p class="text-sm text-gray-500">Masih Dipinjam</p>
                    <h3 class="text-3xl font-bold text-orange-500 mt-2">{{ $totalDipinjam }}</h3>
                </div>

            </div>

            <div class="bg-white rounded-xl shadow-sm border border-pink-100 overflow-hidden">
                <div class="p-6 border-b border-pink-100">
                    <h3 class="text-lg font-semibold text-gray-800">Rekap Buku Berdasarkan Kategori</h3>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left">
                        <thead class="bg-pink-50 text-gray-600">
                            <tr>
                                <th class="px-6 py-3">No</th>
                                <th class="px-6 py-3">Kategori</th>
                                <th class="px-6 py-3">Jumlah Buku</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($bukuPerKategori as $kategori)
                                <tr class="border-t border-gray-100">
                                    <td class="px-6 py-3">{{ $loop->iteration }}</td>
                                    <td class="px-6 py-3">{{ $kategori->nama }}</td>
                                    <td class="px-6 py-3">{{ $kategori->bukus_count }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center px-6 py-5 text-gray-500">
                                        Belum ada data kategori.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-pink-100 overflow-hidden">
                <div class="p-6 border-b border-pink-100">
                    <h3 class="text-lg font-semibold text-gray-800">Rekap Peminjaman Per Buku</h3>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left">
                        <thead class="bg-pink-50 text-gray-600">
                            <tr>
                                <th class="px-6 py-3">No</th>
                                <th class="px-6 py-3">Judul Buku</th>
                                <th class="px-6 py-3">Kategori</th>
                                <th class="px-6 py-3">Jumlah Peminjaman</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($peminjamanPerBuku as $buku)
                                <tr class="border-t border-gray-100">
                                    <td class="px-6 py-3">{{ $loop->iteration }}</td>
                                    <td class="px-6 py-3">{{ $buku->judul }}</td>
                                    <td class="px-6 py-3">{{ $buku->kategori?->nama ?? '-' }}</td>
                                    <td class="px-6 py-3">{{ $buku->peminjamans_count }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center px-6 py-5 text-gray-500">
                                        Belum ada data buku.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="flex justify-end">
                <a href="{{ auth()->user()->hasRole('Petugas') ? route('dashboard.petugas') : route('dashboard.admin') }}"
                   class="px-5 py-2 rounded-lg bg-pink-600 text-white hover:bg-pink-700 transition">
                    Kembali ke Dashboard
                </a>
            </div>

        </div>
    </div>
</x-app-layout>
