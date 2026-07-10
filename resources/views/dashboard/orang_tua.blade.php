<x-app-layout>
    <x-slot name="header">Dashboard Orang Tua</x-slot>

    <div class="p-8">
        {{-- Welcome --}}
        <div class="mb-8">
            <h2 class="text-2xl font-bold text-[#171c1f]">Selamat Datang, {{ Auth::user()->name }} 👋</h2>
            <p class="text-sm text-[#3f493f] mt-1">Pantau perkembangan belajar dan kehadiran putra/putri Anda secara real-time.</p>
        </div>

        {{-- Stats Grid --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-[#0e7a3d] text-[#a5ffb7] rounded-xl p-6 shadow-soft">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-[11px] uppercase tracking-widest text-[#a5ffb7]/80 font-semibold">Kehadiran Hari Ini</p>
                        <p class="text-3xl font-bold text-white mt-1">Hadir</p>
                        <p class="text-xs text-white/60 mt-1">Hari ini</p>
                    </div>
                    <div class="w-12 h-12 bg-white/15 rounded-xl flex items-center justify-center">
                        <span class="material-symbols-outlined text-white filled-icon">check_circle</span>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl p-6 shadow-soft border-t-4 border-[#495362]">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-[11px] uppercase tracking-widest text-[#5c5f61] font-semibold">Tugas Tersedia</p>
                        <p class="text-4xl font-bold text-[#171c1f] mt-1">3</p>
                        <p class="text-xs text-[#5c5f61] mt-1">Tugas aktif</p>
                    </div>
                    <div class="w-12 h-12 bg-[#eaeef2] rounded-xl flex items-center justify-center">
                        <span class="material-symbols-outlined text-[#495362]">assignment</span>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl p-6 shadow-soft border-t-4 border-[#005f2d]">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-[11px] uppercase tracking-widest text-[#5c5f61] font-semibold">Peringatan</p>
                        <p class="text-4xl font-bold text-[#171c1f] mt-1">0</p>
                        <p class="text-xs text-[#5c5f61] mt-1">Tidak ada peringatan</p>
                    </div>
                    <div class="w-12 h-12 bg-[#eaeef2] rounded-xl flex items-center justify-center">
                        <span class="material-symbols-outlined text-[#005f2d]">notifications_none</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Content Grid --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            {{-- Tugas Anak --}}
            <div class="bg-white rounded-xl shadow-soft p-6 border border-[#eaeef2]">
                <div class="flex justify-between items-center mb-5">
                    <h4 class="font-semibold text-[#171c1f]">Status Tugas Anak</h4>
                    <a href="{{ route('laporan.index') }}" class="text-xs font-semibold text-[#005f2d] hover:underline">Lihat Semua</a>
                </div>
                <ul class="space-y-3">
                    <li class="flex items-center justify-between py-2.5 px-3 rounded-xl bg-[#f0fdf4] border border-[#0e7a3d]/10">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 bg-[#0e7a3d]/10 rounded-lg flex items-center justify-center">
                                <span class="material-symbols-outlined text-[#0e7a3d] text-[18px] filled-icon">check_circle</span>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-[#171c1f]">Matematika</p>
                                <p class="text-xs text-[#5c5f61]">Selesai dikumpulkan</p>
                            </div>
                        </div>
                        <span class="px-2.5 py-1 text-[10px] font-bold bg-[#f0fdf4] text-[#005f2d] border border-[#0e7a3d]/20 rounded-full uppercase">Selesai</span>
                    </li>
                    <li class="flex items-center justify-between py-2.5 px-3 rounded-xl bg-amber-50 border border-amber-200">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 bg-amber-100 rounded-lg flex items-center justify-center">
                                <span class="material-symbols-outlined text-amber-600 text-[18px]">schedule</span>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-[#171c1f]">IPA</p>
                                <p class="text-xs text-[#5c5f61]">Belum dikumpulkan</p>
                            </div>
                        </div>
                        <span class="px-2.5 py-1 text-[10px] font-bold bg-amber-100 text-amber-700 rounded-full uppercase">Belum</span>
                    </li>
                    <li class="flex items-center justify-between py-2.5 px-3 rounded-xl bg-[#f0fdf4] border border-[#0e7a3d]/10">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 bg-[#0e7a3d]/10 rounded-lg flex items-center justify-center">
                                <span class="material-symbols-outlined text-[#0e7a3d] text-[18px] filled-icon">check_circle</span>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-[#171c1f]">Bahasa Inggris</p>
                                <p class="text-xs text-[#5c5f61]">Selesai dikumpulkan</p>
                            </div>
                        </div>
                        <span class="px-2.5 py-1 text-[10px] font-bold bg-[#f0fdf4] text-[#005f2d] border border-[#0e7a3d]/20 rounded-full uppercase">Selesai</span>
                    </li>
                </ul>
            </div>

            {{-- Laporan Peringatan --}}
            <div class="bg-white rounded-xl shadow-soft p-6 border border-[#eaeef2]">
                <div class="flex justify-between items-center mb-5">
                    <h4 class="font-semibold text-[#171c1f]">Laporan AI & Peringatan</h4>
                    <a href="{{ route('laporan.index') }}" class="text-xs font-semibold text-[#005f2d] hover:underline">Lihat Laporan</a>
                </div>
                <div class="flex flex-col items-center py-6">
                    <div class="w-16 h-16 bg-[#f0fdf4] rounded-full flex items-center justify-center mb-3">
                        <span class="material-symbols-outlined text-[#0e7a3d] filled-icon text-3xl">shield_with_heart</span>
                    </div>
                    <p class="text-sm font-medium text-[#171c1f]">Semua Baik!</p>
                    <p class="text-xs text-[#5c5f61] text-center mt-1">Tidak ada peringatan untuk anak Anda saat ini.</p>
                </div>
                <a href="{{ route('laporan.index') }}"
                   class="w-full mt-2 border border-[#005f2d] text-[#005f2d] py-2.5 rounded-xl text-sm font-semibold hover:bg-[#f0fdf4] transition-colors text-center block">
                    Lihat Semua Laporan
                </a>
            </div>
        </div>

        {{-- AI Insight Banner --}}
        <div class="mt-6 bg-[#f0fdf4] border border-[#0e7a3d]/20 rounded-xl p-5 flex items-start gap-4">
            <span class="material-symbols-outlined text-[#0e7a3d] filled-icon text-2xl shrink-0 mt-0.5">auto_awesome</span>
            <div>
                <h5 class="text-sm font-semibold text-[#005f2d] mb-1">AI Insight Mingguan</h5>
                <p class="text-sm text-[#3f493f]">
                    Anak Anda menunjukkan konsistensi yang baik dalam kehadiran. Tingkat kehadiran yang tinggi berkorelasi positif dengan peningkatan prestasi akademik.
                </p>
            </div>
        </div>
    </div>
</x-app-layout>
