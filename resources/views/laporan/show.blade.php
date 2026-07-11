<x-app-layout>
    <x-slot name="header">Detail Laporan</x-slot>

    @php
        $year = $laporan->created_at->year;
        $month = $laporan->created_at->month;
        $monthName = $laporan->created_at->translatedFormat('F Y');
        
        // First day of the month
        $firstDay = \Carbon\Carbon::create($year, $month, 1);
        $daysInMonth = $firstDay->daysInMonth;
        // Day of the week (1 = Mon, 7 = Sun)
        $startOffset = $firstDay->dayOfWeekIso - 1; 

        // Fetch actual presensi for the student in this month
        $presensiBulanIni = \App\Models\Presensi::where('siswa_id', $laporan->siswa_id)
            ->whereMonth('waktu_absen', $month)
            ->whereYear('waktu_absen', $year)
            ->get()
            ->keyBy(function($p) {
                return \Carbon\Carbon::parse($p->waktu_absen)->day;
            });

        // Also get all session days in this month to determine Alpha vs Empty days
        $sesiBulanIni = \App\Models\SesiPresensi::whereMonth('created_at', $month)
            ->whereYear('created_at', $year)
            ->get()
            ->keyBy(function($s) {
                return $s->created_at->day;
            });

        // Calculate statistics
        $userKelasIds = \App\Models\SiswaKelas::where('siswa_id', $laporan->siswa_id)->pluck('kelas_id');
        $totalSesi = \App\Models\SesiPresensi::whereIn('kelas_id', $userKelasIds)->count();
        $presensiAll = \App\Models\Presensi::where('siswa_id', $laporan->siswa_id)->get();
        $totalHadir = $presensiAll->where('status', 'hadir')->count();
        $totalTelat = $presensiAll->where('status', 'telat')->count();
        $totalAlpha = max(0, $totalSesi - $presensiAll->count());

        $attendanceRate = $totalSesi > 0 
            ? round((($totalHadir + $totalTelat) / $totalSesi) * 100) 
            : 100;

        $recentPresensi = \App\Models\Presensi::where('siswa_id', $laporan->siswa_id)
            ->orderBy('waktu_absen', 'desc')
            ->take(5)
            ->get();
    @endphp

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Monthly Trend Line Chart
                const trendCtx = document.getElementById('attendanceTrendChart').getContext('2d');
                new Chart(trendCtx, {
                    type: 'line',
                    data: {
                        labels: ['Jul', 'Agu', 'Sep', 'Okt', 'Nov'],
                        datasets: [{
                            label: 'Tingkat Kehadiran %',
                            data: [90, 92, 95, 93, {{ $attendanceRate }}],
                            borderColor: '#005f2d',
                            backgroundColor: 'rgba(0, 95, 45, 0.05)',
                            fill: true,
                            tension: 0.4,
                            borderWidth: 3,
                            pointRadius: 4,
                            pointBackgroundColor: '#005f2d'
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: { display: false }
                        },
                        scales: {
                            y: { min: 0, max: 100, ticks: { stepSize: 20 } }
                        }
                    }
                });

                // Doughnut Chart: Distribution
                const mixCtx = document.getElementById('attendanceMixChart').getContext('2d');
                new Chart(mixCtx, {
                    type: 'doughnut',
                    data: {
                        labels: ['Hadir', 'Telat', 'Alpha'],
                        datasets: [{
                            data: [{{ $totalHadir }}, {{ $totalTelat }}, {{ $totalAlpha }}],
                            backgroundColor: ['#005f2d', '#f59e0b', '#ba1a1a'],
                            borderWidth: 2,
                            borderColor: '#ffffff'
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: { display: false }
                        },
                        cutout: '70%'
                    }
                });
            });
        </script>
    @endpush

    <div class="p-4 md:p-8 max-w-7xl mx-auto space-y-6">
        {{-- Breadcrumb --}}
        <nav class="flex items-center gap-1.5 text-xs text-[#5c5f61] mb-6">
            <a href="{{ route('laporan.index') }}" class="hover:text-[#005f2d] transition-colors">Laporan</a>
            <span class="material-symbols-outlined text-[14px]">chevron_right</span>
            <span class="text-[#171c1f] font-medium">Detail Kehadiran {{ $laporan->siswa->name ?? '' }}</span>
        </nav>

        {{-- Top Info Row (Mockup: Overall Attendance, Present, Excused, Unexcused) --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="bg-white p-6 rounded-2xl border border-[#eaeef2] shadow-soft flex flex-col justify-between">
                <span class="text-[9px] font-bold text-[#5c5f61] uppercase tracking-wider">Overall Attendance</span>
                <p class="text-3xl font-bold text-[#171c1f] mt-2">{{ $attendanceRate }}%</p>
                <span class="text-[10px] text-[#005f2d] font-bold flex items-center gap-1 mt-1">
                    <span class="material-symbols-outlined text-[12px]">trending_up</span> +2.4% dari bulan lalu
                </span>
            </div>

            <div class="bg-white p-6 rounded-2xl border border-[#eaeef2] shadow-soft flex items-center gap-4">
                <div class="w-12 h-12 rounded-full bg-[#f0fdf4] text-[#005f2d] flex items-center justify-center shrink-0">
                    <span class="material-symbols-outlined filled-icon">check_circle</span>
                </div>
                <div>
                    <span class="text-[9px] font-bold text-[#5c5f61] uppercase tracking-wider">Hadir</span>
                    <p class="text-lg font-bold text-[#171c1f]">{{ $totalHadir }} <span class="text-xs font-normal text-[#5c5f61]">Sesi</span></p>
                </div>
            </div>

            <div class="bg-white p-6 rounded-2xl border border-[#eaeef2] shadow-soft flex items-center gap-4">
                <div class="w-12 h-12 rounded-full bg-amber-50 text-amber-600 flex items-center justify-center shrink-0">
                    <span class="material-symbols-outlined">assignment</span>
                </div>
                <div>
                    <span class="text-[9px] font-bold text-[#5c5f61] uppercase tracking-wider">Terlambat</span>
                    <p class="text-lg font-bold text-[#171c1f]">{{ $totalTelat }} <span class="text-xs font-normal text-[#5c5f61]">Sesi</span></p>
                </div>
            </div>

            <div class="bg-white p-6 rounded-2xl border border-[#ba1a1a]/20 shadow-soft flex items-center gap-4">
                <div class="w-12 h-12 rounded-full bg-[#ffdad6] text-[#ba1a1a] flex items-center justify-center shrink-0">
                    <span class="material-symbols-outlined">cancel</span>
                </div>
                <div>
                    <span class="text-[9px] font-bold text-[#5c5f61] uppercase tracking-wider">Alpha / Tanpa Kabar</span>
                    <p class="text-lg font-bold text-[#ba1a1a]">{{ $totalAlpha }} <span class="text-xs font-normal text-[#5c5f61]">Sesi</span></p>
                </div>
            </div>
        </div>

        {{-- Graph & Distribution Row --}}
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
            {{-- Line Chart (Col-span 8) --}}
            <div class="lg:col-span-8 bg-white p-6 rounded-2xl border border-[#eaeef2] shadow-soft h-80 flex flex-col justify-between">
                <div class="flex justify-between items-center">
                    <h4 class="font-bold text-[#171c1f]">Tren Bulanan</h4>
                    <span class="text-[10px] text-[#005f2d] font-bold bg-[#f0fdf4] px-2 py-0.5 rounded">Kehadiran</span>
                </div>
                <div class="flex-1 relative h-48 mt-4">
                    <canvas id="attendanceTrendChart"></canvas>
                </div>
            </div>

            {{-- Doughnut Chart (Col-span 4) --}}
            <div class="lg:col-span-4 bg-white p-6 rounded-2xl border border-[#eaeef2] shadow-soft h-80 flex flex-col justify-between">
                <h4 class="font-bold text-[#171c1f] mb-4">Distribusi Kehadiran</h4>
                <div class="flex-1 relative h-40 flex items-center justify-center">
                    <canvas id="attendanceMixChart"></canvas>
                </div>
                <div class="flex justify-around text-[10px] font-bold text-[#5c5f61] mt-4">
                    <span class="flex items-center gap-1"><span class="w-2.5 h-2.5 rounded-full bg-[#005f2d]"></span> Hadir</span>
                    <span class="flex items-center gap-1"><span class="w-2.5 h-2.5 rounded-full bg-[#f59e0b]"></span> Telat</span>
                    <span class="flex items-center gap-1"><span class="w-2.5 h-2.5 rounded-full bg-[#ba1a1a]"></span> Alpha</span>
                </div>
            </div>
        </div>

        {{-- Calendar & Recent History Row --}}
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
            {{-- Calendar (Col-span 7) --}}
            <div class="lg:col-span-7 bg-white p-6 rounded-2xl shadow-soft border border-[#eaeef2]">
                <div class="flex justify-between items-center mb-6">
                    <h4 class="font-bold text-[#171c1f] capitalize">{{ $monthName }}</h4>
                    <div class="flex gap-2">
                        <div class="flex items-center gap-1"><span class="w-2 h-2 rounded-full bg-[#005f2d]"></span> <span class="text-[9px] text-[#5c5f61]">Hadir</span></div>
                        <div class="flex items-center gap-1"><span class="w-2 h-2 rounded-full bg-amber-400"></span> <span class="text-[9px] text-[#5c5f61]">Telat</span></div>
                        <div class="flex items-center gap-1"><span class="w-2 h-2 rounded-full bg-red-600"></span> <span class="text-[9px] text-[#5c5f61]">Alpha</span></div>
                    </div>
                </div>
                <div class="grid grid-cols-7 gap-2 text-center text-[10px] font-bold text-[#5c5f61] uppercase tracking-wider mb-2">
                    <span>Sen</span><span>Sel</span><span>Rab</span><span>Kam</span><span>Jum</span><span>Sab</span><span>Min</span>
                </div>
                <div class="grid grid-cols-7 gap-2">
                    {{-- Previous Month Offset --}}
                    @for($o = 0; $o < $startOffset; $o++)
                        <div class="aspect-square bg-[#f6fafe] rounded-lg opacity-20 border border-[#eaeef2]"></div>
                    @endfor

                    {{-- Days in current Month --}}
                    @for($d = 1; $d <= $daysInMonth; $d++)
                        @php
                            $bgColor = 'bg-[#f6fafe] text-[#171c1f] border border-[#eaeef2]';
                            $p = $presensiBulanIni->get($d);
                            $s = $sesiBulanIni->get($d);
                            
                            $currentDay = \Carbon\Carbon::create($year, $month, $d);
                            $isWeekend = $currentDay->isWeekend();

                            if ($p) {
                                if ($p->status === 'telat') {
                                    $bgColor = 'bg-amber-400 text-white';
                                } else {
                                    $bgColor = 'bg-[#005f2d]/90 text-white';
                                }
                            } elseif ($s) {
                                $bgColor = 'bg-red-600 text-white';
                            } elseif ($isWeekend) {
                                $bgColor = 'bg-gray-100 opacity-40 text-gray-400 border border-[#eaeef2]';
                            }
                        @endphp
                        <div class="aspect-square flex items-center justify-center font-bold text-xs rounded-lg shadow-sm {{ $bgColor }}">
                            {{ $d }}
                        </div>
                    @endfor
                </div>
            </div>

            {{-- Recent History (Col-span 5) --}}
            <div class="lg:col-span-5 bg-white p-6 rounded-2xl shadow-soft border border-[#eaeef2] flex flex-col justify-between">
                <h4 class="font-bold text-[#171c1f] mb-4">Riwayat Kehadiran Terbaru</h4>
                <div class="overflow-x-auto flex-grow">
                    <table class="w-full text-left text-xs">
                        <thead>
                            <tr class="border-b border-[#eaeef2] text-[#5c5f61] font-bold">
                                <th class="pb-3">TANGGAL</th>
                                <th class="pb-3">STATUS</th>
                                <th class="pb-3">CATATAN</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-[#f0f4f8]">
                            @forelse($recentPresensi as $p)
                                <tr class="hover:bg-[#f6fafe]">
                                    <td class="py-3 font-semibold text-[#171c1f]">
                                        {{ \Carbon\Carbon::parse($p->waktu_absen)->translatedFormat('d M Y') }}
                                    </td>
                                    <td class="py-3">
                                        @if($p->status === 'telat')
                                            <span class="px-2 py-0.5 rounded bg-amber-100 text-amber-700 font-bold uppercase text-[9px]">Telat</span>
                                        @else
                                            <span class="px-2 py-0.5 rounded bg-[#f0fdf4] text-[#005f2d] font-bold uppercase text-[9px]">Hadir</span>
                                        @endif
                                    </td>
                                    <td class="py-3 text-[#5c5f61] italic">
                                        {{ $p->status === 'telat' ? 'Datang terlambat' : 'Tepat waktu' }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="py-4 text-center text-[#5c5f61]">Belum ada riwayat kehadiran.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- AI Insights & Warning --}}
        <div class="bg-[#f0fdf4] border border-[#0e7a3d]/20 rounded-2xl p-6 shadow-soft relative overflow-hidden">
            <div class="absolute right-0 top-0 p-4 opacity-5 pointer-events-none">
                <span class="material-symbols-outlined text-[80px] text-[#0e7a3d]">auto_awesome</span>
            </div>
            <div class="relative z-10 flex items-start gap-4">
                <span class="material-symbols-outlined text-[#005f2d] filled-icon text-2xl shrink-0">auto_awesome</span>
                <div>
                    <h5 class="font-bold text-[#005226] mb-1">Parental Insight AI</h5>
                    <p class="text-xs text-[#005226] leading-relaxed">
                        {{ $laporan->hasil_analisis ?? 'Siswa menunjukkan tren kehadiran yang stabil dan sangat tinggi. Dukung terus proses belajarnya agar performa akademik terus meningkat!' }}
                    </p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
