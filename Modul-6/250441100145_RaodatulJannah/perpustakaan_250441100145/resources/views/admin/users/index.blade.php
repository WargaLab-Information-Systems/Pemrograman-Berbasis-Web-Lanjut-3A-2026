<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Kelola Pengguna
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 rounded-lg shadow-sm">

                <div class="flex justify-between items-center mb-6">
                    <div>
                        <h3 class="text-lg font-bold text-gray-800">
                            Data Pengguna
                        </h3>
                        <p class="text-sm text-gray-500">
                            Kelola akun Admin, Petugas, dan Siswa.
                        </p>
                    </div>

                    <a href="{{ route('admin.users.create') }}"
                       class="bg-pink-500 hover:bg-pink-600 text-white px-4 py-2 rounded-lg">
                        + Tambah Pengguna
                    </a>
                </div>

                @if(session('success'))
                    <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
                        {{ session('error') }}
                    </div>
                @endif

                <div class="overflow-x-auto">
                    <table class="w-full border-collapse">
                        <thead>
                            <tr class="bg-pink-100 text-left">
                                <th class="p-3 border">No.</th>
                                <th class="p-3 border">Nama</th>
                                <th class="p-3 border">Email</th>
                                <th class="p-3 border">Role</th>
                                <th class="p-3 border">Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse($users as $index => $user)
                                <tr class="hover:bg-pink-50">

                                    <td class="p-3 border">
                                        {{ $users->firstItem() + $index }}
                                    </td>

                                    <td class="p-3 border">
                                        {{ $user->name }}
                                    </td>

                                    <td class="p-3 border">
                                        {{ $user->email }}
                                    </td>

                                    <td class="p-3 border">
                                        {{ $user->getRoleNames()->implode(', ') }}
                                    </td>

                                    <td class="p-3 border">
                                        <div class="flex items-center gap-2">

                                            <a href="{{ route('admin.users.edit', ['user' => $user->getKey()]) }}"
                                               class="bg-yellow-400 hover:bg-yellow-500 text-gray-900 font-semibold px-4 py-2 rounded-lg text-sm">
                                                Edit
                                            </a>

                                            @if($user->getKey() != auth()->id())
                                                <form action="{{ route('admin.users.destroy', ['user' => $user->getKey()]) }}"
                                                      method="POST"
                                                      onsubmit="return confirm('Yakin ingin menghapus pengguna ini?')">

                                                    @csrf
                                                    @method('DELETE')

                                                    <button type="submit"
                                                            class="bg-red-600 hover:bg-red-700 text-white font-semibold px-4 py-2 rounded-lg text-sm">
                                                        Hapus
                                                    </button>
                                                </form>
                                            @endif

                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="p-4 text-center text-gray-500">
                                        Belum ada data pengguna.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-5">
                    {{ $users->links() }}
                </div>

                <a href="{{ route('admin.dashboard') }}"
                   class="inline-block mt-5 text-pink-600 hover:underline">
                    Kembali ke Dashboard
                </a>

            </div>
        </div>
    </div>
</x-app-layout>