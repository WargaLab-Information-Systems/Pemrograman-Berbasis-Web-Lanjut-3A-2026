<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-pink-900">
            Data Peminjaman Buku Admin
        </h2>
    </x-slot>

    <div class="min-h-screen py-10" style="background-color: #fce7f3;">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="rounded-2xl shadow-lg p-6"
                 style="background-color: #fff1f7; border: 1px solid #f3b5d0;">

                <a href="{{ route('admin.dashboard') }}"
                   class="inline-block px-5 py-2 mb-6 rounded-lg text-white font-semibold"
                   style="background-color: #be185d;">
                    Kembali ke Dashboard Admin
                </a>

                <h3 class="text-xl font-bold text-pink-900 mb-5">
                    Daftar Pengajuan Peminjaman
                </h3>

                @if(session('success'))
                    <div class="p-3 mb-4 rounded-lg text-green-800 bg-green-100">
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="p-3 mb-4 rounded-lg text-red-800 bg-red-100">
                        {{ session('error') }}
                    </div>
                @endif

                @if($errors->any())
                    <div class="p-3 mb-4 rounded-lg text-red-800 bg-red-100">
                        {{ $errors->first() }}
                    </div>
                @endif

                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left">
                        <thead style="background-color: #f9a8d4;"
                               class="text-pink-950">
                            <tr>
                                <th class="p-3">No</th>
                                <th class="p-3">ID Anggota</th>
                                <th class="p-3">Judul Buku</th>
                                <th class="p-3">Tanggal Pinjam</th>
                                <th class="p-3">Status</th>
                                <th class="p-3">Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse($peminjamans as $peminjaman)
                                <tr class="border-b border-pink-200">
                                    <td class="p-3">
                                        {{ $loop->iteration }}
                                    </td>

                                    <td class="p-3">
                                        {{ $peminjaman->anggota_id }}
                                    </td>

                                    <td class="p-3">
                                        {{ $peminjaman->buku->judul ?? 'Buku tidak ditemukan' }}
                                    </td>

                                    <td class="p-3">
                                        {{ $peminjaman->tanggal_pinjam }}
                                    </td>

                                    <td class="p-3">
                                        @if($peminjaman->status === 'menunggu')
                                            <span class="px-3 py-1 rounded-full bg-yellow-100 text-yellow-800">
                                                Menunggu
                                            </span>

                                        @elseif($peminjaman->status === 'disetujui')
                                            <span class="px-3 py-1 rounded-full bg-green-100 text-green-800">
                                                Disetujui
                                            </span>

                                        @elseif($peminjaman->status === 'ditolak')
                                            <span class="px-3 py-1 rounded-full bg-red-100 text-red-800">
                                                Ditolak
                                            </span>

                                        @elseif($peminjaman->status === 'dikembalikan')
                                            <span class="px-3 py-1 rounded-full bg-blue-100 text-blue-800">
                                                Dikembalikan
                                            </span>
                                        @endif
                                    </td>

                                    <td class="p-3">
                                        @if($peminjaman->status === 'menunggu')
                                            <div class="flex flex-wrap gap-2">

                                                <form action="{{ route('admin.peminjaman.status', $peminjaman->id) }}"
                                                      method="POST">
                                                    @csrf
                                                    @method('PATCH')

                                                    <input type="hidden"
                                                           name="status"
                                                           value="disetujui">

                                                    <button type="submit"
                                                            onclick="return confirm('Setujui pengajuan ini?')"
                                                            class="px-3 py-2 rounded-lg text-white"
                                                            style="background-color: #be185d;">
                                                        Setujui
                                                    </button>
                                                </form>

                                                <form action="{{ route('admin.peminjaman.status', $peminjaman->id) }}"
                                                      method="POST">
                                                    @csrf
                                                    @method('PATCH')

                                                    <input type="hidden"
                                                           name="status"
                                                           value="ditolak">

                                                    <button type="submit"
                                                            onclick="return confirm('Tolak pengajuan ini?')"
                                                            class="px-3 py-2 rounded-lg text-white bg-gray-600"
                                                            style="background-color: #db4684;">
                                                        Tolak
                                                    </button>
                                                </form>

                                            </div>
                                        @else
                                            <span class="text-gray-500">
                                                Sudah diproses
                                            </span>
                                        @endif
                                    </td>
                                </tr>

                            @empty
                                <tr>
                                    <td colspan="6"
                                        class="p-6 text-center text-pink-800">
                                        Belum ada pengajuan peminjaman.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>