<x-app-layout>
    <x-slot name="header">Upload Materi</x-slot>

    <div class="p-6 md:p-8">
        <div class="max-w-3xl mx-auto">
            {{-- Header --}}
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-[#171c1f]">Upload Materi Pembelajaran</h1>
                <p class="text-sm text-[#5c5f61] mt-1">Tambahkan materi baru untuk siswa Anda.</p>
            </div>

            {{-- Form Card --}}
            <div class="bg-white rounded-2xl shadow-soft border border-[#eaeef2] p-8">
                <form action="{{ route('materi.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf

                    {{-- Judul --}}
                    <div>
                        <label for="judul" class="block text-sm font-semibold text-[#171c1f] mb-2">
                            Judul Materi <span class="text-[#ba1a1a]">*</span>
                        </label>
                        <input id="judul" name="judul" type="text"
                               value="{{ old('judul') }}"
                               placeholder="Contoh: Cellular Respiration Guide"
                               class="w-full px-4 py-3 border border-[#becabc] rounded-xl text-sm text-[#171c1f] bg-white
                                      focus:outline-none focus:ring-2 focus:ring-[#005f2d] focus:border-[#005f2d] transition-all"
                               required>
                        @error('judul')
                            <p class="mt-1.5 text-xs text-[#ba1a1a]">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Mata Pelajaran --}}
                    <div>
                        <label for="mata_pelajaran" class="block text-sm font-semibold text-[#171c1f] mb-2">
                            Mata Pelajaran <span class="text-[#ba1a1a]">*</span>
                        </label>
                        <select id="mata_pelajaran" name="mata_pelajaran"
                                class="w-full px-4 py-3 border border-[#becabc] rounded-xl text-sm text-[#171c1f] bg-white
                                       focus:outline-none focus:ring-2 focus:ring-[#005f2d] focus:border-[#005f2d] transition-all"
                                required>
                            <option value="">Pilih Mata Pelajaran</option>
                            <option value="Umum">Umum</option>
                            <option value="Biology">Biologi</option>
                            <option value="Mathematics">Matematika</option>
                            <option value="Physics">Fisika</option>
                            <option value="History">Sejarah</option>
                            <option value="English">Inggris</option>
                            <option value="Indonesian">Indonesia</option>
                        </select>
                        @error('mata_pelajaran')
                            <p class="mt-1.5 text-xs text-[#ba1a1a]">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- File Upload --}}
                    <div>
                        <label class="block text-sm font-semibold text-[#171c1f] mb-2">
                            File Materi <span class="text-[#ba1a1a]">*</span>
                        </label>
                        <label for="file"
                               class="flex flex-col items-center justify-center w-full h-48 border-2 border-dashed border-[#becabc]
                                      rounded-2xl cursor-pointer hover:border-[#005f2d] hover:bg-[#f0fdf4] transition-all group">
                            <span class="material-symbols-outlined text-[#5c5f61] text-5xl group-hover:text-[#0e7a3d] transition-colors mb-3">cloud_upload</span>
                            <p class="text-sm text-[#171c1f] font-semibold group-hover:text-[#005f2d]">
                                Klik untuk upload atau drag & drop
                            </p>
                            <p class="text-xs text-[#5c5f61] mt-2">PDF, DOCX, TXT — Maks. 10 MB</p>
                            <input id="file" name="file" type="file" class="hidden" accept=".txt,.pdf,.docx" required>
                        </label>
                        {{-- Filename preview --}}
                        <div id="filename-display" class="mt-3 hidden p-3 bg-[#f0fdf4] border border-[#0e7a3d]/20 rounded-lg flex items-center gap-2">
                            <span class="material-symbols-outlined text-[#0e7a3d] text-[18px]">attach_file</span>
                            <span id="filename-text" class="text-sm text-[#005f2d] font-medium"></span>
                        </div>
                        @error('file')
                            <p class="mt-1.5 text-xs text-[#ba1a1a]">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Buttons --}}
                    <div class="flex items-center gap-3 pt-4 border-t border-[#eaeef2]">
                        <button type="submit"
                                class="inline-flex items-center gap-2 px-6 py-3 bg-[#005f2d] text-white text-sm font-semibold
                                       rounded-xl hover:bg-[#0e7a3d] transition-all active:scale-95 shadow-soft">
                            <span class="material-symbols-outlined text-[18px]">upload_file</span>
                            Upload Materi
                        </button>
                        <a href="{{ route('materi.index') }}"
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
            } else {
                display.classList.add('hidden');
            }
        });
    </script>
    @endpush
</x-app-layout>
