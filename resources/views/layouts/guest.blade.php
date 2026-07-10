<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Presence-Teen') }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body { font-family: 'Inter', sans-serif; }
        .material-symbols-outlined { font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24; vertical-align: middle; }
        .filled-icon { font-variation-settings: 'FILL' 1, 'wght' 400, 'GRAD' 0, 'opsz' 24; }
    </style>
</head>
<body class="antialiased bg-[#f6fafe]">

    <div class="min-h-screen flex flex-col lg:flex-row">

        {{-- Left Panel: Branding --}}
        <div class="hidden lg:flex lg:w-[45%] bg-[#0e7a3d] relative overflow-hidden items-center justify-center p-12 flex-col">
            {{-- Decorative blobs --}}
            <div class="absolute -top-32 -left-32 w-96 h-96 bg-[#005f2d] rounded-full opacity-50 blur-3xl pointer-events-none"></div>
            <div class="absolute -bottom-32 -right-32 w-96 h-96 bg-[#005f2d] rounded-full opacity-50 blur-3xl pointer-events-none"></div>
            <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-64 h-64 bg-[#97f7ac]/10 rounded-full blur-3xl pointer-events-none"></div>

            <div class="relative text-center">
                {{-- Logo --}}
                <div class="mb-8 flex justify-center">
                    <div class="w-20 h-20 bg-white/15 backdrop-blur-md rounded-2xl flex items-center justify-center shadow-2xl border border-white/20">
                        <span class="material-symbols-outlined filled-icon text-white text-5xl">school</span>
                    </div>
                </div>

                <h1 class="text-4xl font-extrabold text-white mb-3 tracking-tight">Presence-Teen</h1>
                <p class="text-lg text-[#a5ffb7]/80 max-w-sm mx-auto leading-relaxed">
                    Sistem Presensi &amp; Manajemen Belajar berbasis AI untuk Sekolah Modern
                </p>

                {{-- Feature Pills --}}
                <div class="mt-10 grid grid-cols-3 gap-3 max-w-sm mx-auto">
                    <div class="bg-white/10 backdrop-blur-sm rounded-xl p-4 border border-white/10">
                        <span class="material-symbols-outlined text-[#a5ffb7] filled-icon block mb-1.5">qr_code_scanner</span>
                        <p class="text-xs font-semibold text-white">Siswa</p>
                        <p class="text-[10px] text-white/60 mt-0.5">Presensi & Tugas</p>
                    </div>
                    <div class="bg-white/10 backdrop-blur-sm rounded-xl p-4 border border-white/10">
                        <span class="material-symbols-outlined text-[#a5ffb7] filled-icon block mb-1.5">class</span>
                        <p class="text-xs font-semibold text-white">Guru</p>
                        <p class="text-[10px] text-white/60 mt-0.5">Kelola Kelas</p>
                    </div>
                    <div class="bg-white/10 backdrop-blur-sm rounded-xl p-4 border border-white/10">
                        <span class="material-symbols-outlined text-[#a5ffb7] filled-icon block mb-1.5">monitoring</span>
                        <p class="text-xs font-semibold text-white">Orang Tua</p>
                        <p class="text-[10px] text-white/60 mt-0.5">Pantau Anak</p>
                    </div>
                </div>

                {{-- AI Badge --}}
                <div class="mt-8 inline-flex items-center gap-2 bg-white/10 border border-white/20 rounded-full px-4 py-2">
                    <span class="material-symbols-outlined text-[#a5ffb7] filled-icon text-[18px]">auto_awesome</span>
                    <span class="text-xs text-white/80 font-medium">Powered by Claude AI</span>
                </div>
            </div>
        </div>

        {{-- Right Panel: Form --}}
        {{ $slot }}

    </div>

</body>
</html>
