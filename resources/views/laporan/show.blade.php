<x-app-layout>
    <x-slot name="header">Detail Laporan</x-slot>

    <div class="p-8">
        <div class="max-w-3xl mx-auto">
            {{-- Breadcrumb --}}
            <nav class="flex items-center gap-1.5 text-xs text-[#5c5f61] mb-6">
                <a href="{{ route('laporan.index') }}" class="hover:text-[#005f2d] transition-colors">Laporan</a>
                <span class="material-symbols-outlined text-[14px]">chevron_right</span>
                <span class="text-[#171c1f] font-medium">Detail</span>
            </nav>

            {{-- Header Card --}}
            <div class="bg-white rounded-xl shadow-soft border border-[#eaeef2] p-6 mb-6">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <div class="flex items-center gap-4">
                        <div class="w-14 h-14 rounded-full bg-[#0e7a3d] flex items-center justify-center text-white text-xl font-bold shrink-0">
                            {{ substr($laporan->siswa->name ?? '?', 0, 1) }}
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-[#171c1f]">{{ $laporan->siswa->name ?? '-' }}</h3>
                            <p class="text-sm text-[#5c5f61]">Periode: {{ $laporan->periode }}</p>
                        </div>
                    </div>
                    @php
                        $level = $laporan->level_peringatan ?? 'ringan';
                        $badgeMap = [
                            'ringan' => 'bg-[#f0fdf4] text-[#005f2d] border border-[#0e7a3d]/20',
                            'sedang' => 'bg-amber-50 text-amber-700 border border-amber-200',
                            'berat'  => 'bg-[#ffdad6] text-[#93000a] border border-[#ba1a1a]/20',
                        ];
                        $badgeClass = $badgeMap[$level] ?? 'bg-[#eaeef2] text-[#5c5f61]';
                    @endphp
                    <span class="px-4 py-2 text-sm font-bold rounded-full uppercase tracking-wider {{ $badgeClass }}">
                        {{ ucfirst($level) }}
                    </span>
                </div>
            </div>

            {{-- AI Analysis --}}
            <div class="bg-white rounded-xl shadow-soft border border-[#eaeef2] overflow-hidden mb-6">
                <div class="px-6 py-4 bg-[#f0fdf4] border-b border-[#0e7a3d]/15 flex items-center gap-3">
                    <span class="material-symbols-outlined text-[#0e7a3d] filled-icon">auto_awesome</span>
                    <h4 class="font-semibold text-[#005f2d]">Hasil Analisis AI</h4>
                </div>
                <div class="p-6">
                    @if($laporan->hasil_analisis)
                        <div class="text-sm text-[#171c1f] leading-relaxed whitespace-pre-wrap bg-[#f6fafe] rounded-xl p-5 border border-[#eaeef2]">
                            {{ $laporan->hasil_analisis }}
                        </div>
                    @else
                        <div class="py-8 text-center">
                            <span class="material-symbols-outlined text-[#dfe3e7] text-4xl">psychology</span>
                            <p class="text-sm text-[#5c5f61] mt-3">Analisis belum tersedia</p>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Back Button --}}
            <a href="{{ route('laporan.index') }}"
               class="inline-flex items-center gap-2 text-sm font-medium text-[#005f2d] hover:text-[#0e7a3d] transition-colors">
                <span class="material-symbols-outlined text-[18px]">arrow_back</span>
                Kembali ke Daftar Laporan
            </a>
        </div>
    </div>
</x-app-layout>
