<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Presence-Teen') }}</title>
    <link rel="icon" type="image/png" href="{{ asset('smansa.png') }}">

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
        <div class="hidden lg:flex lg:w-[50%] bg-[#eef6fc] relative overflow-hidden items-center justify-center p-12 flex-col">
            
            <div class="relative text-center max-w-lg space-y-8">
                {{-- Figma Mockup Illustration Container --}}
                <div class="bg-white p-8 rounded-3xl shadow-[0_10px_30px_rgba(0,0,0,0.04)] border border-[#eaeef2] flex flex-col items-center">
                    <img class="w-full h-auto object-contain rounded-2xl" 
                         src="https://lh3.googleusercontent.com/aida-public/AB6AXuC7NHPFnEgn_xB8QNk1RUGVKAK052O0mIYENRtBkc8OC_QtHF-CaLWW1FmwnsVi4JUzkBf3VuZBWG_mJl1ByZx4KGccL-EZGu3usY6nXdcTdkGG24yo9UEpJks3mA3TMbrhQ_Sd5lnGgQumPt-SOzHKpsbAswajYqrgFSHdI-DHxdcjsHrDggeaE34oZHmJ8YiEQw1yj8k7KHnLgFxZp2nZFehMXiCRItt9azdIe0W6GNz_-J_gtKvCJwK167BUqXP8sWI_bAk8Haug" 
                         alt="Empowering Education">
                </div>

                <div class="space-y-3">
                    <h2 class="text-3xl font-extrabold text-[#171c1f] tracking-tight">Empowering Education</h2>
                    <p class="text-sm text-[#5c5f61] leading-relaxed">
                        Streamline your school's daily operations with our comprehensive management system designed for modern educators and students.
                    </p>
                </div>
            </div>
        </div>

        {{-- Right Panel: Form --}}
        {{ $slot }}

    </div>

</body>
</html>
