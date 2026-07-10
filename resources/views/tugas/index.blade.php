<x-app-layout>
    <x-slot name="header">Daftar Tugas</x-slot>

    <div class="p-8">
        {{-- Page Header --}}
        <div class="flex justify-between items-center mb-8">
            <div>
                <p class="text-[11px] uppercase tracking-widest text-[#005f2d] font-semibold mb-1">Academic Tasks</p>
                <h2 class="text-2xl font-bold text-[#171c1f]">Daftar Tugas</h2>
            </div>
            @if(auth()->user()->role === 'guru')
                <a href="{{ route('tugas.create') }}"
                   class="inline-flex items-center gap-2 bg-[#005f2d] text-white px-5 py-2.5 rounded-xl text-sm font-semibold hover:bg-[#0e7a3d] transition-colors shadow-soft">
                    <span class="material-symbols-outlined text-[18px]">add</span>
                    Buat Tugas
                </a>
            @endif
        </div>

        {{-- Table Card --}}
        <div class="bg-white rounded-xl shadow-soft border border-[#eaeef2] overflow-hidden">
            <div class="px-6 py-4 border-b border-[#eaeef2] flex justify-between items-center">
                <h4 class="font-semibold text-[#171c1f]">Semua Tugas</h4>
                <span class="text-xs text-[#5c5f61]">{{ $tugas->count() }} tugas</span>
            </div>

            @if($tugas->isEmpty())
                <div class="p-16 text-center">
                    <div class="w-16 h-16 bg-[#eaeef2] rounded-full flex items-center justify-center mx-auto mb-4">
                        <span class="material-symbols-outlined text-[#5c5f61] text-3xl">assignment</span>
                    </div>
                    <p class="text-base font-medium text-[#171c1f]">Belum ada tugas</p>
                    <p class="text-sm text-[#5c5f61] mt-1">
                        @if(auth()->user()->role === 'guru')
                            Klik "Buat Tugas" untuk menambahkan tugas pertama.
                        @else
                            Belum ada tugas yang diberikan guru.
                        @endif
                    </p>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="bg-[#f6fafe]">
                                <th class="px-6 py-3.5 text-left text-[11px] font-semibold text-[#5c5f61] uppercase tracking-wider">No</th>
                                <th class="px-6 py-3.5 text-left text-[11px] font-semibold text-[#5c5f61] uppercase tracking-wider">Judul Tugas</th>
                                <th class="px-6 py-3.5 text-left text-[11px] font-semibold text-[#5c5f61] uppercase tracking-wider">Deadline</th>
                                @if(auth()->user()->role === 'siswa')
                                    <th class="px-6 py-3.5 text-left text-[11px] font-semibold text-[#5c5f61] uppercase tracking-wider">Status</th>
                                @else
                                    <th class="px-6 py-3.5 text-left text-[11px] font-semibold text-[#5c5f61] uppercase tracking-wider">Aksi</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-[#f0f4f8]">
                            @forelse($tugas as $item)
                                @php
                                    $pengumpulanSaya = auth()->user()->role === 'siswa'
                                        ? $item->pengumpulan->where('siswa_id', auth()->id())->first()
                                        : null;
                                    $sudahKumpul = $pengumpulanSaya && $pengumpulanSaya->status === 'sudah';
                                    $isOverdue = $item->deadline->isPast();
                                @endphp
                                <tr class="hover:bg-[#f6fafe] transition-colors">
                                    <td class="px-6 py-4 text-sm text-[#5c5f61] font-medium">{{ $loop->iteration }}</td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            <div class="w-9 h-9 rounded-xl bg-[#f0fdf4] flex items-center justify-center shrink-0">
                                                <span class="material-symbols-outlined text-[#0e7a3d] text-[18px]">assignment</span>
                                            </div>
                                            <div>
                                                <p class="text-sm font-semibold text-[#171c1f]">{{ $item->judul }}</p>
                                                @if($item->deskripsi)
                                                    <p class="text-xs text-[#5c5f61] truncate max-w-xs">{{ $item->deskripsi }}</p>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-1.5">
                                            <span class="material-symbols-outlined text-[16px] {{ $isOverdue ? 'text-[#ba1a1a]' : 'text-[#5c5f61]' }}">schedule</span>
                                            <span class="text-sm {{ $isOverdue ? 'text-[#ba1a1a] font-medium' : 'text-[#5c5f61]' }}">
                                                {{ $item->deadline->format('d M Y, H:i') }}
                                            </span>
                                            @if($isOverdue)
                                                <span class="px-2 py-0.5 text-[9px] font-bold bg-[#ffdad6] text-[#93000a] rounded-full uppercase">Lewat</span>
                                            @endif
                                        </div>
                                    </td>
                                    @if(auth()->user()->role === 'siswa')
                                        <td class="px-6 py-4">
                                            @if($sudahKumpul)
                                                <span class="px-3 py-1 text-[11px] font-bold bg-[#f0fdf4] text-[#005f2d] border border-[#0e7a3d]/20 rounded-full uppercase tracking-wider">
                                                    ✓ Selesai
                                                </span>
                                            @else
                                                <a href="{{ route('tugas.show', $item) }}"
                                                   class="inline-flex items-center gap-1 px-3 py-1.5 bg-[#005f2d] text-white text-xs font-semibold rounded-lg hover:bg-[#0e7a3d] transition-colors">
                                                    <span class="material-symbols-outlined text-[14px]">upload</span>
                                                    Kumpul
                                                </a>
                                            @endif
                                        </td>
                                    @else
                                        <td class="px-6 py-4">
                                            <div class="flex items-center gap-2">
                                                <a href="{{ route('tugas.show', $item) }}"
                                                   class="inline-flex items-center gap-1 text-sm text-[#005f2d] hover:text-[#0e7a3d] font-semibold transition-colors">
                                                    Detail
                                                </a>
                                                <span class="text-[#dfe3e7]">|</span>
                                                <a href="{{ route('tugas.edit', $item) }}"
                                                   class="inline-flex items-center gap-1 text-sm text-[#495362] hover:text-[#171c1f] font-medium transition-colors">
                                                    Edit
                                                </a>
                                                <span class="text-[#dfe3e7]">|</span>
                                                <form action="{{ route('tugas.destroy', $item) }}" method="POST" class="inline"
                                                      onsubmit="return confirm('Yakin ingin menghapus tugas ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                            class="text-sm text-[#ba1a1a] hover:text-[#93000a] font-medium transition-colors">
                                                        Hapus
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    @endif
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-12 text-center text-sm text-[#5c5f61]">Belum ada tugas</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
