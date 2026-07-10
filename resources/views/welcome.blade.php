<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
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
<body class="antialiased bg-[#f6fafe] text-[#171c1f]">

    {{-- Navbar --}}
    <header class="fixed top-0 left-0 right-0 h-16 bg-white/80 backdrop-blur-md border-b border-[#eaeef2] z-50 flex items-center justify-between px-8 md:px-16">
        <div class="flex items-center gap-3">
            <div class="w-9 h-9 bg-[#0e7a3d] rounded-xl flex items-center justify-center">
                <span class="material-symbols-outlined text-white filled-icon">school</span>
            </div>
            <span class="font-bold text-lg text-[#171c1f]">Presence-Teen</span>
        </div>
        <div class="flex items-center gap-3">
            @if (Route::has('login'))
                @auth
                    <a href="{{ url('/dashboard') }}"
                       class="inline-flex items-center gap-2 px-5 py-2.5 bg-[#005f2d] text-white text-sm font-semibold
                              rounded-xl hover:bg-[#0e7a3d] transition-all">
                        <span class="material-symbols-outlined text-[18px]">dashboard</span>
                        Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}"
                       class="px-5 py-2.5 border border-[#005f2d] text-[#005f2d] text-sm font-semibold
                              rounded-xl hover:bg-[#f0fdf4] transition-all">
                        Masuk
                    </a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}"
                           class="px-5 py-2.5 bg-[#005f2d] text-white text-sm font-semibold
                                  rounded-xl hover:bg-[#0e7a3d] transition-all">
                            Daftar
                        </a>
                    @endif
                @endauth
            @endif
        </div>
    </header>

    {{-- Hero Section --}}
    <section class="min-h-screen pt-16 flex items-center">
        <div class="max-w-6xl mx-auto px-8 md:px-16 py-20 grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">

            {{-- Left: Text --}}
            <div>
                {{-- AI Badge --}}
                <div class="inline-flex items-center gap-2 bg-[#f0fdf4] border border-[#0e7a3d]/20 rounded-full px-4 py-1.5 mb-6">
                    <span class="material-symbols-outlined text-[#0e7a3d] filled-icon text-[16px]">auto_awesome</span>
                    <span class="text-xs font-semibold text-[#005f2d]">Powered by Claude AI</span>
                </div>

                <h1 class="text-4xl md:text-5xl font-extrabold text-[#171c1f] leading-tight tracking-tight mb-6">
                    Sistem Presensi<br>
                    <span class="text-[#0e7a3d]">Cerdas & Modern</span><br>
                    untuk Sekolah
                </h1>

                <p class="text-lg text-[#5c5f61] leading-relaxed mb-8 max-w-md">
                    Kelola presensi dengan QR Code, pantau tugas & materi, dan dapatkan laporan AI otomatis
                    untuk siswa, guru, dan orang tua.
                </p>

                <div class="flex flex-wrap gap-3">
                    @auth
                        <a href="{{ url('/dashboard') }}"
                           class="inline-flex items-center gap-2 px-7 py-3.5 bg-[#005f2d] text-white text-sm font-semibold
                                  rounded-xl hover:bg-[#0e7a3d] transition-all shadow-soft">
                            <span class="material-symbols-outlined text-[18px]">dashboard</span>
                            Buka Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}"
                           class="inline-flex items-center gap-2 px-7 py-3.5 bg-[#005f2d] text-white text-sm font-semibold
                                  rounded-xl hover:bg-[#0e7a3d] transition-all shadow-soft">
                            <span class="material-symbols-outlined text-[18px]">login</span>
                            Mulai Sekarang
                        </a>
                        <a href="{{ route('register') }}"
                           class="inline-flex items-center gap-2 px-7 py-3.5 border border-[#005f2d] text-[#005f2d] text-sm font-semibold
                                  rounded-xl hover:bg-[#f0fdf4] transition-all">
                            Daftar Gratis
                        </a>
                    @endauth
                </div>
            </div>

            {{-- Right: Feature cards --}}
            <div class="grid grid-cols-2 gap-4">
                <div class="bg-[#0e7a3d] text-white rounded-2xl p-6 col-span-2">
                    <span class="material-symbols-outlined filled-icon text-[#a5ffb7] text-3xl mb-3 block">qr_code_2</span>
                    <h3 class="font-bold text-lg mb-1">Presensi QR Real-Time</h3>
                    <p class="text-white/70 text-sm">Guru generate QR, siswa scan langsung. Cepat, akurat, tanpa kertas.</p>
                </div>
                <div class="bg-white rounded-2xl p-5 border border-[#eaeef2] shadow-soft">
                    <span class="material-symbols-outlined filled-icon text-[#0e7a3d] text-2xl mb-2 block">auto_awesome</span>
                    <h3 class="font-semibold text-[#171c1f] mb-1">Ringkasan AI</h3>
                    <p class="text-[#5c5f61] text-xs leading-relaxed">Materi diringkas otomatis oleh Claude AI.</p>
                </div>
                <div class="bg-white rounded-2xl p-5 border border-[#eaeef2] shadow-soft">
                    <span class="material-symbols-outlined filled-icon text-[#495362] text-2xl mb-2 block">monitoring</span>
                    <h3 class="font-semibold text-[#171c1f] mb-1">Laporan Orang Tua</h3>
                    <p class="text-[#5c5f61] text-xs leading-relaxed">Pantau perkembangan anak secara real-time.</p>
                </div>
                <div class="bg-white rounded-2xl p-5 border border-[#eaeef2] shadow-soft">
                    <span class="material-symbols-outlined filled-icon text-[#0e7a3d] text-2xl mb-2 block">assignment</span>
                    <h3 class="font-semibold text-[#171c1f] mb-1">Kelola Tugas</h3>
                    <p class="text-[#5c5f61] text-xs leading-relaxed">Buat, bagikan & nilai tugas siswa.</p>
                </div>
                <div class="bg-white rounded-2xl p-5 border border-[#eaeef2] shadow-soft">
                    <span class="material-symbols-outlined filled-icon text-[#495362] text-2xl mb-2 block">notifications_active</span>
                    <h3 class="font-semibold text-[#171c1f] mb-1">Notifikasi Pintar</h3>
                    <p class="text-[#5c5f61] text-xs leading-relaxed">Peringatan otomatis kehadiran siswa.</p>
                </div>
            </div>
        </div>
    </section>

    {{-- 3 Role Section --}}
    <section class="py-20 bg-white border-t border-[#eaeef2]">
        <div class="max-w-6xl mx-auto px-8 md:px-16">
            <div class="text-center mb-12">
                <p class="text-[11px] font-semibold text-[#005f2d] uppercase tracking-widest mb-2">Untuk Semua Pengguna</p>
                <h2 class="text-3xl font-bold text-[#171c1f]">Dirancang untuk 3 Peran</h2>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-[#f6fafe] rounded-2xl p-7 border border-[#eaeef2] hover:border-[#0e7a3d]/40 transition-all group">
                    <div class="w-14 h-14 bg-[#0e7a3d] rounded-2xl flex items-center justify-center mb-5 group-hover:scale-105 transition-transform">
                        <span class="material-symbols-outlined text-white filled-icon text-2xl">qr_code_scanner</span>
                    </div>
                    <h3 class="font-bold text-lg text-[#171c1f] mb-2">Siswa</h3>
                    <ul class="space-y-2 text-sm text-[#5c5f61]">
                        <li class="flex items-center gap-2"><span class="material-symbols-outlined text-[#0e7a3d] text-[16px]">check</span>Scan QR presensi</li>
                        <li class="flex items-center gap-2"><span class="material-symbols-outlined text-[#0e7a3d] text-[16px]">check</span>Akses & ringkas materi AI</li>
                        <li class="flex items-center gap-2"><span class="material-symbols-outlined text-[#0e7a3d] text-[16px]">check</span>Kumpul & pantau tugas</li>
                    </ul>
                </div>
                <div class="bg-[#f6fafe] rounded-2xl p-7 border border-[#eaeef2] hover:border-[#0e7a3d]/40 transition-all group">
                    <div class="w-14 h-14 bg-[#0e7a3d] rounded-2xl flex items-center justify-center mb-5 group-hover:scale-105 transition-transform">
                        <span class="material-symbols-outlined text-white filled-icon text-2xl">class</span>
                    </div>
                    <h3 class="font-bold text-lg text-[#171c1f] mb-2">Guru</h3>
                    <ul class="space-y-2 text-sm text-[#5c5f61]">
                        <li class="flex items-center gap-2"><span class="material-symbols-outlined text-[#0e7a3d] text-[16px]">check</span>Generate QR presensi</li>
                        <li class="flex items-center gap-2"><span class="material-symbols-outlined text-[#0e7a3d] text-[16px]">check</span>Upload materi & tugas</li>
                        <li class="flex items-center gap-2"><span class="material-symbols-outlined text-[#0e7a3d] text-[16px]">check</span>Lihat laporan siswa</li>
                    </ul>
                </div>
                <div class="bg-[#f6fafe] rounded-2xl p-7 border border-[#eaeef2] hover:border-[#0e7a3d]/40 transition-all group">
                    <div class="w-14 h-14 bg-[#0e7a3d] rounded-2xl flex items-center justify-center mb-5 group-hover:scale-105 transition-transform">
                        <span class="material-symbols-outlined text-white filled-icon text-2xl">monitoring</span>
                    </div>
                    <h3 class="font-bold text-lg text-[#171c1f] mb-2">Orang Tua</h3>
                    <ul class="space-y-2 text-sm text-[#5c5f61]">
                        <li class="flex items-center gap-2"><span class="material-symbols-outlined text-[#0e7a3d] text-[16px]">check</span>Pantau kehadiran anak</li>
                        <li class="flex items-center gap-2"><span class="material-symbols-outlined text-[#0e7a3d] text-[16px]">check</span>Laporan AI mingguan</li>
                        <li class="flex items-center gap-2"><span class="material-symbols-outlined text-[#0e7a3d] text-[16px]">check</span>Status tugas real-time</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    {{-- Footer --}}
    <footer class="py-8 border-t border-[#eaeef2] bg-white">
        <div class="max-w-6xl mx-auto px-8 md:px-16 flex flex-col md:flex-row justify-between items-center gap-3">
            <div class="flex items-center gap-2">
                <div class="w-7 h-7 bg-[#0e7a3d] rounded-lg flex items-center justify-center">
                    <span class="material-symbols-outlined text-white filled-icon text-[16px]">school</span>
                </div>
                <span class="font-semibold text-sm text-[#171c1f]">Presence-Teen</span>
            </div>
            <p class="text-xs text-[#5c5f61]">© {{ date('Y') }} Presence-Teen. Dibuat dengan Laravel & Claude AI.</p>
        </div>
    </footer>

</body>
</html>
