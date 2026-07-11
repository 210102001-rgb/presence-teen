<x-app-layout>
    <x-slot name="header">Dashboard Orang Tua</x-slot>

    <div class="p-4 md:p-8 max-w-7xl mx-auto space-y-6">
        {{-- Header Welcome --}}
        <header class="mb-8">
            <h2 class="text-2xl font-bold text-[#171c1f] mb-1">Selamat Datang, {{ Auth::user()->name }} 👋</h2>
            <p class="text-sm text-[#5c5f61]">Pantau perkembangan belajar dan kehadiran putra/putri Anda secara real-time.</p>
        </header>

        {{-- Top Grid Section --}}
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-stretch">
            {{-- Student Profile Card --}}
            <div class="lg:col-span-4 bg-white rounded-2xl p-6 shadow-soft border border-[#eaeef2] flex flex-col items-center text-center justify-between">
                <div class="flex flex-col items-center w-full">
                    <div class="w-24 h-24 rounded-full border-4 border-[#97f7ac] mb-4 overflow-hidden bg-gray-100 flex items-center justify-center">
                        <div class="w-full h-full bg-[#0e7a3d]/10 text-[#005f2d] flex items-center justify-center text-3xl font-bold">
                            {{ $anak ? substr($anak->name, 0, 1) : 'A' }}
                        </div>
                    </div>
                    <h3 class="text-lg font-bold text-[#171c1f]">{{ $anak->name ?? 'Ahmad Rizky Pratama' }}</h3>
                    <p class="text-xs text-[#5c5f61] mb-6">Kelas {{ $kelasNama }} • NISN: {{ $anak->nis ?? '00923841' }}</p>
                </div>
                <div class="w-full flex justify-between px-4 py-3 bg-[#f6fafe] rounded-xl border border-[#eaeef2] mt-auto">
                    <div class="flex flex-col items-center flex-1">
                        <span class="text-[9px] text-[#5c5f61] font-bold uppercase tracking-wider">Peringkat</span>
                        <span class="text-[#005f2d] font-bold text-sm mt-1">#4 / 32</span>
                    </div>
                    <div class="w-px bg-[#becabc] h-8 my-auto"></div>
                    <div class="flex flex-col items-center flex-1">
                        <span class="text-[9px] text-[#5c5f61] font-bold uppercase tracking-wider">IPK</span>
                        <span class="text-[#005f2d] font-bold text-sm mt-1">3.82</span>
                    </div>
                </div>
            </div>

            {{-- Attendance Summary --}}
            <div class="lg:col-span-8 flex flex-col gap-6">
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <div class="bg-[#0e7a3d] text-[#a5ffb7] rounded-2xl p-6 shadow-soft flex flex-col justify-center items-center text-center">
                        <span class="text-[10px] uppercase font-bold tracking-widest opacity-80 mb-1">Hadir</span>
                        <div class="text-3xl font-bold text-white">{{ $presentPercent }}%</div>
                    </div>
                    <div class="bg-white rounded-2xl p-6 shadow-soft border-t-4 border-[#495362] border-l border-r border-b border-[#eaeef2] flex flex-col justify-center items-center text-center">
                        <span class="text-[10px] uppercase font-bold tracking-widest text-[#5c5f61] mb-1">Izin</span>
                        <div class="text-3xl font-bold text-[#171c1f]">{{ $totalTelat }}</div>
                    </div>
                    <div class="bg-white rounded-2xl p-6 shadow-soft border-t-4 border-amber-400 border-l border-r border-b border-[#eaeef2] flex flex-col justify-center items-center text-center">
                        <span class="text-[10px] uppercase font-bold tracking-widest text-[#5c5f61] mb-1">Sakit</span>
                        <div class="text-3xl font-bold text-[#171c1f]">1</div>
                    </div>
                    <div class="bg-white rounded-2xl p-6 shadow-soft border-t-4 border-[#ba1a1a] border-l border-r border-b border-[#eaeef2] flex flex-col justify-center items-center text-center">
                        <span class="text-[10px] uppercase font-bold tracking-widest text-[#5c5f61] mb-1">Alpha</span>
                        <div class="text-3xl font-bold text-[#ba1a1a]">{{ $totalAlpha }}</div>
                    </div>
                </div>

                {{-- Attendance Trend Chart Placeholder --}}
                <div class="bg-white rounded-2xl p-6 shadow-soft border border-[#eaeef2] flex-1 flex flex-col justify-between">
                    <div class="flex justify-between items-center mb-4">
                        <h4 class="font-bold text-[#171c1f]">Tren Kehadiran Bulanan</h4>
                        <select class="bg-[#f6fafe] border-none text-[10px] font-bold rounded-lg px-3 py-1 focus:ring-[#005f2d]">
                            <option>Semester Ganjil</option>
                            <option>Semester Genap</option>
                        </select>
                    </div>
                    <div class="h-32 w-full flex items-end justify-between px-4 gap-4">
                        <div class="flex-1 bg-[#005f2d]/20 rounded-t-lg h-[80%] relative group cursor-pointer hover:bg-[#005f2d]/40 transition-all">
                            <div class="absolute -top-7 left-1/2 -translate-x-1/2 bg-[#171c1f] text-white text-[9px] px-1.5 py-0.5 rounded opacity-0 group-hover:opacity-100 transition-opacity z-10">92%</div>
                        </div>
                        <div class="flex-1 bg-[#005f2d]/20 rounded-t-lg h-[85%] relative group cursor-pointer hover:bg-[#005f2d]/40 transition-all">
                            <div class="absolute -top-7 left-1/2 -translate-x-1/2 bg-[#171c1f] text-white text-[9px] px-1.5 py-0.5 rounded opacity-0 group-hover:opacity-100 transition-opacity z-10">94%</div>
                        </div>
                        <div class="flex-1 bg-[#005f2d] rounded-t-lg h-[95%] relative group cursor-pointer hover:bg-[#005f2d]/90 transition-all">
                            <div class="absolute -top-7 left-1/2 -translate-x-1/2 bg-[#171c1f] text-white text-[9px] px-1.5 py-0.5 rounded opacity-0 group-hover:opacity-100 transition-opacity z-10">98%</div>
                        </div>
                        <div class="flex-1 bg-[#005f2d]/20 rounded-t-lg h-[92%] relative group cursor-pointer hover:bg-[#005f2d]/40 transition-all">
                            <div class="absolute -top-7 left-1/2 -translate-x-1/2 bg-[#171c1f] text-white text-[9px] px-1.5 py-0.5 rounded opacity-0 group-hover:opacity-100 transition-opacity z-10">95%</div>
                        </div>
                        <div class="flex-1 bg-[#005f2d]/20 rounded-t-lg h-[90%] relative group cursor-pointer hover:bg-[#005f2d]/40 transition-all">
                            <div class="absolute -top-7 left-1/2 -translate-x-1/2 bg-[#171c1f] text-white text-[9px] px-1.5 py-0.5 rounded opacity-0 group-hover:opacity-100 transition-opacity z-10">93%</div>
                        </div>
                    </div>
                    <div class="flex justify-between mt-2 text-[10px] text-[#5c5f61] font-bold px-4 uppercase">
                        <span>Jul</span><span>Agu</span><span>Sep</span><span>Okt</span><span>Nov</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Middle Section: Activities & AI Prediction --}}
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
            {{-- Learning Activities --}}
            <div class="lg:col-span-8 bg-white rounded-2xl p-6 shadow-soft border border-[#eaeef2] flex flex-col justify-between">
                <div class="flex justify-between items-center mb-6">
                    <h4 class="font-bold text-[#171c1f]">Aktivitas Belajar (Minggu Ini)</h4>
                    <span class="text-[#005f2d] text-xs font-semibold flex items-center gap-1 cursor-pointer hover:underline">
                        Detail Aktivitas <span class="material-symbols-outlined text-[16px]">open_in_new</span>
                    </span>
                </div>
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4 mb-6">
                    <div class="flex flex-col items-center p-3 bg-[#f6fafe] rounded-xl border border-[#eaeef2]">
                        <span class="material-symbols-outlined text-[#005f2d] mb-1">login</span>
                        <span class="text-lg font-bold">14</span>
                        <span class="text-[9px] text-[#5c5f61] font-bold uppercase">Login</span>
                    </div>
                    <div class="flex flex-col items-center p-3 bg-[#f6fafe] rounded-xl border border-[#eaeef2]">
                        <span class="material-symbols-outlined text-[#005f2d] mb-1">visibility</span>
                        <span class="text-lg font-bold">42</span>
                        <span class="text-[9px] text-[#5c5f61] font-bold uppercase">Akses</span>
                    </div>
                    <div class="flex flex-col items-center p-3 bg-[#f6fafe] rounded-xl border border-[#eaeef2]">
                        <span class="material-symbols-outlined text-[#005f2d] mb-1">download</span>
                        <span class="text-lg font-bold">8</span>
                        <span class="text-[9px] text-[#5c5f61] font-bold uppercase">Unduh</span>
                    </div>
                    <div class="flex flex-col items-center p-3 bg-[#f6fafe] rounded-xl border border-[#eaeef2]">
                        <span class="material-symbols-outlined text-[#005f2d] mb-1">forum</span>
                        <span class="text-lg font-bold">12</span>
                        <span class="text-[9px] text-[#5c5f61] font-bold uppercase">Diskusi</span>
                    </div>
                    <div class="flex flex-col items-center p-3 bg-[#f6fafe] rounded-xl border border-[#eaeef2]">
                        <span class="material-symbols-outlined text-[#005f2d] mb-1">task</span>
                        <span class="text-lg font-bold">5</span>
                        <span class="text-[9px] text-[#5c5f61] font-bold uppercase">Tugas</span>
                    </div>
                    <div class="flex flex-col items-center p-3 bg-[#97f7ac] rounded-xl">
                        <span class="material-symbols-outlined text-[#005f2d] mb-1">schedule</span>
                        <span class="text-lg font-bold text-[#005f2d]">2.4h</span>
                        <span class="text-[9px] text-[#005226] font-bold uppercase">Avg Time</span>
                    </div>
                </div>

                {{-- Activity Chart --}}
                <div class="space-y-4 pt-4 border-t border-[#eaeef2]">
                    <div class="w-full flex flex-col gap-1">
                        <div class="flex justify-between text-xs font-bold text-[#5c5f61]"><span>Senin</span><span>90%</span></div>
                        <div class="w-full h-2.5 bg-[#f6fafe] rounded-full overflow-hidden border border-[#eaeef2]">
                            <div class="h-full bg-[#005f2d] rounded-full" style="width: 90%;"></div>
                        </div>
                    </div>
                    <div class="w-full flex flex-col gap-1">
                        <div class="flex justify-between text-xs font-bold text-[#5c5f61]"><span>Selasa</span><span>75%</span></div>
                        <div class="w-full h-2.5 bg-[#f6fafe] rounded-full overflow-hidden border border-[#eaeef2]">
                            <div class="h-full bg-[#005f2d] rounded-full" style="width: 75%;"></div>
                        </div>
                    </div>
                    <div class="w-full flex flex-col gap-1">
                        <div class="flex justify-between text-xs font-bold text-[#5c5f61]"><span>Rabu</span><span>95%</span></div>
                        <div class="w-full h-2.5 bg-[#f6fafe] rounded-full overflow-hidden border border-[#eaeef2]">
                            <div class="h-full bg-[#005f2d] rounded-full" style="width: 95%;"></div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- AI Motivation & Predict --}}
            <div class="lg:col-span-4 flex flex-col gap-6">
                {{-- AI Insights --}}
                <div class="bg-[#f0fdf4] border border-[#0e7a3d]/20 rounded-2xl p-6 shadow-soft relative overflow-hidden flex-1 flex flex-col justify-between min-h-[220px]">
                    <div class="absolute right-0 top-0 p-4 opacity-5 pointer-events-none">
                        <span class="material-symbols-outlined text-[80px] text-[#0e7a3d]">auto_awesome</span>
                    </div>
                    <div class="relative z-10 space-y-4">
                        <div class="flex items-center gap-2">
                            <span class="material-symbols-outlined text-[#005f2d] filled-icon text-xl">auto_awesome</span>
                            <h4 class="font-bold text-[#171c1f] text-sm">AI Insights & Motivation</h4>
                        </div>
                        <div>
                            <span class="px-2.5 py-0.5 bg-[#005f2d] text-white rounded-full text-[9px] font-bold uppercase mb-2 inline-block">Sangat Aktif</span>
                            <p class="text-xs text-[#171c1f] leading-relaxed">
                                "{{ $laporanTerbaru->hasil_analisis ?? 'Ahmad menunjukkan konsistensi yang luar biasa minggu ini di mata pelajaran Matematika. Ketekunan adalah kunci keberhasilan.' }}"
                            </p>
                        </div>
                    </div>
                    <div class="bg-white/60 p-3 rounded-xl border border-dashed border-[#0e7a3d]/30 italic text-xs text-[#5c5f61] mt-4">
                        "Pendidikan adalah senjata paling ampuh untuk mengubah dunia." — Nelson Mandela
                    </div>
                </div>

                {{-- Prediction Summary --}}
                <div class="bg-white rounded-2xl p-6 shadow-soft border-l-4 border-[#005f2d] border-t border-r border-b border-[#eaeef2] flex flex-col justify-between">
                    <div class="flex justify-between items-center mb-2">
                        <h4 class="font-bold text-[#171c1f] text-xs">Prediksi Absensi Semester</h4>
                        <span class="text-[#005f2d] text-[9px] font-bold uppercase tracking-wider">High Probability</span>
                    </div>
                    <div class="flex items-baseline gap-1">
                        <span class="text-2xl font-bold text-[#171c1f]">97.8%</span>
                        <span class="text-[9px] text-[#0e7a3d] font-bold">+1.2% dari target</span>
                    </div>
                    <p class="text-[9px] text-[#5c5f61] mt-2">Berdasarkan pola historis 3 bulan terakhir.</p>
                </div>
            </div>
        </div>

        {{-- Bottom Section: Announcements --}}
        <section class="mt-6">
            <div class="bg-white rounded-2xl p-6 shadow-soft border border-[#eaeef2]">
                <div class="flex justify-between items-center mb-6">
                    <h4 class="font-bold text-lg text-[#171c1f]">Pengumuman Terbaru</h4>
                    <button class="bg-[#005f2d] hover:bg-[#0e7a3d] text-white px-4 py-2 rounded-xl text-xs font-bold transition-all active:scale-95 shadow-soft">Lihat Semua</button>
                </div>
                <div class="divide-y divide-[#eaeef2]">
                    <div class="flex gap-4 py-4 hover:bg-[#f6fafe] transition-all rounded-xl px-2 cursor-pointer group">
                        <div class="w-12 h-12 rounded-xl bg-[#f6fafe] flex flex-col items-center justify-center shrink-0 border border-[#eaeef2]">
                            <span class="text-[9px] font-bold text-[#5c5f61] uppercase">Nov</span>
                            <span class="text-lg font-bold text-[#005f2d] -mt-1">24</span>
                        </div>
                        <div class="flex flex-col">
                            <h5 class="font-bold text-sm text-[#171c1f] group-hover:text-[#005f2d] transition-colors">Jadwal Ujian Akhir Semester Ganjil 2026</h5>
                            <p class="text-xs text-[#5c5f61] mt-1 line-clamp-1">Berikut kami sampaikan jadwal lengkap pelaksanaan UAS yang akan dimulai pada...</p>
                        </div>
                        <span class="material-symbols-outlined ml-auto text-[#becabc] group-hover:translate-x-1 transition-transform">chevron_right</span>
                    </div>
                    <div class="flex gap-4 py-4 hover:bg-[#f6fafe] transition-all rounded-xl px-2 cursor-pointer group">
                        <div class="w-12 h-12 rounded-xl bg-[#f6fafe] flex flex-col items-center justify-center shrink-0 border border-[#eaeef2]">
                            <span class="text-[9px] font-bold text-[#5c5f61] uppercase">Nov</span>
                            <span class="text-lg font-bold text-[#005f2d] -mt-1">22</span>
                        </div>
                        <div class="flex flex-col">
                            <h5 class="font-bold text-sm text-[#171c1f] group-hover:text-[#005f2d] transition-colors">Undangan Parenting Seminar: Psikologi Remaja</h5>
                            <p class="text-xs text-[#5c5f61] mt-1 line-clamp-1">Menghadirkan narasumber ahli untuk membahas tantangan mendidik anak di era digital...</p>
                        </div>
                        <span class="material-symbols-outlined ml-auto text-[#becabc] group-hover:translate-x-1 transition-transform">chevron_right</span>
                    </div>
                    <div class="flex gap-4 py-4 hover:bg-[#f6fafe] transition-all rounded-xl px-2 cursor-pointer group">
                        <div class="w-12 h-12 rounded-xl bg-[#f6fafe] flex flex-col items-center justify-center shrink-0 border border-[#eaeef2]">
                            <span class="text-[9px] font-bold text-[#5c5f61] uppercase">Nov</span>
                            <span class="text-lg font-bold text-[#005f2d] -mt-1">18</span>
                        </div>
                        <div class="flex flex-col">
                            <h5 class="font-bold text-sm text-[#171c1f] group-hover:text-[#005f2d] transition-colors">Informasi Libur Nasional & Cuti Bersama</h5>
                            <p class="text-xs text-[#5c5f61] mt-1 line-clamp-1">Sehubungan dengan peringatan hari besar, kegiatan belajar mengajar akan diliburkan...</p>
                        </div>
                        <span class="material-symbols-outlined ml-auto text-[#becabc] group-hover:translate-x-1 transition-transform">chevron_right</span>
                    </div>
                </div>
            </div>
        </section>
    </div>
</x-app-layout>
