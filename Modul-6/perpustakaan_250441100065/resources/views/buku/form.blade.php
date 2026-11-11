@extends('layouts.perpus')

@section('content')

@php($edit = $buku->exists)

<h2 class="page-title">{{ $edit ? 'Ubah Buku' : 'Tambah Buku' }}</h2>

<div class="form-card">
    <form method="POST" action="{{ $edit ? route('buku.update', $buku->id) : route('buku.store') }}">
        @csrf
        @if ($edit)
            @method('PUT')
        @endif

        <div class="mgmt-form-group">
            <label for="kategori_id">Kategori</label>
            <select id="kategori_id" name="kategori_id" class="mgmt-control" required>
                <option value="">-- Pilih Kategori --</option>
                @foreach ($kategoris as $k)
                    <option value="{{ $k->id }}" @selected(old('kategori_id', $buku->kategori_id) == $k->id)>{{ $k->nama }}</option>
                @endforeach
            </select>
            @error('kategori_id') <div class="form-error">{{ $message }}</div> @enderror
        </div>

        <div class="mgmt-form-group">
            <label for="judul">Judul Buku</label>
            <input type="text" id="judul" name="judul" class="mgmt-control" value="{{ old('judul', $buku->judul) }}" required>
            @error('judul') <div class="form-error">{{ $message }}</div> @enderror
        </div>

        <div class="mgmt-form-group">
            <label for="penulis">Penulis</label>
            <input type="text" id="penulis" name="penulis" class="mgmt-control" value="{{ old('penulis', $buku->penulis) }}" required>
            @error('penulis') <div class="form-error">{{ $message }}</div> @enderror
        </div>

        <div class="mgmt-form-group">
            <label for="tahun_terbit">Tahun Terbit</label>
            <input type="number" id="tahun_terbit" name="tahun_terbit" class="mgmt-control" value="{{ old('tahun_terbit', $buku->tahun_terbit) }}" required>
            @error('tahun_terbit') <div class="form-error">{{ $message }}</div> @enderror
        </div>

        <div style="display:flex; gap:10px;">
            <button type="submit" class="btn">{{ $edit ? 'Perbarui' : 'Simpan' }}</button>
            <a href="{{ route('buku.index') }}" class="btn btn-red">Batal</a>
        </div>
    </form>
</div>

@endsection
