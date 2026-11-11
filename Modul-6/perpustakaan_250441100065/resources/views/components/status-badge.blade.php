@props(['status'])

@php
    $warna = match ($status) {
        'diajukan'     => 'bg-yellow-100 text-yellow-800',
        'dipinjam'     => 'bg-blue-100 text-blue-800',
        'dikembalikan' => 'bg-green-100 text-green-800',
        'ditolak'      => 'bg-red-100 text-red-800',
        default        => 'bg-gray-100 text-gray-800',
    };
@endphp

<span class="inline-flex px-2 py-1 rounded-full text-xs font-semibold {{ $warna }}">{{ ucfirst($status) }}</span>
