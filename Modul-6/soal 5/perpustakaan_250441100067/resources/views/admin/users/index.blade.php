@extends('layouts.app')

@section('title', 'Manajemen Pengguna')

@section('content')

<style>
    html, body {
        margin: 0;
        font-family: Arial, sans-serif;
    }

    .halaman-pengguna {
        background-color: #dcdafa !important;
        min-height: 100vh;
        padding: 25px 20px;
        box-sizing: border-box;
    }

    .judul-halaman {
        color: #754b32;
        margin: 0 0 8px;
        font-size: 24px;
        font-weight: bold;
    }

    .deskripsi {
        color: #555;
        font-size: 13px;
        margin-bottom: 20px;
    }

    .kartu-pengguna {
        background: #ffffff;
        padding: 22px;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.08);
    }

    .bagian-atas {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 12px;
        margin-bottom: 18px;
    }

    .bagian-atas h3 {
        color: #754b32;
        margin: 0;
        font-size: 18px;
    }

    .tombol {
        display: inline-block;
        border: none;
        border-radius: 6px;
        padding: 9px 13px;
        font-size: 12px;
        cursor: pointer;
        text-decoration: none;
        color: white;
    }

    .tombol-tambah {
        background: #91613f;
    }

    .tombol-tambah:hover {
        background: #70472e;
        color: white;
    }

    .tombol-edit {
        background: #6b67a8;
    }

    .tombol-edit:hover {
        background: #514d8c;
        color: white;
    }

    .tombol-hapus {
        background: #b84d4d;
    }

    .tombol-hapus:hover {
        background: #963838;
    }

    .tabel-wrapper {
        overflow-x: auto;
    }

    .tabel-pengguna {
        width: 100%;
        border-collapse: collapse;
        min-width: 650px;
    }

    .tabel-pengguna th {
        background: #dcdafa;
        color: #754b32;
        padding: 13px;
        font-size: 13px;
        text-align: left;
    }

    .tabel-pengguna td {
        padding: 13px;
        font-size: 13px;
        color: #333;
        border-bottom: 1px solid #eee;
    }

    .tabel-pengguna tr:hover {
        background: #faf9ff;
    }

    .badge-role {
        display: inline-block;
        background: #efdbc3;
        color: #76553b;
        padding: 5px 10px;
        border-radius: 12px;
        font-size: 11px;
        margin: 2px;
    }

    .pesan {
        padding: 12px;
        border-radius: 7px;
        margin-bottom: 15px;
        font-size: 13px;
    }

    .sukses {
        background: #e1f4e5;
        color: #226534;
    }

    .gagal {
        background: #fde5e5;
        color: #9a2525;
    }

    .kosong {
        text-align: center;
        padding: 25px !important;
        color: #777;
    }

    .pagination {
        margin-top: 20px;
    }

    @media (max-width: 600px) {
        .halaman-pengguna {
            padding: 18px 12px;
        }

        .kartu-pengguna {
            padding: 15px;
        }
    }
</style>

<div class="halaman-pengguna">

    <h2 class="judul-halaman">Manajemen Pengguna</h2>

    <p class="deskripsi">
        Kelola akun pengguna dan hak akses pada sistem perpustakaan.
    </p>

    @if(session('success'))
        <div class="pesan sukses">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="pesan gagal">
            {{ session('error') }}
        </div>
    @endif

    @if($errors->any())
        <div class="pesan gagal">
            @foreach($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    @endif

    <div class="kartu-pengguna">

        <div class="bagian-atas">
            <h3>Daftar Pengguna</h3>

            <a href="{{ route('admin.users.create') }}"
               class="tombol tombol-tambah">
                + Tambah Pengguna
            </a>
        </div>

        <div class="tabel-wrapper">
            <table class="tabel-pengguna">

                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Pengguna</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($users as $user)
                        <tr>
                            <td>
                                {{ $users->firstItem() + $loop->index }}
                            </td>

                            <td>{{ $user->name }}</td>

                            <td>{{ $user->email }}</td>

                            <td>
                                @forelse($user->roles as $role)
                                    <span class="badge-role">
                                        {{ ucfirst($role->name) }}
                                    </span>
                                @empty
                                    <span>Belum memiliki role</span>
                                @endforelse
                            </td>

                            <td>
                                <a href="{{ route('admin.users.edit', $user->id) }}"
                                   class="tombol tombol-edit">
                                    Edit
                                </a>

                                @if(auth()->id() != $user->id)
                                    <form action="{{ route('admin.users.destroy', $user->id) }}"
                                          method="POST"
                                          style="display:inline;"
                                          onsubmit="return confirm('Yakin ingin menghapus pengguna ini?')">

                                        @csrf
                                        @method('DELETE')

                                        <button type="submit"
                                                class="tombol tombol-hapus">
                                            Hapus
                                        </button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="kosong">
                                Belum ada data pengguna.
                            </td>
                        </tr>
                    @endforelse
                </tbody>

            </table>
        </div>

        <div class="pagination">
            {{ $users->links() }}
        </div>

    </div>
</div>

@endsection