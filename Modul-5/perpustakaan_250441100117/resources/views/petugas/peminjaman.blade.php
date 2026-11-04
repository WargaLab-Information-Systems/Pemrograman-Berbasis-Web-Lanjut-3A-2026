<x-app-layout>
    <style>
        .table-custom { width: 100%; border-collapse: collapse; background: #fff; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.05); margin-top: 20px; }
        .table-custom th { background: #2c3e50; color: #fff; padding: 15px; text-align: left; }
        .table-custom td { padding: 15px; border-bottom: 1px solid #eee; }
        .badge { padding: 5px 10px; border-radius: 5px; font-weight: bold; font-size: 0.8rem; }
        .badge-success { background: #d4edda; color: #155724; }
        .badge-warning { background: #fff3cd; color: #856404; }
        .btn-kembali { display: inline-block; margin-bottom: 20px; color: #2c3e50; font-weight: 600; text-decoration: none; font-size: 0.9rem; transition: 0.3s; }
        .btn-kembali:hover { color: #d4af37; }
    </style>

    <div class="py-10 max-w-7xl mx-auto sm:px-6 lg:px-8">
        <a href="{{ route('petugas.dashboard') }}" class="btn-kembali">
            &larr; Kembali ke Dashboard
        </a>

        <h2 class="text-2xl font-bold mb-4" style="font-family: 'Playfair Display', serif; color: #2c3e50;">Kelola Peminjaman</h2>
        <p class="text-gray-500 mb-6">Daftar peminjaman buku yang sedang berlangsung.</p>

        <table class="table-custom">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Peminjam</th>
                    <th>Buku</th>
                    <th>Tgl Pinjam</th>
                    <th>Tgl Kembali</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse(\App\Models\Peminjaman::with(['anggota', 'buku'])->latest()->get() as $index => $p)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $p->anggota->nama ?? '-' }}</td>
                    <td>{{ $p->buku->judul ?? '-' }}</td>
                    <td>{{ $p->tanggal_pinjam }}</td>
                    <td>{{ $p->tanggal_kembali ?? '-' }}</td>
                    <td>
                        <span class="badge {{ $p->tanggal_kembali ? 'badge-success' : 'badge-warning' }}">
                            {{ $p->tanggal_kembali ? 'Selesai' : 'Sedang Dipinjam' }}
                        </span>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="text-center">Belum ada data peminjaman.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-app-layout>