<x-app-layout>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600&family=Inter:wght@400;500;600&display=swap');
        .container { font-family: 'Inter', sans-serif; max-width: 1000px; margin: 0 auto; padding: 20px; }
        .page-title { text-align: center; margin-bottom: 5px; font-family: 'Playfair Display', serif; font-size: 2.2rem; color: #2c3e50; }
        .page-subtitle { text-align: center; color: #7f8c8d; margin-bottom: 30px; font-size: 0.9rem; }
        
        .card-custom { background: #ffffff; border-radius: 16px; box-shadow: 0 10px 30px rgba(0,0,0,0.03); padding: 40px; margin-bottom: 40px; border: 1px solid #f0f0f0; }
        .form-title { font-family: 'Playfair Display', serif; font-size: 1.6rem; margin-bottom: 8px; text-align: center; color: #2c3e50; }
        .form-grid { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 24px; margin-bottom: 30px; margin-top: 30px; }
        .form-group { width: 100%; }
        .form-group label { display: block; font-weight: 600; font-size: 0.85rem; margin-bottom: 8px; color: #34495e; }
        .form-control { width: 100%; box-sizing: border-box; padding: 14px; border: 1.5px solid #e0e0e0; border-radius: 10px; font-size: 0.9rem; outline: none; transition: all 0.3s; font-family: 'Inter', sans-serif; background: #fafafa; }
        .form-control:focus { border-color: #4a6fa5; background: #fff; box-shadow: 0 0 0 4px rgba(74, 111, 165, 0.1); }
        
        .btn { padding: 12px 24px; border-radius: 8px; font-size: 0.9rem; font-weight: 600; cursor: pointer; border: none; transition: all 0.3s; font-family: 'Inter', sans-serif; }
        .btn-primary { background: #4a6fa5; color: white; box-shadow: 0 4px 10px rgba(74, 111, 165, 0.2); }
        .btn-primary:hover { background: #385887; transform: translateY(-2px); }
        .btn-secondary { background: #e0e0e0; color: #555; }
        
        .table-custom { width: 100%; border-collapse: separate; border-spacing: 0; background: #fff; border-radius: 16px; overflow: hidden; box-shadow: 0 10px 30px rgba(0,0,0,0.03); border: 1px solid #f0f0f0; }
        .table-custom th { background: #2c3e50; color: #ffffff; padding: 18px 15px; text-align: left; font-size: 0.85rem; font-weight: 600; text-transform: uppercase; letter-spacing: 1px; }
        .table-custom td { padding: 16px 15px; border-bottom: 1px solid #f0f0f0; font-size: 0.9rem; color: #333; }
        .table-custom tr:last-child td { border-bottom: none; }
        .table-custom tr:hover td { background: #f8fbfa; }
        
        .btn-sm { padding: 8px 16px; font-size: 0.75rem; border-radius: 6px; margin-right: 8px; font-weight: 600; }
        .btn-warning { background: transparent; border: 1.5px solid #e67e22; color: #e67e22; }
        .btn-warning:hover { background: #e67e22; color: white; }
        .btn-danger { background: transparent; border: 1.5px solid #e74c3c; color: #e74c3c; }
        .btn-danger:hover { background: #e74c3c; color: white; }
        
        .text-danger { color: #e74c3c; font-size: 0.8rem; margin-top: 5px; display: block; }
        .alert { padding: 15px; border-radius: 8px; margin-bottom: 20px; font-size: 0.9rem; }
        .alert-success { background: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        .alert-danger { background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
        .alert-warning { background: #fff3cd; color: #856404; border: 1px solid #ffeeba; }
    </style>

    <div class="container mt-4">
        <div id="alert-area" class="mb-3"></div>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        @role('admin|petugas')
        <div class="card-custom" id="card-form">
            <h3 class="form-title" id="form-title">Tambah Buku</h3>
            <p class="page-subtitle">Tambahkan koleksi buku baru ke dalam perpustakaan digital melalui form berikut.</p>
            
            <form id="form-buku" novalidate>
                <input type="hidden" id="buku-id">
                <div class="form-grid">
                    <div class="form-group">
                        <label>Kategori</label>
                        <select id="kategori_id" class="form-control" required>
                            <option value="">Pilih Kategori</option>
                            <option value="1">Teknologi & Digital</option>
                            <option value="2">Sastra & Fiksi</option>
                            <option value="3">Pengembangan Diri</option>
                        </select>
                        <small class="text-danger" id="err-kategori_id"></small>
                    </div>
                    <div class="form-group">
                        <label>Judul Buku</label>
                        <input type="text" id="judul" class="form-control" placeholder="Masukkan judul buku" required>
                        <small class="text-danger" id="err-judul"></small>
                    </div>
                    <div class="form-group">
                        <label>Penulis</label>
                        <input type="text" id="penulis" class="form-control" placeholder="Masukkan nama penulis" required>
                        <small class="text-danger" id="err-penulis"></small>
                    </div>
                    <div class="form-group">
                        <label>Tahun Terbit</label>
                        <input type="number" id="tahun" class="form-control" placeholder="Masukkan tahun terbit" required>
                        <small class="text-danger" id="err-tahun"></small>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary" id="btn-simpan">Simpan Data</button>
                <button type="button" class="btn btn-secondary d-none" id="btn-batal">Batal Ubah</button>
            </form>
        </div>
        @endrole

        <div class="mt-5">
            <h2 class="page-title">Data Buku</h2>
            <p class="page-subtitle">Data buku berikut diambil dari database melalui endpoint GET /api/buku menggunakan Fetch API dan async/await.</p>
            
            <table class="table-custom">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Kategori</th>
                        <th>Judul</th>
                        <th>Penulis</th>
                        <th>Tahun Terbit</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody id="tbody-buku">
                    <tr><td colspan="6" class="text-center">Memuat data...</td></tr>
                </tbody>
            </table>
        </div>
    </div>

    <script src="{{ asset('js/buku.js') }}"></script>
</x-app-layout>