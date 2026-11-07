<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Dashboard Petugas
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white shadow-sm sm:rounded-lg p-6 mb-6">
                <h3 class="text-xl font-bold text-gray-800">
                    Selamat Datang, {{ Auth::user()->name }}!
                </h3>

                <p class="text-gray-600 mt-2">
                    Selamat datang di Dashboard Petugas Perpustakaan.
                    Kelola kegiatan operasional perpustakaan melalui halaman ini.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">

                @can('lihat daftar buku')
                    <div class="bg-white p-6 rounded-xl shadow-sm border border-pink-100">
                        <div class="w-12 h-12 flex items-center justify-center rounded-lg bg-pink-100 mb-4">
                            <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="#be185d" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/>
                                <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2Z"/>
                            </svg>
                        </div>

                        <h4 class="font-bold text-gray-800">Data Buku</h4>
                        <p class="text-sm text-gray-600 mt-2 mb-4">
                            Melihat dan mengelola koleksi buku perpustakaan.
                        </p>

                        <a href="{{ route('buku.index') }}" class="inline-block bg-pink-600 text-white px-4 py-2 rounded-lg hover:bg-pink-700">
                            Kelola Buku
                        </a>
                    </div>
                @endcan

                @can('kelola peminjaman')
                    <a href="{{ route('petugas.peminjaman.index') }}"
                        class="block bg-white p-6 rounded-xl shadow-sm border border-pink-100 transition hover:shadow-md hover:-translate-y-1">
                        <div class="w-12 h-12 flex items-center justify-center rounded-lg bg-pink-100 mb-4">
                            <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="#be185d" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M8 2h8l4 4v16H4V2h4Z"/>
                                <path d="M8 2v5h8V2M8 13h8M8 17h5"/>
                            </svg>
                        </div>

                        <h4 class="font-bold text-gray-800">Peminjaman</h4>
                        <p class="text-sm text-gray-600 mt-2 mb-4">
                            Mengelola proses peminjaman buku.
                        </p>

                        <span class="inline-block bg-pink-600 text-white px-4 py-2 rounded-lg">
                            Kelola Peminjaman
                        </span>
                    </a>
                @endcan

                @can('memproses persetujuan peminjaman')
                    <a href="{{ route('petugas.persetujuan.index') }}"
                        class="block bg-white p-6 rounded-xl shadow-sm border border-pink-100 transition hover:shadow-md hover:-translate-y-1">
                        <div class="w-12 h-12 flex items-center justify-center rounded-lg bg-pink-100 mb-4">
                            <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="#be185d" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M9 11l3 3L22 4"/>
                                <path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/>
                            </svg>
                        </div>

                        <h4 class="font-bold text-gray-800">Persetujuan Peminjaman</h4>
                        <p class="text-sm text-gray-600 mt-2 mb-4">
                            Memeriksa, menyetujui, atau menolak pengajuan peminjaman siswa.
                        </p>

                        <span class="inline-block bg-pink-600 text-white px-4 py-2 rounded-lg">
                            Lihat Pengajuan
                        </span>
                    </a>
                @endcan

                @can('kelola pengembalian')
                    <a href="{{ route('petugas.pengembalian.index') }}"
                        class="block bg-white p-6 rounded-xl shadow-sm border border-pink-100 transition hover:shadow-md hover:-translate-y-1">
                        <div class="w-12 h-12 flex items-center justify-center rounded-lg bg-pink-100 mb-4">
                            <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="#be185d" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M3 12a9 9 0 1 0 3-6.7L3 8"/>
                                <path d="M3 3v5h5M12 7v5l3 2"/>
                            </svg>
                        </div>

                        <h4 class="font-bold text-gray-800">Pengembalian</h4>
                        <p class="text-sm text-gray-600 mt-2 mb-4">
                            Mengelola proses pengembalian buku.
                        </p>

                        <span class="inline-block bg-pink-600 text-white px-4 py-2 rounded-lg">
                            Kelola Pengembalian
                        </span>
                    </a>
                @endcan

                @can('lihat laporan perpustakaan')
                    <div class="bg-white p-6 rounded-xl shadow-sm border border-pink-100">
                        <div class="w-12 h-12 flex items-center justify-center rounded-lg bg-pink-100 mb-4">
                            <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="#be185d" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M3 3v18h18"/>
                                <path d="m19 9-5 5-4-4-5 5"/>
                            </svg>
                        </div>

                        <h4 class="font-bold text-gray-800">Laporan</h4>
                        <p class="text-sm text-gray-600 mt-2 mb-4">
                            Melihat laporan aktivitas perpustakaan.
                        </p>

                        <a href="{{ route('petugas.laporan.index') }}" class="inline-block bg-pink-600 text-white px-4 py-2 rounded-lg hover:bg-pink-700">
                            Lihat Laporan
                        </a>
                    </div>
                @endcan

            </div>
        </div>
    </div>
</x-app-layout>
