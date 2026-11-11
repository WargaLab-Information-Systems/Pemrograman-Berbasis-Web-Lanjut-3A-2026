<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Laporan Perpustakaan</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

            <div class="grid grid-cols-2 lg:grid-cols-5 gap-4">
                <x-stat-card label="Total buku" :value="$totalBuku" />
                <x-stat-card label="Diajukan" :value="$perStatus['diajukan'] ?? 0" />
                <x-stat-card label="Dipinjam" :value="$perStatus['dipinjam'] ?? 0" />
                <x-stat-card label="Dikembalikan" :value="$perStatus['dikembalikan'] ?? 0" />
                <x-stat-card label="Ditolak" :value="$perStatus['ditolak'] ?? 0" />
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <div class="bg-white shadow-sm sm:rounded-lg p-5">
                    <h3 class="font-semibold text-gray-800 mb-3">Jumlah buku per kategori</h3>
                    <table class="min-w-full text-sm">
                        <tbody class="divide-y divide-gray-100">
                            @forelse ($perKategori as $k)
                                <tr><td class="py-2">{{ $k->nama }}</td><td class="py-2 text-right font-semibold">{{ $k->bukus_count }}</td></tr>
                            @empty
                                <tr><td class="py-2 text-gray-500">Belum ada kategori.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="bg-white shadow-sm sm:rounded-lg p-5">
                    <h3 class="font-semibold text-gray-800 mb-3">5 buku paling sering dipinjam</h3>
                    <table class="min-w-full text-sm">
                        <tbody class="divide-y divide-gray-100">
                            @forelse ($bukuPopuler as $b)
                                <tr><td class="py-2">{{ $b->judul }}</td><td class="py-2 text-right font-semibold">{{ $b->peminjamans_count }}x</td></tr>
                            @empty
                                <tr><td class="py-2 text-gray-500">Belum ada data.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="bg-white shadow-sm sm:rounded-lg overflow-x-auto">
                <h3 class="font-semibold text-gray-800 p-5 pb-2">10 transaksi terbaru</h3>
                <table class="min-w-full divide-y divide-gray-200 text-sm">
                    <thead class="bg-gray-50 text-left text-gray-600">
                        <tr>
                            <th class="px-4 py-3">Peminjam</th>
                            <th class="px-4 py-3">Buku</th>
                            <th class="px-4 py-3">Tgl Pinjam</th>
                            <th class="px-4 py-3">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse ($terbaru as $p)
                            <tr>
                                <td class="px-4 py-3">{{ $p->anggota->nama ?? '-' }}</td>
                                <td class="px-4 py-3 font-medium">{{ $p->buku->judul ?? '-' }}</td>
                                <td class="px-4 py-3">{{ $p->tanggal_pinjam?->format('d M Y') ?? '-' }}</td>
                                <td class="px-4 py-3"><x-status-badge :status="$p->status" /></td>
                            </tr>
                        @empty
                            <tr><td colspan="4" class="px-4 py-6 text-center text-gray-500">Belum ada transaksi.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
