<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Data Buku</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .form-group { margin-bottom: 10px; }
        label { display: inline-block; width: 130px; }
        input { padding: 5px; width: 250px; }
        button { padding: 5px 10px; cursor: pointer; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        table, th, td { border: 1px solid #ccc; padding: 8px; text-align: left; }
        th { background-color: #f4f4f4; }
        .alert { padding: 10px; margin-bottom: 15px; display: none; }
        .alert-danger { background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
        .alert-success { background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
    </style>
</head>
<body>

    <h2>Kelola Data Buku</h2>

    <div id="alert-message" class="alert"></div>


    <form id="form-buku" novalidate>
        <input type="hidden" id="buku-id">
        <div class="form-group">
            <label>Kategori (ID):</label>
            <input type="number" id="kategori_id" placeholder="ID Kategori">
        </div>
        <div class="form-group">
            <label>Judul Buku:</label>
            <input type="text" id="judul" placeholder="Minimal 3 karakter">
        </div>
        <div class="form-group">
            <label>Penulis:</label>
            <input type="text" id="penulis" placeholder="Minimal 3 karakter">
        </div>
        <div class="form-group">
            <label>Tahun Terbit:</label>
            <input type="number" id="tahun_terbit" placeholder="Contoh: 2024">
        </div>
        <button type="submit" id="btn-simpan">Simpan Buku</button>
        <button type="button" id="btn-batal" onclick="resetForm()" style="display:none;">Batal</button>
    </form>

    <hr>


    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Kategori</th>
                <th>Judul</th>
                <th>Penulis</th>
                <th>Tahun</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody id="tabel-buku">
        </tbody>
    </table>

    <script>
        const API_URL = '/api/buku';

        function showAlert(message, type = 'danger') {
            const alertBox = document.getElementById('alert-message');
            alertBox.className = `alert alert-${type}`;
            alertBox.innerText = message;
            alertBox.style.display = 'block';
            setTimeout(() => { alertBox.style.display = 'none'; }, 5000);
        }

        async function loadBuku() {
            try {
                const response = await fetch(API_URL, {
                    headers: { 'Accept': 'application/json' }
                });

                if (!response.ok) throw new Error('Gagal mengambil data dari API.');

                const result = await response.json();
                const tbody = document.getElementById('tabel-buku');
                tbody.innerHTML = '';

                result.data.forEach((buku, index) => {
                    tbody.innerHTML += `
                        <tr>
                            <td>${index + 1}</td>
                            <td>${buku.kategori}</td>
                            <td>${buku.judul}</td>
                            <td>${buku.penulis}</td>
                            <td>${buku.tahun}</td>
                            <td>
                                <button onclick="editBuku(${buku.id}, ${buku.kategori}, '${buku.judul.replace(/'/g, "\\'")}', '${buku.penulis.replace(/'/g, "\\'")}', ${buku.tahun})">Ubah</button>
                                <button onclick="hapusBuku(${buku.id})" style="color:red;">Hapus</button>
                            </td>
                        </tr>
                    `;
                });
            } catch (error) {
                showAlert(error.message, 'danger');
            }
        }

    
        document.getElementById('form-buku').addEventListener('submit', async function(e) {
            e.preventDefault();

            const id = document.getElementById('buku-id').value;
            const data = {
                kategori_id: document.getElementById('kategori_id').value,
                judul: document.getElementById('judul').value,
                penulis: document.getElementById('penulis').value,
                tahun_terbit: document.getElementById('tahun_terbit').value
            };

            const isEdit = id !== '';
            const url = isEdit ? `${API_URL}/${id}` : API_URL;
            const method = isEdit ? 'PUT' : 'POST';

            try {
                const response = await fetch(url, {
                    method: method,
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify(data)
                });

                const resData = await response.json();

                if (!response.ok) {
                    if (response.status === 422) {
                        const errors = Object.values(resData.errors).flat().join(' | ');
                        throw new Error(`Validasi Gagal: ${errors}`);
                    }
                    throw new Error(resData.message || 'Gagal menyimpan data.');
                }

                showAlert(resData.message, 'success');
                resetForm();
                loadBuku();
            } catch (error) {
                showAlert(error.message, 'danger');
            }
        });

        function editBuku(id, kategori, judul, penulis, tahun) {
            document.getElementById('buku-id').value = id;
            document.getElementById('kategori_id').value = kategori;
            document.getElementById('judul').value = judul;
            document.getElementById('penulis').value = penulis;
            document.getElementById('tahun_terbit').value = tahun;

            document.getElementById('btn-simpan').innerText = 'Perbarui Buku';
            document.getElementById('btn-batal').style.display = 'inline-block';
        }

        function resetForm() {
            document.getElementById('buku-id').value = '';
            document.getElementById('form-buku').reset();
            document.getElementById('btn-simpan').innerText = 'Simpan Buku';
            document.getElementById('btn-batal').style.display = 'none';
        }

        
        async function hapusBuku(id) {
            if (!confirm('Apakah Anda yakin ingin menghapus buku ini?')) return;

            try {
                const response = await fetch(`${API_URL}/${id}`, {
                    method: 'DELETE',
                    headers: { 'Accept': 'application/json' }
                });

                const resData = await response.json();

                if (!response.ok) throw new Error(resData.message || 'Gagal menghapus buku.');

                showAlert(resData.message, 'success');
                loadBuku();
            } catch (error) {
                showAlert(error.message, 'danger');
            }
        }

        document.addEventListener('DOMContentLoaded', loadBuku);
    </script>
</body>
</html>