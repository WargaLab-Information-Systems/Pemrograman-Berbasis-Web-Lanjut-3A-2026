<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Status Peminjaman Saya</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-flash />

            <div class="bg-white shadow-sm sm:rounded-lg overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 text-sm">
                    <thead class="bg-gray-50 text-left text-gray-600">
                        <tr>
                            <th class="px-4 py-3">Buku</th>
                            <th class="px-4 py-3">Kategori</th>
                            <th class="px-4 py-3">Tanggal Pinjam</th>
                            <th class="px-4 py-3">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse ($data as $p)
                            <tr>
                                <td class="px-4 py-3 font-medium">{{ $p->buku->judul ?? '-' }}</td>
                                <td class="px-4 py-3">{{ $p->buku->kategori->nama ?? '-' }}</td>
                                <td class="px-4 py-3">{{ $p->tanggal_pinjam?->format('d M Y') ?? '-' }}</td>
                                <td class="px-4 py-3"><x-status-badge :status="$p->status" /></td>
                            </tr>
                        @empty
                            <tr><td colspan="4" class="px-4 py-6 text-center text-gray-500">Belum ada peminjaman yang berjalan.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                @can('melihat riwayat peminjaman sendiri')
                    <a href="{{ route('riwayat.saya') }}" class="text-sm text-blue-600 hover:underline">Lihat riwayat lengkap &rarr;</a>
                @endcan
            </div>
        </div>
    </div>
</x-app-layout>
