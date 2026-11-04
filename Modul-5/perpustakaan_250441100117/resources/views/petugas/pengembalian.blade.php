<x-app-layout>
    <style>
        .table-custom { width: 100%; border-collapse: collapse; background: #fff; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.05); margin-top: 20px; }
        .table-custom th { background: #2c3e50; color: #fff; padding: 15px; text-align: left; }
        .table-custom td { padding: 15px; border-bottom: 1px solid #eee; }
        .btn-kembali { display: inline-block; margin-bottom: 20px; color: #2c3e50; font-weight: 600; text-decoration: none; font-size: 0.9rem; transition: 0.3s; }
        .btn-kembali:hover { color: #d4af37; }
        .btn-catat { background: #27ae60; color: white; padding: 8px 15px; border-radius: 6px; text-decoration: none; font-size: 0.85rem; font-weight: 600; transition: 0.3s;}
        .btn-catat:hover { background: #1e8449; }
    </style>

    <div class="py-10 max-w-7xl mx-auto sm:px-6 lg:px-8">
        <a href="{{ route('petugas.dashboard') }}" class="btn-kembali">
            &larr; Kembali ke Dashboard
        </a>

        <h2 class="text-2xl font-bold mb-4" style="font-family: 'Playfair Display', serif; color: #2c3e50;">Proses Pengembalian</h2>
        <p class="text-gray-500 mb-6">Daftar buku yang sedang dipinjam dan menunggu dikembalikan.</p>

        <table class="table-custom">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Peminjam</th>
                    <th>Buku</th>
                    <th>Tgl Pinjam</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse(\App\Models\Peminjaman::with(['anggota', 'buku'])->whereNull('tanggal_kembali')->latest()->get() as $index => $p)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $p->anggota->nama ?? '-' }}</td>
                    <td>{{ $p->buku->judul ?? '-' }}</td>
                    <td>{{ $p->tanggal_pinjam }}</td>
                    <td>
                        <a href="#" class="btn-catat" onclick="alert('Buku berhasil dikembalikan!')">Catat Kembali</a>
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" class="text-center">Tidak ada buku yang perlu dikembalikan.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-app-layout>