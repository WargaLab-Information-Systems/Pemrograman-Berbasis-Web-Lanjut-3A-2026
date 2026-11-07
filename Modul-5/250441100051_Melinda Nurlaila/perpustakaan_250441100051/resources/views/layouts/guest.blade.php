<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Perpustakaan') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>

    <body class="font-sans text-[#3c2f33] antialiased">
        <div class="min-h-screen flex items-center justify-center px-6 py-10 bg-[#fff7f9]">
            <div class="w-full sm:max-w-md px-8 py-8 bg-white shadow-lg border border-pink-100 rounded-2xl">

                <div class="flex justify-center mb-7">
                    <a href="/">
                        <x-application-logo class="w-16 h-16 text-pink-600" />
                    </a>
                </div>

                {{ $slot }}

            </div>
        </div>
    </body>
</html>