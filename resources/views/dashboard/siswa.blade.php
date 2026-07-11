<x-app-layout>
    <x-slot name="header">Dashboard Siswa</x-slot>

    <div class="p-4 md:p-8 max-w-7xl mx-auto space-y-6">
        {{-- Header Welcome --}}
        <header class="mb-8">
            <h2 class="text-2xl font-bold text-[#171c1f] mb-1">Selamat Datang, {{ Auth::user()->name }} 👋</h2>
            <p class="text-sm text-[#5c5f61]">Semangat belajar! Pantau tugas, presensi, dan materi pelajaranmu.</p>
        </header>

        {{-- Top Grid Section --}}
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-stretch">
            {{-- Student Profile Card --}}
            <div class="lg:col-span-4 bg-white rounded-2xl p-6 shadow-soft border border-[#eaeef2] flex flex-col items-center text-center justify-between">
                <div class="flex flex-col items-center w-full">
                    <div class="w-24 h-24 rounded-full border-4 border-[#97f7ac] mb-4 overflow-hidden bg-gray-100 flex items-center justify-center">
                        <div class="w-full h-full bg-[#0e7a3d]/10 text-[#005f2d] flex items-center justify-center text-3xl font-bold">
                            {{ substr(Auth::user()->name, 0, 1) }}
                        </div>
                    </div>
                    <h3 class="text-lg font-bold text-[#171c1f]">{{ Auth::user()->name }}</h3>
                    <p class="text-xs text-[#5c5f61] mb-6">Siswa • NIS: {{ Auth::user()->nis ?? '-' }}</p>
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

            {{-- Stats & Chart --}}
            <div class="lg:col-span-8 flex flex-col gap-6">
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                    <div class="bg-[#0e7a3d] text-[#a5ffb7] rounded-2xl p-6 shadow-soft flex flex-col justify-center items-center text-center">
                        <span class="text-[10px] uppercase font-bold tracking-widest text-[#a5ffb7]/80 mb-1">Presensi</span>
                        <div class="text-3xl font-bold text-white">{{ $tingkatKehadiran }}%</div>
                    </div>
                    <div class="bg-white rounded-2xl p-6 shadow-soft border-t-4 border-[#495362] border-l border-r border-b border-[#eaeef2] flex flex-col justify-center items-center text-center">
                        <span class="text-[10px] uppercase font-bold tracking-widest text-[#5c5f61] mb-1">Tugas Aktif</span>
                        <div class="text-3xl font-bold text-[#171c1f]">{{ $tugasAktifCount }}</div>
                    </div>
                    <div class="bg-white rounded-2xl p-6 shadow-soft border-t-4 border-[#005f2d] border-l border-r border-b border-[#eaeef2] flex flex-col justify-center items-center text-center">
                        <span class="text-[10px] uppercase font-bold tracking-widest text-[#5c5f61] mb-1">Materi Tersedia</span>
                        <div class="text-3xl font-bold text-[#005f2d]">{{ $materiTersediaCount }}</div>
                    </div>
                </div>

                {{-- Chart --}}
                <div class="bg-white rounded-2xl p-6 shadow-soft border border-[#eaeef2] flex-1 flex flex-col justify-between">
                    <div class="flex justify-between items-center mb-6">
                        <h4 class="font-bold text-[#171c1f]">Aktivitas Kehadiran Bulanan</h4>
                        <span class="text-[10px] text-[#005f2d] font-bold bg-[#f0fdf4] px-2 py-0.5 rounded-lg border border-[#0e7a3d]/20">Semester Ini</span>
                    </div>
                    <div class="h-32 w-full flex items-end justify-between px-4 gap-4">
                        <div class="flex-1 bg-[#005f2d]/20 rounded-t-lg h-[92%] relative group cursor-pointer hover:bg-[#005f2d]/40 transition-all">
                            <div class="absolute -top-7 left-1/2 -translate-x-1/2 bg-[#171c1f] text-white text-[9px] px-1.5 py-0.5 rounded opacity-0 group-hover:opacity-100 transition-opacity z-10">92%</div>
                        </div>
                        <div class="flex-1 bg-[#005f2d]/20 rounded-t-lg h-[88%] relative group cursor-pointer hover:bg-[#005f2d]/40 transition-all">
                            <div class="absolute -top-7 left-1/2 -translate-x-1/2 bg-[#171c1f] text-white text-[9px] px-1.5 py-0.5 rounded opacity-0 group-hover:opacity-100 transition-opacity z-10">88%</div>
                        </div>
                        <div class="flex-1 bg-[#005f2d] rounded-t-lg h-[98%] relative group cursor-pointer hover:bg-[#005f2d]/90 transition-all">
                            <div class="absolute -top-7 left-1/2 -translate-x-1/2 bg-[#171c1f] text-white text-[9px] px-1.5 py-0.5 rounded opacity-0 group-hover:opacity-100 transition-opacity z-10">98%</div>
                        </div>
                        <div class="flex-1 bg-[#005f2d]/20 rounded-t-lg h-[95%] relative group cursor-pointer hover:bg-[#005f2d]/40 transition-all">
                            <div class="absolute -top-7 left-1/2 -translate-x-1/2 bg-[#171c1f] text-white text-[9px] px-1.5 py-0.5 rounded opacity-0 group-hover:opacity-100 transition-opacity z-10">95%</div>
                        </div>
                        <div class="flex-1 bg-[#005f2d]/20 rounded-t-lg h-[92%] relative group cursor-pointer hover:bg-[#005f2d]/40 transition-all">
                            <div class="absolute -top-7 left-1/2 -translate-x-1/2 bg-[#171c1f] text-white text-[9px] px-1.5 py-0.5 rounded opacity-0 group-hover:opacity-100 transition-opacity z-10">92%</div>
                        </div>
                    </div>
                    <div class="flex justify-between mt-2 text-[10px] text-[#5c5f61] font-bold px-4 uppercase">
                        <span>Jul</span><span>Agu</span><span>Sep</span><span>Okt</span><span>Nov</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Content Grid --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            {{-- Tugas Mendatang --}}
            <div class="bg-white rounded-2xl shadow-soft p-6 border border-[#eaeef2]">
                <div class="flex justify-between items-center mb-5">
                    <h4 class="font-bold text-[#171c1f]">Tugas Mendatang</h4>
                    <a href="{{ route('tugas.index') }}" class="text-xs font-semibold text-[#005f2d] hover:underline">Lihat Semua</a>
                </div>
                <ul class="space-y-4">
                    @forelse($tugasMendatang as $item)
                        <li class="flex items-center justify-between py-2 border-b border-[#f0f4f8] last:border-0">
                            <div>
                                <p class="text-sm font-bold text-[#171c1f]">{{ $item->judul }}</p>
                                <p class="text-[11px] text-[#5c5f61] mt-0.5">Deadline: {{ \Carbon\Carbon::parse($item->deadline)->translatedFormat('d M Y H:i') }}</p>
                            </div>
                            @php
                                $diffInDays = now()->diffInDays(\Carbon\Carbon::parse($item->deadline), false);
                            @endphp
                            @if($diffInDays <= 1)
                                <span class="px-2.5 py-1 text-[9px] font-bold bg-red-100 text-red-700 rounded-full uppercase tracking-wider">Mendesak</span>
                            @elseif($diffInDays <= 3)
                                <span class="px-2.5 py-1 text-[9px] font-bold bg-amber-100 text-amber-700 rounded-full uppercase tracking-wider">Segera</span>
                            @else
                                <span class="px-2.5 py-1 text-[9px] font-bold bg-[#f0fdf4] text-[#005f2d] rounded-full uppercase tracking-wider">{{ $diffInDays }} Hari</span>
                            @endif
                        </li>
                    @empty
                        <li class="py-12 text-center text-xs text-[#5c5f61]">
                            Tidak ada tugas mendatang. Bebas tugas! 🎉
                        </li>
                    @endforelse
                </ul>
            </div>

            {{-- Scan Presensi --}}
            <div class="bg-white rounded-2xl shadow-soft p-6 border border-[#eaeef2] flex flex-col items-center text-center justify-between min-h-[220px] hover:border-[#0e7a3d]/30 transition-all duration-300">
                <div class="w-16 h-16 bg-[#f0fdf4] rounded-full flex items-center justify-center mb-4">
                    <span class="material-symbols-outlined text-[#0e7a3d] filled-icon text-3xl">qr_code_scanner</span>
                </div>
                <div class="mb-4">
                    <h4 class="font-bold text-[#171c1f] mb-1">Scan Presensi</h4>
                    <p class="text-xs text-[#5c5f61] px-2">Scan QR Code yang diberikan guru untuk mencatat kehadiranmu.</p>
                </div>
                <a href="{{ route('presensi.scan') }}"
                   class="w-full bg-[#005f2d] text-white py-2.5 rounded-xl text-sm font-semibold hover:bg-[#0e7a3d] transition-colors text-center shadow-soft">
                    Buka Scanner
                </a>
            </div>

            {{-- Materi AI --}}
            <div class="bg-white rounded-2xl shadow-soft p-6 border border-[#eaeef2] flex flex-col justify-between min-h-[220px] hover:border-[#0e7a3d]/30 transition-all duration-300">
                <div>
                    <div class="w-12 h-12 bg-[#f0fdf4] rounded-xl flex items-center justify-center mb-4 text-[#0e7a3d]">
                        <span class="material-symbols-outlined text-[28px]">auto_awesome</span>
                    </div>
                    <h4 class="font-bold text-[#171c1f] mb-1">Ringkasan Materi AI</h4>
                    <p class="text-xs text-[#5c5f61]">Akses materi pelajaran beserta ringkasan otomatis dari AI Claude.</p>
                </div>
                <a href="{{ route('materi.index') }}"
                   class="inline-flex items-center gap-1 text-xs font-bold text-[#005f2d] hover:text-[#0e7a3d] transition-colors mt-4 self-start">
                    Lihat Materi <span class="material-symbols-outlined text-[16px]">arrow_forward</span>
                </a>
            </div>
        </div>

        {{-- AI Info --}}
        <div class="bg-[#f0fdf4] border border-[#0e7a3d]/20 rounded-2xl p-5 flex items-center gap-4 relative overflow-hidden">
            <div class="absolute right-0 top-0 p-4 opacity-5 pointer-events-none">
                <span class="material-symbols-outlined text-[60px] text-[#005f2d]">auto_awesome</span>
            </div>
            <span class="material-symbols-outlined text-[#0e7a3d] filled-icon text-2xl shrink-0">auto_awesome</span>
            <p class="text-xs text-[#3f493f] relative z-10 leading-relaxed">
                <span class="font-bold text-[#005f2d]">Tips Belajar AI:</span>
                Konsistensi adalah kunci. Usahakan hadir setiap hari dan kumpulkan tugas tepat waktu untuk hasil belajar terbaik!
            </p>
        </div>
    </div>
</x-app-layout>
