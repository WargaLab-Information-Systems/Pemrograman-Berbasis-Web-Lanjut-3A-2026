<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight" style="color: #754b32;">
            Profil Pengguna
        </h2>
    </x-slot>

    <style>
        .halaman-profil {
            background: #dcdafa !important;
            min-height: 100vh;
            padding: 30px 20px;
            box-sizing: border-box;
        }

        .wadah-profil {
            max-width: 1280px;
            margin: auto;
            display: flex;
            flex-direction: column;
            gap: 22px;
        }

        .kartu-profil {
            background: #ffffff;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
        }

        @media (max-width: 450px) {
            .halaman-profil {
                padding: 20px 13px;
            }

            .kartu-profil {
                padding: 18px;
            }
        }
    </style>

    <div class="halaman-profil">

        <div class="wadah-profil">

            {{-- Informasi Profil --}}
            <div class="kartu-profil">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            {{-- Ubah Password --}}
            <div class="kartu-profil">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            {{-- Hapus Akun --}}
            <div class="kartu-profil">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>

        </div>

    </div>

</x-app-layout>
