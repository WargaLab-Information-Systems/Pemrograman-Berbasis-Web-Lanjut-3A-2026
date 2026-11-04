<x-app-layout>
    <style>
        .dash-header { background: #2c3e50; color: #ffffff; padding: 40px; border-radius: 12px; margin-bottom: 30px; box-shadow: 0 10px 20px rgba(0,0,0,0.1); border-bottom: 4px solid #d4af37; }
        .dash-header h3 { font-family: 'Playfair Display', serif; font-size: 2.2rem; margin-bottom: 10px; font-weight: 700; }
        .dash-card { background: #fff; padding: 30px; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); border: 1px solid #f0f0f0; max-width: 400px; transition: 0.3s; }
        .dash-card:hover { transform: translateY(-5px); border-color: #d4af37; }
        .dash-card h4 { font-family: 'Playfair Display', serif; font-size: 1.3rem; color: #2c3e50; margin-bottom: 10px; font-weight: 700; }
        .dash-card p { color: #7f8c8d; font-size: 0.9rem; margin-bottom: 20px; line-height: 1.5; }
        .btn-dash { display: inline-block; padding: 10px 20px; background: #2c3e50; color: #fff; border-radius: 6px; text-decoration: none; font-size: 0.85rem; font-weight: 600; transition: 0.3s; }
        .btn-dash:hover { background: #d4af37; color: #2c3e50; }
    </style>

    <div class="py-10 max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="dash-header">
            <h3>Dashboard Siswa</h3>
            <p class="mb-0">Halo! Temukan buku favoritmu dan pantau riwayat peminjamanmu di sini.</p>
        </div>

        <div class="dash-card">
            <h4>Daftar Buku</h4>
            <p>Jelajahi semua koleksi buku yang tersedia di perpustakaan digital.</p>
            <a href="{{ route('buku.index') }}" class="btn-dash">Lihat Daftar Buku &rarr;</a>
        </div>
    </div>
</x-app-layout>