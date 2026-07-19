<x-app-layout>
    <x-slot name="header">Detail Tugas</x-slot>

    <div class="p-4 md:p-8">
        <div class="max-w-3xl mx-auto">
            {{-- Breadcrumb --}}
            <nav class="flex items-center gap-1.5 text-xs text-[#5c5f61] mb-6">
                <a href="{{ route('tugas.index') }}" class="hover:text-[#005f2d] transition-colors">Tugas</a>
                <span class="material-symbols-outlined text-[14px]">chevron_right</span>
                <span class="text-[#171c1f] font-medium truncate max-w-xs">{{ $tugas->judul }}</span>
            </nav>

            @if(session('success'))
                <div x-data x-init="$dispatch('toast', { type: 'success', message: '{{ session('success') }}' })"></div>
            @endif
            @if(session('error'))
                <div x-data x-init="$dispatch('toast', { type: 'error', message: '{{ session('error') }}' })"></div>
            @endif

            {{-- Tugas Header Card --}}
            <div class="bg-white rounded-xl shadow-soft border border-[#eaeef2] p-6 mb-6">
                <div class="flex items-start justify-between gap-4 mb-4">
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 rounded-xl bg-[#f0fdf4] flex items-center justify-center shrink-0">
                            <span class="material-symbols-outlined text-[#0e7a3d] filled-icon">assignment</span>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-[#171c1f]">{{ $tugas->judul }}</h3>
                            @if($tugas->deskripsi)
                                <p class="text-sm text-[#5c5f61] mt-1">{{ $tugas->deskripsi }}</p>
                            @endif
                        </div>
                    </div>
                    @php
                        $isOverdue = $tugas->deadline->isPast();
                    @endphp
                    <span class="shrink-0 px-3 py-1.5 text-[11px] font-bold rounded-full uppercase tracking-wider
                          {{ $isOverdue ? 'bg-[#ffdad6] text-[#93000a]' : 'bg-[#f0fdf4] text-[#005f2d] border border-[#0e7a3d]/20' }}">
                        {{ $isOverdue ? 'Lewat Deadline' : 'Aktif' }}
                    </span>
                </div>

                <div class="flex items-center gap-2 text-sm text-[#5c5f61] bg-[#f6fafe] rounded-xl px-4 py-3">
                    <span class="material-symbols-outlined text-[18px] {{ $isOverdue ? 'text-[#ba1a1a]' : 'text-[#005f2d]' }}">schedule</span>
                    <span class="{{ $isOverdue ? 'text-[#ba1a1a] font-semibold' : '' }}">
                        Deadline: {{ $tugas->deadline->format('d M Y, H:i') }} WIB
                    </span>
                </div>

                {{-- Kumpul Tugas (siswa) --}}
                @if(auth()->user()->role === 'siswa')
                    @php
                        $pengumpulanSaya = $tugas->pengumpulan->where('siswa_id', auth()->id())->first();
                        $sudahKumpul = $pengumpulanSaya && $pengumpulanSaya->status === 'sudah';
                    @endphp
                    <div class="mt-5 pt-5 border-t border-[#eaeef2]">
                        @if($sudahKumpul)
                            <div class="space-y-4">
                                {{-- Submitted File Info --}}
                                <div class="flex items-center gap-3 p-4 bg-[#f0fdf4] border border-[#0e7a3d]/20 rounded-xl">
                                    <span class="material-symbols-outlined text-[#0e7a3d] filled-icon">check_circle</span>
                                    <div class="flex-1">
                                        <p class="text-sm font-semibold text-[#005f2d]">Tugas sudah dikumpulkan</p>
                                        @if($pengumpulanSaya->waktu_kumpul)
                                            <p class="text-xs text-[#3f493f]">{{ \Carbon\Carbon::parse($pengumpulanSaya->waktu_kumpul)->format('d M Y, H:i') }}</p>
                                        @endif
                                        @if($pengumpulanSaya->nilai)
                                            <p class="text-xs text-[#005f2d] font-semibold mt-0.5">Nilai: {{ $pengumpulanSaya->nilai }}</p>
                                        @endif
                                    </div>
                                </div>

                                {{-- Show Submitted File --}}
                                @if($pengumpulanSaya->file_path)
                                    <div class="p-4 bg-[#f6fafe] border border-[#eaeef2] rounded-xl">
                                        <p class="text-xs font-semibold text-[#5c5f61] uppercase tracking-wider mb-2">File yang Dikumpulkan</p>
                                        <a href="{{ route('tugas.download', $pengumpulanSaya) }}" target="_blank"
                                           class="inline-flex items-center gap-2 text-sm text-[#005f2d] font-medium hover:underline">
                                            <span class="material-symbols-outlined text-[18px]">download</span>
                                            {{ basename($pengumpulanSaya->file_path) }}
                                        </a>
                                    </div>
                                @endif

                                {{-- Allow Re-upload if Not Overdue --}}
                                @if(!$isOverdue)
                                    <div class="p-4 bg-amber-50 border border-amber-200 rounded-xl">
                                        <p class="text-xs font-semibold text-amber-900 mb-3">Upload Ulang Tugas</p>
                                        <form action="{{ route('tugas.kumpul', $tugas) }}" method="POST" enctype="multipart/form-data" class="space-y-3" x-data="{ fileName: '' }">
                                            @csrf
                                            <label for="file_reupload"
                                                   class="flex flex-col items-center justify-center w-full h-24 border-2 border-dashed border-amber-300
                                                          rounded-xl cursor-pointer hover:border-amber-400 hover:bg-amber-50 transition-all group">
                                                <span class="material-symbols-outlined text-amber-700 text-2xl group-hover:scale-110 transition-transform mb-0.5" x-show="!fileName">cloud_upload</span>
                                                <span class="material-symbols-outlined text-amber-700 text-2xl" x-show="fileName" style="display: none;">check_circle</span>
                                                <p class="text-xs text-amber-700" x-show="!fileName"><span class="font-semibold">Klik untuk upload</span> file baru</p>
                                                <p class="text-xs text-amber-700 font-semibold" x-show="fileName" style="display: none;" x-text="fileName"></p>
                                                <input id="file_reupload" name="file" type="file" class="hidden" @change="fileName = $el.files[0]?.name || ''">
                                            </label>
                                            @error('file')
                                                <p class="text-xs text-[#ba1a1a]">{{ $message }}</p>
                                            @enderror
                                            <button type="submit"
                                                    class="w-full py-2 px-3 bg-amber-600 text-white text-xs font-semibold rounded-xl hover:bg-amber-700 transition-all active:scale-95">
                                                Perbarui Tugas
                                            </button>
                                        </form>
                                    </div>
                                @else
                                    <div class="p-4 bg-[#ffdad6]/40 border border-[#ba1a1a]/20 rounded-xl">
                                        <p class="text-xs font-medium text-[#93000a]">⏰ Deadline telah lewat. Tugas tidak dapat diperbarui lagi.</p>
                                    </div>
                                @endif
                            </div>
                        @elseif(!$isOverdue)
                            <form action="{{ route('tugas.kumpul', $tugas) }}" method="POST" enctype="multipart/form-data" class="space-y-4" x-data="{ fileName: '' }">
                                @csrf
                                <div>
                                    <label class="block text-sm font-semibold text-[#171c1f] mb-1.5">Upload File Tugas</label>
                                    <label for="file"
                                           class="flex flex-col items-center justify-center w-full h-32 border-2 border-dashed border-[#becabc]
                                                  rounded-xl cursor-pointer hover:border-[#005f2d] hover:bg-[#f0fdf4] transition-all group">
                                        <span class="material-symbols-outlined text-[#5c5f61] text-3xl group-hover:text-[#0e7a3d] mb-1" x-show="!fileName">cloud_upload</span>
                                        <span class="material-symbols-outlined text-[#0e7a3d] text-3xl mb-1" x-show="fileName" style="display: none;">check_circle</span>
                                        <p class="text-sm text-[#5c5f61]" x-show="!fileName"><span class="font-semibold text-[#005f2d]">Klik untuk upload</span> file tugas</p>
                                        <p class="text-sm font-semibold text-[#005f2d]" x-show="fileName" style="display: none;" x-text="fileName"></p>
                                        <input id="file" name="file" type="file" class="hidden" @change="fileName = $el.files[0]?.name || ''">
                                    </label>
                                    @error('file')
                                        <p class="mt-1 text-xs text-[#ba1a1a]">{{ $message }}</p>
                                    @enderror
                                </div>
                                <button type="submit"
                                        class="inline-flex items-center gap-2 px-6 py-3 bg-[#005f2d] text-white text-sm font-semibold
                                               rounded-xl hover:bg-[#0e7a3d] transition-all active:scale-95 shadow-soft">
                                    <span class="material-symbols-outlined text-[18px]">upload</span>
                                    Kumpulkan Tugas
                                </button>
                            </form>
                        @else
                            <div class="flex items-center gap-3 p-4 bg-[#ffdad6]/40 border border-[#ba1a1a]/20 rounded-xl">
                                <span class="material-symbols-outlined text-[#ba1a1a] filled-icon">cancel</span>
                                <p class="text-sm font-medium text-[#93000a]">Deadline telah lewat. Tugas tidak dapat dikumpulkan.</p>
                            </div>
                        @endif
                    </div>
                @endif

                {{-- Status Pengumpulan Anak (orang_tua) --}}
                @if(auth()->user()->role === 'orang_tua')
                    <div class="mt-5 pt-5 border-t border-[#eaeef2] space-y-4">
                        <h4 class="text-sm font-semibold text-[#171c1f] mb-3">Status Pengumpulan Anak</h4>
                        @php
                            $anakInKelas = auth()->user()->anak->filter(function($a) use ($tugas) {
                                return $a->kelasSaya->contains('id', $tugas->kelas_id);
                            });
                        @endphp
                        @foreach($anakInKelas as $child)
                            @php
                                $kumpul = $tugas->pengumpulan->where('siswa_id', $child->id)->first();
                                $sudah = $kumpul && $kumpul->status === 'sudah';
                            @endphp
                            <div class="flex flex-col sm:flex-row sm:items-center justify-between p-4 bg-[#f6fafe] rounded-xl border border-[#eaeef2] gap-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full bg-[#0e7a3d]/10 flex items-center justify-center text-[#005f2d] font-bold">
                                        {{ substr($child->name, 0, 1) }}
                                    </div>
                                    <div>
                                        <p class="text-sm font-semibold text-[#171c1f]">{{ $child->name }}</p>
                                        <p class="text-xs text-[#5c5f61]">NIS: {{ $child->nis ?? '-' }}</p>
                                    </div>
                                </div>
                                <div class="flex items-center gap-4 justify-between sm:justify-end">
                                    @if($sudah)
                                        <div class="text-right">
                                            <p class="text-[10px] text-[#5c5f61] uppercase tracking-wider font-bold">Dikumpulkan</p>
                                            <p class="text-xs font-semibold text-[#171c1f]">
                                                {{ \Carbon\Carbon::parse($kumpul->waktu_kumpul)->format('d M Y, H:i') }}
                                            </p>
                                            @if($kumpul->nilai)
                                                <p class="text-xs text-[#005f2d] font-bold">Nilai: {{ $kumpul->nilai }}</p>
                                            @endif
                                        </div>
                                        <span class="bg-[#f0fdf4] text-[#005f2d] border border-[#0e7a3d]/20 px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider">Sudah Dikumpulkan</span>
                                    @else
                                        @if($isOverdue)
                                            <span class="bg-[#ffdad6] text-[#93000a] border border-[#ba1a1a]/20 px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider">Belum Dikumpulkan (Terlambat)</span>
                                        @else
                                            <span class="bg-amber-50 text-amber-700 border border-amber-200 px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider">Belum Dikumpulkan</span>
                                        @endif
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            {{-- Daftar Pengumpulan (guru) --}}
            @if(auth()->user()->role === 'guru')
                <div class="bg-white rounded-xl shadow-soft border border-[#eaeef2] overflow-hidden mb-6">
                    <div class="px-6 py-4 border-b border-[#eaeef2] flex justify-between items-center">
                        <h4 class="font-semibold text-[#171c1f]">Daftar Pengumpulan Siswa</h4>
                        <span class="text-xs text-[#5c5f61]">
                            {{ $tugas->pengumpulan->count() }} siswa telah mengumpulkan
                        </span>
                    </div>

                    @if($tugas->pengumpulan && $tugas->pengumpulan->count())
                        <div class="overflow-x-auto">
                            <table class="w-full">
                                <thead>
                                    <tr class="bg-[#f6fafe]">
                                        <th class="px-6 py-3.5 text-left text-[11px] font-semibold text-[#5c5f61] uppercase tracking-wider">Nama Siswa</th>
                                        <th class="px-6 py-3.5 text-left text-[11px] font-semibold text-[#5c5f61] uppercase tracking-wider">Waktu Kumpul</th>
                                        <th class="px-6 py-3.5 text-left text-[11px] font-semibold text-[#5c5f61] uppercase tracking-wider">File</th>
                                        <th class="px-6 py-3.5 text-left text-[11px] font-semibold text-[#5c5f61] uppercase tracking-wider">Nilai</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-[#f0f4f8]">
                                    @foreach($tugas->pengumpulan as $p)
                                        <tr class="hover:bg-[#f6fafe] transition-colors">
                                            <td class="px-6 py-4">
                                                <div class="flex items-center gap-3">
                                                    <div class="w-8 h-8 rounded-full bg-[#0e7a3d] flex items-center justify-center text-white text-sm font-bold shrink-0">
                                                        {{ substr($p->siswa->name ?? '?', 0, 1) }}
                                                    </div>
                                                    <span class="text-sm font-medium text-[#171c1f]">{{ $p->siswa->name ?? '-' }}</span>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 text-sm text-[#5c5f61]">
                                                {{ $p->waktu_kumpul ? \Carbon\Carbon::parse($p->waktu_kumpul)->format('d M Y, H:i') : $p->created_at->format('d M Y, H:i') }}
                                            </td>
                                            <td class="px-6 py-4">
                                                @if($p->file_path)
                                                    <a href="{{ Storage::url($p->file_path) }}" target="_blank"
                                                       class="inline-flex items-center gap-1 text-sm text-[#005f2d] font-medium hover:underline">
                                                        <span class="material-symbols-outlined text-[16px]">download</span>
                                                        Unduh
                                                    </a>
                                                @else
                                                    <span class="text-xs text-[#5c5f61]">—</span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 text-sm font-semibold text-[#171c1f]">
                                                {{ $p->nilai ?? '—' }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="p-12 text-center">
                            <span class="material-symbols-outlined text-[#dfe3e7] text-4xl">inbox</span>
                            <p class="text-sm text-[#5c5f61] mt-3">Belum ada siswa yang mengumpulkan.</p>
                        </div>
                    @endif
                </div>
            @endif

            <a href="{{ route('tugas.index') }}"
               class="inline-flex items-center gap-2 text-sm font-medium text-[#005f2d] hover:text-[#0e7a3d] transition-colors">
                <span class="material-symbols-outlined text-[18px]">arrow_back</span>
                Kembali ke Daftar Tugas
            </a>
        </div>
    </div>
</x-app-layout>
