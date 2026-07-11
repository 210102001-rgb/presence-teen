<x-app-layout>
    <x-slot name="header">Profil Siswa: {{ $siswa->name }}</x-slot>

    @php
        $year = now()->year;
        $month = now()->month;
        $monthName = now()->translatedFormat('F Y');
        
        // First day of the month
        $firstDay = \Carbon\Carbon::create($year, $month, 1);
        $daysInMonth = $firstDay->daysInMonth;
        // Day of the week (1 = Mon, 7 = Sun)
        $startOffset = $firstDay->dayOfWeekIso - 1; 

        // Fetch actual presensi for the student in this month
        $presensiBulanIni = \App\Models\Presensi::where('siswa_id', $siswa->id)
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
        $userKelasIds = \App\Models\SiswaKelas::where('siswa_id', $siswa->id)->pluck('kelas_id');
        $totalSesi = \App\Models\SesiPresensi::whereIn('kelas_id', $userKelasIds)->count();
        $presensiAll = \App\Models\Presensi::where('siswa_id', $siswa->id)->get();
        $totalHadir = $presensiAll->where('status', 'hadir')->count();
        $totalTelat = $presensiAll->where('status', 'telat')->count();
        $totalAlpha = max(0, $totalSesi - $presensiAll->count());

        $attendanceRate = $totalSesi > 0 
            ? round((($totalHadir + $totalTelat) / $totalSesi) * 100) 
            : 100;
    @endphp

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Chart Trend Kehadiran
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

                // Chart Distribusi (Pie)
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
        {{-- Breadcrumbs --}}
        <nav class="flex items-center gap-1.5 text-xs text-[#5c5f61] mb-6">
            <a href="{{ route('dashboard') }}" class="hover:text-[#005f2d] transition-colors">Dashboard</a>
            <span class="material-symbols-outlined text-[14px]">chevron_right</span>
            <span class="text-[#5c5f61]">Profil</span>
            <span class="material-symbols-outlined text-[14px]">chevron_right</span>
            <span class="text-[#171c1f] font-medium">{{ $siswa->name }}</span>
        </nav>

        {{-- Bento Grid Layout --}}
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
            {{-- Main info & Stats (Col-span 8) --}}
            <div class="lg:col-span-8 space-y-6">
                {{-- Identity Card --}}
                <div class="bg-white p-6 rounded-2xl shadow-soft border border-[#eaeef2] flex flex-col md:flex-row gap-6 items-center md:items-start relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-32 h-32 opacity-10 pointer-events-none flex items-center justify-center">
                        <img src="{{ asset('smansa.png') }}" class="w-24 h-24 object-contain" alt="Smansa Logo">
                    </div>
                    
                    <div class="relative shrink-0">
                        <div class="w-32 h-32 rounded-2xl ring-4 ring-[#97f7ac] flex items-center justify-center bg-[#0e7a3d]/10 overflow-hidden">
                            <img src="{{ asset('smansa.png') }}" class="w-24 h-24 object-contain" alt="Smansa Logo">
                        </div>
                        <div class="absolute -bottom-2 -right-2 w-8 h-8 bg-[#7bda92] rounded-full flex items-center justify-center border-2 border-white shadow-soft">
                            <span class="material-symbols-outlined text-white text-[16px]" style="font-variation-settings: 'FILL' 1;">verified</span>
                        </div>
                    </div>

                    <div class="flex-1 space-y-4 text-center md:text-left">
                        <div>
                            <h3 class="text-xl font-bold text-[#171c1f]">{{ $siswa->name }}</h3>
                            <div class="flex items-center justify-center md:justify-start gap-2 mt-1 flex-wrap">
                                <span class="px-2.5 py-[2px] bg-[#97f7ac]/30 text-[#005226] rounded-full text-xs font-bold">NIS: {{ $siswa->nis ?? '-' }}</span>
                                <span class="w-1.5 h-1.5 bg-[#becabc] rounded-full"></span>
                                <span class="text-xs text-[#5c5f61]">Siswa Aktif</span>
                            </div>
                        </div>
                        
                        <div class="grid grid-cols-2 gap-4 pt-4 border-t border-[#eaeef2]">
                            <div>
                                <p class="text-[10px] font-bold text-[#5c5f61] uppercase tracking-wider mb-0.5">E-mail</p>
                                <p class="text-sm font-semibold text-[#171c1f] truncate">{{ $siswa->email }}</p>
                            </div>
                            <div>
                                <p class="text-[10px] font-bold text-[#5c5f61] uppercase tracking-wider mb-0.5">Role</p>
                                <p class="text-sm font-semibold text-[#171c1f] capitalize">{{ $siswa->role }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Academic Details & Stats --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="bg-white p-6 rounded-2xl shadow-soft border-l-4 border-[#005f2d] border-t border-r border-b border-[#eaeef2]">
                        <div class="flex items-center gap-2 mb-6">
                            <span class="material-symbols-outlined text-[#005f2d]">auto_stories</span>
                            <h4 class="font-bold text-[#171c1f]">Akademik & Kelas</h4>
                        </div>
                        <ul class="space-y-3.5">
                            @php
                                $kelas = $siswa->kelasSaya->first();
                            @endphp
                            <li class="flex justify-between items-center pb-2 border-b border-[#f0f4f8]">
                                <span class="text-sm text-[#5c5f61]">Kelas Aktif</span>
                                <span class="text-sm font-bold text-[#171c1f]">{{ $kelas->nama_kelas ?? 'Belum Terdaftar' }}</span>
                            </li>
                            <li class="flex justify-between items-center pb-2 border-b border-[#f0f4f8]">
                                <span class="text-sm text-[#5c5f61]">Mata Pelajaran</span>
                                <span class="text-sm font-bold text-[#171c1f]">{{ $kelas->mata_pelajaran ?? '-' }}</span>
                            </li>
                            <li class="flex justify-between items-center pb-2">
                                <span class="text-sm text-[#5c5f61]">Wali Kelas</span>
                                <span class="text-sm font-bold text-[#005f2d]">{{ $kelas->guru->name ?? '-' }}</span>
                            </li>
                        </ul>
                    </div>

                    <div class="bg-white p-6 rounded-2xl shadow-soft border-l-4 border-[#495362] border-t border-r border-b border-[#eaeef2]">
                        <div class="flex items-center gap-2 mb-6">
                            <span class="material-symbols-outlined text-[#495362]">apartment</span>
                            <h4 class="font-bold text-[#171c1f]">Informasi Sekolah</h4>
                        </div>
                        <div class="flex gap-3 mb-4">
                            <div class="w-10 h-10 bg-[#eaeef2] rounded-lg flex items-center justify-center shrink-0">
                                <span class="material-symbols-outlined text-[#495362]">foundation</span>
                            </div>
                            <div>
                                <p class="text-sm font-bold text-[#171c1f]">SMA Presence-Teen</p>
                                <p class="text-xs text-[#5c5f61]">Akreditasi A (Unggul)</p>
                            </div>
                        </div>
                        <div class="space-y-1 text-xs text-[#5c5f61] bg-[#f6fafe] p-3 rounded-xl border border-[#eaeef2]">
                            <div class="flex items-center gap-2">
                                <span class="material-symbols-outlined text-[14px]">location_on</span>
                                <span>Jl. Melati No. 45, Jakarta</span>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Interactive Charts --}}
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="md:col-span-2 bg-white p-6 rounded-2xl border border-[#eaeef2] shadow-soft h-72 flex flex-col justify-between">
                        <div class="flex justify-between items-center mb-4">
                            <h4 class="font-bold text-[#171c1f]">Tren Bulanan</h4>
                            <span class="text-[10px] text-[#005f2d] font-bold bg-[#f0fdf4] px-2 py-0.5 rounded">Kehadiran</span>
                        </div>
                        <div class="flex-1 relative h-48">
                            <canvas id="attendanceTrendChart"></canvas>
                        </div>
                    </div>

                    <div class="bg-white p-6 rounded-2xl border border-[#eaeef2] shadow-soft h-72 flex flex-col justify-between">
                        <h4 class="font-bold text-[#171c1f] mb-4">Distribusi</h4>
                        <div class="flex-1 relative h-40">
                            <canvas id="attendanceMixChart"></canvas>
                        </div>
                        <div class="flex justify-around text-[10px] font-bold text-[#5c5f61] mt-3">
                            <span class="flex items-center gap-1"><span class="w-2.5 h-2.5 rounded-full bg-[#005f2d]"></span> H</span>
                            <span class="flex items-center gap-1"><span class="w-2.5 h-2.5 rounded-full bg-[#f59e0b]"></span> T</span>
                            <span class="flex items-center gap-1"><span class="w-2.5 h-2.5 rounded-full bg-[#ba1a1a]"></span> A</span>
                        </div>
                    </div>
                </div>

                {{-- Dynamic Attendance Calendar --}}
                <div class="bg-white p-6 rounded-2xl shadow-soft border border-[#eaeef2]">
                    <div class="flex justify-between items-center mb-6">
                        <h4 class="font-bold text-[#171c1f] capitalize">Kalender Absensi ({{ $monthName }})</h4>
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
            </div>

            {{-- AI Analysis & Timeline (Col-span 4) --}}
            <div class="lg:col-span-4 space-y-6">
                {{-- AI Insight --}}
                <div class="bg-[#f0fdf4] p-6 rounded-2xl border border-[#7bda92] relative overflow-hidden">
                    <div class="absolute -bottom-6 -right-6 opacity-5 rotate-12 pointer-events-none">
                        <span class="material-symbols-outlined text-[100px] text-[#005f2d]">insights</span>
                    </div>
                    <div class="flex items-center gap-2 mb-4">
                        <span class="material-symbols-outlined text-[#005f2d]">auto_awesome</span>
                        <h4 class="font-bold text-[#005f2d] uppercase tracking-wider text-xs">AI Insight Mingguan</h4>
                    </div>
                    @if($laporanTerbaru)
                        <p class="text-sm text-[#005226] leading-relaxed italic">
                            "{{ \Illuminate\Support\Str::limit($laporanTerbaru->hasil_analisis, 250) }}"
                        </p>
                        <a href="{{ route('laporan.show', $laporanTerbaru->id) }}" class="mt-4 inline-flex items-center gap-1 text-xs font-bold text-[#005f2d] hover:underline">
                            Lihat Detail Analisis <span class="material-symbols-outlined text-[14px]">arrow_forward</span>
                        </a>
                    @else
                        <p class="text-sm text-[#005226] leading-relaxed italic">
                            Belum ada laporan atau analisis untuk siswa ini.
                        </p>
                    @endif
                </div>

                {{-- Latest Activities --}}
                <div class="bg-white p-6 rounded-2xl shadow-soft border border-[#eaeef2]">
                    <h4 class="font-bold text-[#171c1f] mb-6">Aktivitas Terakhir</h4>
                    @if($aktivitas->isEmpty())
                        <p class="text-sm text-[#5c5f61] italic text-center py-6">Belum ada aktivitas terbaru.</p>
                    @else
                        <div class="relative space-y-6 before:absolute before:left-[11px] before:top-2 before:bottom-2 before:w-[2px] before:bg-[#eaeef2]">
                            @foreach($aktivitas as $act)
                                <div class="relative flex gap-4 items-start">
                                    <div class="w-[24px] h-[24px] rounded-full bg-[#97f7ac] flex items-center justify-center z-10 shadow-soft border-2 border-white">
                                        <span class="material-symbols-outlined text-[#005226] text-[12px]">assignment</span>
                                    </div>
                                    <div class="flex-1 overflow-hidden">
                                        <div class="flex justify-between items-start gap-1">
                                            <p class="text-xs font-bold text-[#171c1f] truncate">Kumpul Tugas: {{ $act->tugas->judul }}</p>
                                        </div>
                                        <p class="text-[10px] text-[#5c5f61] mt-0.5">{{ $act->created_at->diffForHumans() }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
