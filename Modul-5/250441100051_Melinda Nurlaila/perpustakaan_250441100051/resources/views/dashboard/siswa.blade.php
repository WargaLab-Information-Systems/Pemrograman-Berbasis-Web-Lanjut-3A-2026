<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Dashboard Siswa
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white shadow-sm sm:rounded-lg p-6 mb-6">
                <h3 class="text-xl font-bold text-gray-800">
                    Selamat Datang, {{ Auth::user()->name }}!
                </h3>

                <p class="text-gray-600 mt-2">
                    Selamat datang di Perpustakaan. Temukan buku dan pantau aktivitas peminjamanmu di sini.
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

                        <h4 class="font-bold text-gray-800">Daftar Buku</h4>
                        <p class="text-sm text-gray-600 mt-2 mb-4">
                            Jelajahi koleksi buku yang tersedia di perpustakaan.
                        </p>

                        <a href="{{ route('buku.index') }}"
                            class="inline-block bg-pink-600 text-white px-4 py-2 rounded-lg hover:bg-pink-700">
                            Lihat Buku
                        </a>
                    </div>
                @endcan

                @can('mengajukan peminjaman buku')
                    <div class="bg-white p-6 rounded-xl shadow-sm border border-pink-100">
                        <div class="w-12 h-12 flex items-center justify-center rounded-lg bg-pink-100 mb-4">
                            <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="#be185d" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M12 5v14M5 12h14"/>
                                <rect x="3" y="3" width="18" height="18" rx="2"/>
                            </svg>
                        </div>

                        <h4 class="font-bold text-gray-800">Ajukan Peminjaman</h4>
                        <p class="text-sm text-gray-600 mt-2 mb-4">
                            Ajukan peminjaman buku yang ingin kamu baca.
                        </p>

                        <a href="{{ route('siswa.pengajuan.index') }}"
                            class="inline-block bg-pink-600 text-white px-4 py-2 rounded-lg hover:bg-pink-700">
                            Ajukan Sekarang
                        </a>
                    </div>
                @endcan

                @can('melihat status peminjaman sendiri')
                    <div class="bg-white p-6 rounded-xl shadow-sm border border-pink-100">
                        <div class="w-12 h-12 flex items-center justify-center rounded-lg bg-pink-100 mb-4">
                            <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="#be185d" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="12" cy="12" r="10"/>
                                <path d="M12 6v6l4 2"/>
                            </svg>
                        </div>

                        <h4 class="font-bold text-gray-800">Status Peminjaman</h4>
                        <p class="text-sm text-gray-600 mt-2 mb-4">
                            Pantau status pengajuan peminjaman bukumu.
                        </p>

                        <a href="{{ route('siswa.status.index') }}"
                            class="inline-block bg-pink-600 text-white px-4 py-2 rounded-lg hover:bg-pink-700">
                            Lihat Status
                        </a>
                    </div>
                @endcan

                @can('melihat riwayat peminjaman sendiri')
                    <div class="bg-white p-6 rounded-xl shadow-sm border border-pink-100">
                        <div class="w-12 h-12 flex items-center justify-center rounded-lg bg-pink-100 mb-4">
                            <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="#be185d" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M3 12a9 9 0 1 0 3-6.7L3 8"/>
                                <path d="M3 3v5h5M12 7v5l3 2"/>
                            </svg>
                        </div>

                        <h4 class="font-bold text-gray-800">Riwayat Peminjaman</h4>
                        <p class="text-sm text-gray-600 mt-2 mb-4">
                            Lihat daftar buku yang pernah kamu pinjam.
                        </p>

                        <a href="{{ route('siswa.riwayat.index') }}"
                            class="inline-block bg-pink-600 text-white px-4 py-2 rounded-lg hover:bg-pink-700">
                            Lihat Riwayat
                        </a>
                    </div>
                @endcan

            </div>
        </div>
    </div>
</x-app-layout>
