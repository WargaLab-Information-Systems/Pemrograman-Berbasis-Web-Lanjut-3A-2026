
@extends('layouts.buku')

@section('title', 'Atur Permission Role')

@section('content')
<div class="container">
    <h2 class="mb-4">
        Atur Permission: {{ ucfirst($role->name) }}
    </h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            @foreach ($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    @endif

    <form action="{{ route('admin.roles.update', $role->id) }}"
          method="POST">
        @csrf
        @method('PUT')

        <div class="card">
            <div class="card-body">
                <h5 class="mb-3">Daftar Permission</h5>

                @foreach ($permissions as $permission)
                    <div class="form-check mb-2">
                        <input
                            type="checkbox"
                            class="form-check-input"
                            name="permissions[]"
                            value="{{ $permission->id }}"
                            id="permission{{ $permission->id }}"
                            {{ $role->permissions->contains('id', $permission->id) ? 'checked' : '' }}
                        >

                        <label class="form-check-label"
                               for="permission{{ $permission->id }}">
                            {{ ucfirst($permission->name) }}
                        </label>
                    </div>
                @endforeach
            </div>
        </div>

        <button type="submit" class="btn btn-primary mt-3">
            Simpan Permission
        </button>

        <a href="{{ route('admin.roles.index') }}"
           class="btn btn-secondary mt-3">
            Kembali
        </a>
    </form>
</div>
@endsection
