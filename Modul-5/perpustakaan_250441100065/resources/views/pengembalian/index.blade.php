<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Pengembalian Buku</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            <x-flash />

            <div>
                <h3 class="font-semibold text-gray-800 mb-2">Sedang dipinjam</h3>
                <div class="bg-white shadow-sm sm:rounded-lg overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 text-sm">
                        <thead class="bg-gray-50 text-left text-gray-600">
                            <tr>
                                <th class="px-4 py-3">Peminjam</th>
                                <th class="px-4 py-3">Buku</th>
                                <th class="px-4 py-3">Tgl Pinjam</th>
                                <th class="px-4 py-3">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse ($dipinjam as $p)
                                <tr>
                                    <td class="px-4 py-3">{{ $p->anggota->nama ?? '-' }}</td>
                                    <td class="px-4 py-3 font-medium">{{ $p->buku->judul ?? '-' }}</td>
                                    <td class="px-4 py-3">{{ $p->tanggal_pinjam?->format('d M Y') ?? '-' }}</td>
                                    <td class="px-4 py-3">
                                        @can('mencatat pengembalian buku')
                                            <form method="POST" action="{{ route('kelola.pengembalian.store', $p) }}">
                                                @csrf
                                                <button class="px-3 py-1 bg-blue-600 text-white rounded text-xs font-semibold hover:bg-blue-500">Catat Pengembalian</button>
                                            </form>
                                        @endcan
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="4" class="px-4 py-6 text-center text-gray-500">Tidak ada buku yang sedang dipinjam.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div>
                <h3 class="font-semibold text-gray-800 mb-2">10 pengembalian terakhir</h3>
                <div class="bg-white shadow-sm sm:rounded-lg overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 text-sm">
                        <thead class="bg-gray-50 text-left text-gray-600">
                            <tr>
                                <th class="px-4 py-3">Peminjam</th>
                                <th class="px-4 py-3">Buku</th>
                                <th class="px-4 py-3">Tgl Pinjam</th>
                                <th class="px-4 py-3">Tgl Kembali</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse ($selesai as $p)
                                <tr>
                                    <td class="px-4 py-3">{{ $p->anggota->nama ?? '-' }}</td>
                                    <td class="px-4 py-3 font-medium">{{ $p->buku->judul ?? '-' }}</td>
                                    <td class="px-4 py-3">{{ $p->tanggal_pinjam?->format('d M Y') ?? '-' }}</td>
                                    <td class="px-4 py-3">{{ $p->tanggal_kembali?->format('d M Y') ?? '-' }}</td>
                                </tr>
                            @empty
                                <tr><td colspan="4" class="px-4 py-6 text-center text-gray-500">Belum ada pengembalian.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
