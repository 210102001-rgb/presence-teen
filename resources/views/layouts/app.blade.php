<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Presence-Teen') }} — @yield('title', 'Dashboard')</title>

    <!-- Google Fonts: Inter + Material Symbols -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f6fafe; }
        .material-symbols-outlined { font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24; vertical-align: middle; }
        .filled-icon { font-variation-settings: 'FILL' 1, 'wght' 400, 'GRAD' 0, 'opsz' 24; }
        .shadow-soft { box-shadow: 0 1px 3px rgba(0,0,0,0.05), 0 4px 6px rgba(0,0,0,0.02); }
        .ai-glow { background: #f0fdf4; border: 1px solid rgba(14,122,61,0.15); }
        .ai-border {
            border: 1px solid transparent;
            background: linear-gradient(white, white) padding-box,
                        linear-gradient(to right, #0e7a3d, #495362) border-box;
        }
        .bento-card { transition: transform 0.2s ease, box-shadow 0.2s ease; }
        .bento-card:hover { transform: translateY(-2px); box-shadow: 0 10px 15px rgba(0,0,0,0.07); }
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-thumb { background: #dfe3e7; border-radius: 10px; }
    </style>
</head>
<body class="text-[#171c1f] antialiased">

    {{-- Sidebar --}}
    @include('layouts.navigation')

    {{-- Top Header Bar --}}
    <header class="fixed top-0 right-0 w-[calc(100%-16rem)] h-16 bg-[#f6fafe] shadow-sm flex justify-between items-center px-10 z-40 border-b border-[#eaeef2]">
        <div class="flex items-center gap-3">
            @isset($header)
                <div class="font-semibold text-xl text-[#005f2d]">{{ $header }}</div>
            @endisset
        </div>
        <div class="flex items-center gap-5">
            <button class="relative p-1 text-[#3f493f] hover:text-[#005f2d] transition-colors">
                <span class="material-symbols-outlined">notifications</span>
            </button>
            <div class="flex items-center gap-2">
                <div class="w-8 h-8 rounded-full bg-[#0e7a3d] flex items-center justify-center text-white text-sm font-bold">
                    {{ substr(Auth::user()->name, 0, 1) }}
                </div>
                <span class="text-sm font-medium text-[#171c1f] hidden md:block">{{ Auth::user()->name }}</span>
            </div>
        </div>
    </header>

    {{-- Main Content --}}
    <main class="ml-64 pt-16 min-h-screen">
        {{ $slot }}
    </main>

    @stack('scripts')
</body>
</html>
