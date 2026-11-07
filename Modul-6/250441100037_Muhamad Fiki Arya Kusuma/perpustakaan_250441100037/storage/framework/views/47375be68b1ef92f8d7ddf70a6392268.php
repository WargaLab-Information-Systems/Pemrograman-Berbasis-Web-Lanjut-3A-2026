<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Pengguna - E-Perpus Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>body { font-family: 'Plus Jakarta Sans', sans-serif; }</style>
</head>
<body class="bg-slate-950 text-slate-100 min-h-screen">
    <?php echo $__env->make('layouts.nav_admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <div class="py-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mb-8">
            <h1 class="text-3xl font-bold tracking-tight text-white">Manajemen Akun & Role Pengguna</h1>
            <p class="text-slate-400 text-sm mt-1">Atur hak akses pengguna menjadi Petugas atau Siswa</p>
        </div>

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

        <div class="bg-slate-900/60 backdrop-blur-md border border-slate-800/80 rounded-3xl p-6 shadow-2xl overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b border-slate-800 text-slate-400 text-xs font-bold uppercase tracking-wider">
                            <th class="pb-4 px-4">No</th>
                            <th class="pb-4 px-4">Nama Lengkap</th>
                            <th class="pb-4 px-4">Email</th>
                            <th class="pb-4 px-4">Role Sekarang</th>
                            <th class="pb-4 px-4 text-right">Ubah Role</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-800/60 text-sm">
                        <?php $__empty_1 = true; $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr class="hover:bg-slate-800/30 transition">
                                <td class="py-4 px-4 text-slate-500 font-medium"><?php echo e($index + 1); ?></td>
                                <td class="py-4 px-4 font-bold text-white"><?php echo e($user->name); ?></td>
                                <td class="py-4 px-4 text-slate-400 text-xs"><?php echo e($user->email); ?></td>
                                <td class="py-4 px-4">
                                    <span class="px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider
                                        <?php echo e($user->hasRole('admin') ? 'bg-purple-500/10 text-purple-400 border border-purple-500/20' : ''); ?>

                                        <?php echo e($user->hasRole('petugas') ? 'bg-blue-500/10 text-blue-400 border border-blue-500/20' : ''); ?>

                                        <?php echo e($user->hasRole('siswa') ? 'bg-emerald-500/10 text-emerald-400 border border-emerald-500/20' : ''); ?>">
                                        <?php echo e($user->getRoleNames()->first() ?? 'Siswa'); ?>

                                    </span>
                                </td>
                                <td class="py-4 px-4 text-right">
                                    <?php if($user->hasRole('admin')): ?>
                                        <span class="text-xs text-slate-500 italic font-semibold">Admin Utama (Permanen)</span>
                                    <?php else: ?>
                                        <form action="<?php echo e(route('users.updateRole', $user->id)); ?>" method="POST" class="inline-flex items-center space-x-2">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('PUT'); ?>
                                            <select name="role" class="bg-slate-950 border border-slate-800 rounded-xl px-3 py-1.5 text-xs text-slate-200 focus:outline-none focus:border-indigo-500">
                                                <?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($role->name); ?>" <?php echo e($user->hasRole($role->name) ? 'selected' : ''); ?>>
                                                        <?php echo e(ucfirst($role->name)); ?>

                                                    </option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>
                                            <button type="submit" class="px-3 py-1.5 bg-indigo-600 hover:bg-indigo-500 text-white font-semibold text-xs rounded-xl transition">
                                                Simpan
                                            </button>
                                        </form>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="5" class="py-8 text-center text-slate-500 text-sm">Tidak ada data pengguna.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html><?php /**PATH C:\Users\Lenovo\Documents\SEMESTER 3\PRAKTIKUM PBWL\Pemrograman-Berbasis-Web-Lanjut-3A-2026\Modul-6\250441100037_Muhamad Fiki Arya Kusuma\perpustakaan_250441100037\resources\views/users/index.blade.php ENDPATH**/ ?>