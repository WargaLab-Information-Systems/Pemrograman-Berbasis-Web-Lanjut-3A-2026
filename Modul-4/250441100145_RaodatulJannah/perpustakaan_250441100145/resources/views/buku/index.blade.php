@extends('layouts.app')

@section('title', 'Daftar Buku')

@section('content')

<style>
    .api-wrapper {
        max-width: 1100px;
        margin: 0 auto;
    }

    .api-form {
        background: white;
        padding: 24px;
        border-radius: 12px;
        margin-bottom: 28px;
        box-shadow: 0 4px 14px rgba(0, 0, 0, 0.06);
    }

    .api-form h3 {
        margin-bottom: 18px;
    }

    .api-fields {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 15px;
    }

    .api-fields label {
        display: block;
        margin-bottom: 6px;
        font-weight: 600;
    }

    .api-fields input,
    .api-fields select {
        width: 100%;
        padding: 10px 12px;
        border: 1px solid #ddd;
        border-radius: 8px;
        box-sizing: border-box;
    }

    .api-buttons {
        display: flex;
        gap: 10px;
        margin-top: 18px;
    }

    .api-button {
        border: none;
        border-radius: 7px;
        padding: 10px 16px;
        cursor: pointer;
        font-size: 14px;
    }

    .api-save {
        background: #b91c1c;
        color: white;
    }

    .api-cancel {
        background: #e5e7eb;
        color: #222;
    }

    .api-edit {
        background: #f59e0b;
        color: white;
    }

    .api-delete {
        background: #dc2626;
        color: white;
    }

    .api-message {
        padding: 12px 15px;
        border-radius: 8px;
        margin-bottom: 16px;
        display: none;
    }

    .api-success {
        display: block;
        background: #dcfce7;
        color: #166534;
    }

    .api-error {
        display: block;
        background: #fee2e2;
        color: #991b1b;
    }

    .api-actions {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
        margin-top: 12px;
    }

    .api-loading {
        padding: 20px;
        text-align: center;
    }

    @media (max-width: 600px) {
        .api-fields {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="api-wrapper">

    <div class="page-header">
        <h2>Daftar Buku</h2>
        <p>
            Berikut adalah koleksi buku yang tersedia
            di Perpustakaan Digital.
        </p>
    </div>

    <div class="api-form">
        <h3 id="formTitle">Tambah Buku</h3>

        <div id="apiMessage" class="api-message" role="alert"></div>

        <form id="bukuForm">
            @csrf

            <input type="hidden" id="bukuId">

            <div class="api-fields">
                <div>
                    <label for="kategori_id">Kategori</label>
                    <select id="kategori_id" required>
                        <option value="">Pilih kategori</option>

                        @foreach ($kategori as $item)
                            <option value="{{ $item->id }}">
                                {{ $item->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="judul">Judul Buku</label>
                    <input
                        type="text"
                        id="judul"
                        maxlength="150"
                        required
                        placeholder="Masukkan judul buku">
                </div>

                <div>
                    <label for="penulis">Penulis</label>
                    <input
                        type="text"
                        id="penulis"
                        maxlength="100"
                        required
                        placeholder="Masukkan nama penulis">
                </div>

                <div>
                    <label for="tahun_terbit">Tahun Terbit</label>
                    <input
                        type="number"
                        id="tahun_terbit"
                        min="1900"
                        max="2026"
                        required
                        placeholder="Contoh: 2020">
                </div>
            </div>

            <div class="api-buttons">
                <button
                    type="submit"
                    class="api-button api-save"
                    id="submitButton">
                    Simpan Buku
                </button>

                <button
                    type="button"
                    class="api-button api-cancel"
                    id="cancelButton"
                    hidden>
                    Batal Ubah
                </button>
            </div>
        </form>
    </div>

    <div id="bookList" class="book-grid">
        <p class="api-loading">Memuat data buku...</p>
    </div>

</div>

<script>
    const API_URL = '/api/buku';

    const bukuForm = document.getElementById('bukuForm');
    const bukuId = document.getElementById('bukuId');
    const kategoriInput = document.getElementById('kategori_id');
    const judulInput = document.getElementById('judul');
    const penulisInput = document.getElementById('penulis');
    const tahunInput = document.getElementById('tahun_terbit');

    const bookList = document.getElementById('bookList');
    const apiMessage = document.getElementById('apiMessage');
    const formTitle = document.getElementById('formTitle');
    const submitButton = document.getElementById('submitButton');
    const cancelButton = document.getElementById('cancelButton');

    let daftarBuku = [];

    function tampilkanPesan(pesan, tipe = 'success') {
        apiMessage.textContent = pesan;
        apiMessage.className =
            'api-message ' +
            (tipe === 'error' ? 'api-error' : 'api-success');
    }

    function hapusPesan() {
        apiMessage.textContent = '';
        apiMessage.className = 'api-message';
    }

    async function bacaRespons(response) {
        const data = await response.json().catch(() => ({}));

        if (!response.ok) {
            let pesan = data.message || 'Permintaan gagal diproses.';

            if (data.errors) {
                pesan = Object.values(data.errors)
                    .flat()
                    .join(' ');
            }

            throw new Error(pesan);
        }

        return data;
    }

    // Mengambil data buku menggunakan GET dan Fetch API.
    async function ambilBuku() {
        bookList.innerHTML =
            '<p class="api-loading">Memuat data buku...</p>';

        try {
            const response = await fetch(API_URL, {
                headers: {
                    'Accept': 'application/json'
                }
            });

            const hasil = await bacaRespons(response);

            daftarBuku = Array.isArray(hasil.data)
                ? hasil.data
                : [];

            tampilkanBuku(daftarBuku);

        } catch (error) {
            bookList.innerHTML = '';
            tampilkanPesan(
                'Gagal mengambil data buku: ' + error.message,
                'error'
            );
        }
    }

    function buatElemen(tag, teks, className = '') {
        const elemen = document.createElement(tag);
        elemen.textContent = teks ?? '';

        if (className) {
            elemen.className = className;
        }

        return elemen;
    }

    function tampilkanBuku(dataBuku) {
        bookList.innerHTML = '';

        if (dataBuku.length === 0) {
            bookList.appendChild(
                buatElemen('p', 'Belum ada data buku.')
            );
            return;
        }

        dataBuku.forEach(buku => {
            const card = document.createElement('div');
            card.className = 'book-card';

            const cover = document.createElement('div');
            cover.className = 'book-cover';

            const gambar = document.createElement('img');

            const gambarBuku = {
                1: 'images/laskar pelangi.jpg',
                2: 'images/bumi.jpg',
                3: 'images/negeri 5 menara.jpg',
                4: 'images/filosofi teras.jpg',
                5: 'images/atomic habits.png'
            };

            gambar.src = gambarBuku[buku.id]
                ? '/' + gambarBuku[buku.id]
                : '/images/atomic habits.png';

            gambar.alt = buku.judul || 'Sampul buku';
            gambar.onerror = function () {
                this.style.display = 'none';
            };

            cover.appendChild(gambar);

            const content = document.createElement('div');
            content.className = 'book-content';

            content.appendChild(
                buatElemen('span', buku.kategori || '-', 'book-category')
            );

            content.appendChild(
                buatElemen('h3', buku.judul || 'Tanpa judul')
            );

            content.appendChild(
                buatElemen('p', 'Oleh ' + (buku.penulis || '-'), 'book-author')
            );

            content.appendChild(
                buatElemen('p', 'Tahun terbit: ' + (buku.tahun ?? '-'), 'book-year')
            );

            const actions = document.createElement('div');
            actions.className = 'api-actions';

            const detail = document.createElement('a');
            detail.href = '/buku/' + encodeURIComponent(buku.id);
            detail.className = 'btn';
            detail.textContent = 'Lihat Detail';

            const edit = buatElemen(
                'button',
                'Ubah',
                'api-button api-edit'
            );
            edit.type = 'button';
            edit.addEventListener('click', () => isiFormUbah(buku));

            const hapus = buatElemen(
                'button',
                'Hapus',
                'api-button api-delete'
            );
            hapus.type = 'button';
            hapus.addEventListener('click', () => hapusBuku(buku.id));

            actions.append(detail, edit, hapus);
            content.appendChild(actions);
            card.append(cover, content);
            bookList.appendChild(card);
        });
    }

    function resetForm() {
        bukuForm.reset();
        bukuId.value = '';

        formTitle.textContent = 'Tambah Buku';
        submitButton.textContent = 'Simpan Buku';
        cancelButton.hidden = true;
    }

    // POST untuk tambah, PUT untuk ubah buku.
    bukuForm.addEventListener('submit', async function (event) {
        event.preventDefault();
        hapusPesan();

        const id = bukuId.value;

        const dataBuku = {
            kategori_id: Number(kategoriInput.value),
            judul: judulInput.value.trim(),
            penulis: penulisInput.value.trim(),
            tahun_terbit: Number(tahunInput.value)
        };

        const sedangUbah = Boolean(id);

        try {
            const response = await fetch(
                sedangUbah
                    ? `${API_URL}/${encodeURIComponent(id)}`
                    : API_URL,
                {
                    method: sedangUbah ? 'PUT' : 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify(dataBuku)
                }
            );

            const hasil = await bacaRespons(response);

            resetForm();

            tampilkanPesan(
                hasil.message ||
                (sedangUbah
                    ? 'Buku berhasil diperbarui.'
                    : 'Buku berhasil ditambahkan.')
            );

            await ambilBuku();

        } catch (error) {
            tampilkanPesan(
                'Gagal menyimpan buku: ' + error.message,
                'error'
            );
        }
    });

    function isiFormUbah(buku) {
        hapusPesan();

        bukuId.value = buku.id;
        kategoriInput.value = buku.kategori_id ?? '';
        judulInput.value = buku.judul ?? '';
        penulisInput.value = buku.penulis ?? '';
        tahunInput.value = buku.tahun ?? '';

        formTitle.textContent = 'Ubah Buku';
        submitButton.textContent = 'Simpan Perubahan';
        cancelButton.hidden = false;

        bukuForm.scrollIntoView({
            behavior: 'smooth',
            block: 'start'
        });
    }

    cancelButton.addEventListener('click', function () {
        resetForm();
        hapusPesan();
    });

    // Menghapus buku menggunakan DELETE.
    async function hapusBuku(id) {
        const setuju = confirm(
            'Apakah kamu yakin ingin menghapus buku ini?'
        );

        if (!setuju) {
            return;
        }

        hapusPesan();

        try {
            const response = await fetch(
                `${API_URL}/${encodeURIComponent(id)}`,
                {
                    method: 'DELETE',
                    headers: {
                        'Accept': 'application/json'
                    }
                }
            );

            const hasil = await bacaRespons(response);

            if (String(bukuId.value) === String(id)) {
                resetForm();
            }

            tampilkanPesan(
                hasil.message || 'Buku berhasil dihapus.'
            );

            await ambilBuku();

        } catch (error) {
            tampilkanPesan(
                'Gagal menghapus buku: ' + error.message,
                'error'
            );
        }
    }

    // Error GET, POST, PUT, dan DELETE ditangani dengan
    // pemeriksaan response.ok serta try/catch.
    ambilBuku();
</script>

@endsection