<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'PRESENCE-TEEN') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen flex flex-col lg:flex-row">
            <div class="hidden lg:flex lg:w-1/2 bg-gradient-to-br from-indigo-900 via-indigo-800 to-purple-900 relative overflow-hidden items-center justify-center p-12">
                <div class="absolute inset-0 opacity-20">
                    <div class="absolute -top-24 -left-24 w-96 h-96 bg-indigo-400 rounded-full mix-blend-multiply filter blur-3xl"></div>
                    <div class="absolute -bottom-24 -right-24 w-96 h-96 bg-purple-400 rounded-full mix-blend-multiply filter blur-3xl"></div>
                    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-64 h-64 bg-pink-400 rounded-full mix-blend-multiply filter blur-3xl"></div>
                </div>

                <div class="relative text-center">
                    <div class="mb-6 flex justify-center">
                        <div class="w-20 h-20 bg-white/10 backdrop-blur-lg rounded-2xl flex items-center justify-center shadow-2xl">
                            <x-application-logo class="w-12 h-12 text-white" />
                        </div>
                    </div>
                    <h1 class="text-4xl font-extrabold text-white mb-3 tracking-tight">{{ config('app.name', 'PRESENCE-TEEN') }}</h1>
                    <p class="text-lg text-indigo-200 max-w-sm">Sistem Presensi &amp; Manajemen Tugas untuk Siswa, Guru, dan Orang Tua</p>

                    <div class="mt-12 grid grid-cols-3 gap-4 max-w-sm mx-auto">
                        <div class="bg-white/10 backdrop-blur-sm rounded-xl p-4">
                            <div class="text-2xl font-bold text-white">Siswa</div>
                            <div class="text-xs text-indigo-200 mt-1">Presensi &amp; Tugas</div>
                        </div>
                        <div class="bg-white/10 backdrop-blur-sm rounded-xl p-4">
                            <div class="text-2xl font-bold text-white">Guru</div>
                            <div class="text-xs text-indigo-200 mt-1">Kelola Kelas</div>
                        </div>
                        <div class="bg-white/10 backdrop-blur-sm rounded-xl p-4">
                            <div class="text-2xl font-bold text-white">Ortu</div>
                            <div class="text-xs text-indigo-200 mt-1">Pantau Anak</div>
                        </div>
                    </div>
                </div>
            </div>

            {{ $slot }}

            <div class="lg:hidden fixed top-0 left-0 right-0 bg-gradient-to-r from-indigo-900 to-purple-900 p-4 flex items-center gap-3 z-10">
                <x-application-logo class="w-8 h-8 text-white" />
                <span class="text-white font-bold text-sm">{{ config('app.name', 'PRESENCE-TEEN') }}</span>
            </div>
        </div>
    </body>
</html>
