<x-app-layout>
    <x-slot name="header">QR Presensi</x-slot>

    <div class="p-8">
        {{-- Page Header --}}
        <div class="mb-8">
            <p class="text-[11px] uppercase tracking-widest text-[#005f2d] font-semibold mb-1">Attendance Management</p>
            <h2 class="text-2xl font-bold text-[#171c1f]">Generate QR Presensi</h2>
            <p class="text-sm text-[#3f493f] mt-1">Pilih kelas untuk menghasilkan QR Code presensi digital.</p>
        </div>

        @if ($kelas->isEmpty())
            <div class="bg-white rounded-xl shadow-soft border border-[#eaeef2] p-16 text-center">
                <div class="w-16 h-16 bg-[#eaeef2] rounded-full flex items-center justify-center mx-auto mb-4">
                    <span class="material-symbols-outlined text-[#5c5f61] text-3xl">class</span>
                </div>
                <p class="text-base font-medium text-[#171c1f]">Belum ada kelas</p>
                <p class="text-sm text-[#5c5f61] mt-1">Anda belum memiliki kelas aktif. Hubungi administrator.</p>
            </div>
        @else
            {{-- Kelas Grid --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5 mb-8">
                @foreach ($kelas as $k)
                    <div class="bg-white rounded-xl shadow-soft border border-[#eaeef2] hover:border-[#0e7a3d]/50 bento-card overflow-hidden
                                {{ isset($selectedKelas) && $selectedKelas->id === $k->id ? 'border-[#0e7a3d] ring-2 ring-[#0e7a3d]/20' : '' }}">
                        <div class="p-5">
                            <div class="flex items-start justify-between mb-3">
                                <div class="w-11 h-11 rounded-xl bg-[#f0fdf4] flex items-center justify-center">
                                    <span class="material-symbols-outlined text-[#0e7a3d] filled-icon">class</span>
                                </div>
                                @if(isset($selectedKelas) && $selectedKelas->id === $k->id)
                                    <span class="px-2.5 py-1 text-[10px] font-bold bg-[#0e7a3d] text-white rounded-full uppercase">Aktif</span>
                                @endif
                            </div>
                            <h3 class="font-semibold text-[#171c1f] mb-0.5">{{ $k->nama_kelas }}</h3>
                            <p class="text-xs text-[#5c5f61] mb-4">{{ $k->mata_pelajaran }}</p>
                            <a href="{{ route('presensi.guru.qr', $k->id) }}"
                               class="w-full inline-flex items-center justify-center gap-2 py-2.5 rounded-xl text-sm font-semibold transition-all
                                      {{ isset($selectedKelas) && $selectedKelas->id === $k->id
                                         ? 'bg-[#005f2d] text-white hover:bg-[#0e7a3d]'
                                         : 'border border-[#005f2d] text-[#005f2d] hover:bg-[#f0fdf4]' }}">
                                <span class="material-symbols-outlined text-[18px]">qr_code_2</span>
                                Generate QR
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- QR Display --}}
            @if ($selectedKelas)
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-start">
                    {{-- QR Code Generator (Col-span 2) --}}
                    <div class="lg:col-span-2 bg-white rounded-xl shadow-soft border border-[#eaeef2] overflow-hidden">
                        <div class="px-6 py-4 bg-[#f0fdf4] border-b border-[#0e7a3d]/15 flex items-center gap-3">
                            <span class="material-symbols-outlined text-[#0e7a3d] filled-icon">qr_code_scanner</span>
                            <div>
                                <h3 class="font-semibold text-[#005f2d]">Presensi: {{ $selectedKelas->nama_kelas }}</h3>
                                <p class="text-xs text-[#3f493f]">{{ $selectedKelas->mata_pelajaran }}</p>
                            </div>
                        </div>
                        <div class="p-6">
                            @livewire('qr-presensi', ['kelasId' => $selectedKelas->id], key($selectedKelas->id))
                        </div>
                    </div>

                    {{-- Class Settings / Preferences (Col-span 1) --}}
                    <div class="bg-white rounded-xl shadow-soft border border-[#eaeef2] overflow-hidden">
                        <div class="px-6 py-4 border-b border-[#eaeef2] flex items-center gap-3">
                            <span class="material-symbols-outlined text-[#495362]">settings</span>
                            <h3 class="font-semibold text-[#171c1f]">Pengaturan Sesi & Kelas</h3>
                        </div>
                        <div class="p-6">
                            @if (session('status') === 'settings-updated')
                                <div class="mb-4 p-3 bg-green-50 border border-green-200 text-green-700 rounded-lg text-sm flex items-center gap-2">
                                    <span class="material-symbols-outlined text-[18px]">check_circle</span>
                                    <span>Pengaturan berhasil disimpan!</span>
                                </div>
                            @endif

                            <form action="{{ route('presensi.guru.settings', $selectedKelas->id) }}" method="POST" class="space-y-4">
                                @csrf
                                <div>
                                    <label for="batas_terlambat_menit" class="block text-xs font-semibold text-[#3f493f] uppercase tracking-wider mb-1">Toleransi Terlambat (Menit)</label>
                                    <input type="number" name="batas_terlambat_menit" id="batas_terlambat_menit" 
                                           class="w-full rounded-xl border-[#eaeef2] focus:border-[#0e7a3d] focus:ring focus:ring-[#0e7a3d]/20 text-sm"
                                           value="{{ old('batas_terlambat_menit', $selectedKelas->batas_terlambat_menit ?? 15) }}" min="0" max="180">
                                </div>

                                <div>
                                    <label for="durasi_qr_detik" class="block text-xs font-semibold text-[#3f493f] uppercase tracking-wider mb-1">Refresh QR (Detik)</label>
                                    <input type="number" name="durasi_qr_detik" id="durasi_qr_detik" 
                                           class="w-full rounded-xl border-[#eaeef2] focus:border-[#0e7a3d] focus:ring focus:ring-[#0e7a3d]/20 text-sm"
                                           value="{{ old('durasi_qr_detik', $selectedKelas->durasi_qr_detik ?? 30) }}" min="5" max="3600">
                                </div>

                                <div>
                                    <label for="email_pengirim_notifikasi" class="block text-xs font-semibold text-[#3f493f] uppercase tracking-wider mb-1">Email Pengirim Notifikasi</label>
                                    <input type="email" name="email_pengirim_notifikasi" id="email_pengirim_notifikasi" 
                                           class="w-full rounded-xl border-[#eaeef2] focus:border-[#0e7a3d] focus:ring focus:ring-[#0e7a3d]/20 text-sm"
                                           value="{{ old('email_pengirim_notifikasi', $selectedKelas->email_pengirim_notifikasi) }}" placeholder="default@system.com">
                                </div>

                                <div class="flex items-center gap-2 pt-2">
                                    <input type="checkbox" name="kirim_notifikasi_otomatis" id="kirim_notifikasi_otomatis" value="1"
                                           class="rounded border-[#eaeef2] text-[#0e7a3d] focus:ring-[#0e7a3d]/20"
                                           {{ old('kirim_notifikasi_otomatis', $selectedKelas->kirim_notifikasi_otomatis ?? true) ? 'checked' : '' }}>
                                    <label for="kirim_notifikasi_otomatis" class="text-sm text-[#171c1f]">Kirim notifikasi otomatis ke Orang Tua</label>
                                </div>

                                <button type="submit" class="w-full mt-4 bg-[#0e7a3d] text-white py-2.5 rounded-xl text-sm font-semibold hover:bg-[#005f2d] transition-colors flex items-center justify-center gap-2">
                                    <span class="material-symbols-outlined text-[18px]">save</span>
                                    Simpan Pengaturan
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endif
        @endif
    </div>
</x-app-layout>
