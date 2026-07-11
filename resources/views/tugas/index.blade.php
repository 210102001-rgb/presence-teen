<x-app-layout>
    <x-slot name="header">Daftar Tugas</x-slot>

    <div class="p-4 md:p-8 max-w-7xl mx-auto space-y-8">
        {{-- Page Header --}}
        <div class="flex justify-between items-center">
            <div>
                <p class="text-[#005f2d] font-semibold text-xs mb-1 uppercase tracking-widest">Academic Tasks</p>
                <h1 class="text-2xl font-bold text-[#171c1f]">Daftar Tugas</h1>
            </div>
            @if(auth()->user()->role === 'guru')
                <a href="{{ route('tugas.create') }}"
                   class="inline-flex items-center gap-2 bg-[#005f2d] text-white px-5 py-2.5 rounded-xl text-sm font-semibold hover:bg-[#0e7a3d] transition-colors shadow-soft">
                    <span class="material-symbols-outlined text-[18px]">add</span>
                    Buat Tugas
                </a>
            @endif
        </div>

        {{-- Bento Grid Layout --}}
        @if($tugas->isEmpty())
            <div class="bg-white rounded-2xl shadow-soft border border-[#eaeef2] p-16 text-center">
                <div class="w-16 h-16 bg-[#eaeef2] rounded-full flex items-center justify-center mx-auto mb-4">
                    <span class="material-symbols-outlined text-[#5c5f61] text-3xl">assignment</span>
                </div>
                <p class="text-base font-semibold text-[#171c1f]">Belum ada tugas</p>
                <p class="text-sm text-[#5c5f61] mt-1">
                    @if(auth()->user()->role === 'guru')
                        Klik "Buat Tugas" untuk menambahkan tugas pertama.
                    @else
                        Belum ada tugas yang diberikan guru.
                    @endif
                </p>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($tugas as $item)
                    @php
                        $pengumpulanSaya = auth()->user()->role === 'siswa'
                            ? $item->pengumpulan->where('siswa_id', auth()->id())->first()
                            : null;
                        $sudahKumpul = $pengumpulanSaya && $pengumpulanSaya->status === 'sudah';
                        $isOverdue = $item->deadline->isPast();
                    @endphp
                    <div class="group bg-white p-6 rounded-2xl border border-[#eaeef2] shadow-soft hover:-translate-y-1 transition-all duration-300 flex flex-col justify-between">
                        <div>
                            <div class="flex justify-between items-start mb-6">
                                <div class="w-12 h-12 rounded-xl bg-[#0e7a3d]/10 flex items-center justify-center text-[#005f2d] group-hover:bg-[#005f2d] group-hover:text-white transition-colors">
                                    <span class="material-symbols-outlined text-[28px]">assignment</span>
                                </div>
                                @if(auth()->user()->role === 'siswa')
                                    @if($sudahKumpul)
                                        <span class="bg-[#f0fdf4] text-[#005f2d] border border-[#0e7a3d]/20 px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider">Selesai</span>
                                    @elseif($isOverdue)
                                        <span class="bg-[#ffdad6] text-[#93000a] border border-[#ba1a1a]/20 px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider">Lewat</span>
                                    @else
                                        <span class="bg-amber-50 text-amber-700 border border-amber-200 px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider">Belum</span>
                                    @endif
                                @else
                                    <span class="bg-[#f6fafe] text-[#5c5f61] border border-[#becabc] px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider">Kelas: {{ $item->kelas->nama_kelas }}</span>
                                @endif
                            </div>
                            <h3 class="text-md font-bold text-[#171c1f] mb-2 leading-tight group-hover:text-[#005f2d] transition-colors">{{ $item->judul }}</h3>
                            @if($item->deskripsi)
                                <p class="text-xs text-[#5c5f61] line-clamp-2 mb-4">{{ $item->deskripsi }}</p>
                            @endif
                        </div>

                        <div class="space-y-2 border-t border-[#eaeef2] pt-4 mt-auto">
                            <div class="flex items-center justify-between text-xs mb-4">
                                <span class="text-[#5c5f61] flex items-center gap-1"><span class="material-symbols-outlined text-[16px]">schedule</span> Deadline</span>
                                <span class="font-bold {{ $isOverdue ? 'text-[#ba1a1a]' : 'text-[#171c1f]' }}">{{ $item->deadline->format('d M Y, H:i') }}</span>
                            </div>

                            <div class="flex items-center gap-3">
                                <a href="{{ route('tugas.show', $item) }}" class="flex-grow py-2 px-3 border border-[#005f2d] text-[#005f2d] font-bold text-xs rounded-xl hover:bg-[#f0fdf4] transition-all flex items-center justify-center gap-1">
                                    <span class="material-symbols-outlined text-[18px]">visibility</span> Lihat Detail
                                </a>
                                @if(auth()->user()->role === 'guru')
                                    <a href="{{ route('tugas.edit', $item) }}" class="p-2 bg-[#eaeef2] text-[#495362] rounded-xl hover:bg-[#dfe3e7] transition-all">
                                        <span class="material-symbols-outlined text-[20px]">edit</span>
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