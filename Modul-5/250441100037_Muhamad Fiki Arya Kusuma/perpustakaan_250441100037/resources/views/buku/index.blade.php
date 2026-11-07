<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Buku - E-Perpus</title>
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

    <div class="py-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h1 class="text-3xl font-bold tracking-tight text-white">Kelola Koleksi Buku</h1>
                <p class="text-slate-400 text-sm mt-1">Tambah, edit, dan atur ketersediaan seluruh koleksi buku</p>
            </div>

            <form action="{{ route('buku.index') }}" method="GET" class="flex items-center space-x-2">
                <input type="text" name="cari" value="{{ request('cari') }}" placeholder="Cari judul/penulis..." class="bg-slate-900 border border-slate-800 rounded-xl px-4 py-2 text-xs text-slate-100 placeholder-slate-500 focus:outline-none focus:border-indigo-500">
                <button type="submit" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-500 text-white font-semibold text-xs rounded-xl transition">Cari</button>
            </form>
        </div>

        @if(session('success'))
            <div class="mb-6 p-4 bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 rounded-2xl text-xs font-semibold">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="mb-6 p-4 bg-rose-500/10 border border-rose-500/20 text-rose-400 rounded-2xl text-xs font-semibold space-y-1">
                @foreach ($errors->all() as $error)
                    <p>• {{ $error }}</p>
                @endforeach
            </div>
        @endif

        @role('admin|petugas')
        <div class="bg-slate-900/60 backdrop-blur-md border border-slate-800/80 p-6 rounded-3xl mb-8">
            <h3 class="text-lg font-bold text-white mb-4">{{ isset($bukuEdit) ? 'Edit Data Buku' : 'Tambah Buku Baru' }}</h3>
            
            <form action="{{ isset($bukuEdit) ? route('buku.update', $bukuEdit->id) : route('buku.store') }}" method="POST" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                @csrf
                @if(isset($bukuEdit))
                    @method('PUT')
                @endif

                <div>
                    <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Kategori</label>
                    <select name="kategori_id" required class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-2.5 text-xs text-slate-100 focus:outline-none focus:border-indigo-500">
                        <option value="">Pilih Kategori</option>
                        @foreach($kategoris as $kat)
                            <option value="{{ $kat->id }}" {{ (old('kategori_id', $bukuEdit->kategori_id ?? '') == $kat->id) ? 'selected' : '' }}>
                                {{ $kat->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Judul Buku</label>
                    <input type="text" name="judul" value="{{ old('judul', $bukuEdit->judul ?? '') }}" required placeholder="Masukkan Judul" class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-2.5 text-xs text-slate-100 focus:outline-none focus:border-indigo-500">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Penulis</label>
                    <input type="text" name="penulis" value="{{ old('penulis', $bukuEdit->penulis ?? '') }}" required placeholder="Nama Penulis" class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-2.5 text-xs text-slate-100 focus:outline-none focus:border-indigo-500">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Tahun Terbit</label>
                    <input type="number" name="tahun_terbit" value="{{ old('tahun_terbit', $bukuEdit->tahun_terbit ?? '') }}" required placeholder="Contoh: 2024" class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-2.5 text-xs text-slate-100 focus:outline-none focus:border-indigo-500">
                </div>

                <div class="col-span-full flex items-center justify-end space-x-2 pt-2">
                    @if(isset($bukuEdit))
                        <a href="{{ route('buku.index') }}" class="px-4 py-2 bg-slate-800 text-slate-300 font-semibold text-xs rounded-xl hover:bg-slate-700 transition">Batal Edit</a>
                    @endif
                    <button type="submit" class="px-5 py-2.5 bg-gradient-to-r from-indigo-600 to-blue-600 hover:from-indigo-500 hover:to-blue-500 text-white font-semibold text-xs rounded-xl transition shadow-lg shadow-indigo-600/20">
                        {{ isset($bukuEdit) ? 'Perbarui Data Buku' : 'Simpan Buku Baru' }}
                    </button>
                </div>
            </form>
        </div>
        @endrole

        <div class="bg-slate-900/60 backdrop-blur-md border border-slate-800/80 rounded-3xl p-6 shadow-2xl overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b border-slate-800 text-slate-400 text-xs font-bold uppercase tracking-wider">
                            <th class="pb-4 px-4">No</th>
                            <th class="pb-4 px-4">Kategori</th>
                            <th class="pb-4 px-4">Judul</th>
                            <th class="pb-4 px-4">Penulis</th>
                            <th class="pb-4 px-4">Tahun</th>
                            <th class="pb-4 px-4 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-800/60 text-sm">
                        @forelse($bukus as $index => $buku)
                            <tr class="hover:bg-slate-800/30 transition">
                                <td class="py-4 px-4 text-slate-500 font-medium">{{ $index + 1 }}</td>
                                <td class="py-4 px-4">
                                    <span class="text-[10px] font-bold uppercase bg-indigo-500/10 text-indigo-400 border border-indigo-500/20 px-2.5 py-1 rounded-full">
                                        {{ $buku->kategori->nama ?? 'Umum' }}
                                    </span>
                                </td>
                                <td class="py-4 px-4 font-bold text-white">{{ $buku->judul }}</td>
                                <td class="py-4 px-4 text-slate-400 text-xs">{{ $buku->penulis }}</td>
                                <td class="py-4 px-4 text-slate-400 text-xs">{{ $buku->tahun_terbit }}</td>
                                <td class="py-4 px-4 text-right space-x-1">
                                    <a href="{{ route('buku.show', $buku->id) }}" class="px-3 py-1.5 bg-slate-800 hover:bg-slate-700 text-slate-300 text-xs font-semibold rounded-xl transition">Detail</a>

                                    @role('admin|petugas')
                                        <a href="{{ route('buku.edit', $buku->id) }}" class="px-3 py-1.5 bg-amber-500/20 border border-amber-500/30 text-amber-300 text-xs font-semibold rounded-xl hover:bg-amber-500 hover:text-white transition">Edit</a>
                                    @endrole

                                    @role('admin')
                                        <form action="{{ route('buku.destroy', $buku->id) }}" method="POST" onsubmit="return confirm('Hapus data buku ini?');" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="px-3 py-1.5 bg-rose-500/10 border border-rose-500/20 text-rose-400 text-xs font-semibold rounded-xl hover:bg-rose-500 hover:text-white transition">Hapus</button>
                                        </form>
                                    @endrole
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-8 text-center text-slate-500 text-sm">Tidak ada data buku ditemukan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>