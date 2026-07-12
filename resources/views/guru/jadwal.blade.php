<x-app-layout>
    <x-slot name="header">Jadwal Mengajar</x-slot>

    <div class="p-4 md:p-8 max-w-7xl mx-auto space-y-6">
        <div>
            <p class="text-primary font-semibold text-xs mb-1 uppercase tracking-widest">Class Schedule</p>
            <h1 class="text-2xl font-bold text-on-surface">Jadwal Mengajar</h1>
            <p class="text-xs text-secondary">Daftar kelas dan mata pelajaran yang Anda ampu.</p>
        </div>

        <div class="bg-white rounded-2xl shadow-soft border border-surface-container overflow-hidden">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-background text-secondary text-xs font-bold uppercase tracking-wider border-b border-surface-container">
                        <th class="p-4">Nama Kelas</th>
                        <th class="p-4">Mata Pelajaran</th>
                        <th class="p-4">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-surface-container text-sm">
                    @forelse($kelas as $k)
                        <tr class="hover:bg-background/50 transition-colors">
                            <td class="p-4 font-semibold text-on-surface">{{ $k->nama_kelas }}</td>
                            <td class="p-4 text-secondary">{{ $k->mata_pelajaran }}</td>
                            <td class="p-4">
                                <a href="{{ route('presensi.guru.qr', $k->id) }}" class="inline-flex items-center gap-1 text-xs font-bold text-primary hover:underline">
                                    Mulai Sesi <span class="material-symbols-outlined text-[14px]">arrow_forward</span>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="p-8 text-center text-secondary">Belum ada jadwal mengajar yang terdaftar.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
