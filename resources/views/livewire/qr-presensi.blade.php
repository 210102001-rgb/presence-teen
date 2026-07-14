<div wire:poll.5s="refreshToken" class="grid grid-cols-12 gap-6 items-start">
    {{-- Left Column: Form & History --}}
    <div class="col-span-12 lg:col-span-8 flex flex-col gap-6">
        {{-- Create Session Card --}}
        <div class="bg-white rounded-2xl shadow-soft p-6 border border-surface-container">
            <div class="flex items-center gap-2 mb-6 text-primary">
                <span class="material-symbols-outlined font-bold">add_circle</span>
                <h3 class="text-base font-bold text-on-surface">Buat Sesi Baru</h3>
            </div>
            
            <form wire:submit.prevent="mulaiSesi" class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="flex flex-col gap-2">
                    <label class="text-[10px] font-bold text-on-surface-variant uppercase tracking-wider">Kelas</label>
                    <select wire:model.live="selectedKelasId" 
                            class="w-full rounded-xl border border-outline-variant bg-surface px-4 py-3 text-sm text-on-surface focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-colors">
                        @foreach($kelasList as $kelasItem)
                            <option value="{{ $kelasItem->id }}">{{ $kelasItem->nama_kelas }}</option>
                        @endforeach
                    </select>
                    @error('selectedKelasId')
                        <p class="mt-1 text-xs text-error">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex flex-col gap-2">
                    <label class="text-[10px] font-bold text-on-surface-variant uppercase tracking-wider">Mata Pelajaran</label>
                    <input type="text" 
                           wire:model="mataPelajaran" 
                           placeholder="Contoh: Matematika Lanjut, Fisika..."
                           class="w-full rounded-xl border border-outline-variant bg-surface px-4 py-3 text-sm text-on-surface focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-colors">
                    @error('mataPelajaran')
                        <p class="mt-1 text-xs text-error">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex flex-col gap-2 md:col-span-2">
                    <label class="text-[10px] font-bold text-on-surface-variant uppercase tracking-wider">Topik Pertemuan</label>
                    <input type="text" 
                           wire:model="topik" 
                           placeholder="Cth: Trigonometri Dasar"
                           class="w-full rounded-xl border border-outline-variant bg-surface px-4 py-3 text-sm text-on-surface placeholder:text-on-surface-variant/40 focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-colors">
                    @error('topik')
                        <p class="mt-1 text-xs text-error">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex flex-col gap-2">
                    <label class="text-[10px] font-bold text-on-surface-variant uppercase tracking-wider">Durasi (Menit)</label>
                    <input type="number"
                           wire:model.blur="durasi"
                           min="5"
                           max="480"
                           class="w-full rounded-xl border border-outline-variant bg-surface px-4 py-3 text-sm text-on-surface focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-colors">
                    @error('durasi')
                        <p class="mt-1 text-xs text-error">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-end justify-end md:col-span-2 mt-2">
                    <button type="submit"
                            wire:loading.attr="disabled"
                            wire:loading.class="opacity-50 cursor-not-allowed"
                            class="bg-primary text-on-primary font-semibold rounded-xl px-6 py-3 hover:bg-primary/90 shadow-soft transition-all active:scale-95 flex items-center gap-2 disabled:pointer-events-none">
                        <span wire:loading.remove class="material-symbols-outlined" style="font-size: 20px;">play_arrow</span>
                        <span wire:loading class="animate-spin w-5 h-5 border-2 border-on-primary border-t-transparent rounded-full"></span>
                        <span wire:loading.remove>Mulai Sesi</span>
                        <span wire:loading>Memproses...</span>
                    </button>
                </div>
            </form>
        </div>

        {{-- History Table Card --}}
        <div class="bg-white rounded-2xl shadow-soft overflow-hidden border border-surface-container">
            <div class="p-5 border-b border-surface-container flex justify-between items-center bg-white">
                <h3 class="text-sm font-bold text-on-surface">Riwayat Sesi Terakhir</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead class="bg-surface-container-low text-[10px] font-bold text-on-surface-variant uppercase tracking-wider">
                        <tr>
                            <th class="py-3.5 px-6 font-medium">Tanggal</th>
                            <th class="py-3.5 px-6 font-medium">Kelas &amp; Mapel</th>
                            <th class="py-3.5 px-6 font-medium">Topik</th>
                            <th class="py-3.5 px-6 font-medium text-center">Hadir</th>
                            <th class="py-3.5 px-6 font-medium">Status</th>
                        </tr>
                    </thead>
                    <tbody class="text-xs text-on-surface divide-y divide-surface-container/50">
                        @foreach($riwayatSesi as $riwayat)
                            @php
                                $rKelas = $riwayat->kelas;
                                $rTotalSiswa = $rKelas ? $rKelas->siswa->count() : 0;
                                $rHadirCount = $riwayat->presensi->whereIn('status', ['hadir', 'telat'])->count();
                                $rTopik = $riwayat->topik ?? 'Sesi Umum';
                            @endphp
                            <tr class="hover:bg-surface-container-low transition-colors">
                                <td class="py-4 px-6 text-on-surface-variant">
                                    {{ $riwayat->created_at->isToday() ? 'Hari ini, ' . $riwayat->created_at->format('H:i') : ($riwayat->created_at->isYesterday() ? 'Kemarin, ' . $riwayat->created_at->format('H:i') : $riwayat->created_at->translatedFormat('d M, H:i')) }}
                                </td>
                                <td class="py-4 px-6 font-semibold">
                                    {{ $rKelas->nama_kelas ?? '-' }}
                                    <span class="block text-on-surface-variant font-normal text-[10px] mt-0.5">{{ $riwayat->mata_pelajaran }}</span>
                                </td>
                                <td class="py-4 px-6 text-on-surface-variant">{{ $rTopik }}</td>
                                <td class="py-4 px-6 text-center font-bold text-primary">{{ $rHadirCount }}/{{ $rTotalSiswa }}</td>
                                <td class="py-4 px-6">
                                    @if($riwayat->is_active)
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-primary-fixed text-on-primary-fixed text-[10px] font-bold uppercase tracking-wider">
                                            Aktif
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-surface-container-highest text-on-surface-variant text-[10px] font-bold uppercase tracking-wider">
                                            Selesai
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Right Column: Active QR Component --}}
    <div class="col-span-12 lg:col-span-4">
        @if($sesiAktif)
            @if($sesiBerhasilDibuat)
                {{-- Sesi Berhasil Dibuat Confirmation Screen --}}
                <div class="bg-white rounded-2xl shadow-soft p-6 flex flex-col items-center text-center border border-primary/20">
                    <div class="w-20 h-20 bg-primary-container/10 rounded-full flex items-center justify-center mb-4">
                        <span class="material-symbols-outlined text-primary text-5xl">check_circle</span>
                    </div>
                    <h3 class="text-base font-bold text-on-surface mb-2">Sesi Berhasil Dibuat!</h3>
                    <p class="text-xs text-on-surface-variant mb-6 leading-relaxed">
                        Sesi <span class="font-semibold text-primary">{{ $sesiAktif->mata_pelajaran }}</span> untuk kelas <span class="font-semibold text-primary">{{ $sesiAktif->kelas->nama_kelas }}</span> telah disiapkan dan siap dimulai.
                    </p>
                    <div class="w-full flex flex-col gap-3">
                        <button wire:click="showQr" class="w-full bg-primary text-on-primary font-semibold py-3 px-4 rounded-xl hover:bg-primary/90 transition-colors shadow-soft focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2">
                            Tampilkan QR Code Sekarang
                        </button>
                        <button wire:click="kembaliKeBeranda" class="w-full bg-surface-container-low text-secondary font-semibold py-3 px-4 rounded-xl hover:bg-surface-container-high transition-colors focus:outline-none focus:ring-2 focus:ring-outline focus:ring-offset-2">
                            Kembali ke Beranda
                        </button>
                    </div>
                </div>
            @else
                <div class="bg-white rounded-2xl shadow-soft p-6 flex flex-col items-center text-center relative overflow-hidden border border-primary/25">
                    {{-- Pulsing background effect for active state --}}
                    <div class="absolute inset-0 bg-primary-container/10 animate-pulse pointer-events-none"></div>
                    
                    <div class="w-full flex justify-between items-center mb-6 relative z-10">
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-primary-container text-on-primary-container text-[10px] font-bold uppercase tracking-wider">
                            <span class="w-1.5 h-1.5 rounded-full bg-primary animate-ping"></span>
                            Sesi Aktif
                        </span>
                        <span class="text-xs font-semibold text-on-surface-variant">{{ $sesiAktif->kelas->nama_kelas }}</span>
                    </div>

                    <h3 class="text-lg font-bold text-on-surface mb-1 relative z-10 font-sans">{{ $sesiAktif->mata_pelajaran }}</h3>
                    <p class="text-xs text-on-surface-variant mb-6 relative z-10">Scan untuk presensi kehadiran</p>

                    <div class="bg-white p-4 rounded-xl border border-outline-variant shadow-soft mb-6 relative z-10">
                        <div class="w-48 h-48 bg-surface-container-lowest rounded flex items-center justify-center relative overflow-hidden">
                            <div class="scale-95">
                                {!! QrCode::size(180)->generate(route('presensi.scan.token', $sesiAktif->qr_token)) !!}
                            </div>
                            {{-- Scanner line animation overlay --}}
                            <div class="absolute inset-0 bg-gradient-to-b from-transparent via-primary/20 to-transparent w-full h-1/3 opacity-50 animate-scan" style="animation: scan 3s infinite linear;"></div>
                        </div>
                    </div>

                    <div wire:ignore.self class="flex items-center gap-2 mb-8 relative z-10" 
                         x-data="{ 
                             remaining: {{ (int)$remainingSeconds }},
                             formatTime(seconds) {
                                 if (seconds <= 0) return '00:00';
                                 const m = Math.floor(seconds / 60);
                                 const s = Math.floor(seconds % 60);
                                 return `${String(m).padStart(2, '0')}:${String(s).padStart(2, '0')}`;
                             }
                         }" 
                         x-on:timer-sync.window="remaining = $event.detail.remaining"
                         x-init="setInterval(() => { if (remaining > 0) remaining-- }, 1000)">
                        <span class="material-symbols-outlined text-primary text-xl">timer</span>
                        <div class="text-2xl font-bold text-primary font-mono tracking-wider" x-text="formatTime(remaining)">
                            44:59
                        </div>
                    </div>

                    @if($showConfirmAkhiri)
                        <div class="w-full relative z-10 p-4 bg-error-container border border-error/20 rounded-xl space-y-3">
                            <p class="text-[10px] font-bold text-on-error-container uppercase">
                                Konfirmasi Akhiri
                            </p>
                            <p class="text-[11px] text-on-error-container leading-relaxed">
                                Apakah Anda yakin ingin mengakhiri sesi presensi ini? Siswa tidak akan dapat melakukan scan lagi.
                            </p>
                            <div class="flex gap-2">
                                <button wire:click="akhiriSesi" class="px-3.5 py-1.5 bg-error text-white text-[10px] font-bold rounded-lg hover:opacity-90 transition-all">
                                    Ya, Akhiri
                                </button>
                                <button wire:click="batalAkhiri" class="px-3.5 py-1.5 bg-white border border-outline-variant text-on-surface-variant text-[10px] font-bold rounded-lg hover:bg-surface-container-low transition-all">
                                    Batal
                                </button>
                            </div>
                        </div>
                    @else
                        <div class="w-full flex gap-3 relative z-10">
                            <button wire:click="perpanjangSesi" class="flex-1 border border-outline text-on-surface-variant font-semibold text-xs rounded-xl py-3 hover:bg-surface-container-low transition-colors">
                                Perpanjang
                            </button>
                            <button wire:click="konfirmasiAkhiri" class="flex-1 bg-error-container text-on-error-container font-semibold text-xs rounded-xl py-3 hover:bg-error hover:text-white transition-colors">
                                Akhiri Sesi
                            </button>
                        </div>
                    @endif
                </div>

                {{-- Quick Stats below active session --}}
                <div class="grid grid-cols-2 gap-4 mt-6">
                    <div class="bg-white rounded-2xl shadow-soft p-4 border border-surface-container flex flex-col items-center justify-center">
                        <span class="text-2xl font-bold text-primary">{{ $hadirCount }}</span>
                        <span class="text-[9px] font-bold text-on-surface-variant uppercase tracking-wider mt-1">Hadir</span>
                    </div>
                    <div class="bg-white rounded-2xl shadow-soft p-4 border border-surface-container flex flex-col items-center justify-center">
                        <span class="text-2xl font-bold text-on-surface-variant">{{ $belumHadirCount }}</span>
                        <span class="text-[9px] font-bold text-on-surface-variant uppercase tracking-wider mt-1">Belum Hadir</span>
                    </div>
                </div>
            @endif
        @else
            {{-- No Active Session Placeholder --}}
            <div class="bg-white rounded-2xl shadow-soft p-8 text-center border border-surface-container flex flex-col items-center justify-center min-h-[350px]">
                <div class="w-16 h-16 bg-surface-container-low rounded-full flex items-center justify-center text-secondary mb-4">
                    <span class="material-symbols-outlined text-3xl">qr_code_2</span>
                </div>
                <h4 class="text-sm font-bold text-on-surface mb-2">Belum Ada Sesi Aktif</h4>
                <p class="text-xs text-on-surface-variant leading-relaxed max-w-xs">
                    Silakan isi form di panel sebelah kiri dan klik "Mulai Sesi" untuk menghasilkan QR Code presensi kelas secara real-time.
                </p>
            </div>
        @endif
    </div>

    <style>
        @keyframes scan {
            0% { transform: translateY(-100%); }
            100% { transform: translateY(300%); }
        }
        .animate-scan {
            animation: scan 3s infinite linear;
        }
    </style>
</div>
