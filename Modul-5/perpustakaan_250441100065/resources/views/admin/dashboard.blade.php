<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard Admin</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <x-flash />

            <div class="bg-white shadow-sm sm:rounded-lg p-6 text-gray-900">
                Selamat datang, <strong>{{ Auth::user()->name }}</strong>!

                @can('kelola data pengguna')
                    <div class="mt-4 p-3 bg-green-100 text-green-800 rounded">
                        Kamu memiliki hak akses untuk <strong>kelola data pengguna</strong> dan <strong>kelola role pengguna</strong>.
                    </div>
                @endcan
            </div>

            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
                <x-stat-card label="Total buku" :value="$totalBuku" />
                <x-stat-card label="Total pengguna" :value="$totalUser" />
                <x-stat-card label="Pengajuan menunggu" :value="$menunggu" />
                <x-stat-card label="Sedang dipinjam" :value="$dipinjam" />
            </div>

            <div class="grid grid-cols-3 gap-4">
                <x-stat-card label="Admin" :value="$totalAdmin" />
                <x-stat-card label="Petugas" :value="$totalPetugas" />
                <x-stat-card label="Siswa" :value="$totalSiswa" />
            </div>

            <div class="bg-white shadow-sm sm:rounded-lg p-6 flex flex-wrap gap-3">
                @can('kelola data pengguna')
                    <a href="{{ route('admin.users.index') }}" class="px-4 py-2 bg-gray-800 text-white rounded-md text-sm font-semibold hover:bg-gray-700">Kelola Pengguna &amp; Role</a>
                @endcan
                @can('kelola data buku')
                    <a href="{{ route('buku.kelola') }}" class="px-4 py-2 bg-blue-600 text-white rounded-md text-sm font-semibold hover:bg-blue-500">Kelola Buku</a>
                @endcan
                @can('kelola peminjaman')
                    <a href="{{ route('kelola.peminjaman') }}" class="px-4 py-2 bg-yellow-600 text-white rounded-md text-sm font-semibold hover:bg-yellow-500">Data Peminjaman</a>
                @endcan
                @can('lihat laporan perpustakaan')
                    <a href="{{ route('laporan.index') }}" class="px-4 py-2 bg-green-600 text-white rounded-md text-sm font-semibold hover:bg-green-500">Laporan</a>
                @endcan
            </div>
        </div>
    </div>
</x-app-layout>
