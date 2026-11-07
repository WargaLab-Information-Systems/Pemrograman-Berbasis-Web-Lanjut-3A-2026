<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Buku - E-Perpus</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>body { font-family: 'Plus Jakarta Sans', sans-serif; }</style>
</head>
<body class="bg-slate-950 text-slate-100 min-h-screen">
    @role('siswa')
        @include('layouts.nav_siswa')
    @else
        @include('layouts.nav_admin')
    @endrole

    <div class="py-10 max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-slate-900/60 backdrop-blur-md border border-slate-800/80 rounded-3xl p-8 shadow-2xl relative overflow-hidden">
            <!-- Decorative Glow -->
            <div class="absolute -top-10 -right-10 w-40 h-40 bg-indigo-600/10 rounded-full blur-2xl pointer-events-none"></div>

            <div class="flex items-center justify-between mb-6">
                <span class="text-xs font-bold uppercase tracking-wider bg-indigo-500/10 text-indigo-400 border border-indigo-500/20 px-3.5 py-1.5 rounded-full">
                    {{ $buku->kategori->nama ?? 'Umum' }}
                </span>
            </div>

            <h1 class="text-3xl font-extrabold text-white mb-2 leading-tight">{{ $buku->judul }}</h1>
            <p class="text-slate-400 text-sm mb-6">Informasi detail koleksi pustaka digital</p>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 py-6 border-y border-slate-800/80 mb-8">
                <div class="bg-slate-950/40 p-4 rounded-2xl border border-slate-800/50">
                    <span class="text-[11px] font-bold text-slate-500 uppercase tracking-wider block mb-1">Penulis / Pengarang</span>
                    <p class="text-slate-200 font-semibold text-base flex items-center space-x-2">
                        <svg class="w-4 h-4 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        <span>{{ $buku->penulis }}</span>
                    </p>
                </div>

                <div class="bg-slate-950/40 p-4 rounded-2xl border border-slate-800/50">
                    <span class="text-[11px] font-bold text-slate-500 uppercase tracking-wider block mb-1">Tahun Terbit</span>
                    <p class="text-slate-200 font-semibold text-base flex items-center space-x-2">
                        <svg class="w-4 h-4 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        <span>Tahun {{ $buku->tahun_terbit }}</span>
                    </p>
                </div>
            </div>

            <div class="flex items-center justify-between">
                <a href="{{ url()->previous() }}" class="px-5 py-2.5 bg-slate-800 hover:bg-slate-700 text-slate-300 font-semibold text-xs rounded-xl transition flex items-center space-x-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    <span>Kembali</span>
                </a>

                @role('admin|petugas')
                    <a href="{{ route('buku.edit', $buku->id) }}" class="px-5 py-2.5 bg-amber-500/20 border border-amber-500/30 text-amber-300 hover:bg-amber-500 hover:text-white text-xs font-semibold rounded-xl transition">
                        Edit Buku Ini
                    </a>
                @endrole
            </div>
        </div>
    </div>
</body>
</html>