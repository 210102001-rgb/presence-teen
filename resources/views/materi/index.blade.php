<x-app-layout>
    <x-slot name="header">Learning Materials</x-slot>

    <div class="p-6 md:p-8">

        @if(session('success'))
            <div x-data x-init="$dispatch('toast', { type: 'success', message: '{{ session('success') }}' })"></div>
        @endif

        {{-- Header --}}
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-[#171c1f]">Learning Materials</h1>
            <p class="text-sm text-[#5c5f61] mt-1">Manage and access academic resources.</p>
        </div>

        {{-- Action Bar --}}
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8">
            <div class="flex items-center gap-2">
                <span class="material-symbols-outlined text-[#5c5f61]">search</span>
                <input type="text" placeholder="Cari materi..."
                       x-model="search"
                       class="flex-1 min-w-0 px-4 py-2.5 border border-[#becabc] rounded-xl text-sm text-[#171c1f]
                              focus:outline-none focus:ring-2 focus:ring-[#005f2d] focus:border-[#005f2d]">
            </div>
            <div class="flex items-center gap-3">
                <button class="inline-flex items-center gap-2 px-4 py-2.5 border border-[#becabc] text-[#5c5f61] rounded-xl text-sm font-semibold hover:bg-[#f0f4f8] transition-all">
                    <span class="material-symbols-outlined text-[18px]">tune</span>
                    Filter
                </button>
                @if(auth()->user()->role === 'guru')
                    <a href="{{ route('materi.create') }}"
                       class="inline-flex items-center gap-2 bg-[#005f2d] text-white px-5 py-2.5 rounded-xl text-sm font-semibold hover:bg-[#0e7a3d] transition-all">
                        <span class="material-symbols-outlined text-[18px]">upload_file</span>
                        Upload Material
                    </a>
                @endif
            </div>
        </div>

        {{-- Materials Grid - Card Layout --}}
        @if($materi->isEmpty())
            <div class="bg-white rounded-2xl shadow-soft border border-[#eaeef2] p-12 text-center">
                <div class="w-16 h-16 bg-[#eaeef2] rounded-full flex items-center justify-center mx-auto mb-4">
                    <span class="material-symbols-outlined text-[#5c5f61] text-3xl">menu_book</span>
                </div>
                <p class="text-base font-semibold text-[#171c1f]">Belum ada materi</p>
                <p class="text-sm text-[#5c5f61] mt-2 mb-5">Belum ada materi yang ditambahkan.</p>
                @if(auth()->user()->role === 'guru')
                    <a href="{{ route('materi.create') }}"
                       class="inline-flex items-center gap-2 bg-[#005f2d] text-white px-5 py-3 rounded-xl text-sm font-semibold hover:bg-[#0e7a3d] transition-all">
                        <span class="material-symbols-outlined text-[18px]">upload_file</span>
                        Upload Material Pertama
                    </a>
                @endif
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($materi as $item)
                    @php
                        // Map subject to color and icon
                        $subjects = [
                            'Biology' => ['color' => 'bg-[#c8e6c9]', 'icon' => 'biology'],
                            'Mathematics' => ['color' => 'bg-[#bbdefb]', 'icon' => 'calculate'],
                            'History' => ['color' => 'bg-[#ffe0b2]', 'icon' => 'history'],
                            'Physics' => ['color' => 'bg-[#f8bbd0]', 'icon' => 'science'],
                            'English' => ['color' => 'bg-[#d1c4e9]', 'icon' => 'language'],
                        ];
                        
                        $subjectName = $item->mata_pelajaran ?? 'Mathematics';
                        $subjectConfig = $subjects[$subjectName] ?? ['color' => 'bg-[#bbdefb]', 'icon' => 'description'];
                    @endphp
                    <div class="bg-white rounded-2xl shadow-soft border border-[#eaeef2] overflow-hidden hover:shadow-lg transition-shadow group">
                        
                        {{-- Card Top - Subject Icon --}}
                        <div class="p-6 bg-gradient-to-br from-gray-50 to-gray-100 flex items-center justify-between">
                            <div class="w-14 h-14 rounded-xl {{ $subjectConfig['color'] }} flex items-center justify-center">
                                <span class="material-symbols-outlined text-[28px] text-[#171c1f] filled-icon">{{ $subjectConfig['icon'] }}</span>
                            </div>
                            <span class="px-3 py-1.5 bg-white border border-[#becabc] text-[#5c5f61] rounded-full text-xs font-semibold">
                                {{ $subjectName }}
                            </span>
                        </div>

                        {{-- Card Content --}}
                        <div class="p-6 space-y-4">
                            {{-- Title --}}
                            <div>
                                <h3 class="text-base font-bold text-[#171c1f] group-hover:text-[#005f2d] transition-colors">
                                    {{ $item->judul }}
                                </h3>
                            </div>

                            {{-- Meta Info --}}
                            <div class="text-xs text-[#5c5f61] space-y-1">
                                <p>Added {{ $item->created_at->format('M d, Y') }}</p>
                                @if($item->file_path)
                                    <p>
                                        @php
                                            $ext = strtoupper(pathinfo($item->file_path, PATHINFO_EXTENSION));
                                            $fullPath = Storage::disk('public')->path($item->file_path);
                                            $bytes = file_exists($fullPath) ? filesize($fullPath) : 0;
                                            $size = $bytes > 1048576
                                                ? round($bytes / 1048576, 1) . ' MB'
                                                : ($bytes > 1024 ? round($bytes / 1024, 1) . ' KB' : $bytes . ' B');
                                        @endphp
                                        • {{ $ext }} • {{ $size }}
                                    </p>
                                @endif
                            </div>

                            {{-- Action Buttons --}}
                            <div class="flex gap-2 pt-4 border-t border-[#eaeef2]">
                                <a href="{{ route('materi.show', $item) }}"
                                   class="flex-1 inline-flex items-center justify-center gap-1.5 py-2.5 px-3 border border-[#becabc] text-[#5c5f61] rounded-lg text-sm font-semibold hover:bg-[#f0f4f8] transition-all">
                                    <span class="material-symbols-outlined text-[18px]">visibility</span>
                                    Preview
                                </a>
                                @if($item->file_path)
                                    <a href="{{ Storage::url($item->file_path) }}" target="_blank" download
                                       class="flex-1 inline-flex items-center justify-center gap-1.5 py-2.5 px-3 border border-[#becabc] text-[#5c5f61] rounded-lg text-sm font-semibold hover:bg-[#f0f4f8] transition-all">
                                        <span class="material-symbols-outlined text-[18px]">download</span>
                                        Download
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
