@extends('layouts.app')

@section('title', 'Tambah Pengguna')

@section('content')

<style>
    html, body {
        margin: 0;
        font-family: Arial, sans-serif;
    }

    .halaman-form {
        background-color: #dcdafa !important;
        min-height: 100vh;
        padding: 25px 20px;
        box-sizing: border-box;
    }

    .judul {
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

    .kartu-form {
        background: #ffffff;
        padding: 25px;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.08);
        max-width: 650px;
        box-sizing: border-box;
    }

    .kartu-form h3 {
        color: #754b32;
        margin-top: 0;
        margin-bottom: 22px;
        font-size: 18px;
    }

    .field {
        margin-bottom: 17px;
    }

    .field label {
        display: block;
        font-size: 13px;
        margin-bottom: 7px;
        color: #754b32;
        font-weight: bold;
    }

    .field input,
    .field select {
        width: 100%;
        box-sizing: border-box;
        padding: 11px;
        border: 1px solid #d4c9c1;
        border-radius: 6px;
        font-size: 13px;
        background: #ffffff;
        color: #333;
    }

    .field input:focus,
    .field select:focus {
        outline: none;
        border-color: #6b67a8;
        box-shadow: 0 0 4px rgba(107,103,168,0.3);
    }

    .tombol {
        display: inline-block;
        border: none;
        border-radius: 6px;
        padding: 10px 15px;
        font-size: 13px;
        cursor: pointer;
        text-decoration: none;
        color: white;
    }

    .tombol-simpan {
        background: #91613f;
    }

    .tombol-simpan:hover {
        background: #70472e;
        color: white;
    }

    .tombol-kembali {
        background: #6b67a8;
    }

    .tombol-kembali:hover {
        background: #514d8c;
        color: white;
    }

    .error {
        color: #b84d4d;
        font-size: 12px;
        margin-top: 5px;
    }

    @media (max-width: 600px) {
        .halaman-form {
            padding: 18px 12px;
        }

        .kartu-form {
            padding: 18px;
        }
    }
</style>

<div class="halaman-form">

    <h2 class="judul">Tambah Pengguna</h2>

    <p class="deskripsi">
        Tambahkan akun pengguna baru ke sistem perpustakaan.
    </p>

    <div class="kartu-form">

        <h3>Form Data Pengguna</h3>

        <form action="{{ route('admin.users.store') }}" method="POST">

            @csrf

            <div class="field">
                <label>Nama Pengguna</label>

                <input type="text"
                       name="name"
                       value="{{ old('name') }}"
                       placeholder="Masukkan nama pengguna"
                       required>

                @error('name')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="field">
                <label>Email</label>

                <input type="email"
                       name="email"
                       value="{{ old('email') }}"
                       placeholder="Masukkan email"
                       required>

                @error('email')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="field">
                <label>Password</label>

                <input type="password"
                       name="password"
                       placeholder="Minimal 8 karakter"
                       required>

                @error('password')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="field">
                <label>Role Pengguna</label>

                <select name="role" required>
                    <option value="">-- Pilih Role --</option>

                    @foreach($roles as $role)
                        <option value="{{ $role->name }}"
                            {{ old('role') == $role->name ? 'selected' : '' }}>
                            {{ ucfirst($role->name) }}
                        </option>
                    @endforeach

                </select>

                @error('role')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="tombol tombol-simpan">
                Simpan Pengguna
            </button>

            <a href="{{ route('admin.users.index') }}"
               class="tombol tombol-kembali">
                Kembali
            </a>

        </form>

    </div>

</div>

@endsection