<!-- Menu khusus Admin -->
@role('admin')
    <x-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')">
        {{ __('Dashboard Admin') }}
    </x-nav-link>
@endrole

<!-- Menu khusus Petugas -->
@role('petugas')
    <x-nav-link :href="route('petugas.dashboard')" :active="request()->routeIs('petugas.dashboard')">
        {{ __('Dashboard Petugas') }}
    </x-nav-link>
@endrole

<!-- Menu khusus Siswa -->
@role('siswa')
    <x-nav-link :href="route('siswa.dashboard')" :active="request()->routeIs('siswa.dashboard')">
        {{ __('Dashboard Siswa') }}
    </x-nav-link>
@endrole

<!-- Menu yang memerlukan permission tertentu -->
@can('kelola data buku')
    <x-nav-link href="#">
        {{ __('Kelola Buku') }}
    </x-nav-link>
@endcan