<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - E-Perpus</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>body { font-family: 'Plus Jakarta Sans', sans-serif; }</style>
</head>
<body class="bg-slate-950 text-slate-100 min-h-screen">
    <?php echo $__env->make('layouts.nav_admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <div class="py-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mb-8">
            <h1 class="text-3xl font-bold tracking-tight text-white">Panel Administrator</h1>
            <p class="text-slate-400 text-sm mt-1">Ringkasan status dan aktivitas perpustakaan digital</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-slate-900/60 backdrop-blur-md border border-slate-800/80 p-6 rounded-3xl">
                <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Total Koleksi Buku</span>
                <p class="text-4xl font-extrabold text-white mt-2"><?php echo e($totalBuku ?? 0); ?></p>
                <a href="<?php echo e(route('buku.index')); ?>" class="inline-flex items-center text-xs text-indigo-400 font-semibold mt-4 hover:underline">Kelola Koleksi Buku &rarr;</a>
            </div>

            <div class="bg-slate-900/60 backdrop-blur-md border border-slate-800/80 p-6 rounded-3xl">
                <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Total Pengguna Terdaftar</span>
                <p class="text-4xl font-extrabold text-white mt-2"><?php echo e($totalUser ?? 0); ?></p>
                <a href="<?php echo e(route('users.index')); ?>" class="inline-flex items-center text-xs text-indigo-400 font-semibold mt-4 hover:underline">Atur Role Pengguna &rarr;</a>
            </div>

            <div class="bg-slate-900/60 backdrop-blur-md border border-slate-800/80 p-6 rounded-3xl">
                <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Status Sistem</span>
                <p class="text-lg font-bold text-emerald-400 mt-3 flex items-center space-x-2">
                    <span class="w-3 h-3 rounded-full bg-emerald-400 animate-pulse"></span>
                    <span>Aktif Normal</span>
                </p>
                <span class="text-xs text-slate-500 mt-2 block">Database & Auth Terhubung</span>
            </div>
        </div>
    </div>
</body>
</html><?php /**PATH C:\Users\Lenovo\Documents\SEMESTER 3\PRAKTIKUM PBWL\Pemrograman-Berbasis-Web-Lanjut-3A-2026\Modul-5\250441100037_Muhamad Fiki Arya Kusuma\perpustakaan_250441100037\resources\views/dashboard/admin.blade.php ENDPATH**/ ?>