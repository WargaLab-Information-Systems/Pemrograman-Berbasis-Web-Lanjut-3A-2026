<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-pink-900 leading-tight">
            Data Pengembalian Buku
        </h2>
    </x-slot>

    <div class="min-h-screen py-10" style="background-color: #fce7f3;">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="rounded-2xl shadow-lg overflow-hidden"
                 style="background-color: #fff1f7; border: 1px solid #f3b5d0;">

                <div class="p-6 md:p-8">

                    <h3 class="text-lg font-bold text-pink-900 mb-5">
                        Daftar Peminjaman yang Disetujui
                    </h3>

                    @if (session('success'))
                        <div class="mb-4 p-4 rounded-lg bg-green-100 text-green-800">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="mb-4 p-4 rounded-lg bg-red-100 text-red-800">
                            {{ session('error') }}
                        </div>
                    @endif

                    <div class="overflow-x-auto">
                        <table class="w-full border-collapse">
                            <thead>
                                <tr class="bg-pink-200 text-pink-950">
                                    <th class="p-3 border">No</th>
                                    <th class="p-3 border">Nama Anggota</th>
                                    <th class="p-3 border">Judul Buku</th>
                                    <th class="p-3 border">Tanggal Pinjam</th>
                                    <th class="p-3 border">Aksi</th>
                                </tr>
                            </thead>

                            <tbody>
                                @forelse ($peminjamans as $peminjaman)
                                    <tr class="text-pink-950 text-center">
                                        <td class="p-3 border">
                                            {{ $loop->iteration }}
                                        </td>

                                        <td class="p-3 border">
                                            {{ $peminjaman->anggota->nama ?? '-' }}
                                        </td>

                                        <td class="p-3 border">
                                            {{ $peminjaman->buku->judul ?? '-' }}
                                        </td>

                                        <td class="p-3 border">
                                            {{ $peminjaman->tanggal_pinjam }}
                                        </td>

                                        <td class="p-3 border">
                                            <form
                                                action="{{ route('petugas.pengembalian.update', $peminjaman->id) }}"
                                                method="POST"
                                                onsubmit="return confirm('Apakah buku ini sudah dikembalikan?')">

                                                @csrf
                                                @method('PATCH')

                                                @can('record book returns')
                                                    <button type="submit"
                                                        class="px-4 py-2 rounded-lg text-white font-bold hover:opacity-80"
                                                        style="background-color: #be185d;">
                                                        Catat Pengembalian
                                                    </button>
                                                @endcan
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5"
                                            class="p-5 text-center text-pink-900">
                                            Belum ada buku yang perlu dikembalikan.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-6">
                        <a href="{{ route('petugas.dashboard') }}"
                           class="inline-block px-5 py-2 rounded-lg text-white font-bold"
                           style="background-color: #be185d;">
                            Kembali ke Dashboard
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>