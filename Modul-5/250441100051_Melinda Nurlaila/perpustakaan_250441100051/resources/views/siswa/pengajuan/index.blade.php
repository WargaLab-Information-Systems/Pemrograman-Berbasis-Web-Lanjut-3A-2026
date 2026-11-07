<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Ajukan Peminjaman Buku
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="mb-6">
                <h3 class="text-xl font-bold text-gray-800">
                    Pilih Buku
                </h3>
                <p class="text-sm text-gray-600 mt-2">
                    Pilih buku yang ingin kamu pinjam. Pengajuan akan menunggu persetujuan petugas.
                </p>
            </div>

            @if (session('success'))
                <div class="mb-5 rounded-lg bg-green-100 p-4 text-green-700">
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="mb-5 rounded-lg bg-red-100 p-4 text-red-700">
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <div class="mb-6 rounded-xl border border-pink-100 bg-white p-5 shadow-sm">
                <label for="pencarian-buku" class="mb-2 block text-sm font-semibold text-gray-700">
                    Cari Buku
                </label>

                <div class="relative">
                    <input
                        type="text"
                        id="pencarian-buku"
                        placeholder="Cari judul buku, penulis, atau kategori..."
                        class="w-full rounded-lg border-gray-300 py-3 pl-4 pr-12 focus:border-pink-500 focus:ring-pink-500"
                    >

                    <svg class="absolute right-4 top-3.5 text-pink-500" xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="11" cy="11" r="8"/>
                        <path d="m21 21-4.35-4.35"/>
                    </svg>
                </div>

                <p id="jumlah-buku" class="mt-3 text-sm text-gray-500">
                    Menampilkan {{ $bukus->count() }} buku
                </p>
            </div>

            <div id="daftar-buku" class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3">
                @forelse ($bukus as $buku)
                    @php
                        $slug = \Illuminate\Support\Str::slug($buku->judul);
                        $file = null;

                        foreach (['jpg', 'jpeg', 'png', 'webp'] as $ext) {
                            if (file_exists(public_path('images/buku/' . $slug . '.' . $ext))) {
                                $file = $slug . '.' . $ext;
                                break;
                            }
                        }
                    @endphp

                    <div
                        class="kartu-buku rounded-xl border border-pink-100 bg-white p-6 shadow-sm"
                        data-judul="{{ $buku->judul }}"
                        data-penulis="{{ $buku->penulis }}"
                        data-kategori="{{ $buku->kategori?->nama ?? '' }}"
                    >

                        @if ($file)
                            <img
                                src="{{ asset('images/buku/' . $file) }}"
                                alt="Sampul buku {{ $buku->judul }}"
                                class="mb-4 rounded-lg object-cover"
                                style="width: 120px; height: 170px;"
                            >
                        @else
                            <div class="mb-4 flex h-12 w-12 items-center justify-center rounded-lg bg-pink-100 text-pink-700">
                                <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/>
                                    <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2Z"/>
                                </svg>
                            </div>
                        @endif

                        <h4 class="text-lg font-bold text-gray-800">
                            {{ $buku->judul }}
                        </h4>

                        <p class="mt-2 text-sm text-gray-600">
                            Penulis: {{ $buku->penulis }}
                        </p>

                        <p class="text-sm text-gray-600">
                            Kategori: {{ $buku->kategori?->nama ?? '-' }}
                        </p>

                        <p class="text-sm text-gray-600">
                            Tahun terbit: {{ $buku->tahun_terbit }}
                        </p>

                        <form action="{{ route('siswa.pengajuan.store') }}" method="POST" class="mt-5">
                            @csrf
                            <input type="hidden" name="buku_id" value="{{ $buku->id }}">

                            <button type="submit" class="w-full rounded-lg bg-pink-600 px-4 py-2.5 font-semibold text-white transition hover:bg-pink-700">
                                Ajukan Peminjaman
                            </button>
                        </form>
                    </div>
                @empty
                    <div class="col-span-full rounded-xl border border-pink-100 bg-white p-8 text-center text-gray-600">
                        Belum ada buku yang tersedia.
                    </div>
                @endforelse
            </div>

            <div id="buku-tidak-ditemukan" class="hidden rounded-xl border border-pink-100 bg-white p-8 text-center text-gray-600">
                Buku yang kamu cari tidak ditemukan.
            </div>

            <div class="mt-8">
                <a href="{{ route('dashboard.siswa') }}" class="inline-flex rounded-lg border border-pink-600 px-5 py-2.5 font-semibold text-pink-700 transition hover:bg-pink-50">
                    Kembali ke Dashboard
                </a>
            </div>

        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const pencarian = document.getElementById('pencarian-buku');
            const kartuBuku = document.querySelectorAll('.kartu-buku');
            const pesanKosong = document.getElementById('buku-tidak-ditemukan');
            const jumlahBuku = document.getElementById('jumlah-buku');

            pencarian.addEventListener('input', function () {
                const kataKunci = this.value.toLowerCase().trim();
                let jumlahHasil = 0;

                kartuBuku.forEach(function (kartu) {
                    const judul = kartu.dataset.judul.toLowerCase();
                    const penulis = kartu.dataset.penulis.toLowerCase();
                    const kategori = kartu.dataset.kategori.toLowerCase();

                    const cocok = judul.includes(kataKunci) ||
                        penulis.includes(kataKunci) ||
                        kategori.includes(kataKunci);

                    kartu.classList.toggle('hidden', !cocok);

                    if (cocok) {
                        jumlahHasil++;
                    }
                });

                jumlahBuku.textContent = 'Menampilkan ' + jumlahHasil + ' dari ' + kartuBuku.length + ' buku';

                pesanKosong.classList.toggle('hidden', jumlahHasil > 0 || kartuBuku.length === 0);
            });
        });
    </script>
</x-app-layout>