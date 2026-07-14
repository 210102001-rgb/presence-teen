<x-app-layout>
    <x-slot name="header">Dashboard Siswa</x-slot>

    <div class="p-4 md:p-8">
        {{-- Welcome --}}
        <div class="mb-8">
            <h2 class="text-2xl font-bold text-[#171c1f]">Selamat Datang, {{ Auth::user()->name }} 👋</h2>
            <p class="text-sm text-[#3f493f] mt-1">Semangat belajar! Pantau tugas, presensi, dan materi pelajaranmu.</p>
        </div>

        {{-- Stats --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-5 mb-8">
            <div class="animate-fade-in animate-delay-1 bg-[#0e7a3d] text-white rounded-xl p-5 shadow-soft">
                <div class="flex justify-between items-start mb-3">
                    <p class="text-[11px] uppercase tracking-widest text-white/70 font-semibold">Kehadiran Bulan Ini</p>
                    <div class="w-9 h-9 bg-white/15 rounded-xl flex items-center justify-center">
                        <span class="material-symbols-outlined text-white text-[20px] filled-icon">calendar_month</span>
                    </div>
                </div>
                <p class="text-4xl font-bold">{{ $kehadiranBulanIni }}</p>
                <p class="text-xs text-white/60 mt-1">Kali hadir bulan ini</p>
            </div>

            <div class="animate-fade-in animate-delay-2 bg-white rounded-xl p-5 shadow-soft border-t-4 border-[#495362]">
                <div class="flex justify-between items-start mb-3">
                    <p class="text-[11px] uppercase tracking-widest text-[#5c5f61] font-semibold">Total Tugas</p>
                    <div class="w-9 h-9 bg-[#eaeef2] rounded-xl flex items-center justify-center">
                        <span class="material-symbols-outlined text-[#495362] text-[20px]">assignment</span>
                    </div>
                </div>
                <p class="text-4xl font-bold text-[#171c1f]">{{ $totalTugas }}</p>
                <p class="text-xs text-[#5c5f61] mt-1">{{ $tugasSelesai }} selesai bulan ini</p>
            </div>

            <div class="animate-fade-in animate-delay-3 bg-white rounded-xl p-5 shadow-soft border-t-4 border-[#005f2d]">
                <div class="flex justify-between items-start mb-3">
                    <p class="text-[11px] uppercase tracking-widest text-[#5c5f61] font-semibold">Materi Tersedia</p>
                    <div class="w-9 h-9 bg-[#f0fdf4] rounded-xl flex items-center justify-center">
                        <span class="material-symbols-outlined text-[#005f2d] text-[20px]">menu_book</span>
                    </div>
                </div>
                <p class="text-4xl font-bold text-[#171c1f]">{{ $totalMateri }}</p>
                <p class="text-xs text-[#5c5f61] mt-1">Siap dipelajari</p>
            </div>
        </div>

        {{-- Content --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            {{-- Tugas Belum Dikumpul --}}
            <div class="lg:col-span-2 bg-white rounded-xl shadow-soft border border-[#eaeef2]">
                <div class="px-6 py-4 border-b border-[#eaeef2] flex justify-between items-center">
                    <h4 class="font-semibold text-[#171c1f]">Tugas Perlu Dikumpul</h4>
                    <a href="{{ route('tugas.index') }}" class="text-xs font-semibold text-[#005f2d] hover:underline">Lihat Semua</a>
                </div>
                @if($tugasBelum->isEmpty())
                    <div class="p-12 text-center">
                        <span class="material-symbols-outlined text-[#0e7a3d] filled-icon text-5xl">check_circle</span>
                        <p class="text-sm font-medium text-[#171c1f] mt-3">Semua tugas sudah dikumpulkan!</p>
                        <p class="text-xs text-[#5c5f61] mt-1">Tidak ada tugas yang pending.</p>
                    </div>
                @else
                    <div class="divide-y divide-[#f0f4f8]">
                        @foreach($tugasBelum as $t)
                            @php $isClose = $t->deadline->diffInDays(now()) <= 2; @endphp
                            <div class="flex items-center justify-between px-6 py-3.5 hover:bg-[#f6fafe] transition-colors group">
                                <div class="flex items-center gap-3 min-w-0">
                                    <div class="w-9 h-9 rounded-xl flex items-center justify-center shrink-0
                                         {{ $isClose ? 'bg-[#ffdad6]' : 'bg-[#f0fdf4]' }}">
                                        <span class="material-symbols-outlined text-[18px]
                                             {{ $isClose ? 'text-[#ba1a1a]' : 'text-[#0e7a3d]' }}">assignment</span>
                                    </div>
                                    <div class="min-w-0">
                                        <p class="text-sm font-semibold text-[#171c1f] truncate">{{ $t->judul }}</p>
                                        <div class="flex items-center gap-1.5 mt-0.5">
                                            <span class="text-xs text-[#5c5f61]">{{ $t->kelas->nama_kelas ?? '-' }}</span>
                                            <span class="text-[#dfe3e7]">·</span>
                                            <span class="text-xs {{ $isClose ? 'text-[#ba1a1a] font-semibold' : 'text-[#5c5f61]' }}">
                                                Deadline {{ $t->deadline->format('d M Y') }}
                                            </span>
                                            @if($isClose)
                                                <span class="px-1.5 py-0.5 bg-[#ffdad6] text-[#93000a] text-[9px] font-bold rounded-full uppercase">Segera</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <a href="{{ route('tugas.show', $t) }}"
                                    class="shrink-0 ml-3 inline-flex items-center gap-1 px-3 py-1.5 bg-[#005f2d] text-white text-xs font-semibold rounded-lg hover:bg-[#0e7a3d] transition-colors lg:opacity-0 lg:group-hover:opacity-100">
                                    Kumpul
                                </a>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            {{-- Quick Actions --}}
            <div class="flex flex-col gap-4">
                {{-- Scan Presensi --}}
                <div class="bg-white rounded-xl shadow-soft p-5 border border-[#eaeef2] flex flex-col items-center text-center">
                    <div class="w-14 h-14 bg-[#f0fdf4] rounded-full flex items-center justify-center mb-3">
                        <span class="material-symbols-outlined text-[#0e7a3d] filled-icon text-3xl">qr_code_scanner</span>
                    </div>
                    <h4 class="font-semibold text-[#171c1f] mb-1">Scan Presensi</h4>
                    <p class="text-xs text-[#5c5f61] mb-4">Scan QR Code guru untuk catat kehadiran.</p>
                    <a href="{{ route('presensi.scan') }}"
                       class="w-full py-2.5 bg-[#005f2d] text-white text-sm font-semibold rounded-xl hover:bg-[#0e7a3d] transition-colors text-center block">
                        Buka Scanner
                    </a>
                </div>

                {{-- Materi AI --}}
                <div class="bg-white rounded-xl shadow-soft p-5 border border-[#eaeef2]">
                    <div class="w-10 h-10 bg-[#f0fdf4] rounded-xl flex items-center justify-center mb-3">
                        <span class="material-symbols-outlined text-[#0e7a3d] filled-icon">auto_awesome</span>
                    </div>
                    <h4 class="font-semibold text-[#171c1f] mb-1">Materi & Ringkasan AI</h4>
                    <p class="text-xs text-[#5c5f61] mb-3">Akses materi + ringkasan otomatis Claude AI.</p>
                    <a href="{{ route('materi.index') }}"
                       class="inline-flex items-center gap-1 text-sm font-semibold text-[#005f2d] hover:text-[#0e7a3d]">
                        Lihat Materi <span class="material-symbols-outlined text-[16px]">arrow_forward</span>
                    </a>
                </div>
            </div>
        </div>

        {{-- AI Insight --}}
        <div class="mt-6 ai-glow rounded-xl p-5 flex items-center gap-4">
            <span class="material-symbols-outlined text-[#0e7a3d] filled-icon text-2xl shrink-0">auto_awesome</span>
            <p class="text-sm text-[#3f493f]">
                <span class="font-semibold text-[#005f2d]">Tips:</span>
                Konsistensi kehadiran dan ketepatan mengumpulkan tugas adalah kunci nilai terbaik!
            </p>
        </div>
    </div>
</x-app-layout>
