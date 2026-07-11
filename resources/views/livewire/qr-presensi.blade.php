<div wire:poll.5s="refreshToken">
    @if (!$sesiAktif)
        {{-- Form mulai sesi --}}
        <form wire:submit="mulaiSesi" class="space-y-4">
            <div>
                <label class="block text-sm font-semibold text-[#171c1f] mb-1.5">Mata Pelajaran</label>
                <input type="text"
                       wire:model="mataPelajaran"
                       placeholder="Contoh: Matematika, Fisika..."
                       class="w-full px-4 py-3 border border-[#becabc] rounded-xl text-sm text-[#171c1f] bg-white
                              focus:outline-none focus:ring-2 focus:ring-[#005f2d] focus:border-[#005f2d] transition-all">
                @error('mataPelajaran')
                    <p class="mt-1 text-xs text-[#ba1a1a]">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit"
                    class="inline-flex items-center gap-2 px-6 py-3 bg-[#005f2d] text-white text-sm font-semibold
                           rounded-xl hover:bg-[#0e7a3d] transition-all active:scale-95 shadow-soft">
                <span class="material-symbols-outlined text-[18px]">play_circle</span>
                Mulai Sesi Presensi
            </button>
        </form>
    @else
        {{-- Sesi aktif - tampilkan QR --}}
        <div class="space-y-6">
            {{-- Status bar --}}
            <div class="flex items-center justify-between bg-[#f0fdf4] border border-[#0e7a3d]/20 rounded-xl px-5 py-3">
                <div class="flex items-center gap-2">
                    <span class="w-2.5 h-2.5 bg-[#0e7a3d] rounded-full animate-pulse"></span>
                    <span class="text-sm font-semibold text-[#005f2d]">Sesi Aktif</span>
                    <span class="text-sm text-[#3f493f]">— {{ $sesiAktif->mata_pelajaran }}</span>
                </div>
                <span class="text-xs text-[#5c5f61]">Auto-refresh tiap {{ $durasiExpired }}s</span>
            </div>

            {{-- QR Code --}}
            <div x-data="{ isFullscreen: false }" 
                 :class="isFullscreen ? 'fixed inset-0 z-50 bg-[#f6fafe] flex flex-col items-center justify-center p-8' : 'flex flex-col items-center py-6 bg-white rounded-xl border border-[#eaeef2]'">
                
                {{-- Fullscreen Close button --}}
                <template x-if="isFullscreen">
                    <button @click="isFullscreen = false" class="absolute top-6 right-6 p-3 bg-white hover:bg-gray-100 rounded-full border border-gray-200 text-gray-700 shadow-soft flex items-center justify-center">
                        <span class="material-symbols-outlined text-[24px]">close</span>
                    </button>
                </template>

                <div class="p-4 bg-white rounded-2xl shadow-soft border border-[#eaeef2] mb-4 flex items-center justify-center"
                     :class="isFullscreen ? 'w-[420px] h-[420px]' : 'w-[272px] h-[272px]'">
                    <div :class="isFullscreen ? 'scale-[1.6]' : ''" class="transition-transform duration-200">
                        {!! QrCode::size(240)->generate(route('presensi.scan.token', $sesiAktif->qr_token)) !!}
                    </div>
                </div>

                <div class="flex items-center gap-3">
                    <button @click="isFullscreen = !isFullscreen" 
                            class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-[#f0fdf4] border border-[#0e7a3d]/20 text-[#005f2d] hover:bg-[#0e7a3d] hover:text-white transition-all text-xs font-semibold rounded-lg">
                        <span class="material-symbols-outlined text-[16px]" x-text="isFullscreen ? 'fullscreen_exit' : 'fullscreen'">fullscreen</span>
                        <span x-text="isFullscreen ? 'Kecilkan QR' : 'Perbesar QR'">Perbesar QR</span>
                    </button>
                </div>

                <p class="text-sm text-[#5c5f61] text-center mt-3">
                    Tampilkan QR ini ke siswa untuk scan presensi
                </p>
                <p class="text-sm text-[#171c1f] mt-2 font-mono font-bold bg-[#eaeef2] px-3 py-1 rounded-lg border border-[#becabc]">
                    Token: {{ $sesiAktif->qr_token }}
                </p>
            </div>

            {{-- Akhiri sesi --}}
            <button wire:click="akhiriSesi"
                    wire:confirm="Apakah Anda yakin ingin mengakhiri sesi presensi ini? Siswa tidak akan bisa melakukan scan lagi."
                    class="inline-flex items-center gap-2 px-6 py-3 bg-[#ffdad6] border border-[#ba1a1a]/20 text-[#93000a]
                           text-sm font-semibold rounded-xl hover:bg-[#ba1a1a] hover:text-white transition-all active:scale-95">
                <span class="material-symbols-outlined text-[18px]">stop_circle</span>
                Akhiri Sesi Presensi
            </button>
        </div>
    @endif
</div>
