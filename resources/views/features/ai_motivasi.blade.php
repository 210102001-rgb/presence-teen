<x-app-layout>
    <x-slot name="header">AI Insights & Motivasi</x-slot>

    <div class="p-4 md:p-8 max-w-7xl mx-auto space-y-6">

        {{-- ===== SUMMARIZE AI SECTION ===== --}}
        <div class="bg-white rounded-2xl shadow-soft border border-surface-container overflow-hidden">
            <div class="px-6 py-4 bg-gradient-to-r from-primary to-primary-container flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center">
                        <span class="material-symbols-outlined text-white text-[22px] filled-icon">auto_awesome</span>
                    </div>
                    <div>
                        <h2 class="font-bold text-white text-base">Summarize AI</h2>
                        <p class="text-white/70 text-xs">Upload materi dari guru, AI akan merangkumnya untuk kamu</p>
                    </div>
                </div>
                <span class="hidden sm:flex items-center gap-1.5 bg-white/20 text-white text-[10px] font-bold px-3 py-1 rounded-full">
                    <span class="material-symbols-outlined text-[12px] filled-icon">psychology</span>
                    Powered by Claude AI
                </span>
            </div>

            <div class="p-6">
                @if(session('summarize_error'))
                    <div class="mb-4 p-4 bg-error-container border border-error/20 rounded-xl flex items-start gap-3">
                        <span class="material-symbols-outlined text-error text-[20px] shrink-0">error</span>
                        <p class="text-sm text-on-error-container">{{ session('summarize_error') }}</p>
                    </div>
                @endif

                @if(session('summarize_success') && session('summarize_result'))
                    {{-- Hasil Ringkasan --}}
                    <div class="mb-6 space-y-4">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <span class="material-symbols-outlined text-primary text-[20px] filled-icon">task_alt</span>
                                <h3 class="font-bold text-on-surface text-sm">Ringkasan selesai: <span class="text-primary">{{ session('summarize_judul') }}</span></h3>
                            </div>
                            <a href="{{ route('summarize.download', session('summarize_filename')) }}"
                               class="inline-flex items-center gap-2 px-4 py-2 bg-primary text-white rounded-xl text-xs font-semibold hover:bg-primary-container transition-colors shadow-soft">
                                <span class="material-symbols-outlined text-[16px]">file_download</span>
                                Download Ringkasan (.docx)
                            </a>
                        </div>

                        <div class="bg-surface-container-low rounded-xl p-5 max-h-64 overflow-y-auto border border-surface-container">
                            <div class="prose prose-sm text-on-surface text-sm leading-relaxed whitespace-pre-wrap">{{ session('summarize_result') }}</div>
                        </div>

                        <p class="text-xs text-secondary flex items-center gap-1.5">
                            <span class="material-symbols-outlined text-[14px]">info</span>
                            File ringkasan tersimpan dalam format .docx yang bisa dibuka di Microsoft Word.
                        </p>
                    </div>
                    <div class="border-t border-surface-container pt-6">
                        <p class="text-xs text-secondary mb-4 font-semibold uppercase tracking-wider">Upload Materi Baru</p>
                    </div>
                @endif

                <form action="{{ route('summarize.process') }}" method="POST" enctype="multipart/form-data"
                      x-data="{ fileName: '', loading: false, dragging: false }"
                      @submit="loading = true">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        {{-- Upload Area --}}
                        <div>
                            <label class="block text-xs font-semibold text-secondary uppercase tracking-wider mb-2">
                                Upload File Materi
                            </label>
                            <label
                                class="relative flex flex-col items-center justify-center w-full h-36 border-2 border-dashed rounded-xl cursor-pointer transition-all"
                                :class="dragging ? 'border-primary bg-primary/5' : 'border-outline-variant bg-surface-container-low hover:bg-surface-container hover:border-primary'"
                                @dragover.prevent="dragging = true"
                                @dragleave.prevent="dragging = false"
                                @drop.prevent="dragging = false; fileName = $event.dataTransfer.files[0]?.name; $refs.fileInput.files = $event.dataTransfer.files">
                                <input type="file" name="file" accept=".pdf,.docx,.txt"
                                       x-ref="fileInput" class="hidden"
                                       @change="fileName = $event.target.files[0]?.name">

                                <template x-if="!fileName">
                                    <div class="flex flex-col items-center gap-2 text-secondary">
                                        <span class="material-symbols-outlined text-3xl">upload_file</span>
                                        <p class="text-sm font-medium">Klik atau drag & drop</p>
                                        <p class="text-xs">PDF, DOCX, atau TXT (maks. 10MB)</p>
                                    </div>
                                </template>
                                <template x-if="fileName">
                                    <div class="flex flex-col items-center gap-2 text-primary">
                                        <span class="material-symbols-outlined text-3xl filled-icon">check_circle</span>
                                        <p class="text-sm font-semibold truncate max-w-[200px]" x-text="fileName"></p>
                                        <p class="text-xs text-secondary">Siap diproses</p>
                                    </div>
                                </template>
                            </label>
                            @error('file')
                                <p class="mt-1 text-xs text-error">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Info & Submit --}}
                        <div class="flex flex-col justify-between gap-4">
                            <div class="bg-primary/5 border border-primary/20 rounded-xl p-4 space-y-2">
                                <p class="text-xs font-semibold text-primary">Cara Kerja Summarize AI</p>
                                <ol class="text-xs text-secondary space-y-1.5">
                                    <li class="flex items-start gap-2">
                                        <span class="w-4 h-4 bg-primary text-white rounded-full flex items-center justify-center text-[9px] font-bold shrink-0 mt-0.5">1</span>
                                        Upload file materi dari guru (PDF, DOCX, atau TXT)
                                    </li>
                                    <li class="flex items-start gap-2">
                                        <span class="w-4 h-4 bg-primary text-white rounded-full flex items-center justify-center text-[9px] font-bold shrink-0 mt-0.5">2</span>
                                        AI membaca dan merangkum poin-poin penting
                                    </li>
                                    <li class="flex items-start gap-2">
                                        <span class="w-4 h-4 bg-primary text-white rounded-full flex items-center justify-center text-[9px] font-bold shrink-0 mt-0.5">3</span>
                                        Download ringkasan dalam format dokumen (.docx)
                                    </li>
                                </ol>
                            </div>

                            <button type="submit" :disabled="!fileName || loading"
                                    class="w-full py-3 bg-primary text-white rounded-xl text-sm font-semibold
                                           hover:bg-primary-container transition-colors flex items-center justify-center gap-2 shadow-soft
                                           disabled:opacity-50 disabled:cursor-not-allowed">
                                <template x-if="!loading">
                                    <span class="flex items-center gap-2">
                                        <span class="material-symbols-outlined text-[18px] filled-icon">auto_awesome</span>
                                        Summarize Sekarang
                                    </span>
                                </template>
                                <template x-if="loading">
                                    <span class="flex items-center gap-2">
                                        <svg class="animate-spin w-4 h-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                        </svg>
                                        AI sedang merangkum...
                                    </span>
                                </template>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        {{-- ===== HERO BENTO GRID (existing) ===== --}}
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
                            @php
                                $raw = $laporanAi->first()->hasil_analisis ?? '';
                                // Pecah per baris, ambil baris yang bukan markdown syntax
                                $lines = explode("\n", $raw);
                                $cleanLines = [];
                                foreach ($lines as $line) {
                                    $line = trim($line);
                                    if (empty($line)) continue;
                                    if (preg_match('/^#{1,6}/', $line)) continue;    // skip heading
                                    if (preg_match('/^\|/', $line)) continue;         // skip tabel
                                    if (preg_match('/^-{3,}/', $line)) continue;      // skip separator
                                    if (preg_match('/^\*{3,}/', $line)) continue;     // skip ***
                                    // Strip inline markdown
                                    $line = preg_replace('/\*\*(.+?)\*\*/', '$1', $line);
                                    $line = preg_replace('/\*(.+?)\*/', '$1', $line);
                                    $line = preg_replace('/^[-•]\s+/', '• ', $line);
                                    $cleanLines[] = $line;
                                    // Berhenti setelah 3 baris bermakna
                                    if (count($cleanLines) >= 3) break;
                                }
                                $preview = implode(' ', $cleanLines);
                                $preview = \Illuminate\Support\Str::limit($preview, 200);
                            @endphp
                            <div class="italic text-secondary text-xs border-l-4 border-primary pl-4 py-2 bg-surface rounded-r-xl leading-relaxed">
                                {{ $preview ?: 'Belum ada analisis yang tersedia.' }}
                            </div>
                        @else
                            <div class="italic text-secondary text-xs border-l-4 border-primary pl-4 py-2 bg-surface rounded-r-xl">
                                Belum ada analisis AI yang tersedia untuk siswa ini.
                            </div>
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
