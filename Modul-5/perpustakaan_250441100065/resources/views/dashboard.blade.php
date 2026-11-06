<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard Siswa</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <x-flash />

            <div class="bg-white shadow-sm sm:rounded-lg p-6 text-gray-900">
                Halo, <strong>{{ Auth::user()->name }}</strong>! Kamu masuk sebagai
                <span class="font-semibold">{{ Auth::user()->getRoleNames()->implode(', ') }}</span>.
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <x-stat-card label="Pengajuan menunggu" :value="$menunggu" />
                <x-stat-card label="Sedang dipinjam" :value="$dipinjam" />
                <x-stat-card label="Sudah dikembalikan" :value="$selesai" />
            </div>

            <div class="bg-white shadow-sm sm:rounded-lg p-6 flex flex-wrap gap-3">
                @can('lihat daftar buku')
                    <a href="{{ route('buku.index') }}" class="px-4 py-2 bg-gray-800 text-white rounded-md text-sm font-semibold hover:bg-gray-700">Lihat Daftar Buku</a>
                @endcan
                @can('melihat status peminjaman sendiri')
                    <a href="{{ route('peminjaman.saya') }}" class="px-4 py-2 bg-blue-600 text-white rounded-md text-sm font-semibold hover:bg-blue-500">Status Peminjaman Saya</a>
                @endcan
                @can('melihat riwayat peminjaman sendiri')
                    <a href="{{ route('riwayat.saya') }}" class="px-4 py-2 bg-green-600 text-white rounded-md text-sm font-semibold hover:bg-green-500">Riwayat Peminjaman Saya</a>
                @endcan
            </div>
        </div>
    </div>
</x-app-layout>
