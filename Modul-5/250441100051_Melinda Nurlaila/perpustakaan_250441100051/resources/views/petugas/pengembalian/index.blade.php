<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Data Pengembalian Buku
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if (session('success'))
                <div class="mb-5 rounded-lg bg-green-100 p-4 text-sm text-green-700">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="mb-5 rounded-lg bg-red-100 p-4 text-sm text-red-700">
                    {{ session('error') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="mb-5 rounded-lg bg-red-100 p-4 text-sm text-red-700">
                    {{ $errors->first() }}
                </div>
            @endif

            <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                <div class="p-6 overflow-x-auto">

                    <div class="mb-5">
                        <h3 class="text-lg font-bold text-gray-800">
                            Daftar Buku yang Belum Dikembalikan
                        </h3>
                        <p class="text-sm text-gray-500 mt-1">
                            Proses pengembalian buku melalui tabel berikut.
                        </p>
                    </div>

                    <table class="w-full text-left text-sm">
                        <thead class="bg-pink-50 text-gray-700 border-b">
                            <tr>
                                <th class="px-4 py-3">No</th>
                                <th class="px-4 py-3">Nama Anggota</th>
                                <th class="px-4 py-3">Judul Buku</th>
                                <th class="px-4 py-3">Tanggal Pinjam</th>
                                <th class="px-4 py-3">Tanggal Kembali</th>
                                <th class="px-4 py-3">Aksi</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y">
                            @forelse ($peminjamans as $peminjaman)
                                <tr>
                                    <td class="px-4 py-3">
                                        {{ $loop->iteration }}
                                    </td>

                                    <td class="px-4 py-3">
                                        {{ $peminjaman->anggota->nama ?? '-' }}
                                    </td>

                                    <td class="px-4 py-3">
                                        {{ $peminjaman->buku->judul ?? '-' }}
                                    </td>

                                    <td class="px-4 py-3">
                                        {{ $peminjaman->tanggal_pinjam }}
                                    </td>

                                    <td class="px-4 py-3">
                                        <span class="rounded-full bg-yellow-100 px-3 py-1 text-xs font-semibold text-yellow-700">
                                            Belum dikembalikan
                                        </span>
                                    </td>

                                    <td class="px-4 py-3">
                                        <form action="{{ route('petugas.pengembalian.update', $peminjaman->id) }}" method="POST">
                                            @csrf
                                            @method('PATCH')

                                            <input type="hidden" name="tanggal_kembali" value="{{ date('Y-m-d') }}">

                                            <button type="submit"
                                                onclick="return confirm('Konfirmasi pengembalian buku ini?')"
                                                class="rounded-lg bg-pink-600 px-3 py-2 text-xs font-semibold text-white hover:bg-pink-700">
                                                Kembalikan
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-4 py-8 text-center text-gray-500">
                                        Tidak ada buku yang perlu dikembalikan.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                </div>
            </div>

            <div class="mt-5">
                <a href="{{ route('dashboard.petugas') }}"
                    class="text-sm font-medium text-pink-600 hover:text-pink-800">
                    ← Kembali ke Dashboard
                </a>
            </div>

        </div>
    </div>
</x-app-layout>
