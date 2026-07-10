<x-app-layout>
    <x-slot name="header">Materi Pembelajaran</x-slot>

    <div class="p-8">
        {{-- Page Header --}}
        <div class="flex flex-col md:flex-row justify-between items-start md:items-end gap-4 mb-8">
            <div>
                <p class="text-[11px] uppercase tracking-widest text-[#005f2d] font-semibold mb-1">Academic Resources</p>
                <h2 class="text-2xl font-bold text-[#171c1f]">Materi Pembelajaran</h2>
            </div>
            {{-- Stats --}}
            <div class="flex gap-3">
                <div class="bg-white px-4 py-3 rounded-xl shadow-soft text-center border-b-4 border-[#005f2d] min-w-[90px]">
                    <p class="text-[10px] uppercase tracking-wider text-[#5c5f61] font-semibold">Total</p>
                    <p class="text-2xl font-bold text-[#171c1f] mt-0.5">{{ $materi->count() }}</p>
                </div>
                <div class="bg-white px-4 py-3 rounded-xl shadow-soft text-center border-b-4 border-[#0e7a3d] min-w-[90px]">
                    <p class="text-[10px] uppercase tracking-wider text-[#5c5f61] font-semibold">Diringkas</p>
                    <p class="text-2xl font-bold text-[#171c1f] mt-0.5">{{ $materi->filter(fn($m) => $m->ringkasan_ai)->count() }}</p>
                </div>
            </div>
        </div>

        {{-- AI Insight --}}
        <div class="ai-glow rounded-xl p-4 mb-6 flex items-center gap-3">
            <span class="material-symbols-outlined text-[#0e7a3d] filled-icon shrink-0">auto_awesome</span>
            <p class="text-sm text-[#3f493f]">
                <span class="font-semibold text-[#005f2d]">AI Insight:</span>
                Buka detail materi untuk mendapatkan ringkasan otomatis dari AI Claude. Hemat waktu belajarmu!
            </p>
        </div>

        @if($materi->isEmpty())
            <div class="bg-white rounded-xl shadow-soft border border-[#eaeef2] p-16 text-center">
                <div class="w-16 h-16 bg-[#eaeef2] rounded-full flex items-center justify-center mx-auto mb-4">
                    <span class="material-symbols-outlined text-[#5c5f61] text-3xl">menu_book</span>
                </div>
                <h3 class="text-base font-semibold text-[#171c1f]">Belum ada materi</h3>
                <p class="text-sm text-[#5c5f61] mt-2">Guru belum mengupload materi pembelajaran.</p>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($materi as $item)
                    <div class="group bg-white rounded-xl shadow-soft border-l-4 border-[#eaeef2] hover:border-[#0e7a3d] bento-card overflow-hidden border border-[#eaeef2]">
                        <div class="p-6">
                            <div class="flex justify-between items-start mb-4">
                                <div class="w-12 h-12 rounded-xl bg-[#f0fdf4] flex items-center justify-center text-[#0e7a3d] group-hover:bg-[#0e7a3d] group-hover:text-white transition-colors">
                                    <span class="material-symbols-outlined text-[28px]">description</span>
                                </div>
                                @if($item->ringkasan_ai)
                                    <span class="px-2.5 py-1 text-[10px] font-bold bg-[#f0fdf4] text-[#005f2d] border border-[#0e7a3d]/20 rounded-full uppercase tracking-wider">AI Ringkasan</span>
                                @else
                                    <span class="px-2.5 py-1 text-[10px] font-bold bg-[#eaeef2] text-[#5c5f61] rounded-full uppercase tracking-wider">Belum diringkas</span>
                                @endif
                            </div>

                            <h4 class="font-semibold text-[#171c1f] mb-1 leading-tight">{{ $item->judul }}</h4>

                            <div class="space-y-1.5 border-t border-[#f0f4f8] pt-3 mt-3 mb-4">
                                <div class="flex justify-between text-sm">
                                    <span class="text-[#5c5f61] flex items-center gap-1">
                                        <span class="material-symbols-outlined text-[16px]">person</span> Guru
                                    </span>
                                    <span class="font-medium text-[#171c1f]">{{ $item->guru->name ?? 'Guru' }}</span>
                                </div>
                                <div class="flex justify-between text-sm">
                                    <span class="text-[#5c5f61] flex items-center gap-1">
                                        <span class="material-symbols-outlined text-[16px]">calendar_today</span> Tanggal
                                    </span>
                                    <span class="font-medium text-[#171c1f]">{{ $item->created_at->format('d M Y') }}</span>
                                </div>
                            </div>

                            <div class="flex items-center gap-3">
                                <a href="{{ route('materi.show', $item) }}"
                                   class="flex-1 py-2 px-3 border border-[#005f2d] text-[#005f2d] text-sm font-semibold rounded-xl hover:bg-[#f0fdf4] transition-all flex items-center justify-center gap-1">
                                    <span class="material-symbols-outlined text-[18px]">visibility</span>
                                    Lihat
                                </a>
                                @if($item->file_path)
                                    <a href="{{ Storage::url($item->file_path) }}" target="_blank"
                                       class="p-2 bg-[#0e7a3d] text-white rounded-xl hover:bg-[#005f2d] transition-all">
                                        <span class="material-symbols-outlined text-[20px]">download</span>
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</x-app-layout>
