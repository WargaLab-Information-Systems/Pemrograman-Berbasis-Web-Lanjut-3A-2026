<x-app-layout>
    <section class="book-section" data-can-manage="{{ auth()->user()->can('kelola data buku') ? '1' : '0' }}">
        <div class="page-header">
            <span class="hero-label">KOLEKSI PERPUSTAKAAN</span>
            <h2>{{ !empty($kelola) ? 'Kelola Data Buku' : 'Daftar Buku' }}</h2>
            <p>Berikut adalah koleksi buku yang tersedia di perpustakaan.</p>
        </div>

        @can('kelola data buku')
            <h3 id="judul-form">Tambah Buku</h3>

            <form id="form-buku" class="book-form">
                <select name="kategori_id" class="search-input" required>
                    <option value="">Pilih kategori</option>
                    @foreach ($kategoris as $kategori)
                        <option value="{{ $kategori->id }}">
                            {{ $kategori->nama }}
                        </option>
                    @endforeach
                </select>

                <input
                    type="text"
                    name="judul"
                    class="search-input"
                    placeholder="Judul buku"
                    minlength="3"
                    maxlength="150"
                    required
                >

                <input
                    type="text"
                    name="penulis"
                    class="search-input"
                    placeholder="Nama penulis"
                    minlength="3"
                    maxlength="100"
                    required
                >

                <input
                    type="number"
                    name="tahun_terbit"
                    class="search-input"
                    placeholder="Tahun terbit"
                    min="1900"
                    max="{{ date('Y') }}"
                    required
                >

                <div class="book-form-actions">
                    <button
                        type="submit"
                        id="tombol-simpan"
                        class="primary-button"
                    >
                        Tambah Buku
                    </button>

                    <button
                        type="button"
                        id="tombol-batal"
                        class="secondary-button"
                        hidden
                    >
                        Batal Ubah
                    </button>
                </div>
            </form>
        @endcan

        <p
            id="pesan"
            class="status-message"
            role="status"
            aria-live="polite"
        ></p>

        <form id="form-pencarian" class="search-form">
            <input
                type="text"
                id="keyword"
                name="q"
                class="search-input"
                placeholder="Cari judul, penulis, atau kategori..."
            >

            <button type="submit" class="primary-button">
                Cari
            </button>
        </form>

        <div class="table-container">
            <table class="book-table">
                <thead>
                    <tr>
                        <th>Kategori</th>
                        <th>Judul</th>
                        <th>Penulis</th>
                        <th>Tahun Terbit</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody id="daftar-buku">
                    <tr>
                        <td colspan="5">Memuat data buku...</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="pagination" id="pagination">
            <button
                type="button"
                id="halaman-sebelumnya"
                class="secondary-button"
                disabled
            >
                Sebelumnya
            </button>

            <span id="info-halaman">Halaman 1</span>

            <button
                type="button"
                id="halaman-selanjutnya"
                class="primary-button"
                disabled
            >
                Selanjutnya
            </button>
        </div>
    </section>
<script src="{{ asset('js/buku.js') }}?v=4" defer></script>

</x-app-layout>