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

                    <div class="rounded-xl p-6 mb-8"
                         style="background: linear-gradient(135deg, #be185d, #db2777);">
                        <h3 class="text-2xl font-bold text-white mb-2">
                            Pengembalian Buku
                        </h3>
                        <p class="text-pink-100">
                            Kelola proses pengembalian buku perpustakaan.
                        </p>
                    </div>

                    @if (session('success'))
                        <div class="mb-5 p-4 rounded-lg bg-green-100 text-green-800">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="mb-5 p-4 rounded-lg bg-red-100 text-red-800">
                            {{ session('error') }}
                        </div>
                    @endif

                    <div class="overflow-x-auto rounded-xl border border-pink-200">
                        <table class="w-full text-sm text-left">
                            <thead style="background-color: #f9a8d4;"
                                   class="text-pink-950 uppercase">
                                <tr>
                                    <th class="px-5 py-4">No</th>
                                    <th class="px-5 py-4">ID Anggota</th>
                                    <th class="px-5 py-4">Judul Buku</th>
                                    <th class="px-5 py-4">Tanggal Pinjam</th>
                                    <th class="px-5 py-4">Aksi</th>
                                </tr>
                            </thead>

                            <tbody class="divide-y divide-pink-100">
                                @forelse ($peminjamans as $item)
                                    <tr class="hover:bg-pink-50">
                                        <td class="px-5 py-4">
                                            {{ $loop->iteration }}
                                        </td>

                                        <td class="px-5 py-4">
                                            {{ $item->anggota_id }}
                                        </td>

                                        <td class="px-5 py-4 font-semibold text-pink-950">
                                            {{ $item->buku->judul ?? '-' }}
                                        </td>

                                        <td class="px-5 py-4">
                                            {{ $item->tanggal_pinjam }}
                                        </td>

                                        <td class="px-5 py-4">
                                            <form action="{{ route('admin.pengembalian.update', $item->id) }}"
                                                  method="POST"
                                                  onsubmit="return confirm('Konfirmasi pengembalian buku ini?')">
                                                @csrf
                                                @method('PATCH')

                                                <button type="submit"
                                                        class="px-4 py-2 rounded-lg text-white font-semibold hover:opacity-90"
                                                        style="background-color: #be185d;">
                                                    Konfirmasi Pengembalian
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5"
                                            class="px-5 py-8 text-center text-pink-800">
                                            Tidak ada buku yang perlu dikembalikan.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-6">
                        <a href="{{ route('admin.dashboard') }}"
                           class="inline-block px-5 py-2 rounded-lg text-white font-semibold"
                           style="background-color: #be185d;">
                            ← Kembali ke Dashboard
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>