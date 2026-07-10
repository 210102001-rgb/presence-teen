<x-app-layout>
    <x-slot name="header">Laporan Siswa</x-slot>

    <div class="p-8">
        {{-- Page Header --}}
        <div class="mb-8">
            <p class="text-[11px] uppercase tracking-widest text-[#005f2d] font-semibold mb-1">AI-Powered Analytics</p>
            <h2 class="text-2xl font-bold text-[#171c1f]">Laporan & Peringatan Siswa</h2>
        </div>

        {{-- AI Insight Banner --}}
        <div class="ai-glow rounded-xl p-5 mb-6 flex items-start gap-4 relative overflow-hidden">
            <div class="absolute right-0 top-0 p-4 opacity-5 pointer-events-none">
                <span class="material-symbols-outlined text-[80px] text-[#0e7a3d]">auto_awesome</span>
            </div>
            <div class="w-10 h-10 bg-[#0e7a3d]/10 rounded-xl flex items-center justify-center shrink-0">
                <span class="material-symbols-outlined text-[#0e7a3d] filled-icon">auto_awesome</span>
            </div>
            <div class="relative z-10">
                <h5 class="font-semibold text-[#005f2d] mb-1">Ringkasan AI</h5>
                <p class="text-sm text-[#3f493f]">
                    Laporan dianalisis setiap minggu oleh AI. Level peringatan mencerminkan pola kehadiran dan aktivitas belajar siswa secara holistik.
                </p>
            </div>
        </div>

        {{-- Table --}}
        <div class="bg-white rounded-xl shadow-soft border border-[#eaeef2] overflow-hidden">
            <div class="px-6 py-4 border-b border-[#eaeef2] flex justify-between items-center">
                <h4 class="font-semibold text-[#171c1f]">Daftar Laporan</h4>
                <span class="text-xs text-[#5c5f61]">{{ $laporans->count() }} laporan</span>
            </div>

            @if($laporans->isEmpty())
                <div class="p-16 text-center">
                    <div class="w-16 h-16 bg-[#eaeef2] rounded-full flex items-center justify-center mx-auto mb-4">
                        <span class="material-symbols-outlined text-[#5c5f61] text-3xl">monitoring</span>
                    </div>
                    <p class="text-base font-medium text-[#171c1f]">Belum ada laporan</p>
                    <p class="text-sm text-[#5c5f61] mt-1">Laporan akan muncul setelah analisis mingguan dilakukan.</p>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="bg-[#f6fafe]">
                                <th class="px-6 py-3.5 text-left text-[11px] font-semibold text-[#5c5f61] uppercase tracking-wider">Nama Siswa</th>
                                <th class="px-6 py-3.5 text-left text-[11px] font-semibold text-[#5c5f61] uppercase tracking-wider">Periode</th>
                                <th class="px-6 py-3.5 text-left text-[11px] font-semibold text-[#5c5f61] uppercase tracking-wider">Level Peringatan</th>
                                <th class="px-6 py-3.5 text-left text-[11px] font-semibold text-[#5c5f61] uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-[#f0f4f8]">
                            @foreach($laporans as $item)
                                @php
                                    $level = $item->level_peringatan ?? 'ringan';
                                    $badgeMap = [
                                        'ringan' => 'bg-[#f0fdf4] text-[#005f2d] border border-[#0e7a3d]/20',
                                        'sedang' => 'bg-amber-50 text-amber-700 border border-amber-200',
                                        'berat'  => 'bg-[#ffdad6] text-[#93000a] border border-[#ba1a1a]/20',
                                    ];
                                    $badgeClass = $badgeMap[$level] ?? 'bg-[#eaeef2] text-[#5c5f61]';
                                @endphp
                                <tr class="hover:bg-[#f6fafe] transition-colors">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            <div class="w-8 h-8 rounded-full bg-[#0e7a3d] flex items-center justify-center text-white text-sm font-bold shrink-0">
                                                {{ substr($item->siswa->name ?? '?', 0, 1) }}
                                            </div>
                                            <span class="text-sm font-medium text-[#171c1f]">{{ $item->siswa->name ?? '-' }}</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-[#5c5f61]">{{ $item->periode }}</td>
                                    <td class="px-6 py-4">
                                        <span class="px-3 py-1 text-[11px] font-bold rounded-full uppercase tracking-wider {{ $badgeClass }}">
                                            {{ ucfirst($level) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <a href="{{ route('laporan.show', $item) }}"
                                           class="inline-flex items-center gap-1 text-sm font-semibold text-[#005f2d] hover:text-[#0e7a3d] transition-colors">
                                            Detail <span class="material-symbols-outlined text-[16px]">arrow_forward</span>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
