<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-pink-900 leading-tight">
            Dashboard Petugas
        </h2>
    </x-slot>

    <div class="min-h-screen py-10" style="background-color: #fce7f3;">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="rounded-2xl shadow-lg overflow-hidden"
                 style="background-color: #fff1f7; border: 1px solid #f3b5d0;">

                <div class="p-6 md:p-8">

                    <!-- Sambutan -->
                    <div class="rounded-xl p-6 mb-8"
                         style="background: linear-gradient(135deg, #be185d, #db2777);">

                        <h3 class="text-2xl font-bold text-white mb-2">
                            Selamat Datang, Petugas!
                        </h3>

                        <p class="text-pink-100">
                            Selamat bekerja. Kelola layanan perpustakaan melalui dashboard petugas.
                        </p>
                    </div>

                    <!-- Modul Petugas -->
                    <h3 class="text-lg font-bold text-pink-900 mb-5">
                        Modul Petugas
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">

                        <!-- Kelola Buku -->
                        @can('manage books')
                            <a href="{{ route('buku.index') }}"
                               class="block p-6 rounded-xl shadow-sm border border-pink-200 hover:shadow-lg hover:-translate-y-1 transition"
                               style="background-color: #fbcfe8;">

                                <h4 class="font-bold text-pink-950 text-lg">
                                    Kelola Buku
                                </h4>

                                <p class="text-sm text-pink-900 mt-2">
                                    Melihat dan mengelola data buku perpustakaan.
                                </p>

                                <p class="text-sm font-bold text-pink-800 mt-4">
                                    Buka Modul →
                                </p>
                            </a>
                        @endcan


                        <!-- Peminjaman -->
                        @can('manage loans')
                            <a href="{{ route('petugas.peminjaman.index') }}"
                               class="block p-6 rounded-xl shadow-sm border border-pink-200 hover:shadow-lg hover:-translate-y-1 transition"
                               style="background-color: #f9a8d4;">


                                <h4 class="font-bold text-pink-950 text-lg">
                                    Peminjaman
                                </h4>

                                <p class="text-sm text-pink-900 mt-2">
                                    Memproses pengajuan dan peminjaman buku.
                                </p>

                                <p class="text-sm font-bold text-pink-800 mt-4">
                                    Buka Modul →
                                </p>
                            </a>
                        @endcan


                        <!-- Pengembalian -->
                        @can('manage returns')
                            <a href="{{ route('petugas.pengembalian.index') }}"
                                class="block p-6 rounded-xl shadow-sm border border-pink-200 hover:shadow-lg hover:-translate-y-1 transition"
                                style="background-color: #fbcfe8;">

                                <h4 class="font-bold text-pink-950 text-lg">
                                    Pengembalian
                                </h4>

                                <p class="text-sm text-pink-900 mt-2">
                                    Memproses pengembalian buku perpustakaan.
                                </p>

                                <p class="text-sm font-bold text-pink-800 mt-4">
                                    Buka Modul
                                </p>
                            </a>
                        @endcan


                        <!-- Laporan Perpustakaan -->
                        @can('view library reports')
                            <a href="{{ route('petugas.laporan.index') }}"
                                class="block p-6 rounded-xl shadow-sm border border-pink-200 hover:shadow-lg hover:-translate-y-1 transition"
                                style="background-color: #f9a8d4;">

                                <h4 class="font-bold text-pink-950 text-lg"> Laporan Perpustakaan</h4>

                                <p class="text-sm text-pink-900 mt-2">
                                    Melihat statistik buku, anggota, peminjaman,
                                    dan pengembalian perpustakaan.
                                </p>

                                <p class="text-sm font-bold text-pink-800 mt-4">
                                Buka Modul 
                                </p>
                            </a>
                        @endcan


                        <!-- Profil -->
                        @can('view own profile')
                            <a href="{{ route('profile.edit') }}"
                               class="block p-6 rounded-xl shadow-sm border border-pink-200 hover:shadow-lg hover:-translate-y-1 transition"
                               style="background-color: #fbcfe8;">

                                <h4 class="font-bold text-pink-950 text-lg">
                                    Profil
                                </h4>

                                <p class="text-sm text-pink-900 mt-2">
                                    Melihat dan memperbarui profil pribadi.
                                </p>

                                <p class="text-sm font-bold text-pink-800 mt-4">
                                    Buka Profil →
                                </p>
                            </a>
                        @endcan

                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>