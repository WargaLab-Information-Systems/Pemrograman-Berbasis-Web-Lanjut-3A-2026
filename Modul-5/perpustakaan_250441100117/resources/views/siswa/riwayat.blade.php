<x-app-layout>
    <style>
        .table-custom { width: 100%; border-collapse: collapse; background: #fff; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.05); margin-top: 20px; }
        .table-custom th { background: #2c3e50; color: #fff; padding: 15px; text-align: left; }
        .table-custom td { padding: 15px; border-bottom: 1px solid #eee; }
        .badge { padding: 5px 10px; border-radius: 5px; font-weight: bold; font-size: 0.8rem; }
        .badge-success { background: #d4edda; color: #155724; }
        .badge-warning { background: #fff3cd; color: #856404; }
    </style>

    <div class="py-10 max-w-7xl mx-auto sm:px-6 lg:px-8">
        <h2 class="text-2xl font-bold mb-4" style="font-family: 'Playfair Display', serif; color: #2c3e50;">Riwayat Peminjaman Saya</h2>
        <p class="text-gray-500 mb-6">Berikut adalah daftar buku yang pernah Anda pinjam.</p>

        <table class="table-custom">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Judul Buku</th>
                    <th>Tgl Pinjam</th>
                    <th>Tgl Kembali</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($peminjaman as $index => $p)
                <tr>
                    <td>{{ $index + 1 }}</td>
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
                <tr><td colspan="5" class="text-center">Anda belum memiliki riwayat peminjaman.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-app-layout>