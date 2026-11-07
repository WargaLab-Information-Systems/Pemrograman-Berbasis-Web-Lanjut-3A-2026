<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Kelola Pengguna
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if (session('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-lg">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="mb-4 p-4 bg-red-100 text-red-700 rounded-lg">
                    {{ session('error') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="mb-4 p-4 bg-red-100 text-red-700 rounded-lg">
                    <ul class="list-disc pl-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-bold mb-4">
                    Daftar Pengguna
                </h3>

                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left">
                        <thead class="bg-pink-100 text-gray-700">
                            <tr>
                                <th class="p-3">No</th>
                                <th class="p-3">Nama</th>
                                <th class="p-3">Email</th>
                                <th class="p-3">Role</th>
                                <th class="p-3">Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($users as $user)
                                <tr class="border-b">
                                    <td class="p-3">
                                        {{ $users->firstItem() + $loop->index }}
                                    </td>

                                    <td class="p-3">{{ $user->name }}</td>

                                    <td class="p-3">{{ $user->email }}</td>

                                    <td class="p-3">
                                        {{ $user->getRoleNames()->join(', ') ?: 'Belum memiliki role' }}
                                    </td>

                                    <td class="p-3">
                                        @if ($user->id !== auth()->id())
                                            <div class="flex flex-wrap items-center gap-2">

                                                {{-- Form Ubah Role --}}
                                                <form action="{{ route('admin.users.updateRole', $user->id) }}"
                                                      method="POST"
                                                      class="flex items-center gap-2">
                                                    @csrf
                                                    @method('PATCH')

                                                    <select name="role"
                                                        class="border-gray-300 rounded-md text-sm">
                                                        @foreach ($roles as $role)
                                                            <option value="{{ $role->name }}"
                                                                @selected($user->hasRole($role->name))>
                                                                {{ $role->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>

                                                    <button type="submit"
                                                        class="px-3 py-2 bg-pink-600 text-white rounded-md hover:bg-pink-700">
                                                        Simpan
                                                    </button>
                                                </form>

                                                {{-- Form Hapus Pengguna --}}
                                                <form action="{{ route('admin.users.destroy', $user->id) }}"
                                                      method="POST"
                                                      onsubmit="return confirm('Yakin ingin menghapus akun {{ $user->name }}?')">
                                                    @csrf
                                                    @method('DELETE')

                                                    <button type="submit"
                                                        class="px-3 py-2 bg-red-600 text-white rounded-md hover:bg-red-700">
                                                        Hapus
                                                    </button>
                                                </form>

                                            </div>
                                        @else
                                            <span class="text-gray-500 italic">
                                                Tidak Dapat Diubah
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="p-4 text-center">
                                        Belum ada pengguna.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    {{ $users->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
