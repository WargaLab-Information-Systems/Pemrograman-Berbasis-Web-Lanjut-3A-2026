<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Transaksi Peminjaman - PDF</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        @media print {
            nav, button, .no-print { display: none !important; }
            body { background: white !important; color: black !important; padding: 0 !important; }
            .print-area { border: none !important; box-shadow: none !important; background: white !important; width: 100% !important; }
            th, td { color: black !important; border-color: #cbd5e1 !important; padding: 8px !important; }
            .print-title { display: block !important; color: black !important; margin-bottom: 20px; }
            .status-badge { border: 1px solid #94a3b8 !important; color: black !important; background: transparent !important; }
        }
    </style>
</head>
<body class="bg-slate-950 text-slate-100 min-h-screen">
    <div class="no-print">
        @include('layouts.nav_admin')
    </div>

    <div class="py-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mb-8 flex items-center justify-between no-print">
            <div>
                <h1 class="text-3xl font-bold tracking-tight text-white">Laporan Transaksi Peminjaman</h1>
                <p class="text-slate-400 text-sm mt-1">Cetak / Simpan rekapitulasi data peminjaman perpustakaan ke PDF</p>
            </div>
            
            <button onclick="window.print()" class="px-5 py-2.5 bg-gradient-to-r from-indigo-600 to-blue-600 hover:from-indigo-500 hover:to-blue-500 text-white text-xs font-semibold rounded-xl shadow-lg shadow-indigo-600/20 transition flex items-center space-x-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                <span>Cetak Laporan (PDF)</span>
            </button>
        </div>

        <div class="print-area bg-slate-900/60 backdrop-blur-md border border-slate-800/80 rounded-3xl p-6 shadow-2xl overflow-hidden">
            <!-- Header Khusus Mode Cetak PDF -->
            <div class="hidden print-title text-center border-b pb-4 mb-6">
                <h2 class="text-2xl font-bold uppercase">Laporan Rekapitulasi Peminjaman Buku</h2>
                <p class="text-xs text-slate-600 mt-1">E-Perpus Digital - Tanggal Cetak: {{ date('d-m-Y') }}</p>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b border-slate-800 text-slate-400 text-xs font-bold uppercase tracking-wider">
                            <th class="pb-4 px-4">No</th>
                            <th class="pb-4 px-4">Peminjam</th>
                            <th class="pb-4 px-4">Judul Buku</th>
                            <th class="pb-4 px-4">Tgl Pinjam</th>
                            <th class="pb-4 px-4">Rencana Kembali</th>
                            <th class="pb-4 px-4">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-800/60 text-sm">
                        @if(isset($laporans) && count($laporans) > 0)
                            @foreach($laporans as $index => $item)
                                <tr class="hover:bg-slate-800/30 transition">
                                    <td class="py-4 px-4 text-slate-500 font-medium">{{ $index + 1 }}</td>
                                    <td class="py-4 px-4 font-bold text-white">{{ $item->user->name ?? '-' }}</td>
                                    <td class="py-4 px-4 text-slate-300">{{ $item->buku->judul ?? '-' }}</td>
                                    <td class="py-4 px-4 text-slate-400 text-xs">{{ $item->tanggal_pinjam }}</td>
                                    <td class="py-4 px-4 text-slate-400 text-xs">{{ $item->tanggal_kembali }}</td>
                                    <td class="py-4 px-4">
                                        <span class="status-badge px-2.5 py-1 text-[10px] font-bold uppercase rounded-full border
                                            {{ $item->status == 'dikembalikan' ? 'bg-emerald-500/10 text-emerald-400 border-emerald-500/20' : 'bg-slate-800 text-slate-400 border-slate-700' }}">
                                            {{ ucfirst($item->status) }}
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="6" class="py-8 text-center text-slate-500 text-sm">Belum ada transaksi peminjaman.</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>