<x-app-layout>
    <x-slot name="header">Edit Tugas</x-slot>

    <div class="p-4 md:p-8">
        <div class="max-w-2xl mx-auto">
            {{-- Breadcrumb --}}
            <nav class="flex items-center gap-1.5 text-xs text-[#5c5f61] mb-6">
                <a href="{{ route('tugas.index') }}" class="hover:text-[#005f2d] transition-colors">Tugas</a>
                <span class="material-symbols-outlined text-[14px]">chevron_right</span>
                <span class="text-[#171c1f] font-medium">Edit</span>
            </nav>

            <div class="bg-white rounded-xl shadow-soft border border-[#eaeef2] p-8">
                <div class="flex items-center gap-3 mb-6 pb-5 border-b border-[#eaeef2]">
                    <div class="w-10 h-10 bg-[#f0fdf4] rounded-xl flex items-center justify-center">
                        <span class="material-symbols-outlined text-[#0e7a3d]">edit</span>
                    </div>
                    <div>
                        <h3 class="font-semibold text-[#171c1f]">Edit Tugas</h3>
                        <p class="text-xs text-[#5c5f61]">Perbarui detail tugas yang sudah ada</p>
                    </div>
                </div>

                <form action="{{ route('tugas.update', $tugas) }}" method="POST" class="space-y-5">
                    @csrf
                    @method('PUT')

                    <div>
                        <label for="judul" class="block text-sm font-semibold text-[#171c1f] mb-1.5">Judul Tugas</label>
                        <input id="judul" name="judul" type="text"
                               value="{{ old('judul', $tugas->judul) }}"
                               class="w-full px-4 py-3 border border-[#becabc] rounded-xl text-sm text-[#171c1f]
                                      focus:outline-none focus:ring-2 focus:ring-[#005f2d] focus:border-[#005f2d] transition-all"
                               required>
                        @error('judul')
                            <p class="mt-1 text-xs text-[#ba1a1a]">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="deskripsi" class="block text-sm font-semibold text-[#171c1f] mb-1.5">Deskripsi <span class="text-[#5c5f61] font-normal">(opsional)</span></label>
                        <textarea id="deskripsi" name="deskripsi" rows="4"
                                  class="w-full px-4 py-3 border border-[#becabc] rounded-xl text-sm text-[#171c1f]
                                         focus:outline-none focus:ring-2 focus:ring-[#005f2d] focus:border-[#005f2d] transition-all resize-none">{{ old('deskripsi', $tugas->deskripsi) }}</textarea>
                        @error('deskripsi')
                            <p class="mt-1 text-xs text-[#ba1a1a]">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="deadline" class="block text-sm font-semibold text-[#171c1f] mb-1.5">Deadline</label>
                        <input id="deadline" name="deadline" type="datetime-local"
                               value="{{ old('deadline', \Carbon\Carbon::parse($tugas->deadline)->format('Y-m-d\TH:i')) }}"
                               class="w-full px-4 py-3 border border-[#becabc] rounded-xl text-sm text-[#171c1f]
                                      focus:outline-none focus:ring-2 focus:ring-[#005f2d] focus:border-[#005f2d] transition-all"
                               required>
                        @error('deadline')
                            <p class="mt-1 text-xs text-[#ba1a1a]">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="kelas_id" class="block text-sm font-semibold text-[#171c1f] mb-1.5">Kelas</label>
                        <select id="kelas_id" name="kelas_id"
                                class="w-full px-4 py-3 border border-[#becabc] rounded-xl text-sm text-[#171c1f]
                                       focus:outline-none focus:ring-2 focus:ring-[#005f2d] focus:border-[#005f2d] transition-all bg-white"
                                required>
                            <option value="">Pilih Kelas...</option>
                            @foreach($kelas as $k)
                                <option value="{{ $k->id }}" {{ old('kelas_id', $tugas->kelas_id) == $k->id ? 'selected' : '' }}>
                                    {{ $k->nama_kelas }} — {{ $k->mata_pelajaran }}
                                </option>
                            @endforeach
                        </select>
                        @error('kelas_id')
                            <p class="mt-1 text-xs text-[#ba1a1a]">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex items-center gap-3 pt-3 border-t border-[#eaeef2]">
                        <button type="submit"
                                class="inline-flex items-center gap-2 px-6 py-3 bg-[#005f2d] text-white text-sm font-semibold
                                       rounded-xl hover:bg-[#0e7a3d] transition-all active:scale-95 shadow-soft">
                            <span class="material-symbols-outlined text-[18px]">save</span>
                            Perbarui Tugas
                        </button>
                        <a href="{{ route('tugas.index') }}"
                           class="inline-flex items-center px-6 py-3 border border-[#becabc] text-[#5c5f61] text-sm font-semibold
                                  rounded-xl hover:bg-[#f0f4f8] transition-all">
                            Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
