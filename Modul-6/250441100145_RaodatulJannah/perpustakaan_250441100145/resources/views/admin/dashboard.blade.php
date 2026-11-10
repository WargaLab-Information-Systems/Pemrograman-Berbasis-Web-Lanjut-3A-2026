<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-pink-900 leading-tight">
            Dashboard Admin
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
                            Selamat Datang, Admin!
                        </h3>
                        <p class="text-pink-100">
                            Kelola data dan kegiatan perpustakaan melalui dashboard admin.
                        </p>
                    </div>

                    <!-- Modul Admin -->
                    <h3 class="text-lg font-bold text-pink-900 mb-5">
                        Modul Admin
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

                        <!-- Kelola Pengguna -->
                        @can('manage users')
                            <a href="{{ route('admin.users.index') }}"
                               class="block p-6 rounded-xl shadow-sm border border-pink-200 hover:shadow-lg hover:-translate-y-1 transition"
                               style="background-color: #f9a8d4;">
                                <h4 class="font-bold text-pink-950 text-lg">
                                    Kelola Pengguna
                                </h4>
                                <p class="text-sm text-pink-900 mt-2">
                                    Melihat, menambah, mengubah, dan menghapus data pengguna.
                                </p>
                                <p class="text-sm font-bold text-pink-800 mt-4">
                                    Buka Modul →
                                </p>
                            </a>
                        @endcan

                        <!-- Kelola Role -->
                        @can('manage user roles')
                            <div class="p-6 rounded-xl shadow-sm border border-pink-200"
                                 style="background-color: #fbcfe8;">
                                <h4 class="font-bold text-pink-950 text-lg">
                                    Kelola Role
                                </h4>
                                <p class="text-sm text-pink-900 mt-2">
                                    Mengelola hak akses dan peran pengguna.
                                </p>
                                <p class="text-sm font-bold text-pink-800 mt-4">
                                    Pengelolaan melalui modul pengguna
                                </p>
                            </div>
                        @endcan

                        <!-- Peminjaman -->
                        @can('manage loans')
                            <a href="{{ route('admin.peminjaman.index') }}"
                               class="block p-6 rounded-xl shadow-sm border border-pink-200 hover:shadow-lg hover:-translate-y-1 transition"
                               style="background-color: #f9a8d4;">
                                <h4 class="font-bold text-pink-950 text-lg">
                                    Peminjaman
                                </h4>
                                <p class="text-sm text-pink-900 mt-2">
                                    Mengelola proses peminjaman dan pengajuan buku.
                                </p>
                                <p class="text-sm font-bold text-pink-800 mt-4">
                                    Buka Modul →
                                </p>
                            </a>
                        @endcan

                        <!-- Pengembalian -->
                        @can('manage returns')
                            <a href="{{ route('admin.pengembalian.index') }}"
                               class="block p-6 rounded-xl shadow-sm border border-pink-200 hover:shadow-lg hover:-translate-y-1 transition"
                               style="background-color: #fbcfe8;">
                                <h4 class="font-bold text-pink-950 text-lg">
                                    Pengembalian
                                </h4>
                                <p class="text-sm text-pink-900 mt-2">
                                    Mengelola proses pengembalian buku perpustakaan.
                                </p>
                                <p class="text-sm font-bold text-pink-800 mt-4">
                                    Buka Modul →
                                </p>
                            </a>
                        @endcan

                        <!-- Laporan -->
                        @can('view library reports')
                            <a href="{{ route('admin.laporan.index') }}"
                                class="block p-6 rounded-xl shadow-sm border border-pink-200 hover:shadow-lg hover:-translate-y-1 transition"
                                style="background-color: #f9a8d4;">

                                <h4 class="font-bold text-pink-950 text-lg">
                                    Laporan Perpustakaan
                                </h4>

                                <p class="text-sm text-pink-900 mt-2">
                                    Melihat laporan kegiatan dan statistik perpustakaan.
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