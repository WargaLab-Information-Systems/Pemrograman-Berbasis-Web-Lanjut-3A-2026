<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Perpustakaan Suki')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Merriweather:ital,opsz,wght@0,18..144,300..900;1,18..144,300..900&family=Source+Code+Pro:ital,wght@0,200..900;1,200..900&display=swap" rel="stylesheet">

    @vite('resources/css/app.css')
</head>
<body class="min-h-screen flex flex-col bg-slate-200 text-stone-800 font-poppins">
    <header class="bg-white text-stone-900 pt-2 pb-2 px-8 w-full h-auto justify-between items-center shadow-md sticky top-0 z-50">
        <div class="relative flex justify-between items-center">
            <div class="flex items-center gap-3">
                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-book preview-icon"><path d="M4 19.5v-15A2.5 2.5 0 0 1 6.5 2H19a1 1 0 0 1 1 1v18a1 1 0 0 1-1 1H6.5a1 1 0 0 1 0-5H20"/></svg>
                <div class="flex flex-col text-left">
                    <h1 class="text-2xl font-bold m-0">Perpustakaan Suki</h1>
                    <p class="mt-1 text-sm text-stone-300">Temukan dan kelola koleksi buku dengan mudah</p>
                </div>
            </div>
            <nav class="absolute left-1/2 -translate-x-1/2 bg-slate-100 flex justify-center gap-2 rounded-xl p-1">
                <a href="{{ route('home') }}"
                class="font-semibold px-4 py-1.5 rounded-md transition-colors
                        {{ request()->routeIs('home') ? 'bg-stone-900 text-white' : 'hover:bg-slate-400 text-stone-900' }}">
                    Beranda
                </a>
                <a href="{{ route('buku.index') }}"
                class="font-semibold px-4 py-1.5 rounded-md transition-colors
                        {{ request()->routeIs('buku.*') ? 'bg-stone-900 text-white' : 'hover:bg-slate-400 text-stone-900' }}">
                    Daftar Buku
                </a>
            </nav>
            <div>
                <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-user preview-icon bg-gray-100 rounded-xl"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
            </div>
        </div>
    </header>

    <main class="flex-1 w-full">
        @yield('content')
    </main>

<footer class="w-full bg-[#1C1612] text-stone-300 font-sans mt-20 border-t-4 border-amber-800">
    <div class="max-w-7xl mx-auto px-6 py-12">
        <div class="grid grid-cols-2 gap-8 pb-10 border-b border-stone-800">
            <div class="col-span-1 flex flex-col gap-3.5">
                <div class="flex items-center gap-2.5">
                    <div class="bg-amber-700 text-stone-900 p-2 rounded-xl shadow-md">
                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 19.5v-15A2.5 2.5 0 0 1 6.5 2H20v20H6.5a2.5 2.5 0 0 1 0-5H20"/></svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-stone-100 font-['Merriweather'] tracking-tight">Perpustakaan Suki</h3>
                        <p class="text-[10px] font-mono text-amber-600 uppercase tracking-wider">Katalog & Repository Pustaka</p>
                    </div>
                </div>
                <p class="text-xs text-stone-400 leading-relaxed max-w-sm">
                    Pusat layanan literasi digital, arsip ilmu pengetahuan, dan koleksi pustaka akademik untuk mendukung kegiatan pembelajaran, penelitian, dan studi mandiri.
                </p>
            </div>
            <div class="row-span-2">
                <h4 class="text-xs font-bold text-amber-500 uppercase tracking-wider mb-4 font-mono flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 7v14"/><path d="M3 18a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1h5a4 4 0 0 1 4 4 4 4 0 0 1 4-4h5a1 1 0 0 1 1 1v13a1 1 0 0 1-1 1h-6a3 3 0 0 0-3 3 3 3 0 0 0-3-3z"/></svg>
                    Kategori Pustaka
                </h4>
                <ul class="space-y-2.5 text-xs text-stone-400">
                    <li>
                        <p class="hover:text-amber-400 transition-colors inline-flex items-center gap-2">
                            <span class="text-amber-700">›</span> Filosofi & Pemikiran
                        </p>
                    </li>
                    <li>
                        <p class="hover:text-amber-400 transition-colors inline-flex items-center gap-2">
                            <span class="text-amber-700">›</span> Fiksi & Novel Sastra
                        </p>
                    </li>
                    <li>
                        <p class="hover:text-amber-400 transition-colors inline-flex items-center gap-2">
                            <span class="text-amber-700">›</span> Pengembangan Diri
                        </p>
                    </li>
                    <li>
                        <p class="hover:text-amber-400 transition-colors inline-flex items-center gap-2">
                            <span class="text-amber-700">›</span> Sains & Teknologi
                        </p>
                    </li>
                </ul>
            </div>

        </div>
        <div class="pt-6 flex flex-col sm:flex-row items-center justify-center gap-4 text-xs text-stone-500">
            <p>© {{ date('Y') }} Perpustakaan Suki. Dikelola oleh Andreas Tri Zidan Ramadhan.</p>
        </div>
    </div>
</footer>
</body>
</html>
