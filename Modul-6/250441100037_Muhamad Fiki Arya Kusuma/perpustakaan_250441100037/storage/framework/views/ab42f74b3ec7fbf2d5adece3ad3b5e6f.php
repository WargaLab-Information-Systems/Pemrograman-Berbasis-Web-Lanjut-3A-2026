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
    <?php echo $__env->make('layouts.nav_admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

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
                        <?php if(isset($peminjamans) && count($peminjamans) > 0): ?>
                            <?php $__currentLoopData = $peminjamans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr class="hover:bg-slate-800/30 transition">
                                    <td class="py-4 px-4 text-slate-500 font-medium"><?php echo e($index + 1); ?></td>
                                    <td class="py-4 px-4 font-bold text-white"><?php echo e($item->user->name ?? '-'); ?></td>
                                    <td class="py-4 px-4 text-slate-300"><?php echo e($item->buku->judul ?? '-'); ?></td>
                                    <td class="py-4 px-4 text-slate-400 text-xs"><?php echo e($item->tanggal_pinjam ?? '-'); ?></td>
                                    <td class="py-4 px-4 text-slate-400 text-xs"><?php echo e($item->tanggal_kembali ?? '-'); ?></td>
                                    
                                    
                                    <td class="py-4 px-4">
                                        <?php if($item->status == 'diajukan'): ?>
                                            <span class="px-3 py-1 bg-amber-500/10 text-amber-400 border border-amber-500/20 text-[11px] font-bold rounded-full">Diajukan</span>
                                        <?php elseif($item->status == 'dipinjam'): ?>
                                            <span class="px-3 py-1 bg-blue-500/10 text-blue-400 border border-blue-500/20 text-[11px] font-bold rounded-full">Sedang Dipinjam</span>
                                        <?php elseif($item->status == 'menunggu_kembali'): ?>
                                            <span class="px-3 py-1 bg-orange-500/10 text-orange-400 border border-orange-500/20 text-[11px] font-bold rounded-full animate-pulse">Menunggu Konfirmasi Kembali</span>
                                        <?php elseif($item->status == 'dikembalikan'): ?>
                                            <span class="px-3 py-1 bg-emerald-500/10 text-emerald-400 border border-emerald-500/20 text-[11px] font-bold rounded-full">Dikembalikan</span>
                                        <?php else: ?>
                                            <span class="px-3 py-1 bg-rose-500/10 text-rose-400 border border-rose-500/20 text-[11px] font-bold rounded-full">Ditolak</span>
                                        <?php endif; ?>
                                    </td>

                                    
                                    <td class="py-4 px-4 text-right space-x-2">
                                        <?php if($item->status == 'diajukan'): ?>
                                            <form action="<?php echo e(route('peminjaman.validasiPinjam', $item->id)); ?>" method="POST" class="inline">
                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('PUT'); ?>
                                                <input type="hidden" name="action" value="setuju">
                                                <button type="submit" class="px-3 py-1.5 bg-emerald-600 hover:bg-emerald-500 text-white text-xs font-semibold rounded-xl transition">Setujui</button>
                                            </form>
                                            <form action="<?php echo e(route('peminjaman.validasiPinjam', $item->id)); ?>" method="POST" class="inline">
                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('PUT'); ?>
                                                <input type="hidden" name="action" value="tolak">
                                                <button type="submit" class="px-3 py-1.5 bg-rose-600 hover:bg-rose-500 text-white text-xs font-semibold rounded-xl transition">Tolak</button>
                                            </form>
                                        <?php elseif($item->status == 'menunggu_kembali'): ?>
                                            <form action="<?php echo e(route('peminjaman.validasiKembali', $item->id)); ?>" method="POST" class="inline">
                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('PUT'); ?>
                                                <button type="submit" class="px-3 py-1.5 bg-indigo-600 hover:bg-indigo-500 text-white text-xs font-semibold rounded-xl transition">Konfirmasi Dikembalikan</button>
                                            </form>
                                        <?php else: ?>
                                            <span class="text-xs text-slate-600 italic">-</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="7" class="py-8 text-center text-slate-500 text-sm">Belum ada data peminjaman.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html><?php /**PATH C:\Users\Lenovo\Documents\SEMESTER 3\PRAKTIKUM PBWL\Pemrograman-Berbasis-Web-Lanjut-3A-2026\Modul-6\250441100037_Muhamad Fiki Arya Kusuma\perpustakaan_250441100037\resources\views/peminjaman/index.blade.php ENDPATH**/ ?>