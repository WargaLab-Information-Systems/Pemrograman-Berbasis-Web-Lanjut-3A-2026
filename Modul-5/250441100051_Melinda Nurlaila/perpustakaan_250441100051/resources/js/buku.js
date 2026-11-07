document.addEventListener('DOMContentLoaded', () => {
    const daftarBuku = document.getElementById('daftar-buku');
    const pesan = document.getElementById('pesan');
    const formBuku = document.getElementById('form-buku');
    const formPencarian = document.getElementById('form-pencarian');
    const inputKeyword = document.getElementById('keyword');
    const judulForm = document.getElementById('judul-form');
    const tombolSimpan = document.getElementById('tombol-simpan');
    const tombolBatal = document.getElementById('tombol-batal');

    const tombolSebelumnya = document.getElementById('halaman-sebelumnya');
    const tombolSelanjutnya = document.getElementById('halaman-selanjutnya');
    const infoHalaman = document.getElementById('info-halaman');

    const bolehKelola =
        document.querySelector('.book-section')?.dataset.canManage === '1';
    const csrfToken =
        document.querySelector('meta[name="csrf-token"]')?.content ?? '';

    let idBukuDiubah = null;
    let halamanSekarang = 1;
    let halamanTerakhir = 1;

    function tampilkanPesan(teks, warna = 'green') {
        pesan.textContent = teks;
        pesan.dataset.status = warna === 'red' ? 'error' : 'info';
    }

    function buatSel(teks) {
        const sel = document.createElement('td');
        sel.textContent = teks ?? '-';
        return sel;
    }

    function tampilkanStatusTabel(teks) {
        daftarBuku.innerHTML = '';

        const baris = document.createElement('tr');
        const sel = buatSel(teks);
        sel.colSpan = 5;

        baris.appendChild(sel);
        daftarBuku.appendChild(baris);
    }

    function batalUbah() {
        idBukuDiubah = null;
        if (!formBuku) return;

        formBuku.reset();

        judulForm.textContent = 'Tambah Buku';
        tombolSimpan.textContent = 'Tambah Buku';
        tombolBatal.hidden = true;
    }

    // Form tambah/ubah hanya ada untuk user yang boleh mengelola buku
    if (tombolBatal) {
        tombolBatal.addEventListener('click', () => {
            batalUbah();
            tampilkanPesan('Mode ubah dibatalkan.');
        });
    }

    async function tampilkanBuku(
        keyword = inputKeyword.value,
        halaman = halamanSekarang
    ) {
        tampilkanStatusTabel('Memuat data buku...');

        tombolSebelumnya.disabled = true;
        tombolSelanjutnya.disabled = true;

        try {
            const params = new URLSearchParams();

            if (keyword.trim() !== '') {
                params.append('cari', keyword.trim());
            }

            params.append('page', halaman);

            const response = await fetch(
                '/api/buku?' + params.toString(),
                {
                    credentials: 'same-origin',
                    headers: {
                        Accept: 'application/json'
                    }
                }
            );

            const hasil = await response.json();

            if (!response.ok) {
                throw new Error(
                    hasil.message || 'Gagal mengambil data buku.'
                );
            }

            
            const meta = hasil.meta ?? {};

            halamanSekarang = Number(meta.current_page ?? halaman);
            halamanTerakhir = Number(meta.last_page ?? 1);

            infoHalaman.textContent =
                `Halaman ${halamanSekarang} dari ${halamanTerakhir}`;

            tombolSebelumnya.disabled = halamanSekarang <= 1;
            tombolSelanjutnya.disabled = halamanSekarang >= halamanTerakhir;


            daftarBuku.innerHTML = '';

            if (!Array.isArray(hasil.data) || hasil.data.length === 0) {
                tampilkanStatusTabel('Buku tidak ditemukan.');
                return;
            }

            hasil.data.forEach(item => {
                const baris = document.createElement('tr');

                baris.appendChild(buatSel(item.kategori));
                baris.appendChild(buatSel(item.judul));
                baris.appendChild(buatSel(item.penulis));
                baris.appendChild(buatSel(item.tahun_terbit));

                const selAksi = document.createElement('td');

                const tombolDetail = document.createElement('a');
                tombolDetail.href =
                    '/buku/' + encodeURIComponent(item.id);
                tombolDetail.className = 'primary-button';
                tombolDetail.textContent = 'Detail';

                selAksi.appendChild(tombolDetail);

                if (bolehKelola && formBuku) {
                const tombolUbah = document.createElement('button');
                tombolUbah.type = 'button';
                tombolUbah.className = 'secondary-button';
                tombolUbah.textContent = 'Ubah';

                tombolUbah.addEventListener('click', () => {
                    idBukuDiubah = item.id;

                    formBuku.elements.kategori_id.value =
                        item.kategori_id ?? '';

                    formBuku.elements.judul.value =
                        item.judul ?? '';

                    formBuku.elements.penulis.value =
                        item.penulis ?? '';

                    formBuku.elements.tahun_terbit.value =
                        item.tahun_terbit ?? '';

                    judulForm.textContent = 'Ubah Buku';
                    tombolSimpan.textContent = 'Simpan Perubahan';
                    tombolBatal.hidden = false;

                    tampilkanPesan(
                        'Silakan ubah data buku yang dipilih.'
                    );

                    formBuku.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                });

                const tombolHapus = document.createElement('button');
                tombolHapus.type = 'button';
                tombolHapus.className = 'danger-button';
                tombolHapus.textContent = 'Hapus';

                tombolHapus.addEventListener('click', async () => {
                    const yakin = confirm(
                        'Yakin ingin menghapus buku "' +
                        (item.judul ?? '') + '"?'
                    );

                    if (!yakin) return;

                    try {
                        tampilkanPesan('Sedang menghapus buku...');

                        const response = await fetch(
                            '/api/buku/' + encodeURIComponent(item.id),
                            {
                                method: 'DELETE',
                                headers: {
                                    Accept: 'application/json',
                                    'X-CSRF-TOKEN': csrfToken
                                }
                            }
                        );

                        const hasil = await response.json().catch(() => ({}));

                        if (!response.ok) {
                            throw new Error(
                                hasil.message || 'Buku gagal dihapus.'
                            );
                        }

                        if (String(idBukuDiubah) === String(item.id)) {
                            batalUbah();
                        }

                        tampilkanPesan(
                            hasil.message || 'Buku berhasil dihapus!'
                        );

                        const jumlahData = hasil.data?.length ?? 0;
                        let halamanTujuan = halamanSekarang;

                        if (
                            jumlahData === 0 &&
                            halamanSekarang > 1
                        ) {
                            halamanTujuan = halamanSekarang - 1;
                        }

                        await tampilkanBuku(
                            inputKeyword.value,
                            halamanTujuan
                        );
                    } catch (error) {
                        tampilkanPesan(
                            error.message ||
                            'Terjadi kesalahan saat menghapus buku.',
                            'red'
                        );
                    }
                });

                selAksi.append(
                    document.createTextNode(' '),
                    tombolUbah,
                    document.createTextNode(' '),
                    tombolHapus
                );
                }

                baris.appendChild(selAksi);
                daftarBuku.appendChild(baris);
            });
        } catch (error) {
            tampilkanStatusTabel('Data buku gagal dimuat.');

            infoHalaman.textContent = 'Halaman tidak tersedia';

            tampilkanPesan(
                error.message ||
                'Terjadi kesalahan saat mengambil data.',
                'red'
            );
        }
    }

    tombolSebelumnya.addEventListener('click', () => {
        if (halamanSekarang > 1) {
            tampilkanBuku(
                inputKeyword.value,
                halamanSekarang - 1
            );
        }
    });

    tombolSelanjutnya.addEventListener('click', () => {
        if (halamanSekarang < halamanTerakhir) {
            tampilkanBuku(
                inputKeyword.value,
                halamanSekarang + 1
            );
        }
    });

    if (formBuku) formBuku.addEventListener('submit', async event => {
        event.preventDefault();

        const sedangMengubah = idBukuDiubah !== null;

        tampilkanPesan(
            sedangMengubah
                ? 'Sedang menyimpan perubahan...'
                : 'Sedang menyimpan buku...'
        );

        const data = Object.fromEntries(
            new FormData(formBuku).entries()
        );

        data.kategori_id = Number(data.kategori_id);
        data.tahun_terbit = Number(data.tahun_terbit);

        try {
            const url = sedangMengubah
                ? '/api/buku/' + encodeURIComponent(idBukuDiubah)
                : '/api/buku';

            const response = await fetch(url, {
                method: sedangMengubah ? 'PUT' : 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    Accept: 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify(data)
            });

            const hasil = await response.json().catch(() => ({}));

            if (!response.ok) {
                const detailError = hasil.errors
                    ? Object.values(hasil.errors).flat().join(' ')
                    : hasil.message;

                throw new Error(
                    detailError ||
                    (sedangMengubah
                        ? 'Buku gagal diperbarui.'
                        : 'Buku gagal ditambahkan.')
                );
            }

            batalUbah();

            tampilkanPesan(
                hasil.message ||
                (sedangMengubah
                    ? 'Buku berhasil diperbarui!'
                    : 'Buku berhasil ditambahkan!')
            );

            await tampilkanBuku(inputKeyword.value, 1);
        } catch (error) {
            tampilkanPesan(
                error.message ||
                'Terjadi kesalahan saat menyimpan buku.',
                'red'
            );
        }
    });

    formPencarian.addEventListener('submit', event => {
        event.preventDefault();
        tampilkanBuku(inputKeyword.value, 1);
    });

    tampilkanBuku('', 1);
});