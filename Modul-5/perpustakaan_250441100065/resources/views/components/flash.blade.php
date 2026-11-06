{{-- Pesan sukses / error dari session (dipakai di halaman bertema Breeze) --}}
@if (session('status'))
    <div class="mb-4 rounded-md bg-green-50 border border-green-200 text-green-700 px-4 py-3 text-sm">
        {{ session('status') }}
    </div>
@endif

@if (session('error'))
    <div class="mb-4 rounded-md bg-red-50 border border-red-200 text-red-700 px-4 py-3 text-sm">
        {{ session('error') }}
    </div>
@endif
