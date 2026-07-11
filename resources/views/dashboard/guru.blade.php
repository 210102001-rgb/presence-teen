<x-app-layout>
    <x-slot name="header">Dashboard Guru</x-slot>

    <div class="p-4 md:p-8 max-w-7xl mx-auto space-y-6">
        {{-- Welcome Section --}}
        <header class="mb-8">
            <h2 class="text-2xl font-bold text-[#171c1f] mb-1">Selamat Datang, {{ Auth::user()->name }} 👋</h2>
            <p class="text-sm text-[#5c5f61]">Kelola kelas, presensi, tugas, dan pantau laporan siswa dengan mudah.</p>
        </header>

        {{-- Top Grid Section --}}
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-stretch">
            {{-- Profile Card (Left) --}}
            <div class="lg:col-span-4 bg-white rounded-2xl p-6 shadow-soft border border-[#eaeef2] flex flex-col items-center text-center justify-between">
                <div class="flex flex-col items-center w-full">
                    <div class="w-24 h-24 rounded-full border-4 border-[#97f7ac] mb-4 overflow-hidden bg-gray-100 flex items-center justify-center">
                        <div class="w-full h-full bg-[#0e7a3d]/10 text-[#005f2d] flex items-center justify-center text-3xl font-bold">
                            {{ substr(Auth::user()->name, 0, 1) }}
                        </div>
                    </div>
                    <h3 class="text-lg font-bold text-[#171c1f]">{{ Auth::user()->name }}</h3>
                    <p class="text-xs text-[#5c5f61] mb-6">Guru / Pendidik</p>
                </div>
                
                <div class="w-full flex justify-between px-4 py-3 bg-[#f6fafe] rounded-xl border border-[#eaeef2] mt-auto">
                    <div class="flex flex-col items-center flex-1">
                        <span class="text-[9px] text-[#5c5f61] font-bold uppercase tracking-wider">Total Kelas</span>
                        <span class="text-[#005f2d] font-bold text-sm mt-1">{{ $totalKelas }}</span>
                    </div>
                    <div class="w-px bg-[#becabc] h-8 my-auto"></div>
                    <div class="flex flex-col items-center flex-1">
                        <span class="text-[9px] text-[#5c5f61] font-bold uppercase tracking-wider">Total Siswa</span>
                        <span class="text-[#005f2d] font-bold text-sm mt-1">{{ $totalSiswa }}</span>
                    </div>
                </div>
            </div>

            {{-- Stats Grid (Col-span 8) --}}
            <div class="lg:col-span-8 flex flex-col justify-between gap-6">
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                    <div class="bg-[#0e7a3d] text-[#a5ffb7] rounded-2xl p-6 shadow-soft flex flex-col justify-center items-center text-center">
                        <span class="text-[10px] uppercase font-bold tracking-widest text-[#a5ffb7]/80 mb-1">Total Kelas</span>
                        <div class="text-3xl font-bold text-white">{{ $totalKelas }}</div>
                    </div>
                    <div class="bg-white rounded-2xl p-6 shadow-soft border-t-4 border-[#495362] border-l border-r border-b border-[#eaeef2] flex flex-col justify-center items-center text-center">
                        <span class="text-[10px] uppercase font-bold tracking-widest text-[#5c5f61] mb-1">Total Siswa</span>
                        <div class="text-3xl font-bold text-[#171c1f]">{{ $totalSiswa }}</div>
                    </div>
                    <div class="bg-white rounded-2xl p-6 shadow-soft border-t-4 border-[#005f2d] border-l border-r border-b border-[#eaeef2] flex flex-col justify-center items-center text-center">
                        <span class="text-[10px] uppercase font-bold tracking-widest text-[#5c5f61] mb-1">Total Tugas</span>
                        <div class="text-3xl font-bold text-[#005f2d]">{{ $totalTugas }}</div>
                    </div>
                </div>

                {{-- Trend Chart Placeholder --}}
                <div class="bg-white rounded-2xl p-6 shadow-soft border border-[#eaeef2] flex-1 flex flex-col justify-between">
                    <div class="flex justify-between items-center mb-6">
                        <h4 class="font-bold text-[#171c1f]">Grafik Keaktifan Presensi</h4>
                        <span class="text-[10px] text-[#005f2d] font-bold bg-[#f0fdf4] px-2 py-0.5 rounded-lg border border-[#0e7a3d]/20">Bulan Ini</span>
                    </div>
                    <div class="h-32 w-full flex items-end justify-between px-4 gap-4">
                        <div class="flex-1 bg-[#005f2d]/20 rounded-t-lg h-[85%] relative group cursor-pointer hover:bg-[#005f2d]/40 transition-all">
                            <div class="absolute -top-7 left-1/2 -translate-x-1/2 bg-[#171c1f] text-white text-[9px] px-1.5 py-0.5 rounded opacity-0 group-hover:opacity-100 transition-opacity z-10">85%</div>
                        </div>
                        <div class="flex-1 bg-[#005f2d]/20 rounded-t-lg h-[90%] relative group cursor-pointer hover:bg-[#005f2d]/40 transition-all">
                            <div class="absolute -top-7 left-1/2 -translate-x-1/2 bg-[#171c1f] text-white text-[9px] px-1.5 py-0.5 rounded opacity-0 group-hover:opacity-100 transition-opacity z-10">90%</div>
                        </div>
                        <div class="flex-1 bg-[#005f2d] rounded-t-lg h-[95%] relative group cursor-pointer hover:bg-[#005f2d]/90 transition-all">
                            <div class="absolute -top-7 left-1/2 -translate-x-1/2 bg-[#171c1f] text-white text-[9px] px-1.5 py-0.5 rounded opacity-0 group-hover:opacity-100 transition-opacity z-10">95%</div>
                        </div>
                        <div class="flex-1 bg-[#005f2d]/20 rounded-t-lg h-[80%] relative group cursor-pointer hover:bg-[#005f2d]/40 transition-all">
                            <div class="absolute -top-7 left-1/2 -translate-x-1/2 bg-[#171c1f] text-white text-[9px] px-1.5 py-0.5 rounded opacity-0 group-hover:opacity-100 transition-opacity z-10">80%</div>
                        </div>
                        <div class="flex-1 bg-[#005f2d]/20 rounded-t-lg h-[88%] relative group cursor-pointer hover:bg-[#005f2d]/40 transition-all">
                            <div class="absolute -top-7 left-1/2 -translate-x-1/2 bg-[#171c1f] text-white text-[9px] px-1.5 py-0.5 rounded opacity-0 group-hover:opacity-100 transition-opacity z-10">88%</div>
                        </div>
                    </div>
                    <div class="flex justify-between mt-2 text-[10px] text-[#5c5f61] font-bold px-4 uppercase">
                        <span>Minggu 1</span><span>Minggu 2</span><span>Minggu 3</span><span>Minggu 4</span><span>Minggu 5</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Action Cards --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            {{-- QR Presensi --}}
            <div class="bg-white rounded-2xl shadow-soft p-6 border border-[#eaeef2] flex flex-col justify-between min-h-[200px] hover:border-[#0e7a3d]/30 transition-all duration-300">
                <div>
                    <div class="w-12 h-12 bg-[#f0fdf4] rounded-xl flex items-center justify-center mb-4 text-[#0e7a3d]">
                        <span class="material-symbols-outlined text-[28px]">qr_code_2</span>
                    </div>
                    <h4 class="font-bold text-[#171c1f] mb-1">QR Presensi</h4>
                    <p class="text-xs text-[#5c5f61] leading-relaxed">Generate QR Code untuk mempermudah presensi kelas digital secara real-time.</p>
                </div>
                <a href="{{ route('presensi.guru') }}"
                   class="inline-flex items-center gap-1 text-xs font-bold text-[#005f2d] hover:text-[#0e7a3d] transition-colors mt-4 self-start">
                    Generate QR <span class="material-symbols-outlined text-[16px]">arrow_forward</span>
                </a>
            </div>

            {{-- Kelola Tugas --}}
            <div class="bg-white rounded-2xl shadow-soft p-6 border border-[#eaeef2] flex flex-col justify-between min-h-[200px] hover:border-[#0e7a3d]/30 transition-all duration-300">
                <div>
                    <div class="w-12 h-12 bg-[#f0fdf4] rounded-xl flex items-center justify-center mb-4 text-[#0e7a3d]">
                        <span class="material-symbols-outlined text-[28px]">assignment</span>
                    </div>
                    <h4 class="font-bold text-[#171c1f] mb-1">Kelola Tugas</h4>
                    <p class="text-xs text-[#5c5f61] leading-relaxed">Buat, edit, dan kelola penugasan/PR untuk seluruh siswa di kelas Anda.</p>
                </div>
                <a href="{{ route('tugas.index') }}"
                   class="inline-flex items-center gap-1 text-xs font-bold text-[#005f2d] hover:text-[#0e7a3d] transition-colors mt-4 self-start">
                    Kelola Tugas <span class="material-symbols-outlined text-[16px]">arrow_forward</span>
                </a>
            </div>

            {{-- Laporan --}}
            <div class="bg-white rounded-2xl shadow-soft p-6 border border-[#eaeef2] flex flex-col justify-between min-h-[200px] hover:border-[#0e7a3d]/30 transition-all duration-300">
                <div>
                    <div class="w-12 h-12 bg-[#f0fdf4] rounded-xl flex items-center justify-center mb-4 text-[#0e7a3d]">
                        <span class="material-symbols-outlined text-[28px]">monitoring</span>
                    </div>
                    <h4 class="font-bold text-[#171c1f] mb-1">Laporan Siswa</h4>
                    <p class="text-xs text-[#5c5f61] leading-relaxed">Pantau perkembangan kehadiran, nilai, dan analisis warning AI siswa.</p>
                </div>
                <a href="{{ route('laporan.index') }}"
                   class="inline-flex items-center gap-1 text-xs font-bold text-[#005f2d] hover:text-[#0e7a3d] transition-colors mt-4 self-start">
                    Lihat Laporan <span class="material-symbols-outlined text-[16px]">arrow_forward</span>
                </a>
            </div>
        </div>

        {{-- Upload Materi Banner --}}
        <div class="bg-[#f0fdf4] border border-[#0e7a3d]/20 rounded-2xl p-6 flex flex-col md:flex-row items-start md:items-center justify-between gap-4 relative overflow-hidden">
            <div class="absolute right-0 top-0 p-4 opacity-5 pointer-events-none">
                <span class="material-symbols-outlined text-[80px] text-[#0e7a3d]">auto_awesome</span>
            </div>
            <div class="flex items-start gap-4">
                <div class="w-12 h-12 bg-[#0e7a3d]/10 rounded-full flex items-center justify-center text-[#0e7a3d] shrink-0">
                    <span class="material-symbols-outlined filled-icon">auto_awesome</span>
                </div>
                <div class="max-w-xl">
                    <h4 class="font-bold text-[#005f2d] text-sm">Upload Materi + Ringkasan AI</h4>
                    <p class="text-xs text-[#3f493f] mt-1 leading-relaxed">Upload file materi (PDF/DOCX) dan biarkan AI Claude meringkas isi penting materi secara otomatis untuk siswa.</p>
                </div>
            </div>
            <a href="{{ route('materi.create') }}"
               class="shrink-0 bg-[#005f2d] text-white px-5 py-2.5 rounded-xl text-xs font-semibold hover:bg-[#0e7a3d] transition-all shadow-soft relative z-10 self-stretch md:self-auto text-center">
                Upload Sekarang
            </a>
        </div>
    </div>
</x-app-layout>
