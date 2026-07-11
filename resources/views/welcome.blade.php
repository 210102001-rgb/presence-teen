<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Presence Teen — sistem presensi sekolah berbasis QR Code dengan validasi perangkat anti-kecurangan, notifikasi real-time untuk orang tua, dan ringkasan analitik berbasis AI.">
    <title>Presence Teen — Revolusi Manajemen Sekolah Cerdas & Aman</title>
    <link rel="icon" type="image/png" href="{{ asset('smansa.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f6fafe; }
        .material-symbols-outlined { font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24; vertical-align: middle; }
        .material-symbols-outlined.filled { font-variation-settings: 'FILL' 1, 'wght' 400, 'GRAD' 0, 'opsz' 24; }
        .shadow-soft { box-shadow: 0 4px 14px rgba(0, 95, 45, 0.08); }

        /* Mobile menu toggle (CSS-only, tanpa JS tambahan) */
        #mobile-menu-toggle { display: none; }
        #mobile-menu {
            display: none;
            flex-direction: column;
            gap: 0.5rem;
            padding: 1rem 1.5rem 1.5rem;
            border-top: 1px solid #eaeef2;
            background: #fff;
        }
        #mobile-menu-toggle:checked ~ #mobile-menu { display: flex; }
        .hamburger-btn { display: none; }
        @media (max-width: 767px) {
            .hamburger-btn { display: flex; }
        }
    </style>
</head>
<body class="antialiased text-[#171c1f]">

    {{-- Navigation Bar --}}
    <nav class="sticky top-0 bg-white border-b border-[#eaeef2] z-50">
        <div class="max-w-7xl mx-auto px-6 h-16 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <img src="{{ asset('smansa.png') }}" class="w-9 h-9 object-contain" alt="Logo Presence Teen">
                <span class="font-bold text-lg text-[#005f2d]">Presence Teen</span>
            </div>

            <div class="hidden md:flex items-center gap-8 text-sm font-semibold text-[#5c5f61]">
                <a href="#fitur" class="hover:text-[#005f2d] transition-colors">Fitur</a>
                <a href="#cara-kerja" class="hover:text-[#005f2d] transition-colors">Cara Kerja</a>
                <a href="#preview" class="hover:text-[#005f2d] transition-colors">Preview</a>
                <a href="{{ route('login') }}" class="bg-[#005f2d] text-white px-5 py-2.5 rounded-xl text-xs font-bold hover:bg-[#0e7a3d] transition-all shadow-soft">
                    Login Guru
                </a>
            </div>

            {{-- Hamburger toggle (mobile only) --}}
            <label for="mobile-menu-toggle" class="hamburger-btn items-center justify-center w-9 h-9 rounded-lg cursor-pointer text-[#171c1f]" aria-label="Buka menu navigasi">
                <span class="material-symbols-outlined" aria-hidden="true">menu</span>
            </label>
        </div>
        <input type="checkbox" id="mobile-menu-toggle" class="peer">
        <div id="mobile-menu" class="md:hidden text-sm font-semibold text-[#5c5f61]">
            <a href="#fitur" class="hover:text-[#005f2d] transition-colors py-2">Fitur</a>
            <a href="#cara-kerja" class="hover:text-[#005f2d] transition-colors py-2">Cara Kerja</a>
            <a href="#preview" class="hover:text-[#005f2d] transition-colors py-2">Preview</a>
            <a href="{{ route('login') }}" class="bg-[#005f2d] text-white px-5 py-2 rounded-xl text-xs font-bold hover:bg-[#0e7a3d] transition-all shadow-soft text-center mt-2">
                Login Guru
            </a>
        </div>
    </nav>

    {{-- Hero Section --}}
    <header class="py-16 md:py-24 max-w-7xl mx-auto px-6 grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
        <div class="lg:col-span-6 space-y-6 text-left">
            <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-[#f0fdf4] text-[#005f2d] border border-[#0e7a3d]/20 rounded-full text-[11px] font-bold uppercase tracking-wider">
                <span class="material-symbols-outlined text-[14px]" aria-hidden="true">verified_user</span> Sistem Presensi Modern
            </span>
            <h1 class="text-4xl md:text-5xl font-extrabold text-[#171c1f] leading-tight">
                Revolusi <br>
                <span class="text-[#005f2d]">Manajemen Sekolah</span> <br>
                yang Cerdas & Aman
            </h1>
            <p class="text-sm text-[#5c5f61] leading-relaxed max-w-md">
                Presence Teen menyederhanakan proses administratif sekolah dengan teknologi QR Code presensi tinggi, validasi perangkat anti-kecurangan, dan notifikasi real-time untuk orang tua.
            </p>
            <div class="flex items-center gap-4 pt-2">
                <a href="{{ route('login') }}" class="bg-[#005f2d] text-white px-6 py-3 rounded-xl text-xs font-bold hover:bg-[#0e7a3d] transition-all shadow-soft flex items-center justify-center gap-1 min-w-[140px] text-center">
                    Mulai Sekarang <span class="material-symbols-outlined text-[16px]" aria-hidden="true">arrow_forward</span>
                </a>
                <a href="#fitur" class="px-6 py-3 bg-white border border-[#005f2d]/20 text-[#005f2d] rounded-xl text-xs font-bold hover:bg-[#f6fafe] transition-all flex items-center justify-center min-w-[140px] text-center shadow-soft">
                    Pelajari Fitur
                </a>
            </div>
        </div>
        <div class="lg:col-span-6 flex items-center justify-center relative">
            {{-- Figma Mockup Illustration Container --}}
            <div class="relative bg-white p-12 rounded-[2rem] shadow-[0_12px_40px_rgba(0,0,0,0.06)] border border-[#eaeef2] w-full max-w-sm flex flex-col items-center justify-center">
                {{-- Floating Badge --}}
                <div class="absolute -top-4 -right-4 bg-white border border-[#eaeef2] p-3 rounded-2xl shadow-lg flex items-center gap-3 z-10">
                    <div class="w-8 h-8 rounded-full bg-[#f0fdf4] border border-[#0e7a3d]/20 flex items-center justify-center text-[#0e7a3d]">
                        <span class="material-symbols-outlined filled text-[16px]" aria-hidden="true">check_circle</span>
                    </div>
                    <div>
                        <div class="text-xs font-bold text-[#171c1f]">Presensi Berhasil</div>
                        <div class="text-[10px] text-gray-400 mt-0.5">07:15 AM</div>
                    </div>
                </div>
                {{-- Shield Logo --}}
                <img class="w-64 h-64 object-contain" src="{{ asset('smansa.png') }}" alt="Ilustrasi aplikasi Presence Teen">
            </div>
        </div>
    </header>

    {{-- Fitur Section --}}
    <section id="fitur" class="py-20 bg-white border-t border-[#eaeef2]">
        <div class="max-w-7xl mx-auto px-6 text-center space-y-4 mb-16">
            <h2 class="text-3xl font-bold text-[#171c1f]">Teknologi Terdepan untuk Pendidikan</h2>
            <p class="text-sm text-[#5c5f61] max-w-xl mx-auto leading-relaxed">
                Ekosistem lengkap yang dirancang khusus untuk memenuhi kebutuhan pengawasan modern, dari pintu gerbang hingga ruang kelas.
            </p>
        </div>
        <div class="max-w-7xl mx-auto px-6 grid grid-cols-1 lg:grid-cols-3 gap-8">
            {{-- Card 1 (2/3 width) --}}
            <div class="p-8 rounded-2xl bg-white border border-[#eaeef2] shadow-soft space-y-4 lg:col-span-2 relative overflow-hidden flex flex-col justify-between min-h-[220px]">
                <div class="space-y-4 max-w-md relative z-10">
                    <div class="w-12 h-12 rounded-xl bg-[#005f2d]/10 flex items-center justify-center text-[#005f2d]">
                        <span class="material-symbols-outlined text-2xl" aria-hidden="true">qr_code_scanner</span>
                    </div>
                    <h3 class="text-lg font-bold text-[#171c1f]">Presensi QR Code Super Cepat</h3>
                    <p class="text-xs text-[#5c5f61] leading-relaxed">Sistem pemindaian QR dinamis yang mempercepat antrean pagi. Kode berubah setiap detik untuk mencegah kecurangan dan memastikan kehadiran fisik siswa.</p>
                </div>
                <div class="absolute right-0 bottom-0 w-48 h-48 bg-[#005f2d]/5 rounded-tl-full pointer-events-none z-0"></div>
            </div>

            {{-- Card 2 (1/3 width) --}}
            <div class="p-8 rounded-2xl bg-white border border-[#eaeef2] shadow-soft space-y-4 lg:col-span-1 min-h-[220px]">
                <div class="w-12 h-12 rounded-xl bg-[#f0fdf4] border border-[#0e7a3d]/20 flex items-center justify-center text-[#0e7a3d]">
                    <span class="material-symbols-outlined text-2xl" aria-hidden="true">notifications_active</span>
                </div>
                <h3 class="text-lg font-bold text-[#171c1f]">Notifikasi Orang Tua</h3>
                <p class="text-xs text-[#5c5f61] leading-relaxed">Pembaruan real-time via WhatsApp atau Push Notification setiap kali siswa tiba atau meninggalkan area sekolah.</p>
            </div>

            {{-- Card 3 (1/3 width) --}}
            <div class="p-8 rounded-2xl bg-white border border-[#eaeef2] shadow-soft space-y-4 lg:col-span-1 min-h-[220px]">
                <div class="w-12 h-12 rounded-xl bg-orange-50 border border-orange-200 flex items-center justify-center text-orange-600">
                    <span class="material-symbols-outlined text-2xl" aria-hidden="true">phonelink_lock</span>
                </div>
                <h3 class="text-lg font-bold text-[#171c1f]">Validasi Perangkat Cerdas</h3>
                <p class="text-xs text-[#5c5f61] leading-relaxed">Sistem mengunci profil siswa ke satu perangkat utama, mencegah "titip absen" dan meningkatkan integritas data kehadiran.</p>
            </div>

            {{-- Card 4 (2/3 width) --}}
            <div class="p-8 rounded-2xl bg-white border border-[#eaeef2] shadow-soft space-y-4 lg:col-span-2 flex flex-col md:flex-row gap-6 items-center overflow-hidden justify-between min-h-[220px]">
                <div class="space-y-4 flex-1">
                    <div class="w-12 h-12 rounded-xl bg-teal-50 border border-teal-200 flex items-center justify-center text-teal-600">
                        <span class="material-symbols-outlined text-2xl" aria-hidden="true">bar_chart</span>
                    </div>
                    <h3 class="text-lg font-bold text-[#171c1f]">Ringkasan Berbasis AI</h3>
                    <p class="text-xs text-[#5c5f61] leading-relaxed">Dashboard analitik pintar yang secara otomatis mengidentifikasi pola ketidakhadiran, memprediksi risiko putus sekolah, dan menghasilkan laporan komprehensif untuk wali kelas.</p>
                </div>
                <div class="w-full md:w-56 shrink-0 shadow-md rounded-lg overflow-hidden border border-gray-100 bg-white">
                    <img src="{{ asset('statistik_kehadiran.png') }}" class="w-full h-auto object-cover" alt="Statistik Kehadiran">
                </div>
            </div>
        </div>
    </section>

    {{-- Cara Kerja Section --}}
    <section id="cara-kerja" class="py-20 bg-[#f6fafe] border-t border-[#eaeef2]">
        <div class="max-w-7xl mx-auto px-6 text-center space-y-4 mb-16">
            <h2 class="text-3xl font-bold text-[#171c1f]">Cara Kerja Kehadiran</h2>
            <p class="text-sm text-[#5c5f61] max-w-xl mx-auto leading-relaxed">
                Proses yang mulus dari kedatangan hingga pelaporan, dirancang untuk efisiensi maksimum di lingkungan sekolah yang sibuk.
            </p>
        </div>
        <div class="max-w-7xl mx-auto px-6 grid grid-cols-1 md:grid-cols-4 gap-6 text-center relative">
            {{-- Connecting line for steps on desktop --}}
            <div class="hidden md:block absolute top-[1.25rem] left-[12.5%] right-[12.5%] h-[2px] bg-[#eaeef2] z-0"></div>

            @php
                $langkahList = [
                    ['title' => 'Tiba di Sekolah', 'desc' => 'Siswa tiba di gerbang dan membuka aplikasi seluler Presence Teen.'],
                    ['title' => 'Scan QR Dinamis', 'desc' => 'Memindai QR Code unik yang berputar pada layar tablet pengawas gerbang.'],
                    ['title' => 'Validasi Instan', 'desc' => 'Sistem memverifikasi perangkat, lokasi, dan identitas dalam hitungan milidetik.'],
                    ['title' => 'Update & Notifikasi', 'desc' => 'Dashboard guru diperbarui, dan orang tua menerima pesan konfirmasi aman.'],
                ];
            @endphp
            @foreach ($langkahList as $i => $langkah)
                <div class="space-y-3 relative z-10 flex flex-col items-center">
                    <div class="w-10 h-10 bg-white border border-[#97f7ac] text-[#005f2d] rounded-full flex items-center justify-center text-sm font-bold shadow-soft">
                        {{ $i + 1 }}
                    </div>
                    <h4 class="font-bold text-sm text-[#171c1f] pt-2">{{ $langkah['title'] }}</h4>
                    <p class="text-xs text-[#5c5f61] leading-relaxed max-w-[200px]">{{ $langkah['desc'] }}</p>
                </div>
            @endforeach
        </div>
    </section>

    {{-- Admin Preview Section --}}
    <section id="preview" class="py-20 bg-[#005f2d] text-white">
        <div class="max-w-7xl mx-auto px-6 grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
            <div class="lg:col-span-6 flex items-center justify-center">
                <div class="bg-[#97f7ac]/20 p-6 rounded-[2.5rem] border border-[#97f7ac]/30 shadow-2xl w-full max-w-lg">
                    <div class="bg-white rounded-2xl overflow-hidden shadow-lg border border-[#eaeef2]">
                        {{-- Browser frame top bar --}}
                        <div class="bg-[#eaeef2] px-4 py-2.5 flex items-center gap-2 border-b border-[#dfe3e7]">
                            <div class="w-2.5 h-2.5 rounded-full bg-[#ff5f56]"></div>
                            <div class="w-2.5 h-2.5 rounded-full bg-[#ffbd2e]"></div>
                            <div class="w-2.5 h-2.5 rounded-full bg-[#27c93f]"></div>
                            <div class="bg-white text-[9px] text-gray-400 px-3 py-0.5 rounded-md ml-4 w-40 truncate">presence-teen.test/dashboard</div>
                        </div>
                        <img src="{{ asset('dashboard_mockup.png') }}" class="w-full h-auto object-cover" alt="Pratinjau Dashboard Admin">
                    </div>
                </div>
            </div>
            <div class="lg:col-span-6 space-y-6">
                <h2 class="text-3xl font-bold leading-tight">Dashboard Administratif Kuat & Intuitif</h2>
                <p class="text-sm text-[#a5ffb7] leading-relaxed">
                    Dirancang khusus untuk desktop, antarmuka guru dan admin kami menyediakan visibilitas penuh atas operasional harian tanpa kebingungan.
                </p>
                <div class="space-y-4">
                    <div class="flex items-start gap-4">
                        <div class="w-10 h-10 rounded-xl bg-white/10 text-white flex items-center justify-center shrink-0 border border-white/20">
                            <span class="material-symbols-outlined" aria-hidden="true">dashboard</span>
                        </div>
                        <div>
                            <h4 class="font-bold text-sm">Tampilan Kelas Komprehensif</h4>
                            <p class="text-xs text-[#a5ffb7]/80 mt-1">Lihat status seluruh siswa dalam satu pandangan dengan indikator warna yang jelas.</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-4">
                        <div class="w-10 h-10 rounded-xl bg-white/10 text-white flex items-center justify-center shrink-0 border border-white/20">
                            <span class="material-symbols-outlined" aria-hidden="true">file_download</span>
                        </div>
                        <div>
                            <h4 class="font-bold text-sm">Ekspor Laporan Mudah</h4>
                            <p class="text-xs text-[#a5ffb7]/80 mt-1">Hasilkan laporan kehadiran bulanan dalam format Excel atau PDF hanya dengan satu klik.</p>
                        </div>
                    </div>
                </div>
                <div class="pt-4">
                    <a href="{{ route('login') }}" class="inline-flex bg-white text-[#005f2d] px-6 py-3 rounded-xl text-xs font-bold hover:bg-gray-100 transition-all shadow-lg">
                        Lihat Demo Dashboard
                    </a>
                </div>
            </div>
        </div>
    </section>

    {{-- Footer --}}
    <footer class="bg-white border-t border-[#eaeef2] py-16">
        <div class="max-w-7xl mx-auto px-6 grid grid-cols-2 md:grid-cols-4 gap-8">
            <div class="col-span-2 md:col-span-1 space-y-4">
                <div class="flex items-center gap-3">
                    <img src="{{ asset('smansa.png') }}" class="w-8 h-8 object-contain" alt="Logo Presence Teen">
                    <span class="font-bold text-md text-[#005f2d]">Presence Teen</span>
                </div>
                <p class="text-xs text-[#5c5f61] leading-relaxed">
                    Membangun lingkungan sekolah yang lebih aman dan disiplin melalui teknologi cerdas.
                </p>
            </div>
            <div class="space-y-3">
                <h4 class="text-xs font-bold text-[#171c1f] uppercase tracking-wider">Produk</h4>
                <ul class="space-y-2 text-xs text-[#5c5f61]">
                    <li><a href="#" class="hover:text-[#005f2d]">Aplikasi Siswa</a></li>
                    <li><a href="#" class="hover:text-[#005f2d]">Dashboard Admin</a></li>
                    <li><a href="#" class="hover:text-[#005f2d]">Portal Orang Tua</a></li>
                    <li><a href="#" class="hover:text-[#005f2d]">Fitur Keamanan</a></li>
                </ul>
            </div>
            <div class="space-y-3">
                <h4 class="text-xs font-bold text-[#171c1f] uppercase tracking-wider">Perusahaan</h4>
                <ul class="space-y-2 text-xs text-[#5c5f61]">
                    <li><a href="#" class="hover:text-[#005f2d]">Tentang Kami</a></li>
                    <li><a href="#" class="hover:text-[#005f2d]">Karir</a></li>
                    <li><a href="#" class="hover:text-[#005f2d]">Blog</a></li>
                    <li><a href="#" class="hover:text-[#005f2d]">Hubungi Kami</a></li>
                </ul>
            </div>
            <div class="space-y-3">
                <h4 class="text-xs font-bold text-[#171c1f] uppercase tracking-wider">Legal</h4>
                <ul class="space-y-2 text-xs text-[#5c5f61]">
                    <li><a href="#" class="hover:text-[#005f2d]">Syarat & Ketentuan</a></li>
                    <li><a href="#" class="hover:text-[#005f2d]">Kebijakan Privasi</a></li>
                    <li><a href="#" class="hover:text-[#005f2d]">Keamanan Data</a></li>
                </ul>
            </div>
        </div>
        <div class="max-w-7xl mx-auto px-6 mt-12 pt-8 border-t border-[#eaeef2] flex justify-between items-center text-xs text-[#5c5f61]">
            <span>© 2024 Presence Teen. All rights reserved.</span>
            <div class="flex items-center gap-2">
                <a href="#" class="w-8 h-8 rounded-full border border-gray-200 flex items-center justify-center text-gray-400 hover:text-[#005f2d] hover:border-[#005f2d] transition-all">
                    <span class="material-symbols-outlined text-[16px]">link</span>
                </a>
                <a href="#" class="w-8 h-8 rounded-full border border-gray-200 flex items-center justify-center text-gray-400 hover:text-[#005f2d] hover:border-[#005f2d] transition-all">
                    <span class="material-symbols-outlined text-[16px]">share</span>
                </a>
            </div>
        </div>
    </footer>

</body>
</html>
