<x-app-layout>
    <x-slot name="header">Prediksi Absensi AI</x-slot>

    <div class="p-4 md:p-8 max-w-7xl mx-auto space-y-6">
        {{-- Dashboard Header / AI Insight --}}
        <div class="bg-surface-container-lowest border border-primary-container/20 rounded-2xl p-6 shadow-soft flex flex-col md:flex-row items-start md:items-center justify-between gap-4 relative overflow-hidden">
            <div class="absolute right-0 top-0 p-4 opacity-5 pointer-events-none">
                <span class="material-symbols-outlined text-[80px] text-primary-container">auto_awesome</span>
            </div>
            <div class="flex items-start gap-4">
                <div class="w-12 h-12 bg-primary/10 text-primary rounded-xl flex items-center justify-center shrink-0">
                    <span class="material-symbols-outlined filled-icon">auto_awesome</span>
                </div>
                <div>
                    <h3 class="font-bold text-primary text-sm mb-1">AI Insight: Prediksi Absensi & Risiko</h3>
                    <p class="text-xs text-tertiary leading-relaxed max-w-2xl">
                        {{ $siswa->name }} saat ini memiliki tingkat kehadiran <strong>{{ $tingkatKehadiran }}%</strong>.
                        Prediksi kehadiran bulan depan: <strong>{{ $prediksiBulanDepan }}%</strong>.
                        Risiko ketidakhadiran: <strong class="{{ $risikoColor }}">{{ $risiko }}</strong>.
                    </p>
                </div>
            </div>
            <a href="{{ route('presensi.riwayat', ['siswa_id' => $siswa->id]) }}" class="shrink-0 bg-primary text-white px-5 py-2.5 rounded-xl text-xs font-semibold hover:bg-primary-container transition-all shadow-soft z-10 self-stretch md:self-auto text-center inline-flex items-center gap-1">
                <span class="material-symbols-outlined text-[16px]">history</span>
                Lihat Riwayat
            </a>
        </div>

        {{-- Bento Grid Layout --}}
        <div class="grid grid-cols-1 md:grid-cols-12 gap-6">
            {{-- Key Prediction Card 1 --}}
            <div class="md:col-span-3 bg-white p-6 rounded-2xl border border-surface-container shadow-soft flex flex-col justify-between">
                <div class="flex justify-between items-start mb-4">
                    <span class="material-symbols-outlined text-primary bg-surface-container-lowest p-2.5 rounded-xl border border-primary-container/20">event_available</span>
                    <span class="text-[9px] text-primary font-bold bg-surface-container-lowest px-2.5 py-[2px] rounded-full">{{ $tingkatKehadiran >= 90 ? '+' : '' }}{{ $tingkatKehadiran >= 95 ? '1.2' : ($tingkatKehadiran >= 90 ? '0.5' : '-0.3') }}%</span>
                </div>
                <div>
                    <p class="text-secondary font-bold text-[9px] uppercase tracking-wider">Prediksi Kehadiran</p>
                    <h4 class="text-3xl font-bold text-on-surface mt-1">{{ $prediksiBulanDepan }}%</h4>
                </div>
                <p class="text-[10px] text-secondary mt-3">Target minimal sekolah: 95.0%</p>
            </div>

            {{-- Key Prediction Card 2 --}}
            <div class="md:col-span-3 bg-white p-6 rounded-2xl border border-surface-container shadow-soft flex flex-col justify-between">
                <div class="flex justify-between items-start mb-4">
                    <span class="material-symbols-outlined {{ $totalAlpha > 3 ? 'text-error bg-error-container/30 border border-error/20' : 'text-amber-600 bg-amber-50 border border-amber-200' }} p-2.5 rounded-xl">warning</span>
                    <span class="text-[9px] font-bold px-2.5 py-[2px] rounded-full {{ $totalAlpha > 3 ? 'text-error bg-error-container/30' : 'text-amber-700 bg-amber-100' }}">{{ $totalAlpha > 3 ? 'Tinggi' : 'Rendah' }}</span>
                </div>
                <div>
                    <p class="text-secondary font-bold text-[9px] uppercase tracking-wider">Total Alpha</p>
                    <h4 class="text-3xl font-bold text-on-surface mt-1">{{ $totalAlpha }} Hari</h4>
                </div>
                <p class="text-[10px] text-secondary mt-3">Dari {{ $totalSesi }} sesi tercatat</p>
            </div>

            {{-- Confidence Score --}}
            <div class="md:col-span-6 bg-white p-6 rounded-2xl border border-surface-container shadow-soft flex flex-col justify-between">
                <div class="flex justify-between mb-4">
                    <div>
                        <h4 class="font-bold text-sm text-on-surface">Tingkat Akurasi Model AI</h4>
                        <p class="text-[10px] text-secondary">Reliabilitas analisis prediksi saat ini</p>
                    </div>
                    <div class="text-right">
                        <span class="text-2xl font-bold text-primary">{{ $akurasi }}%</span>
                        <p class="text-[9px] text-primary font-bold uppercase">Sangat Tinggi</p>
                    </div>
                </div>
                <div class="w-full bg-surface rounded-full h-3 border border-surface-container overflow-hidden">
                    <div class="h-full bg-primary rounded-full" style="width: {{ $akurasi }}%;"></div>
                </div>
                <p class="text-[10px] text-secondary mt-2">Dihitung berdasarkan riwayat kehadiran dan tugas siswa.</p>
            </div>

            {{-- Trend Chart Container (Col-span 8) --}}
            <div class="md:col-span-8 bg-white p-6 rounded-2xl border border-surface-container shadow-soft flex flex-col justify-between min-h-[300px]">
                <div class="flex justify-between items-center mb-6">
                    <h4 class="font-bold text-sm text-on-surface">Prediksi Tren Kehadiran Semester Ini</h4>
                    <div class="flex gap-4">
                        <span class="flex items-center gap-1.5 text-xs text-secondary"><span class="w-2.5 h-2.5 rounded-full bg-primary"></span> Riwayat Asli</span>
                        <span class="flex items-center gap-1.5 text-xs text-secondary"><span class="w-2.5 h-2.5 rounded-full bg-tertiary border border-primary border-dashed"></span> Prediksi AI</span>
                    </div>
                </div>
                <div class="h-44 w-full flex items-end gap-4 pt-4">
                    @foreach($months as $i => $month)
                        @php
                            $isLast = $loop->last;
                            $val = $trendData[$i] ?? 100;
                        @endphp
                        <div class="flex-1 flex flex-col items-center gap-2">
                            <div class="w-full bg-surface rounded-t-xl h-[90%] relative border border-surface-container">
                                <div class="absolute bottom-0 w-full rounded-t-xl {{ $isLast ? 'bg-tertiary border-2 border-dashed border-primary' : 'bg-primary' }}" style="height: {{ $val }}%;"></div>
                            </div>
                            <span class="text-[10px] font-bold {{ $isLast ? 'text-primary' : 'text-secondary' }}">{{ $month }}</span>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Prediction Factors (Col-span 4) --}}
            <div class="md:col-span-4 bg-white p-6 rounded-2xl border border-surface-container shadow-soft flex flex-col justify-between">
                <div>
                    <h4 class="font-bold text-sm text-on-surface mb-4">Faktor Kunci Prediksi</h4>
                    <ul class="space-y-4">
                        <li class="flex gap-3">
                            <span class="material-symbols-outlined text-primary mt-0.5">sentiment_very_satisfied</span>
                            <div>
                                <h5 class="text-xs font-bold text-on-surface">Tingkat Kehadiran {{ $tingkatKehadiran }}%</h5>
                                <p class="text-[10px] text-secondary mt-0.5">
                                    {{ $tingkatKehadiran >= 95 ? 'Kehadiran sangat konsisten. Pertahankan!' : ($tingkatKehadiran >= 85 ? 'Kehadiran cukup baik, sedikit peningkatan diperlukan.' : 'Perlu peningkatan signifikan di area ini.') }}
                                </p>
                            </div>
                        </li>
                        <li class="flex gap-3">
                            <span class="material-symbols-outlined text-primary mt-0.5">assignment_turned_in</span>
                            <div>
                                <h5 class="text-xs font-bold text-on-surface">Pengumpulan Tugas {{ $tugasSelesai }}/{{ $totalTugas }}</h5>
                                <p class="text-[10px] text-secondary mt-0.5">
                                    {{ $totalTugas > 0 && ($tugasSelesai / $totalTugas) >= 0.8 ? 'Penyelesaian tugas sangat baik.' : 'Masih ada tugas yang perlu diselesaikan.' }}
                                </p>
                            </div>
                        </li>
                        <li class="flex gap-3">
                            <span class="material-symbols-outlined {{ $totalAlpha > 3 ? 'text-error' : 'text-tertiary' }} mt-0.5">info</span>
                            <div>
                                <h5 class="text-xs font-bold text-on-surface">Alpha: {{ $totalAlpha }} Hari</h5>
                                <p class="text-[10px] text-secondary mt-0.5">
                                    {{ $totalAlpha === 0 ? 'Tidak ada catatan alpha. Excellent!' : ($totalAlpha <= 3 ? 'Masih dalam batas toleransi.' : 'Melebihi batas toleransi, perlu perhatian khusus.') }}
                                </p>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
