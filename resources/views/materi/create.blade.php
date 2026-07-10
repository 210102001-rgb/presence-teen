<x-app-layout>
    <x-slot name="header">Upload Materi</x-slot>

    <div class="p-8">
        <div class="max-w-2xl mx-auto">
            {{-- Breadcrumb --}}
            <nav class="flex items-center gap-1.5 text-xs text-[#5c5f61] mb-6">
                <a href="{{ route('dashboard') }}" class="hover:text-[#005f2d] transition-colors">Dashboard</a>
                <span class="material-symbols-outlined text-[14px]">chevron_right</span>
                <span class="text-[#171c1f] font-medium">Upload Materi</span>
            </nav>

            {{-- AI Info Banner --}}
            <div class="ai-glow rounded-xl p-4 mb-6 flex items-center gap-3">
                <span class="material-symbols-outlined text-[#0e7a3d] filled-icon shrink-0">auto_awesome</span>
                <p class="text-sm text-[#3f493f]">
                    Setelah upload, AI Claude akan otomatis mengekstrak teks dan membuat ringkasan untuk siswa.
                    Mendukung format <strong>PDF, DOCX, dan TXT</strong>.
                </p>
            </div>

            <div class="bg-white rounded-xl shadow-soft border border-[#eaeef2] p-8">
                <form action="{{ route('materi.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf

                    {{-- Judul --}}
                    <div>
                        <label for="judul" class="block text-sm font-semibold text-[#171c1f] mb-1.5">
                            Judul Materi
                        </label>
                        <input id="judul" name="judul" type="text"
                               value="{{ old('judul') }}"
                               placeholder="Contoh: Bab 3 — Sistem Persamaan Linear"
                               class="w-full px-4 py-3 border border-[#becabc] rounded-xl text-sm text-[#171c1f] bg-white
                                      focus:outline-none focus:ring-2 focus:ring-[#005f2d] focus:border-[#005f2d] transition-all"
                               required>
                        @error('judul')
                            <p class="mt-1.5 text-xs text-[#ba1a1a]">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- File Upload --}}
                    <div>
                        <label class="block text-sm font-semibold text-[#171c1f] mb-1.5">
                            File Materi
                        </label>
                        <label for="file"
                               class="flex flex-col items-center justify-center w-full h-40 border-2 border-dashed border-[#becabc]
                                      rounded-xl cursor-pointer hover:border-[#005f2d] hover:bg-[#f0fdf4] transition-all group">
                            <span class="material-symbols-outlined text-[#5c5f61] text-4xl group-hover:text-[#0e7a3d] transition-colors mb-2">cloud_upload</span>
                            <p class="text-sm text-[#5c5f61] group-hover:text-[#005f2d]">
                                <span class="font-semibold text-[#005f2d]">Klik untuk upload</span> atau drag & drop
                            </p>
                            <p class="text-xs text-[#5c5f61] mt-1">PDF, DOCX, TXT — Maks. 10 MB</p>
                            <input id="file" name="file" type="file" class="hidden" accept=".txt,.pdf,.docx" required>
                        </label>
                        {{-- Filename preview --}}
                        <p id="filename-display" class="mt-2 text-xs text-[#5c5f61] hidden">
                            <span class="material-symbols-outlined text-[14px] align-middle text-[#0e7a3d]">attach_file</span>
                            <span id="filename-text"></span>
                        </p>
                        @error('file')
                            <p class="mt-1.5 text-xs text-[#ba1a1a]">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Buttons --}}
                    <div class="flex items-center gap-3 pt-2">
                        <button type="submit"
                                class="inline-flex items-center gap-2 px-6 py-3 bg-[#005f2d] text-white text-sm font-semibold
                                       rounded-xl hover:bg-[#0e7a3d] transition-all active:scale-95 shadow-soft">
                            <span class="material-symbols-outlined text-[18px]">upload_file</span>
                            Upload Materi
                        </button>
                        <a href="{{ route('dashboard') }}"
                           class="inline-flex items-center gap-2 px-6 py-3 border border-[#becabc] text-[#5c5f61] text-sm font-semibold
                                  rounded-xl hover:bg-[#f0f4f8] transition-all">
                            Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.getElementById('file').addEventListener('change', function () {
            const display = document.getElementById('filename-display');
            const text = document.getElementById('filename-text');
            if (this.files.length > 0) {
                text.textContent = this.files[0].name;
                display.classList.remove('hidden');
            }
        });
    </script>
    @endpush
</x-app-layout>
