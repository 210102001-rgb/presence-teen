<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Presence-Teen') }} — @yield('title', 'Dashboard')</title>
    <link rel="icon" type="image/png" href="{{ asset('smansa.png') }}">

    <!-- Google Fonts: Inter + Material Symbols -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles

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
<body class="text-[#171c1f] antialiased" x-data="{ mobileSidebarOpen: false }">

    {{-- Mobile Sidebar Backdrop --}}
    <div x-show="mobileSidebarOpen" 
         x-transition:enter="transition-opacity ease-linear duration-200"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition-opacity ease-linear duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 bg-black/50 z-40 lg:hidden"
         @click="mobileSidebarOpen = false"
         style="display: none;">
    </div>

    {{-- Sidebar --}}
    @include('layouts.navigation')

    {{-- Top Header Bar --}}
    <header class="fixed top-0 right-0 w-full lg:w-[calc(100%-16rem)] h-16 bg-surface shadow-sm flex justify-between items-center px-4 md:px-10 z-30 border-b border-surface-container">
        <div class="flex items-center gap-3">
            <button @click="mobileSidebarOpen = !mobileSidebarOpen" class="p-2 text-on-surface-variant hover:text-primary lg:hidden rounded-lg transition-colors focus:outline-none">
                <span class="material-symbols-outlined">menu</span>
            </button>
            @isset($header)
                <div class="font-semibold text-lg lg:text-xl text-primary">{{ $header }}</div>
            @endisset
        </div>
        <div class="flex items-center gap-5">
            <button class="relative p-1 text-on-surface-variant hover:text-primary transition-colors">
                <span class="material-symbols-outlined">notifications</span>
            </button>
            <div class="flex items-center gap-2">
                <div class="w-8 h-8 rounded-full bg-primary-container flex items-center justify-center text-white text-sm font-bold">
                    {{ substr(Auth::user()->name, 0, 1) }}
                </div>
                <span class="text-sm font-medium text-on-surface hidden md:block">{{ Auth::user()->name }}</span>
            </div>
        </div>
    </header>

    {{-- Main Content --}}
    <main class="lg:ml-64 ml-0 pt-16 min-h-screen">
        {{ $slot }}
    </main>

    @livewire('chat-ai')
    @livewireScripts
    @stack('scripts')
</body>
</html>
