<x-app-layout>
    <x-slot name="header">Tambah Pengumuman Baru</x-slot>

    <div class="p-4 md:p-8 max-w-4xl mx-auto space-y-6">
        {{-- Page Header --}}
        <div>
            <h2 class="text-2xl font-bold text-[#171c1f]">Tambah Pengumuman Baru</h2>
            <p class="text-sm text-[#5c5f61] mt-0.5">Buat pengumuman untuk dibagikan ke seluruh sekolah</p>
        </div>

        {{-- Form Card --}}
        <div class="bg-white rounded-2xl shadow-soft border border-[#eaeef2] p-8">
            <form action="{{ route('pengumuman.store') }}" method="POST" class="space-y-6">
                @csrf

                {{-- Judul --}}
                <div>
                    <label for="judul" class="block text-sm font-semibold text-[#171c1f] mb-2">
                        Judul Pengumuman <span class="text-[#ba1a1a]">*</span>
                    </label>
                    <input type="text" id="judul" name="judul" value="{{ old('judul') }}"
                           placeholder="Contoh: Libur Hari Raya, Perubahan Jadwal Kelas..."
                           class="w-full px-4 py-3 border border-[#becabc] rounded-xl text-sm text-[#171c1f] bg-white
                                  focus:outline-none focus:ring-2 focus:ring-[#005f2d] focus:border-transparent transition-all
                                  @error('judul') border-[#ba1a1a] @enderror"
                           required>
                    @error('judul')
                        <p class="mt-1 text-xs text-[#ba1a1a]">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Kategori --}}
                <div>
                    <label for="kategori" class="block text-sm font-semibold text-[#171c1f] mb-2">
                        Kategori <span class="text-[#ba1a1a]">*</span>
                    </label>
                    <select id="kategori" name="kategori"
                            class="w-full px-4 py-3 border border-[#becabc] rounded-xl text-sm text-[#171c1f] bg-white
                                   focus:outline-none focus:ring-2 focus:ring-[#005f2d] focus:border-transparent transition-all
                                   @error('kategori') border-[#ba1a1a] @enderror"
                            required>
                        <option value="">Pilih Kategori...</option>
                        <option value="Akademik" {{ old('kategori') === 'Akademik' ? 'selected' : '' }}>Akademik</option>
                        <option value="Administrasi" {{ old('kategori') === 'Administrasi' ? 'selected' : '' }}>Administrasi</option>
                        <option value="Kegiatan" {{ old('kategori') === 'Kegiatan' ? 'selected' : '' }}>Kegiatan</option>
                    </select>
                    @error('kategori')
                        <p class="mt-1 text-xs text-[#ba1a1a]">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Prioritas --}}
                <div>
                    <label for="prioritas" class="block text-sm font-semibold text-[#171c1f] mb-2">
                        Prioritas <span class="text-[#ba1a1a]">*</span>
                    </label>
                    <select id="prioritas" name="prioritas"
                            class="w-full px-4 py-3 border border-[#becabc] rounded-xl text-sm text-[#171c1f] bg-white
                                   focus:outline-none focus:ring-2 focus:ring-[#005f2d] focus:border-transparent transition-all
                                   @error('prioritas') border-[#ba1a1a] @enderror"
                            required>
                        <option value="">Pilih Prioritas...</option>
                        <option value="Penting" {{ old('prioritas') === 'Penting' ? 'selected' : '' }}>Penting</option>
                        <option value="Sedang" {{ old('prioritas') === 'Sedang' ? 'selected' : '' }}>Sedang</option>
                        <option value="Biasa" {{ old('prioritas') === 'Biasa' ? 'selected' : '' }}>Biasa</option>
                    </select>
                    @error('prioritas')
                        <p class="mt-1 text-xs text-[#ba1a1a]">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Konten --}}
                <div>
                    <label for="konten" class="block text-sm font-semibold text-[#171c1f] mb-2">
                        Isi Pengumuman <span class="text-[#ba1a1a]">*</span>
                    </label>
                    <textarea id="konten" name="konten" rows="8" 
                              placeholder="Tuliskan isi pengumuman di sini. Jelaskan informasi penting dengan detail dan jelas."
                              class="w-full px-4 py-3 border border-[#becabc] rounded-xl text-sm text-[#171c1f] bg-white
                                     focus:outline-none focus:ring-2 focus:ring-[#005f2d] focus:border-transparent transition-all resize-none
                                     @error('konten') border-[#ba1a1a] @enderror"
                              required>{{ old('konten') }}</textarea>
                    @error('konten')
                        <p class="mt-1 text-xs text-[#ba1a1a]">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Action Buttons --}}
                <div class="flex items-center gap-3 pt-4 border-t border-[#eaeef2]">
                    <button type="submit"
                            class="inline-flex items-center gap-2 px-6 py-3 bg-[#005f2d] text-white text-sm font-semibold
                                   rounded-xl hover:bg-[#0e7a3d] transition-all active:scale-95 shadow-soft">
                        <span class="material-symbols-outlined text-[18px]">save</span>
                        Simpan Pengumuman
                    </button>
                    <a href="{{ route('pengumuman.index') }}"
                       class="px-6 py-3 border border-[#becabc] text-[#5c5f61] text-sm font-semibold rounded-xl hover:bg-[#f0f4f8] transition-all">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
