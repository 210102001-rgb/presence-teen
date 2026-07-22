<x-app-layout>
    <x-slot name="header">Dashboard Siswa</x-slot>

    <div class="lg:p-8">

        <div class="lg:hidden px-5 pt-6 pb-24 space-y-6 max-w-lg mx-auto">
            <section>
                <h2 class="text-xl font-semibold text-on-surface">Hi, {{ explode(' ', Auth::user()->name)[0] }} 👋</h2>
                <p class="text-sm text-secondary mt-1">Let's make today productive.</p>
            </section>

            <div class="flex items-center gap-2">
                <span class="material-symbols-outlined text-secondary">search</span>
                <input type="text" placeholder="Cari pelajaran, jadwal..."
                       class="flex-1 min-w-0 px-4 py-2.5 border border-outline-variant rounded-xl text-sm text-on-surface
                              focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary">
            </div>

            <section class="space-y-3">
                <div class="flex justify-between items-center">
                    <h3 class="text-sm font-semibold text-on-surface">Quick Access</h3>
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <a href="{{ route('presensi.scan') }}"
                       class="bg-white p-4 rounded-xl shadow-soft flex flex-col items-center text-center gap-2 border-l-4 border-primary active:scale-95 transition-transform">
                        <div class="w-12 h-12 bg-primary/10 rounded-full flex items-center justify-center">
                            <span class="material-symbols-outlined text-primary">how_to_reg</span>
                        </div>
                        <span class="text-sm font-semibold text-on-surface">Sesi Presensi</span>
                    </a>
                    {{-- Kelas: dihilangkan (tidak relevan untuk siswa)
                    <a href="{{ route('tugas.index') }}"
                       class="bg-white p-4 rounded-xl shadow-soft flex flex-col items-center text-center gap-2 border-l-4 border-primary active:scale-95 transition-transform">
                        <div class="w-12 h-12 bg-primary/10 rounded-full flex items-center justify-center">
                            <span class="material-symbols-outlined text-primary">groups</span>
                        </div>
                        <span class="text-sm font-semibold text-on-surface">Kelas</span>
                    </a>
                    --}}
                    {{-- Jadwal: dihilangkan (belum ada halaman jadwal siswa)
                    <a href="#"
                       class="bg-white p-4 rounded-xl shadow-soft flex flex-col items-center text-center gap-2 border-l-4 border-primary active:scale-95 transition-transform">
                        <div class="w-12 h-12 bg-primary/10 rounded-full flex items-center justify-center">
                            <span class="material-symbols-outlined text-primary">calendar_month</span>
                        </div>
                        <span class="text-sm font-semibold text-on-surface">Jadwal</span>
                    </a>
                    --}}
                    <a href="{{ route('materi.index') }}"
                       class="bg-white p-4 rounded-xl shadow-soft flex flex-col items-center text-center gap-2 border-l-4 border-primary active:scale-95 transition-transform">
                        <div class="w-12 h-12 bg-primary/10 rounded-full flex items-center justify-center">
                            <span class="material-symbols-outlined text-primary">library_books</span>
                        </div>
                        <span class="text-sm font-semibold text-on-surface">Materi</span>
                    </a>
                    <a href="{{ route('tugas.index') }}"
                       class="bg-white p-4 rounded-xl shadow-soft flex flex-col items-center text-center gap-2 border-l-4 border-primary col-span-2 active:scale-95 transition-transform">
                        <div class="w-12 h-12 bg-primary/10 rounded-full flex items-center justify-center">
                            <span class="material-symbols-outlined text-primary">assignment</span>
                        </div>
                        <span class="text-sm font-semibold text-on-surface">Tugas</span>
                    </a>
                    <a href="{{ route('aktivitas.index') }}"
                       class="bg-white p-4 rounded-xl shadow-soft flex flex-col items-center text-center gap-2 border-l-4 border-primary active:scale-95 transition-transform">
                        <div class="w-12 h-12 bg-primary/10 rounded-full flex items-center justify-center">
                            <span class="material-symbols-outlined text-primary">timer</span>
                        </div>
                        <span class="text-sm font-semibold text-on-surface">Aktivitas Belajar</span>
                    </a>
                    <a href="{{ route('motivasi.index') }}"
                       class="bg-white p-4 rounded-xl shadow-soft flex flex-col items-center text-center gap-2 border-l-4 border-primary active:scale-95 transition-transform">
                        <div class="w-12 h-12 bg-primary/10 rounded-full flex items-center justify-center">
                            <span class="material-symbols-outlined text-primary">auto_awesome</span>
                        </div>
                        <span class="text-sm font-semibold text-on-surface">AI Analisis</span>
                    </a>
                    <a href="{{ route('pengumuman.index') }}"
                       class="bg-white p-4 rounded-xl shadow-soft flex flex-col items-center text-center gap-2 border-l-4 border-primary active:scale-95 transition-transform">
                        <div class="w-12 h-12 bg-primary/10 rounded-full flex items-center justify-center">
                            <span class="material-symbols-outlined text-primary">campaign</span>
                        </div>
                        <span class="text-sm font-semibold text-on-surface">Pengumuman</span>
                    </a>
                    <a href="{{ route('profile.edit') }}"
                       class="bg-white p-4 rounded-xl shadow-soft flex flex-col items-center text-center gap-2 border-l-4 border-primary active:scale-95 transition-transform">
                        <div class="w-12 h-12 bg-primary/10 rounded-full flex items-center justify-center">
                            <span class="material-symbols-outlined text-primary">manage_accounts</span>
                        </div>
                        <span class="text-sm font-semibold text-on-surface">Profil</span>
                    </a>
                </div>
            </section>

            @if($jadwalOngoing)
                <section class="bg-surface-container-high rounded-xl p-5 space-y-3">
                    <div class="flex items-center justify-between">
                        <span class="bg-primary/20 text-primary px-3 py-1 rounded-full text-xs font-bold">ONGOING</span>
                        <span class="text-xs font-medium text-secondary">{{ $jadwalOngoing->jam_label }}</span>
                    </div>
                    <div>
                        <h3 class="text-xl font-semibold text-on-surface">{{ $jadwalOngoing->mata_pelajaran }}</h3>
                        <p class="text-sm text-on-surface-variant">{{ $jadwalOngoing->ruang ?? 'Ruang -' }} &bull; {{ $jadwalOngoing->guru->name ?? '-' }}</p>
                    </div>
                    @if($jadwalOngoing->kelas)
                        @php $classmates = $jadwalOngoing->kelas->siswa()->where('users.id', '!=', Auth::id())->limit(3)->get(); @endphp
                        @if($classmates->isNotEmpty())
                            <div class="flex -space-x-2">
                                @foreach($classmates as $mate)
                                    <div class="w-8 h-8 rounded-full border-2 border-surface bg-primary-fixed flex items-center justify-center text-xs font-bold text-primary">
                                        {{ substr($mate->name, 0, 1) }}
                                    </div>
                                @endforeach
                                @php $totalClassmates = $jadwalOngoing->kelas->siswa()->count() - 1; @endphp
                                @if($totalClassmates > 3)
                                    <div class="w-8 h-8 rounded-full border-2 border-surface bg-primary/10 flex items-center justify-center text-[10px] font-bold text-primary">
                                        +{{ $totalClassmates - 3 }}
                                    </div>
                                @endif
                            </div>
                        @endif
                    @endif
                </section>
            @elseif($jadwalHariIni->isNotEmpty())
                @php $nextJadwal = $jadwalHariIni->first(fn($j) => now()->format('H:i:s') < $j->jam_mulai) ?? $jadwalHariIni->last(); @endphp
                <section class="bg-surface-container-high rounded-xl p-5 space-y-3">
                    <div class="flex items-center justify-between">
                        <span class="bg-tertiary/20 text-tertiary px-3 py-1 rounded-full text-xs font-bold">MENDATANG</span>
                        <span class="text-xs font-medium text-secondary">{{ $nextJadwal->jam_label }}</span>
                    </div>
                    <div>
                        <h3 class="text-xl font-semibold text-on-surface">{{ $nextJadwal->mata_pelajaran }}</h3>
                        <p class="text-sm text-on-surface-variant">{{ $nextJadwal->ruang ?? 'Ruang -' }} &bull; {{ $nextJadwal->guru->name ?? '-' }}</p>
                    </div>
                </section>
            @endif
        </div>

        <div class="hidden lg:block p-4 md:p-8">
            <div class="mb-8">
                <h2 class="text-2xl font-bold text-on-surface">Selamat Datang, {{ Auth::user()->name }} 👋</h2>
                <p class="text-sm text-on-surface-variant mt-1">Semangat belajar! Pantau tugas, presensi, dan materi pelajaranmu.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-5 mb-8">
                <div class="bg-primary text-on-primary rounded-xl p-5 shadow-soft">
                    <div class="flex justify-between items-start mb-3">
                        <p class="text-[11px] uppercase tracking-widest text-on-primary/70 font-semibold">Kehadiran Bulan Ini</p>
                        <div class="w-9 h-9 bg-white/15 rounded-xl flex items-center justify-center">
                            <span class="material-symbols-outlined text-on-primary text-[20px] filled-icon">calendar_month</span>
                        </div>
                    </div>
                    <p class="text-4xl font-bold">{{ $kehadiranBulanIni }}</p>
                    <p class="text-xs text-on-primary/60 mt-1">Kali hadir bulan ini</p>
                </div>

                <div class="bg-white rounded-xl p-5 shadow-soft border-t-4 border-tertiary">
                    <div class="flex justify-between items-start mb-3">
                        <p class="text-[11px] uppercase tracking-widest text-secondary font-semibold">Total Tugas</p>
                        <div class="w-9 h-9 bg-surface-container rounded-xl flex items-center justify-center">
                            <span class="material-symbols-outlined text-tertiary text-[20px]">assignment</span>
                        </div>
                    </div>
                    <p class="text-4xl font-bold text-on-surface">{{ $totalTugas }}</p>
                    <p class="text-xs text-secondary mt-1">{{ $tugasSelesai }} selesai bulan ini</p>
                </div>

                <div class="bg-white rounded-xl p-5 shadow-soft border-t-4 border-primary">
                    <div class="flex justify-between items-start mb-3">
                        <p class="text-[11px] uppercase tracking-widest text-secondary font-semibold">Materi Tersedia</p>
                        <div class="w-9 h-9 bg-primary-fixed rounded-xl flex items-center justify-center">
                            <span class="material-symbols-outlined text-primary text-[20px]">menu_book</span>
                        </div>
                    </div>
                    <p class="text-4xl font-bold text-on-surface">{{ $totalMateri }}</p>
                    <p class="text-xs text-secondary mt-1">Siap dipelajari</p>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <div class="lg:col-span-2 bg-white rounded-xl shadow-soft border border-surface-container">
                    <div class="px-6 py-4 border-b border-surface-container flex justify-between items-center">
                        <h4 class="font-semibold text-on-surface">Tugas Perlu Dikumpul</h4>
                        <a href="{{ route('tugas.index') }}" class="text-xs font-semibold text-primary hover:underline">Lihat Semua</a>
                    </div>
                    @if($tugasBelum->isEmpty())
                        <div class="p-12 text-center">
                            <span class="material-symbols-outlined text-primary filled-icon text-5xl">check_circle</span>
                            <p class="text-sm font-medium text-on-surface mt-3">Semua tugas sudah dikumpulkan!</p>
                            <p class="text-xs text-secondary mt-1">Tidak ada tugas yang pending.</p>
                        </div>
                    @else
                        <div class="divide-y divide-surface-container-low">
                            @foreach($tugasBelum as $t)
                                @php $isClose = $t->deadline->diffInDays(now()) <= 2; @endphp
                                <div class="flex items-center justify-between px-6 py-3.5 hover:bg-surface-container-low transition-colors group">
                                    <div class="flex items-center gap-3 min-w-0">
                                        <div class="w-9 h-9 rounded-xl flex items-center justify-center shrink-0
                                             {{ $isClose ? 'bg-error-container' : 'bg-primary-fixed' }}">
                                            <span class="material-symbols-outlined text-[18px]
                                                 {{ $isClose ? 'text-error' : 'text-primary' }}">assignment</span>
                                        </div>
                                        <div class="min-w-0">
                                            <p class="text-sm font-semibold text-on-surface truncate">{{ $t->judul }}</p>
                                            <div class="flex items-center gap-1.5 mt-0.5">
                                                <span class="text-xs text-secondary">{{ $t->kelas->nama_kelas ?? '-' }}</span>
                                                <span class="text-surface-container-highest">&middot;</span>
                                                <span class="text-xs {{ $isClose ? 'text-error font-semibold' : 'text-secondary' }}">
                                                    Deadline {{ $t->deadline->format('d M Y') }}
                                                </span>
                                                @if($isClose)
                                                    <span class="px-1.5 py-0.5 bg-error-container text-on-error-container text-[9px] font-bold rounded-full uppercase">Segera</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <a href="{{ route('tugas.show', $t) }}"
                                        class="shrink-0 ml-3 inline-flex items-center gap-1 px-3 py-1.5 bg-primary text-on-primary text-xs font-semibold rounded-lg hover:bg-primary-container transition-colors lg:opacity-0 lg:group-hover:opacity-100">
                                        Kumpul
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>

                <div class="flex flex-col gap-4">
                    <div class="bg-white rounded-xl shadow-soft p-5 border border-surface-container flex flex-col items-center text-center">
                        <div class="w-14 h-14 bg-primary-fixed rounded-full flex items-center justify-center mb-3">
                            <span class="material-symbols-outlined text-primary filled-icon text-3xl">qr_code_scanner</span>
                        </div>
                        <h4 class="font-semibold text-on-surface mb-1">Scan Presensi</h4>
                        <p class="text-xs text-secondary mb-4">Scan QR Code guru untuk catat kehadiran.</p>
                        <a href="{{ route('presensi.scan') }}"
                           class="w-full py-2.5 bg-primary text-on-primary text-sm font-semibold rounded-xl hover:bg-primary-container transition-colors text-center block">
                            Buka Scanner
                        </a>
                    </div>

                    <div class="bg-white rounded-xl shadow-soft p-5 border border-surface-container">
                        <div class="w-10 h-10 bg-primary-fixed rounded-xl flex items-center justify-center mb-3">
                            <span class="material-symbols-outlined text-primary filled-icon">auto_awesome</span>
                        </div>
                        <h4 class="font-semibold text-on-surface mb-1">Materi & Ringkasan AI</h4>
                        <p class="text-xs text-secondary mb-3">Akses materi + ringkasan otomatis Claude AI.</p>
                        <a href="{{ route('materi.index') }}"
                           class="inline-flex items-center gap-1 text-sm font-semibold text-primary hover:text-primary-container">
                            Lihat Materi <span class="material-symbols-outlined text-[16px]">arrow_forward</span>
                        </a>
                    </div>
                </div>
            </div>

            <div class="mt-6 ai-glow rounded-xl p-5 flex items-center gap-4">
                <span class="material-symbols-outlined text-primary filled-icon text-2xl shrink-0">auto_awesome</span>
                <p class="text-sm text-on-surface-variant">
                    <span class="font-semibold text-primary">Tips:</span>
                    Konsistensi kehadiran dan ketepatan mengumpulkan tugas adalah kunci nilai terbaik!
                </p>
            </div>
        </div>
    </div>
</x-app-layout>
