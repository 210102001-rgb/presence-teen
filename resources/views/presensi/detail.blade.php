<x-app-layout>
    <x-slot name="header">Detail Presensi</x-slot>

    <div class="p-4 md:p-8 max-w-4xl mx-auto space-y-6">
        {{-- Back Button & Title --}}
        <div class="flex items-center gap-3 mb-6">
            <a href="{{ route('presensi.riwayat') }}" class="p-2 hover:bg-surface-container rounded-full text-primary transition-all flex items-center justify-center">
                <span class="material-symbols-outlined">arrow_back</span>
            </a>
            <div>
                <p class="text-primary font-semibold text-xs mb-0.5 uppercase tracking-widest">Detail Kehadiran</p>
                <h2 class="text-xl font-bold text-on-surface">Informasi Presensi</h2>
            </div>
        </div>

        {{-- Hero Card: Subject & Status --}}
        @php
            $status = $presensi->status;
            $time = \Carbon\Carbon::parse($presensi->waktu_absen);
            $sesi = $presensi->sesiPresensi;
            $kelas = $sesi->kelas;
            $guru = $kelas->guru;
        @endphp
        <div class="bg-white rounded-2xl shadow-soft border border-surface-container overflow-hidden relative">
            <div class="absolute left-0 top-0 bottom-0 w-1.5 bg-primary"></div>
            <div class="p-6 pl-8 flex flex-col sm:flex-row justify-between sm:items-center gap-4">
                <div>
                    <span class="text-primary font-bold text-xs uppercase tracking-wider">{{ $kelas->nama_kelas }}</span>
                    <h3 class="text-lg font-bold text-on-surface mt-1">{{ $sesi->mata_pelajaran }}</h3>
                    <p class="text-xs text-secondary mt-0.5">Sesi Dibuat: {{ \Carbon\Carbon::parse($sesi->created_at)->translatedFormat('d M Y, H:i') }}</p>
                </div>
                <div class="flex flex-col sm:items-end shrink-0">
                    <div>
                        @if($status === 'hadir')
                            <span class="bg-[#f0fdf4] text-primary border border-primary-container/20 px-4 py-1.5 rounded-full text-xs font-bold uppercase tracking-wider">Hadir</span>
                        @elseif($status === 'telat')
                            <span class="bg-amber-50 text-amber-700 border border-amber-200 px-4 py-1.5 rounded-full text-xs font-bold uppercase tracking-wider">Terlambat</span>
                        @elseif($status === 'izin')
                            <span class="bg-[#f6fafe] text-secondary border border-surface-container px-4 py-1.5 rounded-full text-xs font-bold uppercase tracking-wider">Izin</span>
                        @elseif($status === 'sakit')
                            <span class="bg-blue-50 text-blue-700 border border-blue-200 px-4 py-1.5 rounded-full text-xs font-bold uppercase tracking-wider">Sakit</span>
                        @else
                            <span class="bg-red-50 text-red-700 border border-red-200 px-4 py-1.5 rounded-full text-xs font-bold uppercase tracking-wider">Alpha</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        {{-- Detail Grid --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            {{-- Info Siswa --}}
            <div class="bg-white p-6 rounded-2xl border border-surface-container shadow-soft space-y-4">
                <h4 class="font-bold text-sm text-on-surface border-b border-surface-container pb-2 flex items-center gap-2">
                    <span class="material-symbols-outlined text-primary text-lg">person</span>
                    Informasi Siswa
                </h4>
                <div class="space-y-3 text-xs">
                    <div>
                        <p class="text-secondary font-semibold">Nama Siswa</p>
                        <p class="text-on-surface font-bold text-sm mt-0.5">{{ $presensi->siswa->name }}</p>
                    </div>
                    <div>
                        <p class="text-secondary font-semibold">NIS</p>
                        <p class="text-on-surface font-semibold mt-0.5">{{ $presensi->siswa->nis ?? '-' }}</p>
                    </div>
                </div>
            </div>

            {{-- Info Sesi & Guru --}}
            <div class="bg-white p-6 rounded-2xl border border-surface-container shadow-soft space-y-4">
                <h4 class="font-bold text-sm text-on-surface border-b border-surface-container pb-2 flex items-center gap-2">
                    <span class="material-symbols-outlined text-primary text-lg">info</span>
                    Detail Presensi
                </h4>
                <div class="space-y-3 text-xs">
                    <div>
                        <p class="text-secondary font-semibold">Guru Pengampu</p>
                        <p class="text-on-surface font-bold text-sm mt-0.5">{{ $guru->name ?? 'Administrator' }}</p>
                    </div>
                    <div>
                        <p class="text-secondary font-semibold">Waktu Absen</p>
                        <p class="text-on-surface font-semibold mt-0.5">{{ $time->translatedFormat('d M Y, H:i') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
