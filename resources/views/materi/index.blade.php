<x-app-layout>
    <x-slot name="header">Materi Pembelajaran</x-slot>

    <div class="p-4 md:p-8 max-w-7xl mx-auto space-y-6">
        {{-- Header & Stats --}}
        <div class="flex flex-col lg:flex-row justify-between items-start lg:items-end gap-6 mb-6">
            <div class="flex-grow">
                <p class="text-[#005f2d] font-semibold text-xs mb-1 uppercase tracking-widest">Academic Resources</p>
                <h1 class="text-2xl font-bold text-[#171c1f] mb-4">Materi Pembelajaran</h1>
                {{-- AI Insight Banner --}}
                <div class="inline-flex items-center gap-3 px-4 py-2.5 rounded-xl bg-[#f0fdf4] border border-[#0e7a3d]/20 shadow-soft">
                    <span class="material-symbols-outlined text-[#0e7a3d] filled-icon shrink-0">auto_awesome</span>
                    <p class="text-xs font-semibold text-[#005226]">AI Insight: Buka detail materi untuk mendapatkan ringkasan otomatis dari AI Claude.</p>
                </div>
            </div>
            {{-- Statistics Cards --}}
            <div class="flex gap-4">
                <div class="bg-white p-4 rounded-xl shadow-soft min-w-[120px] text-center border-b-4 border-[#005f2d] border-l border-r border-t border-gray-100">
                    <p class="text-[10px] font-bold text-[#5c5f61] uppercase tracking-wider">Total</p>
                    <p class="text-2xl font-bold text-[#171c1f] mt-1">{{ $materi->count() }}</p>
                </div>
                <div class="bg-white p-4 rounded-xl shadow-soft min-w-[120px] text-center border-b-4 border-[#495362] border-l border-r border-t border-gray-100">
                    <p class="text-[10px] font-bold text-[#5c5f61] uppercase tracking-wider">Diringkas</p>
                    <p class="text-2xl font-bold text-[#171c1f] mt-1">{{ $materi->filter(fn($m) => $m->ringkasan_ai)->count() }}</p>
                </div>
            </div>
        </div>

        {{-- Filters Section --}}
        <div class="bg-white p-6 rounded-2xl border border-[#eaeef2] shadow-soft flex flex-wrap items-center gap-6">
            <div class="flex flex-col gap-1.5 flex-grow min-w-[200px]">
                <label class="text-[10px] font-bold text-[#5c5f61] uppercase tracking-wider">Cari Materi</label>
                <div class="relative">
                    <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-[#5c5f61] text-[20px]">search</span>
                    <input class="w-full pl-10 pr-4 py-2 border border-[#becabc] rounded-xl focus:ring-2 focus:ring-[#005f2d] focus:border-[#005f2d] outline-none text-sm transition-all" placeholder="Topik, nama guru, atau pelajaran..." type="text"/>
                </div>
            </div>
            <div class="flex flex-col gap-1.5 min-w-[160px]">
                <label class="text-[10px] font-bold text-[#5c5f61] uppercase tracking-wider">Mata Pelajaran</label>
                <select class="w-full px-4 py-2 border border-[#becabc] rounded-xl focus:ring-2 focus:ring-[#005f2d] focus:border-[#005f2d] outline-none text-sm transition-all bg-white">
                    <option>Semua Pelajaran</option>
                    <option>Matematika</option>
                    <option>Fisika</option>
                    <option>Bahasa Inggris</option>
                </select>
            </div>
            <div class="flex flex-col gap-1.5 min-w-[160px]">
                <label class="text-[10px] font-bold text-[#5c5f61] uppercase tracking-wider">Semester</label>
                <div class="flex bg-[#f6fafe] rounded-xl p-1 border border-[#eaeef2]">
                    <button class="px-4 py-1 rounded-lg bg-white shadow-sm text-[#005f2d] font-bold text-xs">S1</button>
                    <button class="px-4 py-1 rounded-lg text-[#5c5f61] font-semibold text-xs hover:bg-white/50 transition-all">S2</button>
                </div>
            </div>
            <div class="flex items-end h-full pt-5">
                <button class="h-10 px-6 bg-[#005f2d] text-white text-xs font-bold rounded-xl hover:bg-[#0e7a3d] active:scale-95 transition-all flex items-center gap-2 shadow-soft">
                    <span class="material-symbols-outlined text-[18px]">filter_list</span>
                    Terapkan Filter
                </button>
            </div>
        </div>

        {{-- Materials Grid --}}
        @if($materi->isEmpty())
            <div class="bg-white rounded-xl shadow-soft border border-[#eaeef2] p-16 text-center">
                <div class="w-16 h-16 bg-[#eaeef2] rounded-full flex items-center justify-center mx-auto mb-4">
                    <span class="material-symbols-outlined text-[#5c5f61] text-3xl">menu_book</span>
                </div>
                <p class="text-base font-semibold text-[#171c1f]">Belum ada materi</p>
                <p class="text-sm text-[#5c5f61] mt-1">Belum ada materi yang ditambahkan.</p>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($materi as $item)
                    @php
                        // Select border color based on subject or status
                        $borderColor = $item->ringkasan_ai ? 'border-l-4 border-[#0e7a3d]' : 'border-l-4 border-[#495362]';
                    @endphp
                    <div class="group bg-white p-6 rounded-2xl border border-[#eaeef2] {{ $borderColor }} shadow-soft hover:-translate-y-1 transition-all duration-300 flex flex-col justify-between min-h-[260px]">
                        <div>
                            <div class="flex justify-between items-start mb-4">
                                <div class="w-12 h-12 rounded-xl bg-[#0e7a3d]/10 flex items-center justify-center text-[#005f2d] group-hover:bg-[#005f2d] group-hover:text-white transition-colors">
                                    <span class="material-symbols-outlined text-[28px]">description</span>
                                </div>
                                @if($item->ringkasan_ai)
                                    <span class="bg-[#f0fdf4] text-[#005f2d] border border-[#0e7a3d]/20 px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider">AI Ringkasan</span>
                                @else
                                    <span class="bg-[#f6fafe] text-[#5c5f61] border border-[#becabc] px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider">Biasa</span>
                                @endif
                            </div>
                            <h3 class="text-md font-bold text-[#171c1f] mb-2 leading-tight group-hover:text-[#005f2d] transition-colors line-clamp-1">{{ $item->judul }}</h3>
                            <p class="text-xs text-[#5c5f61] line-clamp-2 mb-4 leading-relaxed">Panduan dan materi pembelajaran kurikulum terbaru mata pelajaran {{ $item->mata_pelajaran ?? 'Matematika' }}.</p>
                        </div>
                        
                        <div>
                            <div class="space-y-2 border-t border-[#eaeef2] pt-4 mb-4">
                                <div class="flex items-center justify-between text-xs">
                                    <span class="text-[#5c5f61] flex items-center gap-1"><span class="material-symbols-outlined text-[16px]">person</span> Guru</span>
                                    <span class="font-bold text-[#171c1f]">{{ $item->guru->name ?? 'Guru' }}</span>
                                </div>
                                <div class="flex items-center justify-between text-xs">
                                    <span class="text-[#5c5f61] flex items-center gap-1"><span class="material-symbols-outlined text-[16px]">calendar_today</span> Diupload</span>
                                    <span class="font-bold text-[#171c1f]">{{ $item->created_at->format('d M Y') }}</span>
                                </div>
                            </div>
                            
                            <div class="flex items-center gap-3">
                                <a href="{{ route('materi.show', $item) }}" class="flex-grow py-2.5 px-3 border border-[#005f2d] text-[#005f2d] font-bold text-xs rounded-xl hover:bg-[#f0fdf4] transition-all flex items-center justify-center gap-1">
                                    <span class="material-symbols-outlined text-[18px]">visibility</span> Lihat Detail
                                </a>
                                @if($item->file_path)
                                    <a href="{{ Storage::url($item->file_path) }}" target="_blank" class="p-2 bg-[#005f2d] text-white rounded-xl hover:bg-[#0e7a3d] transition-all flex items-center justify-center shadow-soft">
                                        <span class="material-symbols-outlined">download</span>
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
