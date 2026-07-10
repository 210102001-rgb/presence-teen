<x-app-layout>
    <x-slot name="header">Dashboard Siswa</x-slot>

    <div class="p-8">
        {{-- Welcome --}}
        <div class="mb-8">
            <h2 class="text-2xl font-bold text-[#171c1f]">Selamat Datang, {{ Auth::user()->name }} 👋</h2>
            <p class="text-sm text-[#3f493f] mt-1">Semangat belajar! Pantau tugas, presensi, dan materi pelajaranmu.</p>
        </div>

        {{-- Stats Grid --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-[#0e7a3d] text-[#a5ffb7] rounded-xl p-6 shadow-soft">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-[11px] uppercase tracking-widest text-[#a5ffb7]/80 font-semibold">Presensi Bulan Ini</p>
                        <p class="text-4xl font-bold text-white mt-1">95<span class="text-xl">%</span></p>
                        <p class="text-xs text-white/60 mt-1">Tingkat kehadiran</p>
                    </div>
                    <div class="w-12 h-12 bg-white/15 rounded-xl flex items-center justify-center">
                        <span class="material-symbols-outlined text-white filled-icon">calendar_month</span>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl p-6 shadow-soft border-t-4 border-[#495362]">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-[11px] uppercase tracking-widest text-[#5c5f61] font-semibold">Tugas Aktif</p>
                        <p class="text-4xl font-bold text-[#171c1f] mt-1">3</p>
                        <p class="text-xs text-[#5c5f61] mt-1">Perlu dikerjakan</p>
                    </div>
                    <div class="w-12 h-12 bg-[#eaeef2] rounded-xl flex items-center justify-center">
                        <span class="material-symbols-outlined text-[#495362]">assignment</span>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl p-6 shadow-soft border-t-4 border-[#005f2d]">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-[11px] uppercase tracking-widest text-[#5c5f61] font-semibold">Materi Tersedia</p>
                        <p class="text-4xl font-bold text-[#171c1f] mt-1">5</p>
                        <p class="text-xs text-[#5c5f61] mt-1">Siap dipelajari</p>
                    </div>
                    <div class="w-12 h-12 bg-[#eaeef2] rounded-xl flex items-center justify-center">
                        <span class="material-symbols-outlined text-[#005f2d]">menu_book</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Content Grid --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            {{-- Tugas Mendatang --}}
            <div class="bg-white rounded-xl shadow-soft p-6 border border-[#eaeef2]">
                <div class="flex justify-between items-center mb-5">
                    <h4 class="font-semibold text-[#171c1f]">Tugas Mendatang</h4>
                    <a href="{{ route('tugas.index') }}" class="text-xs font-semibold text-[#005f2d] hover:underline">Lihat Semua</a>
                </div>
                <ul class="space-y-3">
                    <li class="flex items-center justify-between py-2 border-b border-[#f0f4f8]">
                        <div>
                            <p class="text-sm font-medium text-[#171c1f]">Matematika</p>
                            <p class="text-xs text-[#5c5f61]">Pengumpulan besok</p>
                        </div>
                        <span class="px-2.5 py-1 text-[10px] font-bold bg-amber-100 text-amber-700 rounded-full uppercase tracking-wider">Besok</span>
                    </li>
                    <li class="flex items-center justify-between py-2 border-b border-[#f0f4f8]">
                        <div>
                            <p class="text-sm font-medium text-[#171c1f]">IPA</p>
                            <p class="text-xs text-[#5c5f61]">Laporan praktikum</p>
                        </div>
                        <span class="px-2.5 py-1 text-[10px] font-bold bg-blue-100 text-blue-700 rounded-full uppercase tracking-wider">3 hari</span>
                    </li>
                    <li class="flex items-center justify-between py-2">
                        <div>
                            <p class="text-sm font-medium text-[#171c1f]">Bahasa Indonesia</p>
                            <p class="text-xs text-[#5c5f61]">Esai deskriptif</p>
                        </div>
                        <span class="px-2.5 py-1 text-[10px] font-bold bg-[#f0fdf4] text-[#005f2d] rounded-full uppercase tracking-wider">1 minggu</span>
                    </li>
                </ul>
            </div>

            {{-- Scan Presensi --}}
            <div class="bg-white rounded-xl shadow-soft p-6 border border-[#eaeef2] flex flex-col items-center text-center">
                <div class="w-16 h-16 bg-[#f0fdf4] rounded-full flex items-center justify-center mb-4">
                    <span class="material-symbols-outlined text-[#0e7a3d] filled-icon text-3xl">qr_code_scanner</span>
                </div>
                <h4 class="font-semibold text-[#171c1f] mb-2">Scan Presensi</h4>
                <p class="text-sm text-[#5c5f61] mb-5">Scan QR Code yang diberikan guru untuk mencatat kehadiranmu.</p>
                <a href="{{ route('presensi.scan') }}"
                   class="w-full bg-[#005f2d] text-white py-2.5 rounded-xl text-sm font-semibold hover:bg-[#0e7a3d] transition-colors text-center">
                    Buka Scanner
                </a>
            </div>

            {{-- Materi AI --}}
            <div class="bg-white rounded-xl shadow-soft p-6 border border-[#eaeef2]">
                <div class="w-12 h-12 bg-[#f0fdf4] rounded-xl flex items-center justify-center mb-4">
                    <span class="material-symbols-outlined text-[#0e7a3d] filled-icon">auto_awesome</span>
                </div>
                <h4 class="font-semibold text-[#171c1f] mb-1">Ringkasan Materi AI</h4>
                <p class="text-sm text-[#5c5f61] mb-4">Akses materi pelajaran beserta ringkasan otomatis dari AI Claude.</p>
                <a href="{{ route('materi.index') }}"
                   class="inline-flex items-center gap-1 text-sm font-semibold text-[#005f2d] hover:text-[#0e7a3d] transition-colors">
                    Lihat Materi <span class="material-symbols-outlined text-[18px]">arrow_forward</span>
                </a>
            </div>
        </div>

        {{-- AI Insight Banner --}}
        <div class="mt-6 bg-[#f0fdf4] border border-[#0e7a3d]/20 rounded-xl p-5 flex items-center gap-4">
            <span class="material-symbols-outlined text-[#0e7a3d] filled-icon text-2xl shrink-0">auto_awesome</span>
            <p class="text-sm text-[#3f493f]">
                <span class="font-semibold text-[#005f2d]">Tips Belajar:</span>
                Konsistensi adalah kunci. Usahakan hadir setiap hari dan kumpulkan tugas tepat waktu untuk hasil terbaik!
            </p>
        </div>
    </div>
</x-app-layout>
