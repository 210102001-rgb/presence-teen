<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <meta name="description" content="Presence Teen — sistem presensi sekolah berbasis QR Code dengan validasi perangkat anti-kecurangan, notifikasi real-time untuk orang tua, dan ringkasan analitik berbasis AI.">
    <title>Presence Teen — Revolusi Manajemen Sekolah Cerdas & Aman</title>
    <link rel="icon" type="image/png" href="{{ asset('smansa.png') }}">
    
    <!-- Google Fonts & Material Symbols -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        body {
            background-color: #f8f9ff;
            color: #0b1c30;
            font-family: 'Poppins', sans-serif;
        }
        .glass-card {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.5);
            box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1), 0 2px 4px -1px rgba(0,0,0,0.06);
        }
        .material-symbols-outlined {
            vertical-align: middle;
        }
    </style>
</head>
<body class="antialiased min-h-screen flex flex-col bg-background" x-data="{ mobileMenuOpen: false }">
    <!-- TopAppBar Navigation -->
    <header class="fixed top-0 w-full z-50 transition-all duration-300 bg-white/90 backdrop-blur-md shadow-sm border-b border-surface-container-high" id="main-header">
        <div class="max-w-7xl mx-auto px-6 h-16 flex justify-between items-center">
            <div class="flex items-center gap-3">
                <img alt="Presence Teen Logo" class="h-9 w-9 object-contain" src="{{ asset('smansa.png') }}"/>
                <span class="font-bold text-lg text-primary tracking-tight">Presence Teen</span>
            </div>
            <nav class="hidden md:flex gap-8 items-center">
                <a class="font-semibold text-sm text-on-surface-variant hover:text-primary transition-colors" href="#features">Fitur</a>
                <a class="font-semibold text-sm text-on-surface-variant hover:text-primary transition-colors" href="#how-it-works">Cara Kerja</a>
                <a class="font-semibold text-sm text-on-surface-variant hover:text-primary transition-colors" href="#preview">Preview</a>
                <a href="{{ route('login') }}" class="bg-primary text-white px-6 py-2.5 rounded-xl font-semibold text-xs shadow-soft hover:bg-primary-container transition-all active:scale-[0.99]">
                    Login Portal
                </a>
            </nav>
            <button @click="mobileMenuOpen = !mobileMenuOpen" class="md:hidden text-on-surface-variant p-2 focus:outline-none">
                <span class="material-symbols-outlined">menu</span>
            </button>
        </div>
        
        {{-- Mobile Menu --}}
        <div x-show="mobileMenuOpen" @click.away="mobileMenuOpen = false" class="md:hidden bg-white border-t border-gray-100 px-6 py-4 flex flex-col gap-3 shadow-md" style="display: none;">
            <a class="font-semibold text-sm text-on-surface-variant hover:text-primary transition-colors" href="#features">Fitur</a>
            <a class="font-semibold text-sm text-on-surface-variant hover:text-primary transition-colors" href="#how-it-works">Cara Kerja</a>
            <a class="font-semibold text-sm text-on-surface-variant hover:text-primary transition-colors" href="#preview">Preview</a>
            <a href="{{ route('login') }}" class="bg-primary text-white px-6 py-2.5 rounded-xl font-semibold text-xs shadow-soft hover:bg-primary-container transition-all text-center">
                Login Portal
            </a>
        </div>
    </header>

    <!-- Main Content Canvas -->
    <main class="flex-grow pt-16">
        <!-- Hero Section -->
        <section class="relative pt-16 pb-32 overflow-hidden">
            <div class="absolute inset-0 bg-gradient-to-br from-surface-container-low to-surface-container z-0"></div>
            <div class="absolute top-0 right-0 w-[800px] h-[800px] bg-primary/5 rounded-full blur-3xl -translate-y-1/2 translate-x-1/3"></div>
            <div class="max-w-7xl mx-auto px-6 relative z-10 grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
                <div class="flex flex-col gap-6 max-w-xl">
                    <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white border border-gray-200 w-fit shadow-sm">
                        <span class="material-symbols-outlined text-primary text-sm">verified</span>
                        <span class="font-bold text-[10px] text-primary uppercase tracking-wider">Sistem Presensi Modern</span>
                    </div>
                    <h1 class="text-4xl md:text-5xl font-extrabold text-on-surface tracking-tight leading-tight">
                        Revolusi <span class="text-primary relative inline-block">Manajemen Sekolah<svg class="absolute w-full h-3 -bottom-1 left-0 text-secondary-container opacity-50 z-[-1]" preserveAspectRatio="none" viewBox="0 0 100 10"><path d="M0,5 Q50,10 100,5" fill="none" stroke="currentColor" stroke-width="8"></path></svg></span> yang Cerdas &amp; Aman
                    </h1>
                    <p class="text-sm text-secondary leading-relaxed">
                        Presence Teen menyederhanakan proses administratif sekolah dengan teknologi QR Code presensi tinggi, validasi perangkat anti-kecurangan, dan notifikasi real-time untuk orang tua.
                    </p>
                    <div class="flex flex-wrap gap-4 pt-2">
                        <a href="{{ route('login') }}" class="bg-primary text-white px-8 py-4 rounded-xl font-bold text-xs shadow-md hover:bg-primary-container transition-all active:scale-[0.99] flex items-center gap-2">
                            Mulai Sekarang
                            <span class="material-symbols-outlined">arrow_forward</span>
                        </a>
                        <a href="#features" class="bg-white text-primary border border-outline-variant px-8 py-4 rounded-xl font-bold text-xs shadow-sm hover:bg-gray-50 transition-all flex items-center gap-2">
                            Pelajari Fitur
                        </a>
                    </div>
                </div>
                <div class="relative w-full h-[400px] lg:h-[500px] rounded-2xl overflow-hidden glass-card p-4 flex items-center justify-center">
                    <img alt="Presence Teen Platform Preview" class="w-full h-full object-contain filter drop-shadow-2xl z-10" src="https://lh3.googleusercontent.com/aida-public/AB6AXuBT8kp_Jfc9rmqP83IRWOnXoDG3nMNm4pVkKdfptASeNsj4j8BGuSZgt1A_mBI1F-L9-hJneAsoVAQ27Oe4ysmVZjrIOpoxxIECnOFIbw-8hHkBpnZXv38DPB5n4aVeIAHaB3-u5a4hDgimssAnCiZs21RgaX51-jbmpTGZsTgofI5Jpyg2Jl7OiGROKA_DZR8yHMg3trI2WZOdbr9Q0Pc56ek9yOBoVbM90SpCdmnK5Rb-5pb5nnkIUkOplh8cFqQ1f1zeRszBkU8U" style="animation: float 6s ease-in-out infinite;"/>
                    <!-- Floating decorative elements -->
                    <div class="absolute top-10 right-10 bg-white rounded-xl p-4 shadow-lg flex items-center gap-3 z-20">
                        <div class="w-10 h-10 rounded-full bg-primary/10 flex items-center justify-center text-primary">
                            <span class="material-symbols-outlined">check_circle</span>
                        </div>
                        <div>
                            <p class="font-bold text-xs text-on-surface">Presensi Berhasil</p>
                            <p class="text-[10px] text-secondary">07:15 AM</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Features Section (Bento Grid) -->
        <section class="py-24 bg-white" id="features">
            <div class="max-w-7xl mx-auto px-6">
                <div class="text-center mb-16 max-w-2xl mx-auto">
                    <h2 class="text-3xl font-extrabold text-on-surface mb-4">Teknologi Terdepan untuk Pendidikan</h2>
                    <p class="text-sm text-secondary">Ekosistem lengkap yang dirancang khusus untuk memenuhi kebutuhan pengawasan modern, dari pintu gerbang hingga ruang kelas.</p>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Bento Item 1: QR Code -->
                    <div class="md:col-span-2 bg-[#f6fafe] rounded-2xl p-8 shadow-soft border border-surface-container relative overflow-hidden group hover:shadow-md transition-all">
                        <div class="absolute top-0 right-0 w-64 h-64 bg-primary/5 rounded-bl-full z-0 transition-transform group-hover:scale-110 duration-500"></div>
                        <div class="relative z-10 h-full flex flex-col justify-between min-h-[180px]">
                            <div class="w-14 h-14 bg-primary/10 rounded-xl flex items-center justify-center text-primary mb-6">
                                <span class="material-symbols-outlined text-3xl">qr_code_scanner</span>
                            </div>
                            <div>
                                <h3 class="text-lg text-on-surface mb-2 font-bold">Presensi QR Code Super Cepat</h3>
                                <p class="text-xs text-secondary max-w-md leading-relaxed">Sistem pemindaian QR dinamis yang mempercepat antrean pagi. Kode berubah setiap detik untuk mencegah kecurangan dan memastikan kehadiran fisik siswa.</p>
                            </div>
                        </div>
                    </div>
                    <!-- Bento Item 2: Parent Notifications -->
                    <div class="bg-[#f6fafe] rounded-2xl p-8 shadow-soft border border-surface-container relative overflow-hidden group hover:shadow-md transition-all">
                        <div class="relative z-10 h-full flex flex-col justify-between min-h-[180px]">
                            <div class="w-14 h-14 bg-primary/10 rounded-xl flex items-center justify-center text-primary mb-6">
                                <span class="material-symbols-outlined text-3xl">notifications_active</span>
                            </div>
                            <div>
                                <h3 class="text-lg text-on-surface mb-2 font-bold">Notifikasi Orang Tua</h3>
                                <p class="text-xs text-secondary leading-relaxed">Pembaruan real-time via WhatsApp atau Push Notification setiap kali siswa tiba atau meninggalkan area sekolah.</p>
                            </div>
                        </div>
                    </div>
                    <!-- Bento Item 3: Device Validation -->
                    <div class="bg-[#f6fafe] rounded-2xl p-8 shadow-soft border border-surface-container relative overflow-hidden group hover:shadow-md transition-all">
                        <div class="relative z-10 h-full flex flex-col justify-between min-h-[180px]">
                            <div class="w-14 h-14 bg-primary/10 rounded-xl flex items-center justify-center text-primary mb-6">
                                <span class="material-symbols-outlined text-3xl">devices</span>
                            </div>
                            <div>
                                <h3 class="text-lg text-on-surface mb-2 font-bold">Validasi Perangkat Cerdas</h3>
                                <p class="text-xs text-secondary leading-relaxed">Sistem mengunci profil siswa ke satu perangkat utama, mencegah "titip absen" dan meningkatkan integritas data kehadiran.</p>
                            </div>
                        </div>
                    </div>
                    <!-- Bento Item 4: AI Summaries -->
                    <div class="md:col-span-2 bg-[#f6fafe] rounded-2xl p-8 shadow-soft border border-surface-container relative overflow-hidden group hover:shadow-md transition-all flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
                        <div class="relative z-10 flex-1">
                            <div class="w-14 h-14 bg-primary/10 rounded-xl flex items-center justify-center text-primary mb-6">
                                <span class="material-symbols-outlined text-3xl">analytics</span>
                            </div>
                            <h3 class="text-lg text-on-surface mb-2 font-bold">Ringkasan Berbasis AI</h3>
                            <p class="text-xs text-secondary leading-relaxed">Dashboard analitik pintar yang secara otomatis mengidentifikasi pola ketidakhadiran, memprediksi risiko putus sekolah, dan menghasilkan laporan komprehensif untuk wali kelas.</p>
                        </div>
                        <div class="w-full md:w-48 h-32 bg-white rounded-xl flex-shrink-0 relative overflow-hidden border border-surface-container flex items-center justify-center">
                            <span class="material-symbols-outlined text-primary text-[60px] opacity-20">auto_awesome</span>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- How It Works Section (Process) -->
        <section class="py-24 bg-[#f6fafe]" id="how-it-works">
            <div class="max-w-7xl mx-auto px-6">
                <div class="text-center mb-20">
                    <h2 class="text-3xl font-extrabold text-on-surface mb-4">Cara Kerja Kehadiran</h2>
                    <p class="text-sm text-secondary max-w-2xl mx-auto">Proses yang mulus dari kedatangan hingga pelaporan, dirancang untuk efisiensi maksimum di lingkungan sekolah yang sibuk.</p>
                </div>
                <div class="relative">
                    <!-- Connecting Line -->
                    <div class="hidden lg:block absolute top-10 left-0 w-full h-1 bg-gray-200 z-0"></div>
                    <div class="grid grid-cols-1 lg:grid-cols-4 gap-12 relative z-10">
                        <!-- Step 1 -->
                        <div class="flex flex-col items-center text-center">
                            <div class="w-20 h-20 bg-white rounded-full shadow-soft flex items-center justify-center mb-6 border-4 border-[#f6fafe] z-10 font-extrabold text-xl text-primary">
                                1
                            </div>
                            <h4 class="font-bold text-sm text-on-surface mb-2">Tiba di Sekolah</h4>
                            <p class="text-xs text-secondary">Siswa tiba di gerbang dan membuka aplikasi seluler Presence Teen.</p>
                        </div>
                        <!-- Step 2 -->
                        <div class="flex flex-col items-center text-center">
                            <div class="w-20 h-20 bg-white rounded-full shadow-soft flex items-center justify-center mb-6 border-4 border-[#f6fafe] z-10 font-extrabold text-xl text-primary">
                                2
                            </div>
                            <h4 class="font-bold text-sm text-on-surface mb-2">Scan QR Dinamis</h4>
                            <p class="text-xs text-secondary">Memindai QR Code unik yang berputar pada layar tablet pengawas gerbang.</p>
                        </div>
                        <!-- Step 3 -->
                        <div class="flex flex-col items-center text-center">
                            <div class="w-20 h-20 bg-white rounded-full shadow-soft flex items-center justify-center mb-6 border-4 border-[#f6fafe] z-10 font-extrabold text-xl text-primary">
                                3
                            </div>
                            <h4 class="font-bold text-sm text-on-surface mb-2">Validasi Instan</h4>
                            <p class="text-xs text-secondary">Sistem memverifikasi perangkat, lokasi, dan identitas dalam hitungan milidetik.</p>
                        </div>
                        <!-- Step 4 -->
                        <div class="flex flex-col items-center text-center">
                            <div class="w-20 h-20 bg-white rounded-full shadow-soft flex items-center justify-center mb-6 border-4 border-[#f6fafe] z-10 font-extrabold text-xl text-primary">
                                4
                            </div>
                            <h4 class="font-bold text-sm text-on-surface mb-2">Update &amp; Notifikasi</h4>
                            <p class="text-xs text-secondary">Dashboard guru diperbarui, dan orang tua menerima pesan konfirmasi aman.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Preview Section -->
        <section class="py-24 bg-primary text-white overflow-hidden" id="preview">
            <div class="max-w-7xl mx-auto px-6 grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
                <div class="order-2 lg:order-1 relative">
                    <div class="glass-card rounded-3xl p-4 md:p-8 transform rotate-[-2deg] shadow-2xl relative z-10">
                        <img class="w-full h-auto rounded-xl shadow-inner border border-white/20" alt="Presence Teen Dashboard Preview" src="https://lh3.googleusercontent.com/aida-public/AB6AXuDMzR9K2zlipFXHPAm1_KDUEJ0GIRhpGiX8sPHj6FWD8pa4Lhiv1uTXeCZWGjUzLcSyQMmdkTkIwIqrU-UfLXPchuM_5mjKYLaNZkpYI-wg0yryaSspvpqM1MtgcLEjSHh2RATEB1znS5ykcLPDRpbaTfKqaWOjMz-2MtttNBAXw0ICH6twzYNKsgmFu0I1pVTnnfbtKYaNiodHHMZBYLisfiGV3pVVec0omBRJeUqQgnSqG0dPpi5RjdUkHbSspRpDJ5qvq2edFwjw"/>
                    </div>
                    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-full h-full bg-white/5 blur-3xl rounded-full z-0"></div>
                </div>
                <div class="order-1 lg:order-2 flex flex-col gap-6">
                    <h2 class="text-3xl font-extrabold text-white mb-2">Dashboard Administratif Kuat &amp; Intuitif</h2>
                    <p class="text-sm text-white/90 leading-relaxed">Dirancang khusus untuk desktop, antarmuka guru dan admin kami menyediakan visibilitas penuh atas operasional harian tanpa kebingungan.</p>
                    <ul class="flex flex-col gap-4">
                        <li class="flex items-start gap-4">
                            <div class="bg-white/20 p-2 rounded-lg backdrop-blur-sm mt-1">
                                <span class="material-symbols-outlined text-white">checklist</span>
                            </div>
                            <div>
                                <h4 class="font-bold text-sm text-white">Tampilan Kelas Komprehensif</h4>
                                <p class="text-xs text-white/80 mt-1">Lihat status seluruh siswa dalam satu pandangan dengan indikator warna yang jelas.</p>
                            </div>
                        </li>
                        <li class="flex items-start gap-4">
                            <div class="bg-white/20 p-2 rounded-lg backdrop-blur-sm mt-1">
                                <span class="material-symbols-outlined text-white">summarize</span>
                            </div>
                            <div>
                                <h4 class="font-bold text-sm text-white">Ekspor Laporan Mudah</h4>
                                <p class="text-xs text-white/80 mt-1">Hasilkan laporan kehadiran bulanan dalam format Excel atau PDF hanya dengan satu klik.</p>
                            </div>
                        </li>
                    </ul>
                    <div class="mt-4">
                        <a href="{{ route('login') }}" class="inline-flex bg-white text-primary px-8 py-3 rounded-xl font-bold text-xs shadow-lg hover:bg-gray-100 transition-all">
                            Lihat Demo Dashboard
                        </a>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <!-- Footer -->
    <footer class="bg-white border-t border-gray-100 pt-16 pb-8">
        <div class="max-w-7xl mx-auto px-6">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-12 mb-16">
                <div class="col-span-1 flex flex-col gap-4">
                    <div class="flex items-center gap-3 mb-2">
                        <img alt="Presence Teen Logo" class="h-8 w-8 object-contain" src="{{ asset('smansa.png') }}"/>
                        <span class="font-bold text-lg text-primary tracking-tight">Presence Teen</span>
                    </div>
                    <p class="text-xs text-secondary leading-relaxed">
                        Membangun lingkungan sekolah yang lebih aman dan disiplin melalui teknologi cerdas.
                    </p>
                </div>
                <div class="flex flex-col gap-4">
                    <h5 class="font-bold text-sm text-on-surface">Produk</h5>
                    <a class="text-xs text-secondary hover:text-primary transition-colors" href="#">Aplikasi Siswa</a>
                    <a class="text-xs text-secondary hover:text-primary transition-colors" href="#">Dashboard Admin</a>
                    <a class="text-xs text-secondary hover:text-primary transition-colors" href="#">Portal Orang Tua</a>
                    <a class="text-xs text-secondary hover:text-primary transition-colors" href="#">Fitur Keamanan</a>
                </div>
                <div class="flex flex-col gap-4">
                    <h5 class="font-bold text-sm text-on-surface">Perusahaan</h5>
                    <a class="text-xs text-secondary hover:text-primary transition-colors" href="#">Tentang Kami</a>
                    <a class="text-xs text-secondary hover:text-primary transition-colors" href="#">Karir</a>
                    <a class="text-xs text-secondary hover:text-primary transition-colors" href="#">Blog</a>
                    <a class="text-xs text-secondary hover:text-primary transition-colors" href="#">Hubungi Kami</a>
                </div>
                <div class="flex flex-col gap-4">
                    <h5 class="font-bold text-sm text-on-surface">Legal</h5>
                    <a class="text-xs text-secondary hover:text-primary transition-colors" href="#">Syarat &amp; Ketentuan</a>
                    <a class="text-xs text-secondary hover:text-primary transition-colors" href="#">Kebijakan Privasi</a>
                    <a class="text-xs text-secondary hover:text-primary transition-colors" href="#">Keamanan Data</a>
                </div>
            </div>
            <div class="border-t border-gray-100 pt-8 flex flex-col md:flex-row justify-between items-center gap-4">
                <p class="text-xs text-secondary text-center md:text-left">
                    © 2024 Presence Teen. All rights reserved.
                </p>
                <div class="flex gap-4">
                    <a class="w-10 h-10 rounded-full bg-background flex items-center justify-center text-secondary hover:bg-gray-200 transition-colors" href="#">
                        <span class="material-symbols-outlined text-sm">link</span>
                    </a>
                    <a class="w-10 h-10 rounded-full bg-background flex items-center justify-center text-secondary hover:bg-gray-200 transition-colors" href="#">
                        <span class="material-symbols-outlined text-sm">share</span>
                    </a>
                </div>
            </div>
        </div>
    </footer>
</body>
</html>
