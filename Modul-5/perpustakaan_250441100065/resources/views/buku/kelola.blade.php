@extends('layouts.perpus')

@section('content')
<div class="mgmt-wrapper">

    <div class="mgmt-header">
        <div>
            <h2 class="mgmt-title">Manajemen Data Buku</h2>
        </div>
        <div class="mgmt-badge-api">
            <span class="dot"></span> API Terhubung
        </div>
    </div>
    
    <div class="mgmt-card">
        <form id="bukuForm">
            <input type="hidden" id="bukuId">

            <div class="mgmt-form-grid">
                <div class="mgmt-form-group">
                    <label for="kategori">Kategori</label>
                    <select id="kategori" required class="mgmt-control">
                        <option value="">-- Pilih Kategori --</option>
                        @isset($kategoris)
                            @foreach($kategoris as $k)
                                <option value="{{ $k->id }}">{{ $k->nama }}</option>
                            @endforeach
                        @endisset
                    </select>
                </div>

                <div class="mgmt-form-group">
                    <label for="judul">Judul Buku</label>
                    <input type="text" id="judul" required class="mgmt-control" placeholder="masukkan judul buku...">
                </div>

                <div class="mgmt-form-group">
                    <label for="penulis">Penulis</label>
                    <input type="text" id="penulis" required class="mgmt-control" placeholder="Masukkan nama penulis...">
                </div>

                <div class="mgmt-form-group">
                    <label for="tahun_terbit">Tahun Terbit</label>
                    <input type="number" id="tahun_terbit" required min="1000" max="9999" class="mgmt-control" placeholder="Contoh: 2024">
                </div>
            </div>

            <div class="mgmt-actions">
                <button type="submit" id="submitBtn" class="btn-save">
                    <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="margin-right:8px;"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path><polyline points="17 21 17 13 7 13 7 21"></polyline><polyline points="7 3 7 8 15 8"></polyline></svg>
                    Simpan Buku
                </button>
                <button type="button" id="cancelBtn" class="btn-cancel" style="display:none;" onclick="resetForm()">
                    Batal
                </button>
            </div>
        </form>
    </div>

    <div class="mgmt-card table-card">
        <div class="table-accent-line"></div>
        <div class="mgmt-table-wrapper">
            <table class="mgmt-table">
                <thead>
                    <tr>
                        <th style="width:60px;text-align:center;">No</th>
                        <th>Kategori</th>
                        <th>Judul Buku</th>
                        <th>Penulis</th>
                        <th>Tahun</th>
                        <th style="text-align:center;width:120px;">Aksi</th>
                    </tr>
                </thead>
                <tbody id="bukuTableBody">
                    <tr>
                        <td colspan="6" style="text-align:center;padding:40px;color:#94a3b8;">
                            ⏳ Memuat data buku...
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        
        <!-- Container Pagination -->
        <div id="pagination-container" style="padding: 16px 24px; border-top: 1px solid #e2e8f0; display: flex; justify-content: center;"></div>
    </div>

</div>

@verbatim
<script>
    const apiUrl = '/api/buku';
    const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
    let currentPage = 1; // Menyimpan halaman saat ini

    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.onmouseenter = Swal.stopTimer;
            toast.onmouseleave = Swal.resumeTimer;
        }
    });

    function showAlert(message, isError = false) {
        Toast.fire({
            icon: isError ? 'error' : 'success',
            title: message
        });
    }

    function getKategoriText(buku) {
        if (buku.kategori && typeof buku.kategori === 'object') {
            return buku.kategori.nama ?? buku.kategori.kategori_buku ?? buku.kategori.name ?? '-';
        }
        return buku.kategori ?? buku.kategori_buku ?? buku.nama_kategori ?? '-';
    }

    function getKategoriId(buku) {
        if (buku.kategori && typeof buku.kategori === 'object') {
            return buku.kategori_id ?? buku.kategori.id ?? '';
        }
        return buku.kategori_id ?? '';
    }

    async function fetchBuku(page = 1) {
        const tbody = document.getElementById('bukuTableBody');
        const paginationContainer = document.getElementById('pagination-container');
        currentPage = page;

        try {
            // Menambahkan parameter ?page= pada URL API
            const response = await fetch(`${apiUrl}?page=${page}`, {
                headers: { 'Accept': 'application/json' }
            });

            const result = await response.json();

            if (!response.ok) {
                throw new Error(result.message || 'Gagal mengambil data buku.');
            }

            // Ekstrak data dan meta (untuk pagination)
            const data = Array.isArray(result) ? result : (Array.isArray(result.data) ? result.data : []);
            const meta = result.meta || null; 
            
            tbody.innerHTML = '';

            if (data.length === 0) {
                tbody.innerHTML = `
                    <tr>
                        <td colspan="6" style="text-align:center;padding:40px;color:#94a3b8;">
                            Belum ada data buku.
                        </td>
                    </tr>
                `;
                paginationContainer.innerHTML = '';
                return;
            }

            data.forEach((buku, index) => {
                const tr = document.createElement('tr');
                const kategoriNama = getKategoriText(buku);
                const judulBuku = buku.judul ?? buku.judul_buku ?? '-';
                const penulisBuku = buku.penulis ?? '-';
                const tahunBuku = buku.tahun ?? buku.tahun_terbit ?? '-';

                const tdNo = document.createElement('td');
                // Agar penomoran lanjut di halaman 2, 3, dst.
                const nomorUrut = meta ? ((meta.current_page - 1) * meta.per_page) + index + 1 : index + 1;
                tdNo.textContent = nomorUrut;
                tdNo.style.textAlign = 'center';
                tdNo.style.color = '#64748b';
                tr.appendChild(tdNo);

                const tdKategori = document.createElement('td');
                const badge = document.createElement('span');
                badge.className = 'badge-cat';
                badge.textContent = kategoriNama;
                tdKategori.appendChild(badge);
                tr.appendChild(tdKategori);

                const tdJudul = document.createElement('td');
                tdJudul.textContent = judulBuku;
                tdJudul.style.fontWeight = '600';
                tdJudul.style.color = '#1e293b';
                tr.appendChild(tdJudul);

                const tdPenulis = document.createElement('td');
                tdPenulis.textContent = penulisBuku;
                tr.appendChild(tdPenulis);

                const tdTahun = document.createElement('td');
                tdTahun.textContent = tahunBuku;
                tr.appendChild(tdTahun);

                const tdAksi = document.createElement('td');
                tdAksi.style.textAlign = 'center';
                tdAksi.style.whiteSpace = 'nowrap';

                const btnEdit = document.createElement('button');
                btnEdit.type = 'button';
                btnEdit.className = 'btn-action btn-edit';
                btnEdit.title = 'Ubah Data';
                btnEdit.innerHTML = `<svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>`;
                btnEdit.addEventListener('click', () => { editBuku(buku); });

                const btnHapus = document.createElement('button');
                btnHapus.type = 'button';
                btnHapus.className = 'btn-action btn-delete';
                btnHapus.title = 'Hapus Data';
                btnHapus.innerHTML = `<svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg>`;
                btnHapus.addEventListener('click', () => { deleteBuku(buku.id, judulBuku); });

                tdAksi.append(btnEdit, btnHapus);
                tr.appendChild(tdAksi);
                tbody.appendChild(tr);
            });

            // Render Navigasi Pagination
            renderPagination(meta);

        } catch (error) {
            showAlert(error.message, true);
            tbody.innerHTML = `
                <tr>
                    <td colspan="6" style="text-align:center;padding:40px;color:#ef4444;">
                        Gagal memuat data. Periksa koneksi API.
                    </td>
                </tr>
            `;
            paginationContainer.innerHTML = '';
        }
    }

    // Fungsi Membuat Tombol Navigasi Halaman
    function renderPagination(meta) {
        const container = document.getElementById('pagination-container');
        container.innerHTML = ''; 

        if (!meta || meta.last_page <= 1) return; // Jika cuma 1 halaman, sembunyikan pagination

        const nav = document.createElement('div');
        nav.className = 'pagination-wrapper';

        // Tombol Prev
        const btnPrev = document.createElement('button');
        btnPrev.className = 'page-btn';
        btnPrev.innerHTML = '&laquo; Prev';
        btnPrev.disabled = meta.current_page === 1;
        btnPrev.onclick = () => { if(meta.current_page > 1) fetchBuku(meta.current_page - 1); };
        nav.appendChild(btnPrev);

        // Tombol Angka Halaman
        for (let i = 1; i <= meta.last_page; i++) {
            const btnPage = document.createElement('button');
            btnPage.className = `page-btn ${i === meta.current_page ? 'active' : ''}`;
            btnPage.textContent = i;
            btnPage.onclick = () => fetchBuku(i);
            nav.appendChild(btnPage);
        }

        // Tombol Next
        const btnNext = document.createElement('button');
        btnNext.className = 'page-btn';
        btnNext.innerHTML = 'Next &raquo;';
        btnNext.disabled = meta.current_page === meta.last_page;
        btnNext.onclick = () => { if(meta.current_page < meta.last_page) fetchBuku(meta.current_page + 1); };
        nav.appendChild(btnNext);

        container.appendChild(nav);
    }

    document.getElementById('bukuForm').addEventListener('submit', async function(e) {
        e.preventDefault();
        const id = document.getElementById('bukuId').value;

        const payload = {
            kategori_id: document.getElementById('kategori').value,
            judul: document.getElementById('judul').value,
            penulis: document.getElementById('penulis').value,
            tahun_terbit: document.getElementById('tahun_terbit').value
        };

        const url = id ? `${apiUrl}/${id}` : apiUrl;
        const method = id ? 'PUT' : 'POST';

        try {
            const response = await fetch(url, {
                method: method,
                headers: { 'Content-Type': 'application/json', 'Accept': 'application/json', 'X-CSRF-TOKEN': csrfToken },
                body: JSON.stringify(payload)
            });

            const result = await response.json();

            if (!response.ok) {
                const message = result.errors
                    ? Object.values(result.errors).flat().join(' ')
                    : result.message || 'Gagal menyimpan buku.';
                throw new Error(message);
            }

            showAlert(id ? 'Data buku berhasil diperbarui!' : 'Data buku berhasil ditambahkan!');
            resetForm();
            // Kembali ke halaman 1 setelah menambah/mengubah data
            await fetchBuku(currentPage); 
        } catch (error) {
            showAlert(error.message, true);
        }
    });

    function editBuku(buku) {
        document.getElementById('bukuId').value = buku.id;
        document.getElementById('kategori').value = getKategoriId(buku);
        document.getElementById('judul').value = buku.judul ?? buku.judul_buku ?? '';
        document.getElementById('penulis').value = buku.penulis ?? '';
        document.getElementById('tahun_terbit').value = buku.tahun ?? buku.tahun_terbit ?? '';

        const btn = document.getElementById('submitBtn');
        btn.innerHTML = `Perbarui Buku`;
        btn.style.background = '#f59e0b';
        document.getElementById('cancelBtn').style.display = 'inline-block';
        document.getElementById('bukuForm').scrollIntoView({ behavior: 'smooth', block: 'start' });
    }

    function resetForm() {
        document.getElementById('bukuForm').reset();
        document.getElementById('bukuId').value = '';

        const btn = document.getElementById('submitBtn');
        btn.innerHTML = `<svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="margin-right:8px;"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path><polyline points="17 21 17 13 7 13 7 21"></polyline><polyline points="7 3 7 8 15 8"></polyline></svg> Simpan Buku`;
        btn.style.background = '#2563eb';
        document.getElementById('cancelBtn').style.display = 'none';
    }

    async function deleteBuku(id, judul) {
        const konfirmasi = await Swal.fire({
            title: 'Hapus Buku?',
            html: `Apakah kamu yakin ingin menghapus buku <b>"${judul}"</b>? Data ini tidak bisa dikembalikan.`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ef4444',
            cancelButtonColor: '#94a3b8',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal',
            reverseButtons: true
        });

        if (!konfirmasi.isConfirmed) return;

        try {
            const response = await fetch(`${apiUrl}/${id}`, {
                method: 'DELETE',
                headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': csrfToken }
            });

            const result = await response.json();
            if (!response.ok) throw new Error(result.message || 'Gagal menghapus buku.');

            showAlert(result.message || 'Data buku berhasil dihapus!');
            
            // Jika menghapus data terakhir di halaman terakhir, mundurkan 1 halaman
            const metaElement = document.getElementById('pagination-container');
            const isLastPage = document.querySelector('.page-btn.active')?.textContent == document.querySelectorAll('.page-btn:not(:first-child):not(:last-child)').length;
            let nextPage = currentPage;
            if (isLastPage && currentPage > 1) {
                nextPage = currentPage - 1;
            }
            
            await fetchBuku(nextPage);

        } catch (error) {
            showAlert(error.message, true);
        }
    }

    document.addEventListener('DOMContentLoaded', () => fetchBuku(1));
</script>
@endverbatim
@endsection