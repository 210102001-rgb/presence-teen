<x-app-layout>
    <x-slot name="header">Pengumuman Sekolah</x-slot>

    <div class="p-4 md:p-8 max-w-7xl mx-auto space-y-6" x-data="{ filter: 'Semua', expanded: null, showForm: false }">
        {{-- Success Message --}}
        @if(session('success'))
            <div x-data x-init="$dispatch('toast', { type: 'success', message: '{{ session('success') }}' })"></div>
        @endif

        {{-- Page Header dengan Tombol Tambah --}}
        <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4 mb-8">
            <div>
                <h2 class="text-2xl font-bold text-[#171c1f]">Pengumuman Sekolah</h2>
                <p class="text-sm text-[#5c5f61] mt-0.5">Kelola dan bagikan informasi penting dengan seluruh sekolah</p>
            </div>
            @if(auth()->user()->role === 'guru')
                <a href="{{ route('pengumuman.create') }}"
                   class="inline-flex items-center gap-2 bg-[#005f2d] text-white px-5 py-2.5 rounded-xl text-sm font-semibold hover:bg-[#0e7a3d] transition-all shadow-soft">
                    <span class="material-symbols-outlined text-[18px]">add</span>
                    Tambah Pengumuman
                </a>
            @endif
        </div>

        {{-- Hero Section / AI Insight --}}
        <section class="mb-6">
            <div class="p-6 bg-surface-container-lowest rounded-2xl border border-primary-container/20 shadow-soft flex items-start gap-4 relative overflow-hidden">
                <div class="absolute top-0 right-0 p-6 opacity-5 pointer-events-none">
                    <span class="material-symbols-outlined text-[100px] text-primary">auto_awesome</span>
                </div>
                <div class="bg-primary-container/10 p-2.5 rounded-xl text-primary shrink-0">
                    <span class="material-symbols-outlined filled-icon">auto_awesome</span>
                </div>
                <div class="relative z-10">
                    <h3 class="font-bold text-primary text-sm mb-1">Ringkasan AI Pekan Ini</h3>
                    <p class="text-xs text-tertiary max-w-2xl leading-relaxed">
                        Terdapat {{ $pengumuman->count() }} pengumuman yang tersedia. Gunakan filter di bawah untuk melihat berdasarkan kategori.
                    </p>
                </div>
            </div>
        </section>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
            {{-- Announcement List Column (Col-span 8) --}}
            <div class="lg:col-span-8 space-y-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="font-bold text-lg text-on-surface">Terbaru</h3>
                    <div class="flex flex-wrap gap-2">
                        <template x-for="cat in ['Semua', 'Akademik', 'Administrasi', 'Kegiatan']" :key="cat">
                            <button
                                @click="filter = cat"
                                :class="filter === cat ? 'bg-primary text-white border-primary' : 'bg-white border-outline-variant text-secondary hover:bg-surface-container-lowest'"
                                class="px-3 py-1.5 min-h-[36px] text-xs font-semibold rounded-lg border transition-all"
                                x-text="cat">
                            </button>
                        </template>
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
                            'Sedang' => 'bg-surface-container-lowest text-primary',
                            default => 'bg-surface-container text-secondary'
                        };
                    @endphp
                    <div x-show="filter === 'Semua' || filter === '{{ $item->kategori }}'"
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 scale-95"
                         x-transition:enter-end="opacity-100 scale-100"
                         class="bg-white p-6 rounded-2xl shadow-soft border-l-4 {{ $borderCol }} border-t border-r border-b border-surface-container hover:shadow-md transition-shadow">
                        <div class="flex justify-between items-start mb-2">
                            <span class="px-2.5 py-0.5 text-[9px] font-bold {{ $bgCol }} rounded-full uppercase tracking-wider">{{ $item->prioritas }}</span>
                            <span class="text-[10px] text-secondary font-semibold">{{ $item->created_at->translatedFormat('d M Y') }}</span>
                        </div>
                        <h4 class="font-bold text-base text-on-surface mb-1">{{ $item->judul }}</h4>
                        <div class="flex items-center gap-1.5 mb-3 text-xs text-secondary">
                            <span class="material-symbols-outlined text-[16px]">category</span>
                            <span>{{ $item->kategori }}</span>
                        </div>
                        <p class="text-xs text-secondary leading-relaxed"
                           x-show="expanded === {{ $item->id }}">{{ $item->konten }}</p>
                        <p class="text-xs text-secondary leading-relaxed line-clamp-2"
                           x-show="expanded !== {{ $item->id }}">{{ $item->konten }}</p>
                        <div class="mt-4 pt-4 border-t border-surface-container flex justify-between items-center">
                            <button @click="expanded = expanded === {{ $item->id }} ? null : {{ $item->id }}"
                                    class="text-primary font-bold text-xs flex items-center gap-1 hover:underline">
                                <span x-text="expanded === {{ $item->id }} ? 'Tutup' : 'Lihat Detail'"></span>
                                <span class="material-symbols-outlined text-[16px]" x-text="expanded === {{ $item->id }} ? 'expand_less' : 'arrow_forward'"></span>
                            </button>
                            @if(auth()->user()->role === 'guru')
                                <div class="flex items-center gap-2">
                                    <a href="{{ route('pengumuman.edit', $item) }}"
                                       class="text-[#005f2d] hover:text-[#0e7a3d] text-xs font-semibold flex items-center gap-1 transition-colors">
                                        <span class="material-symbols-outlined text-[16px]">edit</span>
                                        Edit
                                    </a>
                                    <form action="{{ route('pengumuman.destroy', $item) }}" method="POST" style="display:inline;"
                                          onsubmit="return confirm('Apakah Anda yakin ingin menghapus pengumuman ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-[#ba1a1a] hover:text-[#93000a] text-xs font-semibold flex items-center gap-1 transition-colors">
                                            <span class="material-symbols-outlined text-[16px]">delete</span>
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            @endif
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
                <div class="bg-white p-6 rounded-2xl shadow-soft border border-surface-container h-full flex flex-col justify-between">
                    <div>
                        <h3 class="font-bold text-base text-on-surface mb-6">Linimasa Akademik</h3>
                        <div class="relative space-y-6 before:absolute before:left-[11px] before:top-2 before:bottom-2 before:w-[2px] before:bg-surface-container">
                            @forelse($pengumuman->take(5) as $timeline)
                                <div class="relative flex gap-4 items-start">
                                    <div class="w-6 h-6 rounded-full bg-primary flex items-center justify-center z-10 shadow-soft border-2 border-white text-white">
                                        <span class="material-symbols-outlined text-[12px]">event</span>
                                    </div>
                                    <div>
                                        <p class="text-[9px] font-bold text-primary uppercase tracking-wider">{{ $timeline->created_at->translatedFormat('d M Y') }}</p>
                                        <h5 class="font-bold text-sm text-on-surface leading-tight mt-0.5">{{ $timeline->judul }}</h5>
                                        <p class="text-[10px] text-secondary mt-1 italic">{{ $timeline->kategori }}</p>
                                    </div>
                                </div>
                            @empty
                                <p class="text-xs text-secondary text-center py-4">Belum ada linimasa.</p>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
