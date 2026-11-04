document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('form-buku');
    const alertArea = document.getElementById('alert-area');
    const tbody = document.getElementById('tbody-buku');
    const btnBatal = document.getElementById('btn-batal');
    const formTitle = document.getElementById('form-title');

    // CEK ROLE DARI HTML (Kita taruh data-role di body nanti)
    const userRole = document.body.getAttribute('data-role') || '';
    const isAdminOrPetugas = (userRole === 'admin' || userRole === 'petugas');
    const isSiswa = (userRole === 'siswa');

    function showAlert(message, type = 'success') {
        if (!alertArea) return;
        alertArea.innerHTML = `
            <div class="alert alert-${type} alert-dismissible fade show" role="alert">
                ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        `;
    }

    function clearErrors() {
        document.querySelectorAll('.text-danger').forEach(el => el.innerText = '');
    }
 
    function resetForm() {
        if (!form) return;
        form.reset();
        document.getElementById('buku-id').value = '';
        formTitle.innerText = 'Tambah Buku Baru';
        btnBatal.classList.add('d-none');
        clearErrors();
    }

    async function fetchBuku() {
        if (!tbody) return;
        try {
            tbody.innerHTML = '<tr><td colspan="6" class="text-center">Memuat data...</td></tr>';
            const response = await fetch('/api/buku', {
                headers: { 'Accept': 'application/json' }
            });

            if (!response.ok) throw new Error('Gagal mengambil data dari server.');

            const result = await response.json();
            tbody.innerHTML = '';
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';

            result.data.forEach((item, index) => {
                let tombolAksi = '';
                
                // KALAU ADMIN/PETUGAS
                if (isAdminOrPetugas) {
                    tombolAksi = `
                        <button class="btn btn-sm btn-warning" onclick="editBuku(${item.id})">Ubah</button>
                        <button class="btn btn-sm btn-danger" onclick="hapusBuku(${item.id})">Hapus</button>
                    `;
                } 
                // KALAU SISWA
                else if (isSiswa) {
                    tombolAksi = `
                        <form action="/buku/${item.id}/pinjam" method="POST" style="display:inline;">
                            <input type="hidden" name="_token" value="${csrfToken}">
                            <button type="submit" class="btn btn-sm btn-primary" style="background:#2c3e50; color:white; padding:8px 15px; border-radius:6px; font-weight:bold; cursor:pointer;">Pinjam</button>
                        </form>
                    `;
                } else {
                    tombolAksi = `<span class="text-muted">-</span>`;
                }

                const row = `
                    <tr>
                        <td>${index + 1}</td>
                        <td>${item.kategori}</td>
                        <td>
                            <a href="/buku/${item.id}" class="text-blue-600 hover:underline font-semibold">
                                ${item.judul}
                            </a>
                        </td>
                        <td>${item.penulis}</td>
                        <td>${item.tahun}</td>
                        <td>${tombolAksi}</td>
                    </tr>
                `;
                tbody.insertAdjacentHTML('beforeend', row);
            });
        } catch (error) {
            showAlert(error.message, 'danger');
            tbody.innerHTML = '<tr><td colspan="6" class="text-center text-danger">Data gagal dimuat.</td></tr>';
        }
    }

    if (form) {
        form.addEventListener('submit', async (e) => {
            e.preventDefault();
            clearErrors();

            const id = document.getElementById('buku-id').value;
            const isEdit = id !== '';
            
            const payload = {
                kategori_id: document.getElementById('kategori_id').value,
                judul: document.getElementById('judul').value,
                penulis: document.getElementById('penulis').value,
                tahun_terbit: document.getElementById('tahun').value
            };

            const url = isEdit ? `/api/buku/${id}` : '/api/buku';
            const method = isEdit ? 'PUT' : 'POST';

            try {
                const response = await fetch(url, {
                    method: method,
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify(payload)
                });

                const result = await response.json();

                if (!response.ok) {
                    if (response.status === 422) {
                        for (const [field, messages] of Object.entries(result.errors)) {
                            const errEl = document.getElementById(`err-${field}`);
                            if (errEl) errEl.innerText = messages[0];
                        }
                        showAlert('Periksa kembali isian Anda.', 'warning');
                    } else {
                        showAlert(result.message || 'Terjadi kesalahan server.', 'danger');
                    }
                    return;
                }

                showAlert(isEdit ? 'Buku berhasil diubah!' : 'Buku berhasil ditambahkan!', 'success');
                resetForm();
                fetchBuku(); 

            } catch (error) {
                showAlert('Gagal terhubung ke server. Cek koneksi Anda.', 'danger');
            }
        });

        btnBatal.addEventListener('click', resetForm);
    }

    window.editBuku = async (id) => {
        clearErrors();
        try {
            const response = await fetch(`/api/buku/${id}`, {
                headers: { 'Accept': 'application/json' }
            });
            
            if (!response.ok) throw new Error('Gagal mengambil data buku.');
            
            const result = await response.json();
            const buku = result.data;

            document.getElementById('buku-id').value = buku.id;
            document.getElementById('judul').value = buku.judul;
            document.getElementById('penulis').value = buku.penulis;
            document.getElementById('tahun').value = buku.tahun;

            if (buku.kategori === 'Teknologi & Digital' || buku.kategori === 'Novel') document.getElementById('kategori_id').value = '1';
            else if (buku.kategori === 'Sastra & Fiksi' || buku.kategori === 'Sejarah') document.getElementById('kategori_id').value = '2';
            else if (buku.kategori === 'Pengembangan Diri' || buku.kategori === 'Filsafat') document.getElementById('kategori_id').value = '3';

            formTitle.innerText = 'Ubah Data Buku';
            btnBatal.classList.remove('d-none');
            window.scrollTo({ top: 0, behavior: 'smooth' });
        } catch (error) {
            showAlert(error.message, 'danger');
        }
    };

    window.hapusBuku = async (id) => {
        if (!confirm('Apakah Anda yakin ingin menghapus buku ini?')) return;

        try {
            const response = await fetch(`/api/buku/${id}`, {
                method: 'DELETE',
                headers: { 'Accept': 'application/json' }
            });

            if (!response.ok) throw new Error('Gagal menghapus data.');

            showAlert('Buku berhasil dihapus!', 'success');
            fetchBuku();
        } catch (error) {
            showAlert(error.message, 'danger');
        }
    };

    fetchBuku();
});