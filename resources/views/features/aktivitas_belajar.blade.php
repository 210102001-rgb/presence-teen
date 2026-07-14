<x-app-layout>
    <x-slot name="header">Aktivitas Belajar Siswa</x-slot>

    <div class="p-4 md:p-8 max-w-7xl mx-auto space-y-6">
        {{-- AI Insight Section --}}
        <div class="bg-[#f0fdf4] border border-[#0e7a3d]/20 rounded-2xl p-6 shadow-soft flex flex-col md:flex-row items-start md:items-center justify-between gap-4 relative overflow-hidden">
            <div class="absolute right-0 top-0 p-4 opacity-5 pointer-events-none">
                <span class="material-symbols-outlined text-[80px] text-[#0e7a3d]">auto_awesome</span>
            </div>
            <div class="flex items-start gap-4">
                <div class="w-12 h-12 bg-[#0e7a3d]/10 rounded-full flex items-center justify-center text-[#0e7a3d] shrink-0 border border-[#0e7a3d]/20">
                    <span class="material-symbols-outlined text-[28px]">auto_awesome</span>
                </div>
                <div>
                    <h3 class="font-bold text-sm text-[#005f2d] mb-1">Analisis Aktivitas Mingguan</h3>
                    @php
                        $statusAktivitas = $attendanceRate >= 80 ? 'Sangat Aktif' : ($attendanceRate >= 50 ? 'Aktif' : 'Perlu Perhatian');
                    @endphp
                    <p class="text-xs text-[#3f493f] leading-relaxed max-w-2xl">
                        {{ $siswa->name }} menunjukkan status <span class="font-bold text-[#005f2d]">{{ $statusAktivitas }}</span> minggu ini dengan tingkat kehadiran sebesar {{ $attendanceRate }}% dari total sesi kelas.
                    </p>
                </div>
            </div>
            <button class="shrink-0 bg-[#005f2d] text-white px-5 py-2.5 rounded-xl text-xs font-semibold hover:bg-[#0e7a3d] transition-all shadow-soft z-10 self-stretch md:self-auto text-center">
                Lihat Laporan Detail
            </button>
        </div>

        {{-- Stats Grid --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-6">
            <div class="bg-white p-6 rounded-2xl shadow-soft border border-[#eaeef2] flex flex-col gap-2 justify-between">
                <div class="flex justify-between items-start">
                    <span class="material-symbols-outlined text-[#5c5f61]">login</span>
                    <span class="text-[9px] text-[#005f2d] font-bold bg-[#f0fdf4] px-1.5 py-0.5 rounded border border-[#0e7a3d]/20">+2</span>
                </div>
                <div>
                    <p class="text-[9px] font-bold text-[#5c5f61] uppercase tracking-wider">LMS Login</p>
                    <p class="text-2xl font-bold text-[#171c1f] mt-1">24 <span class="text-xs font-normal text-[#5c5f61]">Kali</span></p>
                </div>
            </div>
            <div class="bg-white p-6 rounded-2xl shadow-soft border border-[#eaeef2] flex flex-col gap-2 justify-between">
                <div class="flex justify-between items-start">
                    <span class="material-symbols-outlined text-[#5c5f61]">menu_book</span>
                    <span class="text-[9px] text-[#005f2d] font-bold bg-[#f0fdf4] px-1.5 py-0.5 rounded border border-[#0e7a3d]/20">100%</span>
                </div>
                <div>
                    <p class="text-[9px] font-bold text-[#5c5f61] uppercase tracking-wider">Akses Materi</p>
                    <p class="text-2xl font-bold text-[#171c1f] mt-1">{{ $totalMateri }} <span class="text-xs font-normal text-[#5c5f61]">Modul</span></p>
                </div>
            </div>
            <div class="bg-white p-6 rounded-2xl shadow-soft border border-[#eaeef2] flex flex-col gap-2 justify-between">
                <div class="flex justify-between items-start">
                    <span class="material-symbols-outlined text-[#5c5f61]">assignment</span>
                    <div class="w-2.5 h-2.5 rounded-full bg-primary animate-pulse mt-1"></div>
                </div>
                <div>
                    <p class="text-[9px] font-bold text-[#5c5f61] uppercase tracking-wider">Tugas Selesai</p>
                    <p class="text-2xl font-bold text-[#171c1f] mt-1">{{ $tugasSelesai }} / {{ $totalTugas }}</p>
                </div>
            </div>
            <div class="bg-white p-6 rounded-2xl shadow-soft border border-[#eaeef2] flex flex-col gap-2 justify-between">
                <div class="flex justify-between items-start">
                    <span class="material-symbols-outlined text-[#5c5f61]">forum</span>
                </div>
                <div>
                    <p class="text-[9px] font-bold text-[#5c5f61] uppercase tracking-wider">Diskusi Aktif</p>
                    <p class="text-2xl font-bold text-[#171c1f] mt-1">8 <span class="text-xs font-normal text-[#5c5f61]">Thread</span></p>
                </div>
            </div>
            <div class="bg-white p-6 rounded-2xl shadow-soft border border-[#eaeef2] flex flex-col gap-2 justify-between">
                <div class="flex justify-between items-start">
                    <span class="material-symbols-outlined text-[#5c5f61]">timer</span>
                </div>
                <div>
                    <p class="text-[9px] font-bold text-[#5c5f61] uppercase tracking-wider">Total Durasi</p>
                    <p class="text-2xl font-bold text-[#171c1f] mt-1">18.5 <span class="text-xs font-normal text-[#5c5f61]">Jam</span></p>
                </div>
            </div>
        </div>

        {{-- Main Grid Content --}}
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
            {{-- Activity Bar Chart (Col-span 8) --}}
            <div class="lg:col-span-8 bg-white p-6 rounded-2xl shadow-soft border border-[#eaeef2] flex flex-col justify-between min-h-[300px]">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="font-bold text-sm text-[#171c1f]">Grafik Aktivitas Harian</h3>
                    <div class="flex gap-4">
                        <span class="flex items-center gap-1 text-xs text-[#5c5f61]"><span class="w-2.5 h-2.5 rounded-full bg-[#005f2d]"></span> Belajar Mandiri</span>
                        <span class="flex items-center gap-1 text-xs text-[#5c5f61]"><span class="w-2.5 h-2.5 rounded-full bg-[#495362]"></span> Kelas Virtual</span>
                    </div>
                </div>
                <div class="h-48 flex items-end justify-between px-4 gap-6">
                    <div class="flex flex-col items-center gap-2 w-full group">
                        <div class="w-8 bg-[#495362]/20 rounded-t-lg relative flex flex-col justify-end h-[60%] border border-[#eaeef2]">
                            <div class="w-full bg-[#005f2d] rounded-t-lg h-[70%]" style="transition: opacity 0.2s"></div>
                        </div>
                        <span class="text-[10px] font-bold text-[#5c5f61]">Sen</span>
                    </div>
                    <div class="flex flex-col items-center gap-2 w-full group">
                        <div class="w-8 bg-[#495362]/20 rounded-t-lg relative flex flex-col justify-end h-[75%] border border-[#eaeef2]">
                            <div class="w-full bg-[#005f2d] rounded-t-lg h-[40%]" style="transition: opacity 0.2s"></div>
                        </div>
                        <span class="text-[10px] font-bold text-[#5c5f61]">Sel</span>
                    </div>
                    <div class="flex flex-col items-center gap-2 w-full group">
                        <div class="w-8 bg-[#495362]/20 rounded-t-lg relative flex flex-col justify-end h-[85%] border border-[#eaeef2]">
                            <div class="w-full bg-[#005f2d] rounded-t-lg h-[80%]" style="transition: opacity 0.2s"></div>
                        </div>
                        <span class="text-[10px] font-bold text-[#5c5f61]">Rab</span>
                    </div>
                    <div class="flex flex-col items-center gap-2 w-full group">
                        <div class="w-8 bg-[#495362]/20 rounded-t-lg relative flex flex-col justify-end h-[65%] border border-[#eaeef2]">
                            <div class="w-full bg-[#005f2d] rounded-t-lg h-[50%]" style="transition: opacity 0.2s"></div>
                        </div>
                        <span class="text-[10px] font-bold text-[#5c5f61]">Kam</span>
                    </div>
                    <div class="flex flex-col items-center gap-2 w-full group">
                        <div class="w-8 bg-[#495362]/20 rounded-t-lg relative flex flex-col justify-end h-[90%] border border-[#eaeef2]">
                            <div class="w-full bg-[#005f2d] rounded-t-lg h-[85%]" style="transition: opacity 0.2s"></div>
                        </div>
                        <span class="text-[10px] font-bold text-[#5c5f61]">Jum</span>
                    </div>
                </div>
            </div>

            {{-- Recent Activity Log (Col-span 4) --}}
            <div class="lg:col-span-4 bg-white p-6 rounded-2xl shadow-soft border border-[#eaeef2] h-full flex flex-col justify-between">
                <div>
                    <h3 class="font-bold text-sm text-[#171c1f] mb-6">Log Aktivitas Terbaru</h3>
                    <div class="relative space-y-6 before:absolute before:left-[11px] before:top-2 before:bottom-2 before:w-[2px] before:bg-[#eaeef2]">
                        @if($latestPresensi)
                            <div class="relative flex gap-4 items-start">
                                <div class="w-6 h-6 rounded-full bg-[#97f7ac] flex items-center justify-center z-10 shadow-soft border-2 border-white text-[#005226]">
                                    <span class="material-symbols-outlined text-[12px]">check_circle</span>
                                </div>
                                <div>
                                    <h5 class="text-xs font-bold text-[#171c1f] leading-tight">Presensi Berhasil Terverifikasi</h5>
                                    <p class="text-[9px] text-[#5c5f61] mt-0.5">{{ $latestPresensi->waktu_absen->diffForHumans() }} • Sesi {{ $latestPresensi->sesiPresensi->mata_pelajaran }} {{ $latestPresensi->sesiPresensi->kelas->nama_kelas }}</p>
                                </div>
                            </div>
                        @endif
                        <div class="relative flex gap-4 items-start">
                            <div class="w-6 h-6 rounded-full bg-[#97f7ac] flex items-center justify-center z-10 shadow-soft border-2 border-white text-[#005226]">
                                <span class="material-symbols-outlined text-[12px]">download</span>
                            </div>
                            <div>
                                <h5 class="text-xs font-bold text-[#171c1f] leading-tight">Mengunduh Materi</h5>
                                <p class="text-[9px] text-[#5c5f61] mt-0.5">2 jam yang lalu • Modul Pembelajaran</p>
                            </div>
                        </div>
                        <div class="relative flex gap-4 items-start">
                            <div class="w-6 h-6 rounded-full bg-[#97f7ac] flex items-center justify-center z-10 shadow-soft border-2 border-white text-[#005226]">
                                <span class="material-symbols-outlined text-[12px]">login</span>
                            </div>
                            <div>
                                <h5 class="text-xs font-bold text-[#171c1f] leading-tight">Login Portal</h5>
                                <p class="text-[9px] text-[#5c5f61] mt-0.5">Hari ini, 08:15 AM</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
