<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard Petugas</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <x-flash />

            <div class="bg-white shadow-sm sm:rounded-lg p-6 text-gray-900">
                Selamat bertugas, <strong>{{ Auth::user()->name }}</strong>!
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <x-stat-card label="Total buku" :value="$totalBuku" />
                <x-stat-card label="Pengajuan menunggu" :value="$menunggu" />
                <x-stat-card label="Sedang dipinjam" :value="$dipinjam" />
            </div>

            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <h3 class="font-semibold text-gray-800 mb-3">Pengajuan terbaru yang menunggu</h3>

                @forelse ($pengajuan as $p)
                    <div class="flex flex-wrap items-center justify-between gap-3 py-3 border-b last:border-0">
                        <div class="text-sm">
                            <span class="font-semibold">{{ $p->anggota->nama ?? '-' }}</span>
                            ingin meminjam
                            <span class="font-semibold">{{ $p->buku->judul ?? '-' }}</span>
                        </div>

                        @can('memproses persetujuan peminjaman')
                            <div class="flex gap-2">
                                <form method="POST" action="{{ route('kelola.peminjaman.setujui', $p) }}">
                                    @csrf
                                    <button class="px-3 py-1 bg-green-600 text-white rounded text-xs font-semibold hover:bg-green-500">Setujui</button>
                                </form>
                                <form method="POST" action="{{ route('kelola.peminjaman.tolak', $p) }}">
                                    @csrf
                                    <button class="px-3 py-1 bg-red-600 text-white rounded text-xs font-semibold hover:bg-red-500">Tolak</button>
                                </form>
                            </div>
                        @endcan
                    </div>
                @empty
                    <p class="text-sm text-gray-500">Tidak ada pengajuan yang menunggu.</p>
                @endforelse
            </div>

            <div class="bg-white shadow-sm sm:rounded-lg p-6 flex flex-wrap gap-3">
                @can('kelola-buku')
                    <a href="{{ route('buku.kelola') }}" class="px-4 py-2 bg-blue-600 text-white rounded-md text-sm font-semibold hover:bg-blue-500">Kelola Buku</a>
                @endcan
                @can('kelola peminjaman')
                    <a href="{{ route('kelola.peminjaman') }}" class="px-4 py-2 bg-yellow-600 text-white rounded-md text-sm font-semibold hover:bg-yellow-500">Data Peminjaman</a>
                @endcan
                @can('kelola pengembalian')
                    <a href="{{ route('kelola.pengembalian') }}" class="px-4 py-2 bg-gray-800 text-white rounded-md text-sm font-semibold hover:bg-gray-700">Pengembalian</a>
                @endcan
                @can('lihat laporan perpustakaan')
                    <a href="{{ route('laporan.index') }}" class="px-4 py-2 bg-green-600 text-white rounded-md text-sm font-semibold hover:bg-green-500">Laporan</a>
                @endcan
            </div>
        </div>
    </div>
</x-app-layout>
