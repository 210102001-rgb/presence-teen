<x-app-layout>
    <x-slot name="header">Riwayat Kehadiran Siswa</x-slot>

    <div class="p-4 md:p-8 max-w-7xl mx-auto space-y-6" x-data="{ search: '' }">

        {{-- Header --}}
        <div>
            <p class="text-primary font-semibold text-xs mb-1 uppercase tracking-widest">Catatan Kehadiran</p>
            <h1 class="text-2xl font-bold text-on-surface">Riwayat Kehadiran Siswa</h1>
            <p class="text-xs text-secondary">Ringkasan tingkat kehadiran seluruh siswa di kelas Anda.</p>
        </div>

        {{-- Stats ringkasan --}}
        @php
            $totalSiswa = $siswaList->count();
            $avgRate = $totalSiswa > 0 ? round($siswaList->avg('rate')) : 0;
            $siswaAktif = $siswaList->where('rate', '>', 0)->count();
        @endphp
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <div class="bg-primary text-white rounded-2xl p-5 flex flex-col items-center text-center shadow-soft">
                <span class="text-[10px] uppercase font-bold tracking-widest opacity-80 mb-1">Rata-rata Kehadiran</span>
                <span class="text-3xl font-bold">{{ $avgRate }}%</span>
            </div>
            <div class="bg-white rounded-2xl p-5 flex flex-col items-center text-center shadow-soft border border-surface-container">
                <span class="text-[10px] uppercase font-bold tracking-widest text-secondary mb-1">Total Siswa</span>
                <span class="text-3xl font-bold text-on-surface">{{ $totalSiswa }}</span>
            </div>
            <div class="bg-white rounded-2xl p-5 flex flex-col items-center text-center shadow-soft border border-surface-container">
                <span class="text-[10px] uppercase font-bold tracking-widest text-secondary mb-1">Pernah Hadir</span>
                <span class="text-3xl font-bold text-on-surface">{{ $siswaAktif }}</span>
            </div>
        </div>

        {{-- Search --}}
        <div class="relative max-w-md">
            <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-secondary text-lg">search</span>
            <input x-model="search" type="text" placeholder="Cari nama siswa atau kelas..."
                   class="w-full pl-11 pr-4 py-3 bg-white rounded-xl border border-surface-container focus:border-primary focus:ring focus:ring-primary/20 text-sm text-on-surface transition-all">
        </div>

        {{-- Tabel --}}
        <div class="bg-white rounded-2xl shadow-soft border border-surface-container overflow-hidden">
            @if($siswaList->isEmpty())
                <div class="p-16 text-center">
                    <span class="material-symbols-outlined text-4xl text-secondary/30">group_off</span>
                    <p class="text-sm font-semibold text-on-surface mt-3">Belum ada siswa di kelas Anda</p>
                    <p class="text-xs text-secondary mt-1">Tambahkan siswa ke kelas terlebih dahulu.</p>
                </div>
            @else
                <table class="w-full text-left">
                    <thead class="bg-surface-container border-b border-surface-container">
                        <tr>
                            <th class="px-6 py-3 text-xs font-semibold text-on-surface uppercase tracking-wider">Siswa</th>
                            <th class="px-6 py-3 text-xs font-semibold text-on-surface uppercase tracking-wider">Kelas</th>
                            <th class="px-6 py-3 text-xs font-semibold text-on-surface uppercase tracking-wider">Hadir / Total Sesi</th>
                            <th class="px-6 py-3 text-xs font-semibold text-on-surface uppercase tracking-wider">Kehadiran</th>
                            <th class="px-6 py-3 text-xs font-semibold text-on-surface uppercase tracking-wider">Detail</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-surface-container">
                        @foreach($siswaList as $item)
                            <tr class="hover:bg-surface-container/30 transition-colors"
                                x-show="search === '' || '{{ strtolower($item['siswa']->name) }}'.includes(search.toLowerCase()) || '{{ strtolower($item['kelas']->nama_kelas ?? '') }}'.includes(search.toLowerCase())">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-9 h-9 rounded-full bg-primary/10 flex items-center justify-center text-primary text-sm font-bold shrink-0">
                                            {{ substr($item['siswa']->name, 0, 1) }}
                                        </div>
                                        <div>
                                            <p class="text-sm font-semibold text-on-surface">{{ $item['siswa']->name }}</p>
                                            <p class="text-xs text-secondary">{{ $item['siswa']->nis ? 'NIS: '.$item['siswa']->nis : $item['siswa']->email }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-sm text-secondary">{{ $item['kelas']->nama_kelas ?? '-' }}</td>
                                <td class="px-6 py-4 text-sm text-on-surface">
                                    <span class="font-semibold">{{ $item['hadir'] }}</span>
                                    <span class="text-secondary"> / {{ $item['totalSesi'] }}</span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3 min-w-[140px]">
                                        <span class="text-sm font-bold w-10 shrink-0
                                            @if($item['rate'] >= 90) text-primary
                                            @elseif($item['rate'] >= 75) text-amber-600
                                            @else text-error @endif">
                                            {{ $item['rate'] }}%
                                        </span>
                                        <div class="flex-1 h-2 bg-surface-container rounded-full overflow-hidden">
                                            <div class="h-full rounded-full transition-all"
                                                 style="width: {{ $item['rate'] }}%; background-color: {{ $item['rate'] >= 90 ? '#005f2d' : ($item['rate'] >= 75 ? '#f59e0b' : '#ba1a1a') }};"></div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <a href="{{ route('presensi.riwayat') }}?siswa_id={{ $item['siswa']->id }}"
                                       class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-primary/10 text-primary rounded-lg text-xs font-semibold hover:bg-primary/20 transition-colors">
                                        <span class="material-symbols-outlined text-[14px]">visibility</span>
                                        Lihat Detail
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
</x-app-layout>
