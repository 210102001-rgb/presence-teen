<x-app-layout>
    <x-slot name="header">Data Siswa & Kelas</x-slot>

    <div class="p-4 md:p-8 max-w-7xl mx-auto space-y-6">
        <div>
            <p class="text-primary font-semibold text-xs mb-1 uppercase tracking-widest">Students & Classes</p>
            <h1 class="text-2xl font-bold text-on-surface">Data Siswa & Kelas</h1>
            <p class="text-xs text-secondary">Daftar siswa terdaftar pada kelas yang Anda ampu.</p>
        </div>

        <div class="space-y-8">
            @forelse($kelas as $k)
                <div class="bg-white rounded-2xl shadow-soft border border-surface-container overflow-hidden">
                    <div class="p-5 bg-background border-b border-surface-container flex justify-between items-center">
                        <div>
                            <h3 class="font-bold text-base text-on-surface">{{ $k->nama_kelas }}</h3>
                            <p class="text-xs text-secondary">{{ $k->mata_pelajaran }}</p>
                        </div>
                        <span class="px-3 py-1 bg-primary/10 text-primary rounded-full text-xs font-bold">{{ $k->siswa->count() }} Siswa</span>
                    </div>
                    <div class="p-5">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="text-secondary text-[11px] font-bold uppercase tracking-wider border-b border-surface-container">
                                    <th class="pb-3 w-1/12">No</th>
                                    <th class="pb-3 w-4/12">Nama Siswa</th>
                                    <th class="pb-3 w-4/12">Email</th>
                                    <th class="pb-3 w-3/12">NIS</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-surface-container text-xs">
                                @forelse($k->siswa as $index => $siswa)
                                    <tr class="hover:bg-background/20">
                                        <td class="py-3 font-medium text-secondary">{{ $index + 1 }}</td>
                                        <td class="py-3 font-semibold text-on-surface">{{ $siswa->name }}</td>
                                        <td class="py-3 text-secondary">{{ $siswa->email }}</td>
                                        <td class="py-3 text-secondary font-mono">{{ $siswa->nis ?? '-' }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="py-4 text-center text-secondary">Belum ada siswa terdaftar di kelas ini.</td>
                                    </tr>
                                @endempty
                            </tbody>
                        </table>
                    </div>
                </div>
            @empty
                <div class="bg-white rounded-2xl shadow-soft border border-surface-container p-12 text-center text-secondary">
                    Anda belum mengampu kelas apapun.
                </div>
            @endforelse
        </div>
    </div>
</x-app-layout>
