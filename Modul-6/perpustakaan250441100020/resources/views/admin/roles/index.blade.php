
@extends('layouts.buku')

@section('title', 'Manajemen Role')

@section('content')
<div class="container">
    <h2 class="mb-4">Manajemen Role</h2>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Nama Role</th>
                    <th>Jumlah Permission</th>
                    <th>Permission</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($roles as $role)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ ucfirst($role->name) }}</td>
                        <td>{{ $role->permissions->count() }}</td>
                        <td>
                            {{ $role->permissions->pluck('name')->implode(', ') }}
                        </td>
                        <td>
                            <a href="{{ route('admin.roles.edit', $role->id) }}"
                               class="btn btn-warning btn-sm">
                                Atur Permission
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center">
                            Belum ada data role.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
