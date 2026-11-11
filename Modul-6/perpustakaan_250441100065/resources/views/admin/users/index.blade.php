<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Kelola Pengguna &amp; Role</h2>
            <a href="{{ route('admin.users.create') }}" class="px-4 py-2 bg-gray-800 text-white rounded-md text-sm font-semibold hover:bg-gray-700">+ Tambah Pengguna</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-flash />

            <form method="GET" class="mb-4 flex gap-2">
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari nama / email..." class="rounded-md border-gray-300 text-sm w-64">
                <button class="px-4 py-2 bg-gray-800 text-white rounded-md text-sm font-semibold">Cari</button>
            </form>

            <div class="bg-white shadow-sm sm:rounded-lg overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 text-sm">
                    <thead class="bg-gray-50 text-left text-gray-600">
                        <tr>
                            <th class="px-4 py-3">Nama</th>
                            <th class="px-4 py-3">Email</th>
                            <th class="px-4 py-3">Role</th>
                            <th class="px-4 py-3">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach ($users as $u)
                            <tr>
                                <td class="px-4 py-3 font-medium">{{ $u->name }}</td>
                                <td class="px-4 py-3">{{ $u->email }}</td>
                                <td class="px-4 py-3">
                                    @can('kelola role pengguna')
                                        @if ($u->id !== Auth::id())
                                            <form method="POST" action="{{ route('admin.users.role', $u) }}" class="flex gap-2 items-center">
                                                @csrf
                                                @method('PATCH')
                                                <select name="role" class="rounded-md border-gray-300 text-sm py-1">
                                                    @foreach ($roles as $r)
                                                        <option value="{{ $r }}" @selected($u->hasRole($r))>{{ ucfirst($r) }}</option>
                                                    @endforeach
                                                </select>
                                                <button class="px-3 py-1 bg-blue-600 text-white rounded text-xs font-semibold hover:bg-blue-500">Simpan</button>
                                            </form>
                                        @else
                                            <span class="font-semibold">{{ ucfirst($u->getRoleNames()->first()) }}</span>
                                            <span class="text-xs text-gray-400">(akunmu)</span>
                                        @endif
                                    @else
                                        {{ ucfirst($u->getRoleNames()->first() ?? '-') }}
                                    @endcan
                                </td>
                                <td class="px-4 py-3">
                                    <div class="flex gap-2">
                                        <a href="{{ route('admin.users.edit', $u) }}" class="px-3 py-1 bg-yellow-500 text-white rounded text-xs font-semibold hover:bg-yellow-400">Ubah</a>
                                        @if ($u->id !== Auth::id())
                                            <form method="POST" action="{{ route('admin.users.destroy', $u) }}" onsubmit="return confirm('Hapus pengguna {{ $u->name }}?')">
                                                @csrf
                                                @method('DELETE')
                                                <button class="px-3 py-1 bg-red-600 text-white rounded text-xs font-semibold hover:bg-red-500">Hapus</button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-4">{{ $users->links() }}</div>
        </div>
    </div>
</x-app-layout>
