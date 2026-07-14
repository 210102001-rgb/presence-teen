<x-app-layout>
    <x-slot name="header">AI Insights & Motivasi</x-slot>

    <div class="p-4 md:p-8 max-w-7xl mx-auto space-y-6">
        {{-- Hero Bento Grid Section --}}
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-stretch">
            {{-- AI Avatar & High-Level Insights --}}
            <div class="lg:col-span-8 bg-white rounded-2xl shadow-soft border border-surface-container overflow-hidden flex flex-col md:flex-row relative">
                <div class="absolute top-4 right-4 z-10">
                    <span class="flex items-center gap-1 bg-surface-container-lowest text-primary px-3 py-1 rounded-full text-[10px] font-bold border border-primary-container/20">
                        <span class="material-symbols-outlined filled-icon text-[12px]">verified</span>
                        {{ $akurasi }}% Akurasi Model AI
                    </span>
                </div>
                <div class="w-full md:w-1/3 bg-surface p-6 flex flex-col items-center justify-center text-center border-r border-surface-container">
                    <div class="w-28 h-28 rounded-full border-4 border-primary-fixed p-1 mb-4 flex items-center justify-center bg-primary-container/10">
                        <span class="material-symbols-outlined text-[64px] text-primary">psychology</span>
                    </div>
                    <h3 class="font-bold text-sm text-primary">AcademAI Engine</h3>
                    <p class="text-[10px] text-secondary mt-1 leading-normal">Mesin rekomendasi motivasi & belajar presisi</p>
                </div>
                <div class="w-full md:w-2/3 p-6 flex flex-col justify-between">
                    <div class="space-y-4">
                        <p class="text-[9px] text-secondary font-bold uppercase tracking-widest">Analisis Hari Ini</p>
                        <h2 class="text-lg font-bold text-on-surface leading-snug">
                            {{ $siswa->name }} saat ini beraktivitas dengan klasifikasi <strong>{{ $klasifikasi }}</strong>.
                        </h2>
                        @if($laporanAi->isNotEmpty())
                            <blockquote class="italic text-secondary text-xs border-l-4 border-primary pl-4 py-2 bg-surface rounded-r-xl">
                                {!! nl2br(e(Str::limit($laporanAi->first()->hasil_analisis, 200))) !!}
                            </blockquote>
                        @else
                            <blockquote class="italic text-secondary text-xs border-l-4 border-primary pl-4 py-2 bg-surface rounded-r-xl">
                                Belum ada analisis AI yang tersedia untuk siswa ini.
                            </blockquote>
                        @endif
                    </div>
                    <div class="mt-6 flex flex-wrap gap-4">
                        <div class="px-4 py-2 bg-surface-container-lowest rounded-xl flex items-center gap-2 border border-primary-container/10">
                            <span class="material-symbols-outlined text-primary text-[18px]">trending_up</span>
                            <div>
                                <p class="text-[8px] text-secondary font-bold uppercase">Klasifikasi</p>
                                <p class="text-[10px] font-bold text-primary">{{ $klasifikasi }}</p>
                            </div>
                        </div>
                        <div class="px-4 py-2 bg-surface-container-lowest rounded-xl flex items-center gap-2 border border-primary-container/10">
                            <span class="material-symbols-outlined text-primary-container text-[18px]">security</span>
                            <div>
                                <p class="text-[8px] text-secondary font-bold uppercase">Tingkat Risiko</p>
                                <p class="text-[10px] font-bold text-primary">{{ $risiko }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Achievement Badge --}}
            <div class="lg:col-span-4 bg-white rounded-2xl shadow-soft border border-surface-container p-6 flex flex-col items-center justify-center text-center">
                <p class="text-[9px] text-secondary font-bold uppercase tracking-widest mb-4">Ringkasan Kehadiran</p>
                <div class="w-16 h-16 bg-surface-container-lowest rounded-full border border-primary-container/20 flex items-center justify-center text-primary-container mb-4">
                    <span class="material-symbols-outlined text-3xl">{{ $tingkatKehadiran >= 90 ? 'workspace_premium' : 'trending_up' }}</span>
                </div>
                <h3 class="font-bold text-sm text-on-surface">{{ $tingkatKehadiran }}% Kehadiran</h3>
                <p class="text-xs text-secondary mt-2 px-2 leading-relaxed">
                    {{ $tingkatKehadiran >= 95 ? 'Prestasi luar biasa! Kehadiran sangat konsisten.' : ($tingkatKehadiran >= 85 ? 'Kehadiran cukup baik. Pertahankan dan tingkatkan lagi!' : 'Perlu peningkatan kehadiran untuk mencapai target sekolah.') }}
                </p>
                <div class="mt-4 w-full space-y-2">
                    <div class="flex justify-between text-[10px]">
                        <span class="text-secondary">Tugas Selesai</span>
                        <span class="font-bold text-on-surface">{{ $tugasSelesai }}/{{ $totalTugas }}</span>
                    </div>
                    <div class="w-full bg-surface rounded-full h-2 border border-surface-container overflow-hidden">
                        <div class="h-full bg-primary rounded-full" style="width: {{ $totalTugas > 0 ? round(($tugasSelesai / $totalTugas) * 100) : 0 }}%;"></div>
                    </div>
                </div>
                <a href="{{ route('presensi.riwayat', ['siswa_id' => $siswa->id]) }}" class="mt-4 w-full py-2.5 bg-primary hover:bg-primary-container text-white rounded-xl text-xs font-bold transition-all active:scale-95 shadow-soft inline-flex items-center justify-center gap-1">
                    <span class="material-symbols-outlined text-[16px]">history</span>
                    Lihat Riwayat
                </a>
            </div>
        </div>

        {{-- Recommendations Section --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            {{-- Recommendations for Parents --}}
            <div class="bg-white rounded-2xl shadow-soft border border-surface-container overflow-hidden">
                <div class="bg-surface px-6 py-4 border-b border-surface-container flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <span class="material-symbols-outlined text-primary">family_restroom</span>
                        <h4 class="font-bold text-sm text-on-surface">Panduan untuk Orang Tua</h4>
                    </div>
                    <span class="px-2.5 py-0.5 bg-surface-container-lowest border border-primary-container/20 text-primary rounded-full text-[9px] font-bold">REKOMENDASI AI</span>
                </div>
                <div class="p-6 space-y-4">
                    @if($tingkatKehadiran >= 95)
                        <div class="flex gap-4 p-4 hover:bg-surface rounded-xl border border-transparent hover:border-surface-container transition-all">
                            <div class="w-10 h-10 rounded-full bg-surface-container-lowest flex items-center justify-center shrink-0 border border-surface-container">
                                <span class="material-symbols-outlined text-secondary text-[20px]">celebration</span>
                            </div>
                            <div>
                                <h5 class="text-xs font-bold text-on-surface">Pertahankan Konsistensi</h5>
                                <p class="text-xs text-secondary mt-1 leading-relaxed">{{ $siswa->name }} menunjukkan kehadiran yang sangat konsisten. Puji dan berikan motivasi agar terus mempertahankan pencapaian ini.</p>
                            </div>
                        </div>
                    @else
                        <div class="flex gap-4 p-4 hover:bg-surface rounded-xl border border-transparent hover:border-surface-container transition-all">
                            <div class="w-10 h-10 rounded-full bg-surface-container-lowest flex items-center justify-center shrink-0 border border-surface-container">
                                <span class="material-symbols-outlined text-secondary text-[20px]">menu_book</span>
                            </div>
                            <div>
                                <h5 class="text-xs font-bold text-on-surface">Dukung Kehadiran</h5>
                                <p class="text-xs text-secondary mt-1 leading-relaxed">Tingkat kehadiran {{ $siswa->name }} adalah {{ $tingkatKehadiran }}%. Diskusikan bersama untuk mencari solusi agar lebih konsisten hadir ke sekolah.</p>
                            </div>
                        </div>
                    @endif
                    @if($tugasTerlambat > 0)
                        <div class="flex gap-4 p-4 hover:bg-surface rounded-xl border border-transparent hover:border-surface-container transition-all">
                            <div class="w-10 h-10 rounded-full bg-surface-container-lowest flex items-center justify-center shrink-0 border border-surface-container">
                                <span class="material-symbols-outlined text-secondary text-[20px]">schedule</span>
                            </div>
                            <div>
                                <h5 class="text-xs font-bold text-on-surface">Perhatikan Pengumpulan Tugas</h5>
                                <p class="text-xs text-secondary mt-1 leading-relaxed">Ada {{ $tugasTerlambat }} tugas yang terlambat dikumpulkan. Bantu {{ $siswa->name }} mengatur waktu belajar di rumah.</p>
                            </div>
                        </div>
                    @endif
                    <div class="flex gap-4 p-4 hover:bg-surface rounded-xl border border-transparent hover:border-surface-container transition-all">
                        <div class="w-10 h-10 rounded-full bg-surface-container-lowest flex items-center justify-center shrink-0 border border-surface-container">
                            <span class="material-symbols-outlined text-secondary text-[20px]">forum</span>
                        </div>
                        <div>
                            <h5 class="text-xs font-bold text-on-surface">Komunikasi Aktif dengan Guru</h5>
                            <p class="text-xs text-secondary mt-1 leading-relaxed">Pantau perkembangan {{ $siswa->name }} melalui laporan berkala yang tersedia di dashboard.</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Recommendations for Student --}}
            <div class="bg-white rounded-2xl shadow-soft border border-surface-container overflow-hidden">
                <div class="bg-surface px-6 py-4 border-b border-surface-container flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <span class="material-symbols-outlined text-primary">person</span>
                        <h4 class="font-bold text-sm text-on-surface">Misi Mingguan Siswa</h4>
                    </div>
                    <span class="px-2.5 py-0.5 bg-primary text-white rounded-full text-[9px] font-bold">AKTIF</span>
                </div>
                <div class="p-6 space-y-4">
                    @if($tugasSelesai < $totalTugas)
                        <div class="flex gap-4 p-4 bg-surface-container-lowest rounded-xl border border-primary-container/20 relative">
                            <div class="w-10 h-10 rounded-full bg-primary/10 text-primary flex items-center justify-center shrink-0 border border-primary-container/20">
                                <span class="material-symbols-outlined text-[20px]">fitness_center</span>
                            </div>
                            <div>
                                <h5 class="text-xs font-bold text-on-primary-fixed-variant">Selesaikan Tugas Tertunda</h5>
                                <p class="text-xs text-tertiary mt-1 leading-relaxed">Masih ada {{ $totalTugas - $tugasSelesai }} tugas yang belum dikumpulkan. Menyelesaikannya akan meningkatkan indeks keaktifan belajar.</p>
                            </div>
                        </div>
                    @else
                        <div class="flex gap-4 p-4 bg-surface-container-lowest rounded-xl border border-primary-container/20 relative">
                            <div class="w-10 h-10 rounded-full bg-primary/10 text-primary flex items-center justify-center shrink-0 border border-primary-container/20">
                                <span class="material-symbols-outlined text-[20px]">emoji_events</span>
                            </div>
                            <div>
                                <h5 class="text-xs font-bold text-on-primary-fixed-variant">Semua Tugas Selesai!</h5>
                                <p class="text-xs text-tertiary mt-1 leading-relaxed">Kerja bagus! Semua tugas telah dikumpulkan tepat waktu. Pertahankan semangat ini.</p>
                            </div>
                        </div>
                    @endif
                    <div class="flex gap-4 p-4 hover:bg-surface rounded-xl border border-transparent hover:border-surface-container transition-all">
                        <div class="w-10 h-10 rounded-full bg-surface-container-lowest flex items-center justify-center shrink-0 border border-surface-container">
                            <span class="material-symbols-outlined text-secondary text-[20px]">explore</span>
                        </div>
                        <div>
                            <h5 class="text-xs font-bold text-on-surface">Jaga Konsistensi Kehadiran</h5>
                            <p class="text-xs text-secondary mt-1 leading-relaxed">Tingkat kehadiranmu saat ini {{ $tingkatKehadiran }}%. Terus pertahankan agar mencapai target minimal 95%.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
