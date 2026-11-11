<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Data Peminjaman</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-flash />

            <form method="GET" class="mb-4 flex flex-wrap gap-2 items-center">
                <label class="text-sm text-gray-600" for="status">Filter status:</label>
                <select id="status" name="status" class="rounded-md border-gray-300 text-sm" onchange="this.form.submit()">
                    <option value="">Semua</option>
                    @foreach (['diajukan', 'dipinjam', 'dikembalikan', 'ditolak'] as $s)
                        <option value="{{ $s }}" @selected($status === $s)>{{ ucfirst($s) }}</option>
                    @endforeach
                </select>
            </form>

            <div class="bg-white shadow-sm sm:rounded-lg overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 text-sm">
                    <thead class="bg-gray-50 text-left text-gray-600">
                        <tr>
                            <th class="px-4 py-3">Peminjam</th>
                            <th class="px-4 py-3">Buku</th>
                            <th class="px-4 py-3">Tgl Pinjam</th>
                            <th class="px-4 py-3">Tgl Kembali</th>
                            <th class="px-4 py-3">Status</th>
                            <th class="px-4 py-3">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse ($data as $p)
                            <tr>
                                <td class="px-4 py-3">{{ $p->anggota->nama ?? '-' }}</td>
                                <td class="px-4 py-3 font-medium">{{ $p->buku->judul ?? '-' }}</td>
                                <td class="px-4 py-3">{{ $p->tanggal_pinjam?->format('d M Y') ?? '-' }}</td>
                                <td class="px-4 py-3">{{ $p->tanggal_kembali?->format('d M Y') ?? '-' }}</td>
                                <td class="px-4 py-3"><x-status-badge :status="$p->status" /></td>
                                <td class="px-4 py-3">
                                    @if ($p->status === 'diajukan')
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
                                    @elseif ($p->status === 'dipinjam')
                                        @can('mencatat pengembalian buku')
                                            <form method="POST" action="{{ route('kelola.pengembalian.store', $p) }}">
                                                @csrf
                                                <button class="px-3 py-1 bg-blue-600 text-white rounded text-xs font-semibold hover:bg-blue-500">Catat Kembali</button>
                                            </form>
                                        @endcan
                                    @else
                                        <span class="text-gray-400">-</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="6" class="px-4 py-6 text-center text-gray-500">Tidak ada data.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4">{{ $data->links() }}</div>
        </div>
    </div>
</x-app-layout>
