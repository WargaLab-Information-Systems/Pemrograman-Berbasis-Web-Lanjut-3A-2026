<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Validasi Peminjaman - E-Perpus Admin/Petugas</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>body { font-family: 'Plus Jakarta Sans', sans-serif; }</style>
</head>
<body class="bg-slate-950 text-slate-100 min-h-screen">
    @include('layouts.nav_admin')

    <div class="py-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        @if(session('success'))
            <div class="mb-6 p-4 bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 rounded-2xl text-xs font-semibold">
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="mb-6 p-4 bg-rose-500/10 border border-rose-500/20 text-rose-400 rounded-2xl text-xs font-semibold">
                {{ session('error') }}
            </div>
        @endif

        <div class="mb-8">
            <h1 class="text-3xl font-bold tracking-tight text-white">Kelola & Validasi Peminjaman</h1>
            <p class="text-slate-400 text-sm mt-1">Konfirmasi pengajuan pinjaman dan pengembalian buku siswa</p>
        </div>

        <div class="bg-slate-900/60 backdrop-blur-md border border-slate-800/80 rounded-3xl p-6 shadow-2xl overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b border-slate-800 text-slate-400 text-xs font-bold uppercase tracking-wider">
                            <th class="pb-4 px-4">No</th>
                            <th class="pb-4 px-4">Peminjam</th>
                            <th class="pb-4 px-4">Buku</th>
                            <th class="pb-4 px-4">Tgl Pinjam</th>
                            <th class="pb-4 px-4">Rencana Kembali</th>
                            <th class="pb-4 px-4">Status</th>
                            <th class="pb-4 px-4 text-right">Aksi Validasi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-800/60 text-sm">
                        @if(isset($peminjamans) && count($peminjamans) > 0)
                            @foreach($peminjamans as $index => $item)
                                <tr class="hover:bg-slate-800/30 transition">
                                    <td class="py-4 px-4 text-slate-500 font-medium">{{ $index + 1 }}</td>
                                    <td class="py-4 px-4 font-bold text-white">{{ $item->user->name ?? '-' }}</td>
                                    <td class="py-4 px-4 text-slate-300">{{ $item->buku->judul ?? '-' }}</td>
                                    <td class="py-4 px-4 text-slate-400 text-xs">{{ $item->tanggal_pinjam ?? '-' }}</td>
                                    <td class="py-4 px-4 text-slate-400 text-xs">{{ $item->tanggal_kembali ?? '-' }}</td>
                                    
                                    {{-- Status Badge --}}
                                    <td class="py-4 px-4">
                                        @if($item->status == 'diajukan')
                                            <span class="px-3 py-1 bg-amber-500/10 text-amber-400 border border-amber-500/20 text-[11px] font-bold rounded-full">Diajukan</span>
                                        @elseif($item->status == 'dipinjam')
                                            <span class="px-3 py-1 bg-blue-500/10 text-blue-400 border border-blue-500/20 text-[11px] font-bold rounded-full">Sedang Dipinjam</span>
                                        @elseif($item->status == 'menunggu_kembali')
                                            <span class="px-3 py-1 bg-orange-500/10 text-orange-400 border border-orange-500/20 text-[11px] font-bold rounded-full animate-pulse">Menunggu Konfirmasi Kembali</span>
                                        @elseif($item->status == 'dikembalikan')
                                            <span class="px-3 py-1 bg-emerald-500/10 text-emerald-400 border border-emerald-500/20 text-[11px] font-bold rounded-full">Dikembalikan</span>
                                        @else
                                            <span class="px-3 py-1 bg-rose-500/10 text-rose-400 border border-rose-500/20 text-[11px] font-bold rounded-full">Ditolak</span>
                                        @endif
                                    </td>

                                    {{-- Tombol Aksi Petugas --}}
                                    <td class="py-4 px-4 text-right space-x-2">
                                        @if($item->status == 'diajukan')
                                            <form action="{{ route('peminjaman.validasiPinjam', $item->id) }}" method="POST" class="inline">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="action" value="setuju">
                                                <button type="submit" class="px-3 py-1.5 bg-emerald-600 hover:bg-emerald-500 text-white text-xs font-semibold rounded-xl transition">Setujui</button>
                                            </form>
                                            <form action="{{ route('peminjaman.validasiPinjam', $item->id) }}" method="POST" class="inline">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="action" value="tolak">
                                                <button type="submit" class="px-3 py-1.5 bg-rose-600 hover:bg-rose-500 text-white text-xs font-semibold rounded-xl transition">Tolak</button>
                                            </form>
                                        @elseif($item->status == 'menunggu_kembali')
                                            <form action="{{ route('peminjaman.validasiKembali', $item->id) }}" method="POST" class="inline">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit" class="px-3 py-1.5 bg-indigo-600 hover:bg-indigo-500 text-white text-xs font-semibold rounded-xl transition">Konfirmasi Dikembalikan</button>
                                            </form>
                                        @else
                                            <span class="text-xs text-slate-600 italic">-</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="7" class="py-8 text-center text-slate-500 text-sm">Belum ada data peminjaman.</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>