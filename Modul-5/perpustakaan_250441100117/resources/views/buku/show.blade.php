<x-app-layout>
    <style>
        .detail-wrapper { max-width: 800px; margin: 0 auto; padding: 20px; font-family: 'Inter', sans-serif; }
        .link-kembali { display: inline-block; margin-bottom: 20px; color: #4a6fa5; text-decoration: none; font-weight: 600; }
        .detail-card { background: #fff; border-radius: 16px; box-shadow: 0 10px 30px rgba(0,0,0,0.05); padding: 40px; border: 1px solid #f0f0f0; }
        .detail-header { border-bottom: 2px solid #f0f0f0; padding-bottom: 20px; margin-bottom: 20px; }
        .detail-header h2 { font-family: 'Playfair Display', serif; font-size: 2rem; color: #2c3e50; margin: 0 0 10px 0; }
        .badge-kategori { background: #fce4ec; color: #880e4f; padding: 6px 12px; border-radius: 20px; font-size: 0.85rem; font-weight: bold; }
        .detail-body { display: grid; gap: 20px; }
        .detail-item { display: flex; flex-direction: column; }
        .detail-item .label { font-size: 0.85rem; color: #7f8c8d; font-weight: 600; text-transform: uppercase; margin-bottom: 5px; }
        .detail-item .nilai { font-size: 1.1rem; color: #2c3e50; font-weight: 500; }
        .not-found { text-align: center; padding: 50px; background: #fff; border-radius: 16px; }
    </style>

    <div class="detail-wrapper">
        @if ($buku)
            <a href="{{ route('buku.index') }}" class="link-kembali">&larr; Kembali ke Daftar Buku</a>

            <div class="detail-card">
                <div class="detail-header">
                    <h2>{{ $buku['judul'] }}</h2>
                    <span class="badge-kategori">{{ $buku['kategori'] }}</span>
                </div>

                <div class="detail-body">
                    <div class="detail-item">
                        <span class="label">Penulis</span>
                        <span class="nilai">{{ $buku['penulis'] }}</span>
                    </div>
                    <div class="detail-item">
                        <span class="label">Tahun Terbit</span>
                        <span class="nilai">{{ $buku['tahun_terbit'] ?? $buku['tahun'] }}</span>
                    </div>
                    <div class="detail-item">
                        <span class="label">ID Buku</span>
                        <span class="nilai">{{ $buku['id'] }}</span>
                    </div>
                </div>
            </div>
        @else
            <div class="not-found">
                <h2>Buku Tidak Ditemukan</h2>
                <p>Maaf, buku dengan ID tersebut tidak ada dalam koleksi kami.</p>
                <a href="{{ route('buku.index') }}" class="btn btn-primary mt-4">Kembali</a>
            </div>
        @endif
    </div>
</x-app-layout>