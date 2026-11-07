<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Peminjaman - E-Perpus Siswa</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>body { font-family: 'Plus Jakarta Sans', sans-serif; }</style>
</head>
<body class="bg-slate-950 text-slate-100 min-h-screen">
    <?php echo $__env->make('layouts.nav_siswa', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <div class="py-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <?php if(session('success')): ?>
            <div class="mb-6 p-4 bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 rounded-2xl text-xs font-semibold">
                <?php echo e(session('success')); ?>

            </div>
        <?php endif; ?>
        <?php if(session('error')): ?>
            <div class="mb-6 p-4 bg-rose-500/10 border border-rose-500/20 text-rose-400 rounded-2xl text-xs font-semibold">
                <?php echo e(session('error')); ?>

            </div>
        <?php endif; ?>

        <div class="mb-8">
            <h1 class="text-3xl font-bold tracking-tight text-white">Status & Riwayat Peminjaman</h1>
            <p class="text-slate-400 text-sm mt-1">Pantau status pengajuan peminjaman dan pengembalian buku Anda</p>
        </div>

        <div class="bg-slate-900/60 backdrop-blur-md border border-slate-800/80 rounded-3xl p-6 shadow-2xl overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b border-slate-800 text-slate-400 text-xs font-bold uppercase tracking-wider">
                            <th class="pb-4 px-4">No</th>
                            <th class="pb-4 px-4">Judul Buku</th>
                            <th class="pb-4 px-4">Tgl Pinjam</th>
                            <th class="pb-4 px-4">Rencana Kembali</th>
                            <th class="pb-4 px-4">Status</th>
                            <th class="pb-4 px-4 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-800/60 text-sm">
                        <?php $__empty_1 = true; $__currentLoopData = $riwayats; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr class="hover:bg-slate-800/30 transition">
                                <td class="py-4 px-4 text-slate-500 font-medium"><?php echo e($index + 1); ?></td>
                                <td class="py-4 px-4 font-bold text-white"><?php echo e($item->buku->judul ?? '-'); ?></td>
                                <td class="py-4 px-4 text-slate-400 text-xs"><?php echo e($item->tanggal_pinjam ?? '-'); ?></td>
                                <td class="py-4 px-4 text-slate-400 text-xs"><?php echo e($item->tanggal_kembali ?? '-'); ?></td>
                                
                                <td class="py-4 px-4">
                                    <?php if($item->status == 'diajukan'): ?>
                                        <span class="px-3 py-1 bg-amber-500/10 text-amber-400 border border-amber-500/20 text-[11px] font-bold rounded-full">Menunggu Validasi</span>
                                    <?php elseif($item->status == 'dipinjam'): ?>
                                        <?php
                                            $isOverdue = false;
                                            if (!empty($item->tanggal_kembali)) {
                                                $tglKembali = \Carbon\Carbon::parse($item->tanggal_kembali);
                                                $isOverdue = $tglKembali->isPast() && !$tglKembali->isToday();
                                            }
                                        ?>

                                        <?php if($isOverdue): ?>
                                            <span class="px-3 py-1 bg-rose-500/20 text-rose-400 border border-rose-500/30 text-[11px] font-bold rounded-full animate-pulse">
                                                Terlambat (Lewat HPL)
                                            </span>
                                        <?php else: ?>
                                            <span class="px-3 py-1 bg-blue-500/10 text-blue-400 border border-blue-500/20 text-[11px] font-bold rounded-full">
                                                Sedang Dipinjam
                                            </span>
                                        <?php endif; ?>
                                    <?php elseif($item->status == 'menunggu_kembali'): ?>
                                        <span class="px-3 py-1 bg-orange-500/10 text-orange-400 border border-orange-500/20 text-[11px] font-bold rounded-full">Proses Pengembalian</span>
                                    <?php elseif($item->status == 'dikembalikan'): ?>
                                        <span class="px-3 py-1 bg-emerald-500/10 text-emerald-400 border border-emerald-500/20 text-[11px] font-bold rounded-full">Sudah Dikembalikan</span>
                                    <?php else: ?>
                                        <span class="px-3 py-1 bg-rose-500/10 text-rose-400 border border-rose-500/20 text-[11px] font-bold rounded-full">Ditolak</span>
                                    <?php endif; ?>
                                </td>

                                <td class="py-4 px-4 text-right">
                                    <?php if($item->status == 'dipinjam'): ?>
                                        <form action="<?php echo e(route('peminjaman.ajukanKembali', $item->id)); ?>" method="POST" class="inline">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('PUT'); ?>
                                            <button type="submit" onclick="return confirm('Kembalikan buku ini?');" class="px-3.5 py-1.5 bg-amber-600 hover:bg-amber-500 text-white text-xs font-semibold rounded-xl transition shadow-lg shadow-amber-600/20">
                                                Kembalikan Buku
                                            </button>
                                        </form>
                                    <?php else: ?>
                                        <span class="text-xs text-slate-600 italic">-</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="6" class="py-8 text-center text-slate-500 text-sm">Belum ada riwayat peminjaman.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html><?php /**PATH C:\Users\Lenovo\Documents\SEMESTER 3\PRAKTIKUM PBWL\Pemrograman-Berbasis-Web-Lanjut-3A-2026\Modul-5\250441100037_Muhamad Fiki Arya Kusuma\perpustakaan_250441100037\resources\views/peminjaman/riwayat.blade.php ENDPATH**/ ?>