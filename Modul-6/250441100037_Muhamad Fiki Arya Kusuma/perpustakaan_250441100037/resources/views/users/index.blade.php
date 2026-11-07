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
    @include('layouts.nav_admin')

    <div class="py-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mb-8">
            <h1 class="text-3xl font-bold tracking-tight text-white">Manajemen Akun & Role Pengguna</h1>
            <p class="text-slate-400 text-sm mt-1">Atur hak akses pengguna menjadi Petugas atau Siswa</p>
        </div>

        @if(session('success'))
            <div class="mb-6 p-4 bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 rounded-2xl text-xs font-semibold">
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="mb-6 p-4 bg-rose-500/10 border border-rose-500/20 text-rose-400 rounded-2xl text-xs font-semibold">
                {{ session('error') }}
            </div>
        @endif

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
                        @forelse($users as $index => $user)
                            <tr class="hover:bg-slate-800/30 transition">
                                <td class="py-4 px-4 text-slate-500 font-medium">{{ $index + 1 }}</td>
                                <td class="py-4 px-4 font-bold text-white">{{ $user->name }}</td>
                                <td class="py-4 px-4 text-slate-400 text-xs">{{ $user->email }}</td>
                                <td class="py-4 px-4">
                                    <span class="px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider
                                        {{ $user->hasRole('admin') ? 'bg-purple-500/10 text-purple-400 border border-purple-500/20' : '' }}
                                        {{ $user->hasRole('petugas') ? 'bg-blue-500/10 text-blue-400 border border-blue-500/20' : '' }}
                                        {{ $user->hasRole('siswa') ? 'bg-emerald-500/10 text-emerald-400 border border-emerald-500/20' : '' }}">
                                        {{ $user->getRoleNames()->first() ?? 'Siswa' }}
                                    </span>
                                </td>
                                <td class="py-4 px-4 text-right">
                                    @if($user->hasRole('admin'))
                                        <span class="text-xs text-slate-500 italic font-semibold">Admin Utama (Permanen)</span>
                                    @else
                                        <form action="{{ route('users.updateRole', $user->id) }}" method="POST" class="inline-flex items-center space-x-2">
                                            @csrf
                                            @method('PUT')
                                            <select name="role" class="bg-slate-950 border border-slate-800 rounded-xl px-3 py-1.5 text-xs text-slate-200 focus:outline-none focus:border-indigo-500">
                                                @foreach($roles as $role)
                                                    <option value="{{ $role->name }}" {{ $user->hasRole($role->name) ? 'selected' : '' }}>
                                                        {{ ucfirst($role->name) }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <button type="submit" class="px-3 py-1.5 bg-indigo-600 hover:bg-indigo-500 text-white font-semibold text-xs rounded-xl transition">
                                                Simpan
                                            </button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-8 text-center text-slate-500 text-sm">Tidak ada data pengguna.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>