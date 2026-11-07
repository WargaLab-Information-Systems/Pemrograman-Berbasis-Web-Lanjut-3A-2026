<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">
            Tambah Peminjaman
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-3xl px-4 sm:px-6 lg:px-8">
            <div class="rounded-xl bg-white p-6 shadow-sm">

                <form action="{{ route('petugas.peminjaman.store') }}" method="POST">
                    @csrf

                    <div class="mb-5">
                        <label for="anggota_id" class="mb-2 block text-sm font-medium text-gray-700">
                            Nama Anggota
                        </label>

                        <select name="anggota_id" id="anggota_id"
                            class="w-full rounded-lg border-gray-300 focus:border-pink-500 focus:ring-pink-500">
                            <option value="">Pilih Anggota</option>
                            @foreach ($anggotas as $anggota)
                                <option value="{{ $anggota->id }}" {{ old('anggota_id') == $anggota->id ? 'selected' : '' }}>
                                    {{ $anggota->nama }}
                                </option>
                            @endforeach
                        </select>

                        @error('anggota_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-5">
                        <label for="buku_id" class="mb-2 block text-sm font-medium text-gray-700">
                            Judul Buku
                        </label>

                        <select name="buku_id" id="buku_id"
                            class="w-full rounded-lg border-gray-300 focus:border-pink-500 focus:ring-pink-500">
                            <option value="">Pilih Buku</option>
                            @foreach ($bukus as $buku)
                                <option value="{{ $buku->id }}" {{ old('buku_id') == $buku->id ? 'selected' : '' }}>
                                    {{ $buku->judul }}
                                </option>
                            @endforeach
                        </select>

                        @error('buku_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-6">
                        <label for="tanggal_pinjam" class="mb-2 block text-sm font-medium text-gray-700">
                            Tanggal Peminjaman
                        </label>

                        <input type="date" name="tanggal_pinjam" id="tanggal_pinjam"
                            value="{{ old('tanggal_pinjam', date('Y-m-d')) }}"
                            class="w-full rounded-lg border-gray-300 focus:border-pink-500 focus:ring-pink-500">

                        @error('tanggal_pinjam')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex justify-end gap-3">
                        <a href="{{ route('petugas.peminjaman.index') }}"
                            class="rounded-lg border border-gray-300 px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50">
                            Batal
                        </a>

                        <button type="submit"
                            class="rounded-lg bg-pink-600 px-4 py-2 text-sm font-semibold text-white hover:bg-pink-700">
                            Simpan Peminjaman
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
