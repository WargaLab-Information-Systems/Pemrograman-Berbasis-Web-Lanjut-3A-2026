<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Dashboard Admin
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white shadow-sm sm:rounded-lg p-6 mb-6">
                <h3 class="text-xl font-bold text-gray-800">
                    Selamat Datang, {{ Auth::user()->name }}!
                </h3>

                <p class="text-gray-600 mt-2">
                    Selamat datang di Dashboard Admin Perpustakaan.
                    Kelola data dan aktivitas perpustakaan melalui halaman ini.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">

                <div class="bg-white p-6 rounded-xl shadow-sm border border-pink-100 transition hover:shadow-md hover:-translate-y-1">
                    <div class="w-12 h-12 flex items-center justify-center rounded-lg bg-pink-100 mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="#be185d" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/>
                            <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2Z"/>
                        </svg>
                    </div>

                    <h4 class="font-bold text-gray-800">Manajemen Buku</h4>
                    <p class="text-sm text-gray-600 mt-2 mb-4">
                        Melihat dan mengelola koleksi buku perpustakaan.
                    </p>

                    <a href="{{ route('buku.index') }}" class="inline-block bg-pink-600 text-white px-4 py-2 rounded-lg hover:bg-pink-700">
                        Kelola Buku
                    </a>
                </div>

                <div class="bg-white p-6 rounded-xl shadow-sm border border-pink-100 transition hover:shadow-md hover:-translate-y-1">
                    <div class="w-12 h-12 flex items-center justify-center rounded-lg bg-pink-100 mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="#be185d" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M16 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                            <circle cx="10" cy="7" r="4"/>
                            <path d="M20 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75"/>
                        </svg>
                    </div>

                    <h4 class="font-bold text-gray-800">Pengguna</h4>
                    <p class="text-sm text-gray-600 mt-2 mb-4">
                        Mengelola akun dan hak akses pengguna perpustakaan.
                    </p>

                    <a href="{{ route('admin.users.index') }}" class="inline-block bg-pink-600 text-white px-4 py-2 rounded-lg hover:bg-pink-700">
                        Kelola Pengguna
                    </a>
                </div>

                <div class="bg-white p-6 rounded-xl shadow-sm border border-pink-100 transition hover:shadow-md hover:-translate-y-1">
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

                    <a href="{{ route('admin.laporan.index') }}" class="inline-block bg-pink-600 text-white px-4 py-2 rounded-lg hover:bg-pink-700">
                        Lihat Laporan
                    </a>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>