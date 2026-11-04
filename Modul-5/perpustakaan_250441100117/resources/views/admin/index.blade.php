<x-app-layout>
    <style>
        .page-title { font-family: 'Playfair Display', serif; font-size: 2rem; color: #2c3e50; margin-bottom: 20px; }
        .table-custom { width: 100%; border-collapse: collapse; background: #fff; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.05); }
        .table-custom th { background: #2c3e50; color: #fff; padding: 15px; text-align: left; }
        .table-custom td { padding: 15px; border-bottom: 1px solid #eee; }
        .btn-simpan { background: #2c3e50; color: #fff; padding: 8px 15px; border-radius: 6px; border: none; cursor: pointer; font-weight: 600; }
        .btn-simpan:hover { background: #d4af37; color: #2c3e50; }
        select { padding: 8px; border-radius: 6px; border: 1px solid #ccc; }
    </style>

    <div class="py-10 max-w-7xl mx-auto sm:px-6 lg:px-8">
        <h2 class="page-title">Kelola Pengguna & Role</h2>
        
        @if(session('success'))
            <div class="alert alert-success mb-4" style="background: #d4edda; color: #155724; padding: 15px; border-radius: 8px;">
                {{ session('success') }}
            </div>
        @endif

        <table class="table-custom">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Role Saat Ini</th>
                    <th>Ubah Role</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $index => $user)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>
                        <span style="background: #fce4ec; color: #880e4f; padding: 5px 10px; border-radius: 5px; font-weight: bold;">
                            {{ $user->roles->first()->name ?? 'Tidak ada role' }}
                        </span>
                    </td>
                    <td>
                        <form action="{{ route('admin.users.update-role', $user->id) }}" method="POST" style="display: flex; gap: 10px;">
                            @csrf
                            @method('PATCH')
                            <select name="role" required>
                                @foreach($roles as $role)
                                    <option value="{{ $role->name }}" {{ $user->hasRole($role->name) ? 'selected' : '' }}>
                                        {{ ucfirst($role->name) }}
                                    </option>
                                @endforeach
                            </select>
                            <button type="submit" class="btn-simpan">Simpan</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-app-layout>