<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Peminjaman ID: {{ $peminjaman->id }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>body { font-family: 'Plus Jakarta Sans', sans-serif; }</style>
</head>
<body class="bg-slate-950 text-slate-100 min-h-screen p-8">
    <div class="max-w-3xl mx-auto bg-slate-900 border border-slate-800 rounded-3xl p-6 shadow-2xl">
        <div class="mb-6 border-b border-slate-800 pb-4 flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold text-white">Detail Peminjaman Buku</h1>
                <p class="text-xs text-slate-400 mt-1">ID Peminjaman: #{{ $peminjaman->id }}</p>
            </div>
            <span class="px-3 py-1 bg-indigo-500/10 text-indigo-400 border border-indigo-500/20 text-xs font-bold rounded-full">
                {{ ucfirst($peminjaman->status) }}
            </span>
        </div>

        <div class="space-y-4 text-sm">
            <div class="flex justify-between border-b border-slate-800/60 pb-3">
                <span class="text-slate-400">Nama Peminjam:</span>
                <span class="font-bold text-white">{{ $peminjaman->user->name ?? 'User ID: '.$peminjaman->user_id }}</span>
            </div>
            <div class="flex justify-between border-b border-slate-800/60 pb-3">
                <span class="text-slate-400">Judul Buku:</span>
                <span class="font-bold text-indigo-400">{{ $peminjaman->buku->judul ?? 'Buku ID: '.$peminjaman->buku_id }}</span>
            </div>
            <div class="flex justify-between border-b border-slate-800/60 pb-3">
                <span class="text-slate-400">Tanggal Pinjam:</span>
                <span class="text-slate-300">{{ $peminjaman->tanggal_pinjam }}</span>
            </div>
            <div class="flex justify-between pb-2">
                <span class="text-slate-400">Tanggal Rencana Kembali:</span>
                <span class="text-slate-300">{{ $peminjaman->tanggal_kembali }}</span>
            </div>
        </div>
    </div>
</body>
</html>