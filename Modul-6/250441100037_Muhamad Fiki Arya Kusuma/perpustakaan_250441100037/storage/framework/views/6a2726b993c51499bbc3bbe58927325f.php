<nav class="bg-slate-900/90 backdrop-blur-md border-b border-slate-800 text-slate-100 sticky top-0 z-40">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">
            <div class="flex items-center space-x-8">
                <a href="<?php echo e(route('dashboard')); ?>" class="flex items-center space-x-3">
                    <div class="w-9 h-9 rounded-xl bg-gradient-to-tr from-indigo-600 to-blue-500 flex items-center justify-center font-bold text-white shadow-md shadow-indigo-500/20">
                        E
                    </div>
                    <span class="font-bold text-lg tracking-tight bg-gradient-to-r from-white to-slate-400 bg-clip-text text-transparent">E-Perpus Admin</span>
                </a>

                <div class="hidden md:flex items-center space-x-1">
                    <a href="<?php echo e(route('dashboard')); ?>" class="px-3.5 py-2 rounded-xl text-xs font-semibold text-slate-300 hover:text-white hover:bg-slate-800 transition">Dashboard</a>
                    <a href="<?php echo e(route('buku.index')); ?>" class="px-3.5 py-2 rounded-xl text-xs font-semibold text-slate-300 hover:text-white hover:bg-slate-800 transition">Kelola Buku</a>
                    <a href="<?php echo e(route('peminjaman.index')); ?>" class="px-3.5 py-2 rounded-xl text-xs font-semibold text-slate-300 hover:text-white hover:bg-slate-800 transition">Validasi Pinjaman</a>
                    <?php if (\Illuminate\Support\Facades\Blade::check('role', 'admin')): ?>
                        <a href="<?php echo e(route('users.index')); ?>" class="px-3.5 py-2 rounded-xl text-xs font-semibold text-slate-300 hover:text-white hover:bg-slate-800 transition">Kelola Users</a>
                    <?php endif; ?>
                    <a href="<?php echo e(route('laporan.index')); ?>" class="px-3.5 py-2 rounded-xl text-xs font-semibold text-slate-300 hover:text-white hover:bg-slate-800 transition">Laporan Cetak</a>
                </div>
            </div>

            <div class="flex items-center space-x-4">
                <a href="<?php echo e(route('profil.edit')); ?>" class="text-xs bg-slate-800/80 hover:bg-slate-800 border border-slate-700/60 px-3.5 py-2 rounded-xl text-slate-300 flex items-center space-x-2 transition">
                    <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                    <span class="font-semibold"><?php echo e(Auth::user()->name); ?></span>
                    <span class="bg-indigo-500/20 text-indigo-300 text-[10px] px-2 py-0.5 rounded-md border border-indigo-500/30 font-bold uppercase"><?php echo e(Auth::user()->getRoleNames()->first()); ?></span>
                </a>

                <form method="POST" action="<?php echo e(route('logout')); ?>">
                    <?php echo csrf_field(); ?>
                    <button type="submit" class="px-3.5 py-2 bg-rose-500/10 border border-rose-500/20 text-rose-400 font-semibold text-xs rounded-xl hover:bg-rose-500 hover:text-white transition duration-200">
                        Logout
                    </button>
                </form>
            </div>
        </div>
    </div>
</nav><?php /**PATH C:\Users\Lenovo\Documents\SEMESTER 3\PRAKTIKUM PBWL\Pemrograman-Berbasis-Web-Lanjut-3A-2026\Modul-6\250441100037_Muhamad Fiki Arya Kusuma\perpustakaan_250441100037\resources\views/layouts/nav_admin.blade.php ENDPATH**/ ?>