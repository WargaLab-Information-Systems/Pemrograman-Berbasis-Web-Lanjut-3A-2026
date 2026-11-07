<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    @if (auth()->check() && ! request()->is('/'))
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center gap-8">
                    <a href="{{ auth()->user()->hasRole('Petugas') ? route('dashboard.petugas') : (auth()->user()->hasRole('Admin') ? route('dashboard.admin') : route('dashboard.siswa')) }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-gray-800" />
                    </a>

                    <div class="hidden sm:flex items-center gap-6">
                        @if (auth()->user()->hasRole('Petugas'))
                            <x-nav-link :href="route('dashboard.petugas')" :active="request()->routeIs('dashboard.petugas')">
                                Dashboard Petugas
                            </x-nav-link>
                        @elseif (auth()->user()->hasRole('Admin'))
                            <x-nav-link :href="route('dashboard.admin')" :active="request()->routeIs('dashboard.admin')">
                                Dashboard Admin
                            </x-nav-link>
                        @elseif (auth()->user()->hasRole('Siswa'))
                            <x-nav-link :href="route('dashboard.siswa')" :active="request()->routeIs('dashboard.siswa')">
                                Dashboard Siswa
                            </x-nav-link>
                        @endif

                        @can('lihat daftar buku')
                            <x-nav-link :href="route('buku.index')" :active="request()->routeIs('buku.*')">
                                Daftar Buku
                            </x-nav-link>
                        @endcan

                        @role('Siswa')
                            @can('mengajukan peminjaman buku')
                                <x-nav-link :href="route('siswa.pengajuan.index')" :active="request()->routeIs('siswa.pengajuan.*')">
                                    Ajukan Peminjaman
                                </x-nav-link>
                            @endcan

                            @can('melihat status peminjaman sendiri')
                                <x-nav-link :href="route('siswa.status.index')" :active="request()->routeIs('siswa.status.*')">
                                    Status Peminjaman
                                </x-nav-link>
                            @endcan

                            @can('melihat riwayat peminjaman sendiri')
                                <x-nav-link :href="route('siswa.riwayat.index')" :active="request()->routeIs('siswa.riwayat.*')">
                                    Riwayat Peminjaman
                                </x-nav-link>
                            @endcan
                        @endrole

                        @hasanyrole('Admin|Petugas')
                            @can('kelola peminjaman')
                                <x-nav-link :href="route('petugas.peminjaman.index')" :active="request()->routeIs('petugas.peminjaman.*')">
                                    Kelola Peminjaman
                                </x-nav-link>
                            @endcan

                            @can('memproses persetujuan peminjaman')
                                <x-nav-link :href="route('petugas.persetujuan.index')" :active="request()->routeIs('petugas.persetujuan.*')">
                                    Persetujuan Peminjaman
                                </x-nav-link>
                            @endcan

                            @can('kelola pengembalian')
                                <x-nav-link :href="route('petugas.pengembalian.index')" :active="request()->routeIs('petugas.pengembalian.*')">
                                    Pengembalian
                                </x-nav-link>
                            @endcan
                        @endhasanyrole

                        @can('kelola data pengguna')
                            <x-nav-link :href="route('admin.users.index')" :active="request()->routeIs('admin.users.*')">
                                Kelola Pengguna
                            </x-nav-link>
                        @endcan

                        @can('lihat laporan perpustakaan')
                            <x-nav-link
                                :href="auth()->user()->hasRole('Petugas') ? route('petugas.laporan.index') : route('admin.laporan.index')"
                                :active="request()->routeIs('admin.laporan.index', 'petugas.laporan.index')">
                                Laporan
                            </x-nav-link>
                        @endcan
                    </div>
                </div>

                <div class="hidden sm:flex sm:items-center">
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="inline-flex items-center px-3 py-2 text-sm text-gray-500">
                                {{ Auth::user()->name }}
                                <span class="ms-2">⌄</span>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <x-dropdown-link :href="route('profile.edit')">
                                Profil
                            </x-dropdown-link>

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault(); this.closest('form').submit();">
                                    Keluar
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                </div>

                <div class="-me-2 flex items-center sm:hidden">
                    <button @click="open = !open" class="p-2 text-gray-400">
                        ☰
                    </button>
                </div>
            </div>
        </div>

        <div :class="{ 'block': open, 'hidden': !open }" class="hidden sm:hidden">
            <div class="pt-2 pb-3 space-y-1">
                @if (auth()->user()->hasRole('Petugas'))
                    <x-responsive-nav-link :href="route('dashboard.petugas')">
                        Dashboard Petugas
                    </x-responsive-nav-link>
                @elseif (auth()->user()->hasRole('Admin'))
                    <x-responsive-nav-link :href="route('dashboard.admin')">
                        Dashboard Admin
                    </x-responsive-nav-link>
                @elseif (auth()->user()->hasRole('Siswa'))
                    <x-responsive-nav-link :href="route('dashboard.siswa')">
                        Dashboard Siswa
                    </x-responsive-nav-link>
                @endif

                @can('lihat daftar buku')
                    <x-responsive-nav-link :href="route('buku.index')">
                        Daftar Buku
                    </x-responsive-nav-link>
                @endcan

                @role('Siswa')
                    @can('mengajukan peminjaman buku')
                        <x-responsive-nav-link :href="route('siswa.pengajuan.index')">
                            Ajukan Peminjaman
                        </x-responsive-nav-link>
                    @endcan

                    @can('melihat status peminjaman sendiri')
                        <x-responsive-nav-link :href="route('siswa.status.index')">
                            Status Peminjaman
                        </x-responsive-nav-link>
                    @endcan

                    @can('melihat riwayat peminjaman sendiri')
                        <x-responsive-nav-link :href="route('siswa.riwayat.index')">
                            Riwayat Peminjaman
                        </x-responsive-nav-link>
                    @endcan
                @endrole

                @hasanyrole('Admin|Petugas')
                    @can('kelola peminjaman')
                        <x-responsive-nav-link :href="route('petugas.peminjaman.index')">
                            Kelola Peminjaman
                        </x-responsive-nav-link>
                    @endcan

                    @can('memproses persetujuan peminjaman')
                        <x-responsive-nav-link :href="route('petugas.persetujuan.index')">
                            Persetujuan Peminjaman
                        </x-responsive-nav-link>
                    @endcan

                    @can('kelola pengembalian')
                        <x-responsive-nav-link :href="route('petugas.pengembalian.index')">
                            Pengembalian
                        </x-responsive-nav-link>
                    @endcan
                @endhasanyrole

                @can('kelola data pengguna')
                    <x-responsive-nav-link :href="route('admin.users.index')">
                        Kelola Pengguna
                    </x-responsive-nav-link>
                @endcan

                @can('lihat laporan perpustakaan')
                    <x-responsive-nav-link
                        :href="auth()->user()->hasRole('Petugas') ? route('petugas.laporan.index') : route('admin.laporan.index')">
                        Laporan
                    </x-responsive-nav-link>
                @endcan
            </div>

            <div class="pt-4 pb-1 border-t border-gray-200">
                <div class="px-4">
                    <div class="font-medium text-base text-gray-800">
                        {{ Auth::user()->name }}
                    </div>
                    <div class="font-medium text-sm text-gray-500">
                        {{ Auth::user()->email }}
                    </div>
                </div>

                <div class="mt-3 space-y-1">
                    <x-responsive-nav-link :href="route('profile.edit')">
                        Profil
                    </x-responsive-nav-link>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault(); this.closest('form').submit();">
                            Keluar
                        </x-responsive-nav-link>
                    </form>
                </div>
            </div>
        </div>
    @endif

    @if (auth()->check() && request()->is('/'))
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-end items-center h-16 gap-6">
                <a href="{{ route('dashboard') }}" class="text-sm font-semibold text-pink-600 hover:text-pink-700">
                    Dashboard
                </a>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="text-sm font-semibold text-pink-600 hover:text-pink-700">
                        Keluar
                    </button>
                </form>
            </div>
        </div>
    @endif

    @guest
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-end items-center h-16 gap-6">
                <a href="{{ route('login') }}" class="text-sm font-semibold text-pink-600 hover:text-pink-700">
                    Login
                </a>

                <a href="{{ route('register') }}" class="text-sm font-semibold text-pink-600 hover:text-pink-700">
                    Register
                </a>
            </div>
        </div>
    @endguest
</nav>