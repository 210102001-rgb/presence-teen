<x-app-layout>
    <x-slot name="header">Riwayat Presensi</x-slot>

    <div class="p-4 md:p-8 max-w-7xl mx-auto space-y-6" x-data="{ searchQuery: '' }">
        {{-- Page Header --}}
        <header class="mb-8 flex flex-col sm:flex-row justify-between sm:items-center gap-4">
            <div>
                <p class="text-primary font-semibold text-xs mb-1 uppercase tracking-widest">Catatan Kehadiran</p>
                <h1 class="text-2xl font-bold text-on-surface">Riwayat Presensi</h1>
                <p class="text-xs text-secondary">Lacak riwayat kehadiran dan keterlambatan Anda di kelas.</p>
            </div>
        </header>

        {{-- Stats Bento Grid --}}
        @php
            $totalSesi = $presensi->count();
            $hadir = $presensi->where('status', 'hadir')->count();
            $telat = $presensi->where('status', 'telat')->count();
            $alpha = $presensi->where('status', 'alpha')->count();
            $izin = $presensi->where('status', 'izin')->count();
            $sakit = $presensi->where('status', 'sakit')->count();

            $attendanceRate = $totalSesi > 0 
                ? round((($hadir + $telat) / $totalSesi) * 100) 
                : 100;
        @endphp
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <div class="bg-primary text-white rounded-2xl p-6 shadow-soft flex flex-col justify-center items-center text-center">
                <span class="text-[10px] uppercase font-bold tracking-widest opacity-80 mb-1">Tingkat Kehadiran</span>
                <div class="text-3xl font-bold">{{ $attendanceRate }}%</div>
            </div>
            <div class="bg-white rounded-2xl p-6 shadow-soft border-t-4 border-primary border-l border-r border-b border-surface-container flex flex-col justify-center items-center text-center">
                <span class="text-[10px] uppercase font-bold tracking-widest text-secondary mb-1">Total Hadir & Telat</span>
                <div class="text-3xl font-bold text-on-surface">{{ $hadir + $telat }}</div>
            </div>
            <div class="bg-white rounded-2xl p-6 shadow-soft border-t-4 border-amber-500 border-l border-r border-b border-surface-container flex flex-col justify-center items-center text-center">
                <span class="text-[10px] uppercase font-bold tracking-widest text-secondary mb-1">Izin & Sakit</span>
                <div class="text-3xl font-bold text-on-surface">{{ $izin + $sakit }}</div>
            </div>
            <div class="bg-white rounded-2xl p-6 shadow-soft border-t-4 border-error border-l border-r border-b border-surface-container flex flex-col justify-center items-center text-center">
                <span class="text-[10px] uppercase font-bold tracking-widest text-secondary mb-1">Tanpa Keterangan</span>
                <div class="text-3xl font-bold text-error">{{ $alpha }}</div>
            </div>
        </div>

        {{-- Search Input --}}
        <div class="relative max-w-md">
            <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-secondary text-lg">search</span>
            <input x-model="searchQuery" 
                   type="text" 
                   placeholder="Cari mata pelajaran atau guru..." 
                   class="w-full pl-11 pr-4 py-3 bg-white rounded-xl border border-surface-container focus:border-primary focus:ring focus:ring-primary/20 text-sm transition-all text-on-surface">
        </div>

        {{-- History Log List --}}
        <div class="space-y-6">
            @if($presensi->isEmpty())
                <div class="bg-white rounded-2xl shadow-soft border border-surface-container p-16 text-center">
                    <div class="w-16 h-16 bg-surface-container rounded-full flex items-center justify-center mx-auto mb-4">
                        <span class="material-symbols-outlined text-secondary text-3xl">calendar_today</span>
                    </div>
                    <p class="text-base font-semibold text-on-surface">Belum ada riwayat presensi</p>
                    <p class="text-sm text-secondary mt-1">
                        Kehadiran Anda akan muncul di sini setelah Anda melakukan scan QR code presensi.
                    </p>
                </div>
            @else
                @php
                    // Group by month
                    $grouped = $presensi->groupBy(function($item) {
                        return \Carbon\Carbon::parse($item->waktu_absen)->translatedFormat('F Y');
                    });
                @endphp

                @foreach($grouped as $month => $logs)
                    <section class="space-y-4" 
                             x-show="searchQuery === '' || {{ json_encode($logs->map(fn($l) => strtolower($l->sesiPresensi->mata_pelajaran))->toArray()) }}.some(s => s.includes(searchQuery.toLowerCase()))">
                        <div class="flex items-center gap-4">
                            <h3 class="font-bold text-xs text-primary bg-primary-container/10 px-4 py-1.5 rounded-full uppercase tracking-wider">{{ $month }}</h3>
                            <div class="flex-grow h-px bg-surface-container"></div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @foreach($logs as $log)
                                @php
                                    $mapel = $log->sesiPresensi->mata_pelajaran;
                                    $time = \Carbon\Carbon::parse($log->waktu_absen);
                                    $status = $log->status;
                                @endphp
                                <div class="bg-white p-5 rounded-2xl border border-surface-container shadow-soft flex items-center justify-between hover:border-primary-container/30 transition-all cursor-pointer"
                                     x-show="searchQuery === '' || '{{ strtolower($mapel) }}'.includes(searchQuery.toLowerCase())"
                                     @click="window.location.href = '{{ route('presensi.detail', $log) }}'">
                                    <div class="flex gap-4 items-center min-w-0">
                                        <div class="w-12 h-12 rounded-xl bg-primary-container/10 flex items-center justify-center text-primary shrink-0">
                                            <span class="material-symbols-outlined text-[28px]">menu_book</span>
                                        </div>
                                        <div class="min-w-0">
                                            <h4 class="font-bold text-sm text-on-surface truncate">{{ $mapel }}</h4>
                                            <p class="text-xs text-secondary mt-0.5">{{ $time->translatedFormat('l, d M Y') }}</p>
                                        </div>
                                    </div>
                                    <div class="flex items-center gap-3 shrink-0">
                                        <div class="text-right">
                                            <p class="text-[9px] text-secondary uppercase font-bold tracking-wider">Waktu</p>
                                            <p class="text-xs font-semibold text-on-surface">{{ $time->format('H:i') }}</p>
                                        </div>
                                        <div>
                                            @if($status === 'hadir')
                                                <span class="bg-surface-container-lowest text-primary border border-primary-container/20 px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider">Hadir</span>
                                            @elseif($status === 'telat')
                                                <span class="bg-amber-50 text-amber-700 border border-amber-200 px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider">Terlambat</span>
                                            @elseif($status === 'izin')
                                                <span class="bg-surface text-secondary border border-surface-container px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider">Izin</span>
                                            @elseif($status === 'sakit')
                                                <span class="bg-blue-50 text-blue-700 border border-blue-200 px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider">Sakit</span>
                                            @else
                                                <span class="bg-red-50 text-red-700 border border-red-200 px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider">Alpha</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </section>
                @endforeach
            @endif
        </div>
    </div>
</x-app-layout>
