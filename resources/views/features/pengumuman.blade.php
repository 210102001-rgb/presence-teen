<x-app-layout>
    <x-slot name="header">Pengumuman Sekolah</x-slot>

    <div class="p-4 md:p-8 max-w-7xl mx-auto space-y-6">
        {{-- Hero Section / AI Insight --}}
        <section class="mb-6">
            <div class="p-6 bg-[#f0fdf4] rounded-2xl border border-[#0e7a3d]/20 shadow-soft flex items-start gap-4 relative overflow-hidden">
                <div class="absolute top-0 right-0 p-6 opacity-5 pointer-events-none">
                    <span class="material-symbols-outlined text-[100px] text-[#005f2d]">auto_awesome</span>
                </div>
                <div class="bg-[#0e7a3d]/10 p-2.5 rounded-xl text-[#005f2d] shrink-0">
                    <span class="material-symbols-outlined filled-icon">auto_awesome</span>
                </div>
                <div class="relative z-10">
                    <h3 class="font-bold text-[#005f2d] text-sm mb-1">Ringkasan AI Pekan Ini</h3>
                    <p class="text-xs text-[#3f493f] max-w-2xl leading-relaxed">
                        Terdapat 3 pengumuman baru yang memerlukan perhatian Anda, termasuk perincian biaya ujian akhir dan jadwal pertemuan wali murid semester genap. Pastikan untuk meninjau detailnya sebelum akhir pekan ini.
                    </p>
                </div>
            </div>
        </section>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
            {{-- Announcement List Column (Col-span 8) --}}
            <div class="lg:col-span-8 space-y-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="font-bold text-lg text-[#171c1f]">Terbaru</h3>
                    <div class="flex gap-2">
                        <button class="px-3 py-1 bg-white border border-[#becabc] text-xs font-semibold rounded-lg text-[#5c5f61] hover:bg-[#f6fafe] transition-all">Semua</button>
                        <button class="px-3 py-1 bg-white border border-[#becabc] text-xs font-semibold rounded-lg text-[#5c5f61] hover:bg-[#f6fafe] transition-all">Akademik</button>
                        <button class="px-3 py-1 bg-white border border-[#becabc] text-xs font-semibold rounded-lg text-[#5c5f61] hover:bg-[#f6fafe] transition-all">Administrasi</button>
                    </div>
                </div>

                @forelse($pengumuman as $item)
                    @php
                        $borderCol = match($item->prioritas) {
                            'Penting' => 'border-red-600',
                            'Sedang' => 'border-primary',
                            default => 'border-tertiary'
                        };
                        $bgCol = match($item->prioritas) {
                            'Penting' => 'bg-red-100 text-red-700',
                            'Sedang' => 'bg-[#f0fdf4] text-primary',
                            default => 'bg-gray-100 text-[#5c5f61]'
                        };
                    @endphp
                    <div class="bg-white p-6 rounded-2xl shadow-soft border-l-4 {{ $borderCol }} border-t border-r border-b border-surface-container hover:shadow-md transition-shadow group cursor-pointer">
                        <div class="flex justify-between items-start mb-2">
                            <span class="px-2.5 py-0.5 text-[9px] font-bold {{ $bgCol }} rounded-full uppercase tracking-wider">{{ $item->prioritas }}</span>
                            <span class="text-[10px] text-secondary font-semibold">{{ $item->created_at->translatedFormat('d M Y') }}</span>
                        </div>
                        <h4 class="font-bold text-base text-on-surface mb-1 group-hover:text-primary transition-colors">{{ $item->judul }}</h4>
                        <div class="flex items-center gap-1.5 mb-3 text-xs text-secondary">
                            <span class="material-symbols-outlined text-[16px]">category</span>
                            <span>{{ $item->kategori }}</span>
                        </div>
                        <p class="text-xs text-secondary leading-relaxed">
                            {{ $item->konten }}
                        </p>
                        <div class="mt-4 pt-4 border-t border-surface-container flex justify-end">
                            <button class="text-primary font-bold text-xs flex items-center gap-1 hover:underline">
                                Lihat Detail <span class="material-symbols-outlined text-[16px]">arrow_forward</span>
                            </button>
                        </div>
                    </div>
                @empty
                    <div class="bg-white rounded-2xl shadow-soft border border-surface-container p-12 text-center text-secondary">
                        Belum ada pengumuman hari ini.
                    </div>
                @endforelse
            </div>

            {{-- Timeline Column (Col-span 4) --}}
            <div class="lg:col-span-4">
                <div class="bg-white p-6 rounded-2xl shadow-soft border border-[#eaeef2] h-full flex flex-col justify-between">
                    <div>
                        <h3 class="font-bold text-base text-[#171c1f] mb-6">Linimasa Akademik</h3>
                        <div class="relative space-y-6 before:absolute before:left-[11px] before:top-2 before:bottom-2 before:w-[2px] before:bg-[#eaeef2]">
                            {{-- Timeline Item 1 --}}
                            <div class="relative flex gap-4 items-start">
                                <div class="w-6 h-6 rounded-full bg-[#005f2d] flex items-center justify-center z-10 shadow-soft border-2 border-white text-white">
                                    <span class="material-symbols-outlined text-[12px]">event</span>
                                </div>
                                <div>
                                    <p class="text-[9px] font-bold text-[#005f2d] uppercase tracking-wider">Mendatang - 28 Okt</p>
                                    <h5 class="font-bold text-sm text-[#171c1f] leading-tight mt-0.5">Pertemuan Orang Tua & Guru</h5>
                                    <p class="text-[10px] text-[#5c5f61] mt-1 italic">09:00 - 12:00 @ Aula Utama</p>
                                </div>
                            </div>
                            {{-- Timeline Item 2 --}}
                            <div class="relative flex gap-4 items-start">
                                <div class="w-6 h-6 rounded-full bg-[#495362] flex items-center justify-center z-10 shadow-soft border-2 border-white text-white">
                                    <span class="material-symbols-outlined text-[12px]">schedule</span>
                                </div>
                                <div>
                                    <p class="text-[9px] font-bold text-[#5c5f61] uppercase tracking-wider">Selesai - 15 Okt</p>
                                    <h5 class="font-bold text-sm text-[#171c1f] leading-tight mt-0.5">Penyerahan Rapor Siswa</h5>
                                    <p class="text-[10px] text-[#5c5f61] mt-1 italic">08:00 - 15:00 @ Ruang Kelas masing-masing</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
