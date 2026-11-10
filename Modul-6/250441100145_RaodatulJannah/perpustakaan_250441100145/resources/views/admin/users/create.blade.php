<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Tambah Pengguna
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 rounded-lg shadow-sm">

                <h3 class="text-lg font-bold text-gray-800 mb-5">
                    Form Tambah Pengguna
                </h3>

                @if ($errors->any())
                    <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
                        <ul class="list-disc pl-5">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('admin.users.store') }}" method="POST">
                    @csrf

                    <div class="mb-4">
                        <label class="block font-medium mb-2">Nama Lengkap</label>
                        <input
                            type="text"
                            name="name"
                            value="{{ old('name') }}"
                            class="w-full border-gray-300 rounded-lg"
                            required
                        >
                    </div>

                    <div class="mb-4">
                        <label class="block font-medium mb-2">Email</label>
                        <input
                            type="email"
                            name="email"
                            value="{{ old('email') }}"
                            class="w-full border-gray-300 rounded-lg"
                            required
                        >
                    </div>

                    <div class="mb-4">
                        <label class="block font-medium mb-2">Password</label>
                        <input
                            type="password"
                            name="password"
                            class="w-full border-gray-300 rounded-lg"
                            required
                        >
                    </div>

                    <div class="mb-4">
                        <label class="block font-medium mb-2">
                            Konfirmasi Password
                        </label>
                        <input
                            type="password"
                            name="password_confirmation"
                            class="w-full border-gray-300 rounded-lg"
                            required
                        >
                    </div>

                    <div class="mb-6">
                        <label class="block font-medium mb-2">
                            Role Pengguna
                        </label>

                        <select
                            name="role"
                            class="w-full border-gray-300 rounded-lg"
                            required
                        >
                            <option value="">-- Pilih Role --</option>

                            @foreach ($roles as $role)
                                <option
                                    value="{{ $role->name }}"
                                    {{ old('role') == $role->name ? 'selected' : '' }}
                                >
                                    {{ ucfirst($role->name) }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="flex gap-3">
                        <button
                            type="submit"
                            class="bg-pink-500 hover:bg-pink-600 text-white px-5 py-2 rounded-lg"
                        >
                            Simpan Pengguna
                        </button>

                        <a
                            href="{{ route('admin.users.index') }}"
                            class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-5 py-2 rounded-lg"
                        >
                            Batal
                        </a>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>