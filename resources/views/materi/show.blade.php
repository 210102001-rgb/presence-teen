<x-app-layout>
    <x-slot name="header">{{ $materi->judul }}</x-slot>

    <div class="p-4 md:p-8">
        <div class="max-w-3xl mx-auto">
            {{-- Breadcrumb --}}
            <nav class="flex items-center gap-1.5 text-xs text-[#5c5f61] mb-6">
                <a href="{{ route('materi.index') }}" class="hover:text-[#005f2d] transition-colors">Materi</a>
                <span class="material-symbols-outlined text-[14px]">chevron_right</span>
                <span class="text-[#171c1f] font-medium truncate max-w-xs">{{ $materi->judul }}</span>
            </nav>

            @if(session('success'))
                <div x-data x-init="$dispatch('toast', { type: 'success', message: '{{ session('success') }}' })"></div>
            @endif
            @if(session('error'))
                <div x-data x-init="$dispatch('toast', { type: 'error', message: '{{ session('error') }}' })"></div>
            @endif

            {{-- Info Bar --}}
            <div class="bg-white rounded-xl shadow-soft border border-[#eaeef2] p-4 mb-6 flex flex-wrap items-center justify-between gap-3">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-[#f0fdf4] rounded-xl flex items-center justify-center">
                        <span class="material-symbols-outlined text-[#0e7a3d]">description</span>
                    </div>
                    <div>
                        <p class="text-sm font-semibold text-[#171c1f]">{{ $materi->judul }}</p>
                        <p class="text-xs text-[#5c5f61]">Oleh: {{ $materi->guru->name ?? 'Guru' }} · {{ $materi->created_at->format('d M Y') }}</p>
                    </div>
                </div>
                @if($materi->file_path)
                    <a href="{{ Storage::url($materi->file_path) }}" target="_blank"
                       class="inline-flex items-center gap-2 px-4 py-2 bg-[#f0fdf4] border border-[#0e7a3d]/20 text-[#005f2d] text-sm font-semibold rounded-xl hover:bg-[#0e7a3d] hover:text-white transition-all">
                        <span class="material-symbols-outlined text-[18px]">download</span>
                        Download File
                    </a>
                @endif
            </div>

            {{-- Materi Asli --}}
            <div class="bg-white rounded-xl shadow-soft border border-[#eaeef2] overflow-hidden mb-6">
                <div class="px-6 py-4 border-b border-[#eaeef2] flex items-center gap-2">
                    <span class="material-symbols-outlined text-[#5c5f61] text-[20px]">article</span>
                    <h3 class="text-sm font-semibold text-[#171c1f] uppercase tracking-wider">Materi Asli</h3>
                </div>
                <div class="p-6 max-h-96 overflow-y-auto text-sm text-[#3f493f] leading-relaxed whitespace-pre-wrap bg-[#f6fafe]">
                    {{ $materi->materi_asli }}
                </div>
            </div>

            {{-- Ringkasan AI --}}
            @if($materi->ringkasan_ai)
            <div class="bg-white rounded-xl shadow-soft border border-[#eaeef2] overflow-hidden mb-6">
                <div class="px-6 py-4 bg-[#f0fdf4] border-b border-[#0e7a3d]/15 flex items-center gap-2">
                    <span class="material-symbols-outlined text-[#0e7a3d] filled-icon">auto_awesome</span>
                    <h3 class="text-sm font-semibold text-[#005f2d] uppercase tracking-wider">Ringkasan AI</h3>
                </div>
                <div class="p-6 text-sm text-[#171c1f] leading-relaxed whitespace-pre-wrap bg-[#f0fdf4]/40">
                    {{ $materi->ringkasan_ai }}
                </div>
            </div>
            @endif

            {{-- Back --}}
            <a href="{{ route('materi.index') }}"
               class="inline-flex items-center gap-2 text-sm font-medium text-[#005f2d] hover:text-[#0e7a3d] transition-colors">
                <span class="material-symbols-outlined text-[18px]">arrow_back</span>
                Kembali ke Daftar Materi
            </a>
        </div>
    </div>
</x-app-layout>
