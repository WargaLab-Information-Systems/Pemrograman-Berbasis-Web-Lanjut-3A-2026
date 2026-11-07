<x-app-layout>
    <div class="min-h-screen bg-[#fff7f9] py-10">
        <div class="mx-auto max-w-7xl px-6">
            <div class="mb-8">
                <h1 class="text-2xl font-bold text-[#b85a70]">Persetujuan Peminjaman</h1>
                <p class="mt-2 text-gray-600">Periksa pengajuan peminjaman dari siswa dan tentukan persetujuannya.</p>
            </div>

            @if (session('success'))
                <div class="mb-5 rounded-lg bg-green-100 p-4 text-green-700">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="mb-5 rounded-lg bg-red-100 p-4 text-red-700">
                    {{ session('error') }}
                </div>
            @endif

            <div class="overflow-x-auto rounded-xl border border-[#f3d3dc] bg-white shadow-sm">
                <table class="w-full text-left text-sm">
                    <thead class="bg-[#fbe4ea] text-[#9f4b61]">
                        <tr>
                            <th class="px-5 py-4">No</th>
                            <th class="px-5 py-4">Nama Siswa</th>
                            <th class="px-5 py-4">Judul Buku</th>
                            <th class="px-5 py-4">Tanggal Pengajuan</th>
                            <th class="px-5 py-4">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#f3d3dc]">
                        @forelse ($peminjamans as $peminjaman)
                            <tr class="text-gray-700">
                                <td class="px-5 py-4">{{ $loop->iteration }}</td>
                                <td class="px-5 py-4 font-medium">{{ $peminjaman->anggota?->nama ?? '-' }}</td>
                                <td class="px-5 py-4">{{ $peminjaman->buku?->judul ?? '-' }}</td>
                                <td class="px-5 py-4">{{ $peminjaman->tanggal_pinjam }}</td>
                                <td class="px-5 py-4">
                                    <div class="flex flex-wrap gap-2">
                                        <form action="{{ route('petugas.persetujuan.proses', $peminjaman->id) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="status" value="disetujui">
                                            <button type="submit" class="rounded-lg bg-green-600 px-3 py-2 font-semibold text-white hover:bg-green-700">
                                                Setujui
                                            </button>
                                        </form>

                                        <form action="{{ route('petugas.persetujuan.proses', $peminjaman->id) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="status" value="ditolak">
                                            <button type="submit" class="rounded-lg bg-red-600 px-3 py-2 font-semibold text-white hover:bg-red-700">
                                                Tolak
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-5 py-10 text-center text-gray-500">
                                    Belum ada pengajuan peminjaman yang menunggu persetujuan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-8">
                <a href="{{ route('dashboard.petugas') }}" class="inline-flex rounded-lg border border-[#d9738a] px-5 py-2.5 font-semibold text-[#b85a70] transition hover:bg-[#fbe4ea]">
                    Kembali ke Dashboard
                </a>
            </div>
        </div>
    </div>
</x-app-layout>