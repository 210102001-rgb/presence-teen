<x-app-layout>
    <x-slot name="header">Dashboard Guru</x-slot>

    <div class="p-8">
        {{-- Welcome Section --}}
        <div class="mb-8">
            <h2 class="text-2xl font-bold text-[#171c1f]">Selamat Datang, {{ Auth::user()->name }} 👋</h2>
            <p class="text-sm text-[#3f493f] mt-1">Kelola kelas, presensi, tugas, dan pantau laporan siswa dengan mudah.</p>
        </div>

        {{-- Stats Grid --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-[#0e7a3d] text-[#a5ffb7] rounded-xl p-6 shadow-soft">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-[11px] uppercase tracking-widest text-[#a5ffb7]/80 font-semibold">Total Kelas</p>
                        <p class="text-4xl font-bold text-white mt-1">{{ $totalKelas }}</p>
                        <p class="text-xs text-white/60 mt-1">Kelas aktif</p>
                    </div>
                    <div class="w-12 h-12 bg-white/15 rounded-xl flex items-center justify-center">
                        <span class="material-symbols-outlined text-white filled-icon">class</span>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl p-6 shadow-soft border-t-4 border-[#495362]">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-[11px] uppercase tracking-widest text-[#5c5f61] font-semibold">Total Siswa</p>
                        <p class="text-4xl font-bold text-[#171c1f] mt-1">{{ $totalSiswa }}</p>
                        <p class="text-xs text-[#5c5f61] mt-1">Seluruh siswa</p>
                    </div>
                    <div class="w-12 h-12 bg-[#eaeef2] rounded-xl flex items-center justify-center">
                        <span class="material-symbols-outlined text-[#495362]">groups</span>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl p-6 shadow-soft border-t-4 border-[#005f2d]">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-[11px] uppercase tracking-widest text-[#5c5f61] font-semibold">Total Tugas</p>
                        <p class="text-4xl font-bold text-[#171c1f] mt-1">{{ $totalTugas }}</p>
                        <p class="text-xs text-[#5c5f61] mt-1">Tugas dibuat</p>
                    </div>
                    <div class="w-12 h-12 bg-[#eaeef2] rounded-xl flex items-center justify-center">
                        <span class="material-symbols-outlined text-[#005f2d]">assignment</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Action Cards --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            {{-- QR Presensi --}}
            <div class="bg-white rounded-xl shadow-soft p-6 bento-card border border-[#eaeef2] hover:border-[#0e7a3d]/30">
                <div class="w-12 h-12 bg-[#f0fdf4] rounded-xl flex items-center justify-center mb-4">
                    <span class="material-symbols-outlined text-[#0e7a3d] filled-icon">qr_code_2</span>
                </div>
                <h4 class="font-semibold text-[#171c1f] mb-1">QR Presensi</h4>
                <p class="text-sm text-[#5c5f61] mb-4">Generate QR Code untuk presensi kelas dengan mudah.</p>
                <a href="{{ route('presensi.guru') }}"
                   class="inline-flex items-center gap-1 text-sm font-semibold text-[#005f2d] hover:text-[#0e7a3d] transition-colors">
                    Generate QR <span class="material-symbols-outlined text-[18px]">arrow_forward</span>
                </a>
            </div>

            {{-- Kelola Tugas --}}
            <div class="bg-white rounded-xl shadow-soft p-6 bento-card border border-[#eaeef2] hover:border-[#0e7a3d]/30">
                <div class="w-12 h-12 bg-[#f0fdf4] rounded-xl flex items-center justify-center mb-4">
                    <span class="material-symbols-outlined text-[#0e7a3d] filled-icon">assignment</span>
                </div>
                <h4 class="font-semibold text-[#171c1f] mb-1">Kelola Tugas</h4>
                <p class="text-sm text-[#5c5f61] mb-4">Buat, edit, dan kelola tugas untuk siswa.</p>
                <a href="{{ route('tugas.index') }}"
                   class="inline-flex items-center gap-1 text-sm font-semibold text-[#005f2d] hover:text-[#0e7a3d] transition-colors">
                    Kelola Tugas <span class="material-symbols-outlined text-[18px]">arrow_forward</span>
                </a>
            </div>

            {{-- Laporan --}}
            <div class="bg-white rounded-xl shadow-soft p-6 bento-card border border-[#eaeef2] hover:border-[#0e7a3d]/30">
                <div class="w-12 h-12 bg-[#f0fdf4] rounded-xl flex items-center justify-center mb-4">
                    <span class="material-symbols-outlined text-[#0e7a3d] filled-icon">monitoring</span>
                </div>
                <h4 class="font-semibold text-[#171c1f] mb-1">Laporan Siswa</h4>
                <p class="text-sm text-[#5c5f61] mb-4">Pantau laporan kehadiran dan peringatan siswa.</p>
                <a href="{{ route('laporan.index') }}"
                   class="inline-flex items-center gap-1 text-sm font-semibold text-[#005f2d] hover:text-[#0e7a3d] transition-colors">
                    Lihat Laporan <span class="material-symbols-outlined text-[18px]">arrow_forward</span>
                </a>
            </div>
        </div>

        {{-- Upload Materi --}}
        <div class="mt-6">
            <div class="bg-[#f0fdf4] border border-[#0e7a3d]/20 rounded-xl p-6 flex items-center gap-5">
                <div class="w-12 h-12 bg-[#0e7a3d]/10 rounded-full flex items-center justify-center text-[#0e7a3d] shrink-0">
                    <span class="material-symbols-outlined filled-icon">auto_awesome</span>
                </div>
                <div class="flex-1">
                    <h4 class="font-semibold text-[#005f2d]">Upload Materi + Ringkasan AI</h4>
                    <p class="text-sm text-[#3f493f] mt-0.5">Upload file materi (PDF/DOCX) dan biarkan AI Claude meringkas secara otomatis untuk siswa.</p>
                </div>
                <a href="{{ route('materi.create') }}"
                   class="shrink-0 bg-[#005f2d] text-white px-5 py-2.5 rounded-xl text-sm font-semibold hover:bg-[#0e7a3d] transition-colors">
                    Upload Sekarang
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
