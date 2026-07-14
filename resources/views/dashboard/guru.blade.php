<x-app-layout>
    <x-slot name="header">Dashboard</x-slot>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const labels = {!! json_encode(array_column($chartData, 'label')) !!};
            const hadir  = {!! json_encode(array_column($chartData, 'hadir')) !!};
            const total  = {!! json_encode(array_column($chartData, 'total')) !!};

            new Chart(document.getElementById('attendanceChart'), {
                type: 'bar',
                data: {
                    labels,
                    datasets: [
                        {
                            label: 'Hadir',
                            data: hadir,
                            backgroundColor: '#005f2d',
                            borderRadius: 6,
                            borderSkipped: false,
                        },
                        {
                            label: 'Total Siswa',
                            data: total,
                            backgroundColor: '#a7d9b2',
                            borderRadius: 6,
                            borderSkipped: false,
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            callbacks: {
                                label: ctx => ` ${ctx.dataset.label}: ${ctx.raw}`
                            }
                        }
                    },
                    scales: {
                        x: {
                            grid: { display: false },
                            ticks: { font: { family: 'Inter', size: 11 }, color: '#5c5f61' }
                        },
                        y: {
                            beginAtZero: true,
                            grid: { color: '#f0f4f8' },
                            ticks: { font: { family: 'Inter', size: 11 }, color: '#5c5f61', stepSize: 1 }
                        }
                    }
                }
            });
        });
    </script>
    @endpush

    <div class="p-6 md:p-8 bg-[#f6fafe] min-h-screen">

        {{-- ===== TOP BAR ===== --}}
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8">
            <div>
                <h1 class="text-2xl font-bold text-[#171c1f]">Selamat datang kembali, {{ Auth::user()->name }}!</h1>
                <p class="text-sm text-[#5c5f61] mt-0.5">Here is what's happening in your classes today.</p>
            </div>
            <a href="{{ route('presensi.guru') }}"
               class="inline-flex items-center gap-2 bg-[#005f2d] text-white px-5 py-3 rounded-xl text-sm font-semibold
                      hover:bg-[#0e7a3d] transition-all shadow-soft shrink-0">
                <span class="material-symbols-outlined text-[18px]">add</span>
                New Session
            </a>
        </div>

        {{-- ===== ROW 1: Stats (kiri) + Chart (kanan) ===== --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">

            {{-- Stats kolom kiri --}}
            <div class="flex flex-col gap-5">

                {{-- Total Sessions --}}
                <div class="bg-white rounded-2xl p-5 shadow-soft border border-[#eaeef2] flex items-center justify-between">
                    <div>
                        <p class="text-[10px] font-bold text-[#5c5f61] uppercase tracking-wider">Total Sessions</p>
                        <p class="text-4xl font-bold text-[#171c1f] mt-1">{{ $totalSesi }}</p>
                    </div>
                    <div class="w-12 h-12 bg-[#f0fdf4] rounded-full flex items-center justify-center">
                        <span class="material-symbols-outlined text-[#005f2d] text-[24px] filled-icon">school</span>
                    </div>
                </div>

                {{-- Avg Attendance --}}
                <div class="bg-white rounded-2xl p-5 shadow-soft border border-[#eaeef2] flex items-center justify-between">
                    <div>
                        <p class="text-[10px] font-bold text-[#5c5f61] uppercase tracking-wider">Avg. Attendance</p>
                        <p class="text-4xl font-bold text-[#171c1f] mt-1">{{ $avgAttendance }}%</p>
                    </div>
                    <div class="w-12 h-12 bg-[#f0fdf4] rounded-full flex items-center justify-center">
                        <span class="material-symbols-outlined text-[#005f2d] text-[24px]">trending_up</span>
                    </div>
                </div>

                {{-- Active Students --}}
                <div class="bg-white rounded-2xl p-5 shadow-soft border border-[#eaeef2] flex items-center justify-between">
                    <div>
                        <p class="text-[10px] font-bold text-[#5c5f61] uppercase tracking-wider">Active Students</p>
                        <p class="text-4xl font-bold text-[#171c1f] mt-1">{{ $totalSiswa }}</p>
                    </div>
                    <div class="w-12 h-12 bg-[#f0fdf4] rounded-full flex items-center justify-center">
                        <span class="material-symbols-outlined text-[#005f2d] text-[24px] filled-icon">groups</span>
                    </div>
                </div>
            </div>

            {{-- Attendance Chart --}}
            <div class="lg:col-span-2 bg-white rounded-2xl shadow-soft border border-[#eaeef2] p-6">
                <div class="flex items-center justify-between mb-5">
                    <h3 class="font-bold text-[#171c1f] text-base">Attendance Overview</h3>
                    <div class="flex items-center gap-4">
                        {{-- Legend --}}
                        <div class="hidden sm:flex items-center gap-4 text-xs text-[#5c5f61]">
                            <span class="flex items-center gap-1.5">
                                <span class="w-3 h-3 rounded-sm bg-[#005f2d] inline-block"></span> Hadir
                            </span>
                            <span class="flex items-center gap-1.5">
                                <span class="w-3 h-3 rounded-sm bg-[#a7d9b2] inline-block"></span> Total
                            </span>
                        </div>
                        <span class="text-xs border border-[#eaeef2] rounded-lg px-3 py-1.5 text-[#5c5f61] font-medium">
                            This Week
                        </span>
                    </div>
                </div>
                <div class="bg-[#f6fafe] rounded-xl p-4" style="height:220px;">
                    <canvas id="attendanceChart" class="w-full h-full"></canvas>
                </div>
            </div>
        </div>

        {{-- ===== ROW 2: Today's Schedule (kiri) + Recent Activity (kanan) ===== --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

            {{-- Today's Schedule --}}
            <div class="bg-white rounded-2xl shadow-soft border border-[#eaeef2] overflow-hidden">
                <div class="flex items-center justify-between px-6 py-4 border-b border-[#eaeef2]">
                    <h3 class="font-bold text-[#171c1f]">Today's Schedule</h3>
                    <a href="{{ route('guru.jadwal') }}"
                       class="text-xs font-semibold text-[#005f2d] hover:underline flex items-center gap-0.5">
                        View All <span class="material-symbols-outlined text-[14px]">arrow_forward</span>
                    </a>
                </div>

                <div class="divide-y divide-[#f0f4f8]">
                    @forelse($jadwalHariIni as $j)
                        @php
                            $now       = \Carbon\Carbon::now();
                            $mulai     = \Carbon\Carbon::createFromFormat('H:i:s', $j->jam_mulai);
                            $selesai   = \Carbon\Carbon::createFromFormat('H:i:s', $j->jam_selesai);
                            $isActive  = $now->between($mulai, $selesai);
                            $isUpcoming = $now->lt($mulai);
                            $jamFmt    = $mulai->format('h');
                            $ampm      = $mulai->format('A');
                        @endphp
                        <div class="flex items-center gap-4 px-6 py-4 hover:bg-[#f6fafe] transition-colors">
                            {{-- Jam box --}}
                            <div class="w-14 h-14 rounded-xl flex flex-col items-center justify-center shrink-0
                                         {{ $isActive ? 'bg-[#005f2d] text-white' : 'bg-[#f0f4f8] text-[#171c1f]' }}">
                                <span class="text-lg font-extrabold leading-none">{{ $jamFmt }}</span>
                                <span class="text-[10px] font-semibold uppercase">{{ $ampm }}</span>
                            </div>
                            {{-- Info --}}
                            <div class="flex-1 min-w-0">
                                <p class="font-bold text-sm text-[#171c1f] truncate">{{ $j->mata_pelajaran }}</p>
                                <p class="text-xs text-[#5c5f61] flex items-center gap-1 mt-0.5">
                                    <span class="material-symbols-outlined text-[14px]">location_on</span>
                                    {{ $j->ruang ?: ($j->kelas->nama_kelas ?? '-') }}
                                </p>
                            </div>
                            {{-- Badge status --}}
                            @if($isActive)
                                <span class="shrink-0 px-3 py-1 bg-[#f0fdf4] text-[#005f2d] border border-[#0e7a3d]/20 text-[10px] font-bold rounded-full">
                                    In Progress
                                </span>
                            @elseif($isUpcoming)
                                <span class="shrink-0 px-3 py-1 bg-[#eaeef2] text-[#5c5f61] text-[10px] font-bold rounded-full">
                                    Upcoming
                                </span>
                            @else
                                <span class="shrink-0 px-3 py-1 bg-[#f0f4f8] text-[#5c5f61] text-[10px] font-bold rounded-full">
                                    Done
                                </span>
                            @endif
                        </div>
                    @empty
                        <div class="px-6 py-12 text-center">
                            <span class="material-symbols-outlined text-[#dfe3e7] text-4xl">event_busy</span>
                            <p class="text-sm text-[#5c5f61] mt-3">Tidak ada jadwal hari ini.</p>
                            <a href="{{ route('guru.jadwal') }}"
                               class="mt-3 inline-flex items-center gap-1 text-sm font-semibold text-[#005f2d] hover:underline">
                                Tambah jadwal <span class="material-symbols-outlined text-[14px]">add</span>
                            </a>
                        </div>
                    @endforelse
                </div>
            </div>

            {{-- Recent Activity --}}
            <div class="bg-white rounded-2xl shadow-soft border border-[#eaeef2] overflow-hidden">
                <div class="flex items-center justify-between px-6 py-4 border-b border-[#eaeef2]">
                    <h3 class="font-bold text-[#171c1f]">Recent Activity</h3>
                    <a href="{{ route('laporan.index') }}"
                       class="text-xs font-semibold text-[#005f2d] hover:underline">View All</a>
                </div>

                @if($recentActivity->isEmpty())
                    <div class="px-6 py-12 text-center">
                        <span class="material-symbols-outlined text-[#dfe3e7] text-4xl">history</span>
                        <p class="text-sm text-[#5c5f61] mt-3">Belum ada aktivitas presensi.</p>
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="w-full text-left">
                            <thead>
                                <tr class="bg-[#f6fafe]">
                                    <th class="px-5 py-3 text-[10px] font-bold text-[#5c5f61] uppercase tracking-wider">Student</th>
                                    <th class="px-5 py-3 text-[10px] font-bold text-[#5c5f61] uppercase tracking-wider">Action</th>
                                    <th class="px-5 py-3 text-[10px] font-bold text-[#5c5f61] uppercase tracking-wider">Time</th>
                                    <th class="px-5 py-3 text-[10px] font-bold text-[#5c5f61] uppercase tracking-wider">Status</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-[#f0f4f8]">
                                @foreach($recentActivity as $act)
                                    <tr class="hover:bg-[#f6fafe] transition-colors">
                                        <td class="px-5 py-3.5">
                                            <div class="flex items-center gap-2">
                                                <div class="w-7 h-7 rounded-full bg-[#0e7a3d] flex items-center justify-center text-white text-[11px] font-bold shrink-0">
                                                    {{ substr($act->siswa->name ?? '?', 0, 1) }}
                                                </div>
                                                <span class="text-sm font-medium text-[#171c1f] truncate max-w-[100px]">
                                                    {{ $act->siswa->name ?? '-' }}
                                                </span>
                                            </div>
                                        </td>
                                        <td class="px-5 py-3.5 text-xs text-[#5c5f61]">Checked In</td>
                                        <td class="px-5 py-3.5 text-xs text-[#5c5f61] whitespace-nowrap">
                                            {{ \Carbon\Carbon::parse($act->waktu_absen)->format('h:i A') }}
                                        </td>
                                        <td class="px-5 py-3.5">
                                            @if($act->status === 'hadir')
                                                <span class="px-2.5 py-1 bg-[#f0fdf4] text-[#005f2d] text-[10px] font-bold rounded-full">Present</span>
                                            @elseif($act->status === 'telat')
                                                <span class="px-2.5 py-1 bg-amber-50 text-amber-700 text-[10px] font-bold rounded-full">Late</span>
                                            @elseif($act->status === 'sakit')
                                                <span class="px-2.5 py-1 bg-blue-50 text-blue-700 text-[10px] font-bold rounded-full">Sick</span>
                                            @elseif($act->status === 'izin')
                                                <span class="px-2.5 py-1 bg-[#eaeef2] text-[#495362] text-[10px] font-bold rounded-full">Excused</span>
                                            @else
                                                <span class="px-2.5 py-1 bg-[#ffdad6] text-[#93000a] text-[10px] font-bold rounded-full">Absent</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>
