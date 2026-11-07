<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Katalog Buku - E-Perpus Siswa</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>body { font-family: 'Plus Jakarta Sans', sans-serif; }</style>
</head>
<body class="bg-slate-950 text-slate-100 min-h-screen">
    <?php echo $__env->make('layouts.nav_siswa', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <div class="py-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <?php if(session('success')): ?>
            <div class="mb-6 p-4 bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 rounded-2xl text-xs font-semibold flex items-center space-x-3">
                <svg class="w-5 h-5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                <span><?php echo e(session('success')); ?></span>
            </div>
        <?php endif; ?>

        <div class="flex flex-col md:flex-row md:items-center justify-between mb-8 gap-4">
            <div>
                <h1 class="text-3xl font-bold tracking-tight text-white">Katalog Buku Digital</h1>
                <p class="text-slate-400 text-sm mt-1">Eksplorasi dan ajukan peminjaman buku perpustakaan secara online</p>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php $__empty_1 = true; $__currentLoopData = $bukus; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $buku): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <div class="bg-slate-900/60 backdrop-blur-md rounded-3xl border border-slate-800/80 p-6 flex flex-col justify-between hover:border-slate-700 transition duration-300">
                    <div>
                        <div class="flex items-center justify-between mb-4">
                            <span class="text-[11px] font-bold tracking-wider uppercase bg-indigo-500/10 text-indigo-400 border border-indigo-500/20 px-3 py-1 rounded-full">
                                <?php echo e($buku->kategori->nama ?? 'Umum'); ?>

                            </span>
                            <span class="text-xs text-slate-500 font-medium">Tahun <?php echo e($buku->tahun_terbit); ?></span>
                        </div>

                        <h3 class="text-xl font-bold text-white mb-2 leading-snug"><?php echo e($buku->judul); ?></h3>
                        <p class="text-slate-400 text-xs flex items-center space-x-1.5">
                            <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                            <span>Penulis: <?php echo e($buku->penulis); ?></span>
                        </p>
                    </div>

                    <div class="mt-8 pt-4 border-t border-slate-800/80 flex items-center justify-between gap-3">
                        <a href="<?php echo e(route('buku.show', $buku->id)); ?>" class="px-4 py-2.5 bg-slate-800 hover:bg-slate-700 text-slate-200 text-xs font-semibold rounded-xl transition">
                            Detail
                        </a>

                        <?php
                            $sedangDipinjam = $buku->peminjamans->isNotEmpty();
                        ?>

                        <?php if($sedangDipinjam): ?>
                            <span class="px-4 py-2.5 bg-rose-500/10 border border-rose-500/20 text-rose-400 text-xs font-semibold rounded-xl cursor-not-allowed">
                                Tidak Tersedia
                            </span>
                        <?php else: ?>
                            <button onclick="openModalPinjam('<?php echo e($buku->id); ?>', '<?php echo e($buku->judul); ?>')" class="px-4 py-2.5 bg-gradient-to-r from-indigo-600 to-blue-600 hover:from-indigo-500 hover:to-blue-500 text-white text-xs font-semibold rounded-xl shadow-lg shadow-indigo-600/20 transition">
                                Pinjam Buku
                            </button>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <div class="col-span-full bg-slate-900/40 rounded-3xl border border-slate-800 p-12 text-center text-slate-500">
                    Tidak ada koleksi buku yang ditemukan.
                </div>
            <?php endif; ?>
        </div>

        <div class="mt-8">
            <?php echo e($bukus->links()); ?>

        </div>
    </div>

    <!-- MODAL POPUP FIX CENTERING & MODERN STYLE -->
    <div id="modalPinjam" class="fixed inset-0 bg-slate-950/80 backdrop-blur-md hidden items-center justify-center p-4 z-50">
        <div class="bg-slate-900 border border-slate-800 rounded-3xl max-w-md w-full p-6 shadow-2xl relative">
            <h3 class="text-xl font-bold text-white mb-4 pb-3 border-b border-slate-800">Pengajuan Peminjaman Buku</h3>
            
            <?php if($errors->any()): ?>
                <div class="mb-4 p-3.5 bg-rose-500/10 border border-rose-500/20 text-rose-400 rounded-xl text-xs font-semibold space-y-1">
                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <p>• <?php echo e($error); ?></p>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            <?php endif; ?>

            <form action="<?php echo e(route('peminjaman.storeSiswa')); ?>" method="POST" class="space-y-4">
                <?php echo csrf_field(); ?>
                <input type="hidden" name="buku_id" id="modalBukuId" value="<?php echo e(old('buku_id')); ?>">
                <input type="hidden" name="judul_buku" id="hiddenJudulBuku" value="<?php echo e(old('judul_buku')); ?>">

                <div>
                    <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Judul Buku</label>
                    <input type="text" id="modalJudulBuku" value="<?php echo e(old('judul_buku')); ?>" readonly class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-3 text-sm text-indigo-300 font-bold focus:outline-none">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Tanggal Pinjam</label>
                    <input type="date" name="tanggal_pinjam" value="<?php echo e(old('tanggal_pinjam', date('Y-m-d'))); ?>" required class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-3 text-sm text-slate-100 focus:outline-none focus:border-indigo-500">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Rencana Tanggal Kembali</label>
                    <input type="date" name="tanggal_kembali" value="<?php echo e(old('tanggal_kembali')); ?>" required class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-3 text-sm text-slate-100 focus:outline-none focus:border-indigo-500">
                </div>

                <div class="flex items-center justify-end space-x-3 pt-4 border-t border-slate-800">
                    <button type="button" onclick="closeModalPinjam()" class="px-5 py-2.5 bg-slate-800 hover:bg-slate-700 text-slate-300 font-semibold text-xs rounded-xl transition">Batal</button>
                    <button type="submit" class="px-5 py-2.5 bg-gradient-to-r from-indigo-600 to-blue-600 hover:from-indigo-500 hover:to-blue-500 text-white font-semibold text-xs rounded-xl shadow-lg shadow-indigo-600/20 transition">Kirim Pengajuan</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openModalPinjam(id, judul) {
            document.getElementById('modalBukuId').value = id;
            document.getElementById('hiddenJudulBuku').value = judul;
            document.getElementById('modalJudulBuku').value = judul;
            
            const modal = document.getElementById('modalPinjam');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function closeModalPinjam() {
            const modal = document.getElementById('modalPinjam');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }

        document.addEventListener('DOMContentLoaded', () => {
            const hasError = document.querySelector('#modalPinjam .bg-rose-500\\/10');
            if (hasError) {
                const modal = document.getElementById('modalPinjam');
                modal.classList.remove('hidden');
                modal.classList.add('flex');
            }
        });
    </script>
</body>
</html><?php /**PATH C:\Users\Lenovo\Documents\SEMESTER 3\PRAKTIKUM PBWL\Pemrograman-Berbasis-Web-Lanjut-3A-2026\Modul-5\250441100037_Muhamad Fiki Arya Kusuma\perpustakaan_250441100037\resources\views/dashboard/siswa.blade.php ENDPATH**/ ?>