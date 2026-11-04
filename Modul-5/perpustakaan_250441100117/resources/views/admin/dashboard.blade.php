<x-app-layout>
    <style>
        .dash-header { background: #2c3e50; color: #ffffff; padding: 40px; border-radius: 12px; margin-bottom: 30px; box-shadow: 0 10px 20px rgba(0,0,0,0.1); border-bottom: 4px solid #d4af37; }
        .dash-header h3 { font-family: 'Playfair Display', serif; font-size: 2.2rem; margin-bottom: 10px; font-weight: 700; }
        .dash-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 25px; }
        .dash-card { background: #fff; padding: 25px; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); border: 1px solid #f0f0f0; transition: 0.3s; }
        .dash-card:hover { transform: translateY(-5px); box-shadow: 0 15px 30px rgba(0,0,0,0.1); border-color: #d4af37; }
        .dash-card h4 { font-family: 'Playfair Display', serif; font-size: 1.3rem; color: #2c3e50; margin-bottom: 10px; font-weight: 700; }
        .dash-card p { color: #7f8c8d; font-size: 0.9rem; line-height: 1.5; }
        .btn-dash { display: inline-block; margin-top: 15px; padding: 10px 20px; background: #2c3e50; color: #fff; border-radius: 6px; text-decoration: none; font-size: 0.85rem; font-weight: 600; transition: 0.3s; margin-right: 5px; }
        .btn-dash:hover { background: #d4af37; color: #2c3e50; }
    </style>

    <div class="py-10 max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="dash-header">
            <h3>Dashboard Admin</h3>
            <p class="mb-0">Selamat datang kembali, Admin. Kelola sistem perpustakaan digital dengan mudah.</p>
        </div>

        <div class="dash-grid">

            <div class="dash-card">
                <h4>Kelola Data Buku</h4>
                <p>Tambah, ubah, dan hapus koleksi buku di perpustakaan.</p>
                <a href="{{ route('buku.index') }}" class="btn-dash">Masuk Panel</a>
            </div>

            <div class="dash-card">
                <h4>Kelola Pengguna & Role</h4>
                <p>Atur akun, petugas, dan hak akses pengguna.</p>
                <a href="{{ route('admin.users.index') }}" class="btn-dash">Masuk Panel</a>
            </div>

            <div class="dash-card">
                <h4>Peminjaman & Pengembalian</h4>
                <p>Lihat data sirkulasi peminjaman dan pengembalian buku.</p>
                <a href="{{ route('admin.peminjaman') }}" class="btn-dash">Peminjaman</a>
                <a href="{{ route('admin.pengembalian') }}" class="btn-dash">Pengembalian</a>
            </div>

            <div class="dash-card">
                <h4>Laporan Perpustakaan</h4>
                <p>Lihat laporan rekapitulasi data perpustakaan.</p>
                <a href="{{ route('admin.laporan') }}" class="btn-dash">Lihat Laporan</a>
            </div>
        </div>
    </div>
</x-app-layout>