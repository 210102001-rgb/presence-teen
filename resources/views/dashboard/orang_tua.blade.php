<x-app-layout>
    <x-slot name="header">Dashboard Orang Tua</x-slot>

    <div class="p-4 md:p-8">
        {{-- Welcome --}}
        <div class="mb-8">
            <h2 class="text-2xl font-bold text-[#171c1f]">Selamat Datang, {{ Auth::user()->name }} 👋</h2>
            <p class="text-sm text-[#3f493f] mt-1">Pantau perkembangan belajar putra/putri Anda secara real-time.</p>
        </div>

        {{-- Stats --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-5 mb-8">
            <div class="animate-fade-in animate-delay-1 bg-[#0e7a3d] text-white rounded-xl p-5 shadow-soft">
                <div class="flex justify-between items-start mb-3">
                    <p class="text-[11px] uppercase tracking-widest text-white/70 font-semibold">Anak Terdaftar</p>
                    <div class="w-9 h-9 bg-white/15 rounded-xl flex items-center justify-center">
                        <span class="material-symbols-outlined text-white text-[20px] filled-icon">family_restroom</span>
                    </div>
                </div>
                <p class="text-4xl font-bold">{{ $siswa->count() }}</p>
                <p class="text-xs text-white/60 mt-1">Anak terhubung</p>
            </div>

            <div class="animate-fade-in animate-delay-2 bg-white rounded-xl p-5 shadow-soft {{ $totalPeringatan > 0 ? 'border-t-4 border-[#ba1a1a]' : 'border-t-4 border-[#005f2d]' }}">
                <div class="flex justify-between items-start mb-3">
                    <p class="text-[11px] uppercase tracking-widest text-[#5c5f61] font-semibold">Peringatan</p>
                    <div class="w-9 h-9 {{ $totalPeringatan > 0 ? 'bg-[#ffdad6]' : 'bg-[#f0fdf4]' }} rounded-xl flex items-center justify-center">
                        <span class="material-symbols-outlined {{ $totalPeringatan > 0 ? 'text-[#ba1a1a]' : 'text-[#005f2d]' }} text-[20px]">notifications</span>
                    </div>
                </div>
                <p class="text-4xl font-bold {{ $totalPeringatan > 0 ? 'text-[#ba1a1a]' : 'text-[#171c1f]' }}">{{ $totalPeringatan }}</p>
                <p class="text-xs text-[#5c5f61] mt-1">{{ $totalPeringatan > 0 ? 'Perlu perhatian' : 'Semua baik' }}</p>
            </div>

            <div class="animate-fade-in animate-delay-3 bg-white rounded-xl p-5 shadow-soft border-t-4 border-[#495362]">
                <div class="flex justify-between items-start mb-3">
                    <p class="text-[11px] uppercase tracking-widest text-[#5c5f61] font-semibold">Total Laporan</p>
                    <div class="w-9 h-9 bg-[#eaeef2] rounded-xl flex items-center justify-center">
                        <span class="material-symbols-outlined text-[#495362] text-[20px]">monitoring</span>
                    </div>
                </div>
                <p class="text-4xl font-bold text-[#171c1f]">{{ $laporans->count() }}</p>
                <p class="text-xs text-[#5c5f61] mt-1">Laporan AI tersedia</p>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            {{-- Laporan Terbaru --}}
            <div class="lg:col-span-2 bg-white rounded-xl shadow-soft border border-[#eaeef2]">
                <div class="px-6 py-4 border-b border-[#eaeef2] flex justify-between items-center">
                    <h4 class="font-semibold text-[#171c1f]">Laporan AI Terbaru</h4>
                    <a href="{{ route('laporan.index') }}" class="text-xs font-semibold text-[#005f2d] hover:underline">Lihat Semua</a>
                </div>
                @if($laporans->isEmpty())
                    <div class="p-12 text-center">
                        <span class="material-symbols-outlined text-[#dfe3e7] text-4xl">monitoring</span>
                        <p class="text-sm text-[#5c5f61] mt-3">Belum ada laporan tersedia.</p>
                        <p class="text-xs text-[#5c5f61] mt-1">Laporan AI dibuat setiap minggu secara otomatis.</p>
                    </div>
                @else
                    <div class="divide-y divide-[#f0f4f8]">
                        @foreach($laporans as $l)
                            @php
                                $level = $l->level_peringatan ?? 'aman';
                                $badgeMap = [
                                    'aman'      => 'bg-[#f0fdf4] text-[#005f2d]',
                                    'perhatian' => 'bg-amber-50 text-amber-700',
                                    'kritis'    => 'bg-[#ffdad6] text-[#93000a]',
                                ];
                            @endphp
                            <div class="flex items-center justify-between px-6 py-3.5 hover:bg-[#f6fafe] transition-colors group">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-full bg-[#0e7a3d] flex items-center justify-center text-white text-sm font-bold shrink-0">
                                        {{ substr($l->siswa->name ?? '?', 0, 1) }}
                                    </div>
                                    <div>
                                        <p class="text-sm font-semibold text-[#171c1f]">{{ $l->siswa->name ?? '-' }}</p>
                                        <p class="text-xs text-[#5c5f61]">{{ $l->periode }}</p>
                                    </div>
                                </div>
                                <div class="flex items-center gap-3">
                                    <span class="px-2.5 py-1 text-[10px] font-bold rounded-full uppercase {{ $badgeMap[$level] ?? 'bg-[#eaeef2] text-[#5c5f61]' }}">
                                        {{ ucfirst($level) }}
                                    </span>
                                    <a href="{{ route('laporan.show', $l) }}"
                                       class="text-[#005f2d] opacity-0 group-hover:opacity-100 transition-opacity">
                                        <span class="material-symbols-outlined text-[20px]">arrow_forward</span>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            {{-- Profil Anak --}}
            <div class="flex flex-col gap-4">
                <div class="bg-white rounded-xl shadow-soft border border-[#eaeef2]">
                    <div class="px-5 py-4 border-b border-[#eaeef2]">
                        <h4 class="font-semibold text-[#171c1f]">Profil Anak</h4>
                    </div>
                    @if($siswa->isEmpty())
                        <div class="p-8 text-center">
                            <span class="material-symbols-outlined text-[#dfe3e7] text-3xl">person</span>
                            <p class="text-xs text-[#5c5f61] mt-2">Tidak ada anak terhubung.</p>
                        </div>
                    @else
                        <div class="p-4 space-y-3">
                            @foreach($siswa as $anak)
                                @php
                                    $kelas = $anak->siswaKelas->first()?->kelas;
                                @endphp
                                <div class="flex items-center gap-3 p-3 bg-[#f6fafe] rounded-xl">
                                    <div class="w-10 h-10 rounded-full bg-[#0e7a3d] flex items-center justify-center text-white font-bold shrink-0">
                                        {{ substr($anak->name, 0, 1) }}
                                    </div>
                                    <div class="min-w-0">
                                        <p class="text-sm font-semibold text-[#171c1f] truncate">{{ $anak->name }}</p>
                                        <p class="text-xs text-[#5c5f61]">{{ $kelas->nama_kelas ?? 'Belum ada kelas' }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>

                {{-- Lihat Laporan --}}
                <div class="bg-white rounded-xl shadow-soft p-5 border border-[#eaeef2]">
                    <div class="w-10 h-10 bg-[#f0fdf4] rounded-xl flex items-center justify-center mb-3">
                        <span class="material-symbols-outlined text-[#0e7a3d] filled-icon">analytics</span>
                    </div>
                    <h4 class="font-semibold text-[#171c1f] mb-1">Laporan Lengkap</h4>
                    <p class="text-xs text-[#5c5f61] mb-3">Lihat analisis AI lengkap tentang perkembangan anak.</p>
                    <a href="{{ route('laporan.index') }}"
                       class="w-full block text-center py-2.5 border border-[#005f2d] text-[#005f2d] text-sm font-semibold rounded-xl hover:bg-[#f0fdf4] transition-colors">
                        Buka Laporan
                    </a>
                </div>
            </div>
        </div>

        {{-- AI Banner --}}
        <div class="mt-6 ai-glow rounded-xl p-5 flex items-start gap-4">
            <span class="material-symbols-outlined text-[#0e7a3d] filled-icon text-2xl shrink-0 mt-0.5">auto_awesome</span>
            <div>
                <h5 class="font-semibold text-[#005f2d] mb-1">AI Insight Mingguan</h5>
                <p class="text-sm text-[#3f493f]">
                    Laporan AI dianalisis setiap Senin pagi secara otomatis berdasarkan pola kehadiran dan aktivitas belajar minggu sebelumnya.
                </p>
            </div>
        </div>
    </div>
</x-app-layout>
