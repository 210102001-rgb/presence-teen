<x-app-layout>
    <x-slot name="header">Jadwal Kelas</x-slot>

    @php
        $hariNama  = ['Senin','Selasa','Rabu','Kamis','Jumat'];
        $urutan    = ['Senin'=>0,'Selasa'=>1,'Rabu'=>2,'Kamis'=>3,'Jumat'=>4,'Sabtu'=>5];
    @endphp

    <div class="p-6 md:p-8" x-data="{ showForm: {{ $errors->any() || old('kelas_id') ? 'true' : 'false' }} }">

        @if(session('success'))
            <div x-data x-init="$dispatch('toast', { type: 'success', message: '{{ session('success') }}' })"></div>
        @endif

        {{-- Page Header --}}
        <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4 mb-8">
            <div>
                <h2 class="text-2xl font-bold text-[#171c1f]">Jadwal Kelas</h2>
                <p class="text-sm text-[#5c5f61] mt-0.5">Manage and view daily class schedules</p>
            </div>
            <button @click="showForm = !showForm"
                    class="inline-flex items-center gap-2 bg-[#005f2d] text-white px-5 py-2.5 rounded-xl text-sm font-semibold hover:bg-[#0e7a3d] transition-all shadow-soft">
                <span class="material-symbols-outlined text-[18px]" x-text="showForm ? 'close' : 'add'">add</span>
                <span x-text="showForm ? 'Batal' : 'Tambah Jadwal'">Tambah Jadwal</span>
            </button>
        </div>

        {{-- ===== FORM TAMBAH JADWAL ===== --}}
        <div x-show="showForm"
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 -translate-y-2"
             x-transition:enter-end="opacity-100 translate-y-0"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="mb-6 bg-white rounded-2xl shadow-soft border border-[#eaeef2] overflow-hidden">

            <div class="px-6 py-4 bg-[#f0fdf4] border-b border-[#0e7a3d]/15 flex items-center gap-3">
                <span class="material-symbols-outlined text-[#0e7a3d] filled-icon">calendar_add_on</span>
                <h3 class="font-semibold text-[#005f2d]">Tambah Jadwal Baru</h3>
            </div>

            <form action="{{ route('guru.jadwal.store') }}" method="POST" class="p-6">
                @csrf
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">

                    {{-- Kelas --}}
                    <div>
                        <label class="block text-sm font-semibold text-[#171c1f] mb-1.5">Kelas <span class="text-[#ba1a1a]">*</span></label>
                        <select name="kelas_id" required
                                class="w-full px-4 py-3 border border-[#becabc] rounded-xl text-sm text-[#171c1f] bg-white
                                       focus:outline-none focus:ring-2 focus:ring-[#005f2d] focus:border-[#005f2d] transition-all">
                            <option value="">Pilih Kelas...</option>
                            @foreach($kelas as $k)
                                <option value="{{ $k->id }}" {{ old('kelas_id') == $k->id ? 'selected' : '' }}>
                                    {{ $k->nama_kelas }}
                                </option>
                            @endforeach
                        </select>
                        @error('kelas_id') <p class="mt-1 text-xs text-[#ba1a1a]">{{ $message }}</p> @enderror
                    </div>

                    {{-- Mata Pelajaran --}}
                    <div>
                        <label class="block text-sm font-semibold text-[#171c1f] mb-1.5">Mata Pelajaran <span class="text-[#ba1a1a]">*</span></label>
                        <input type="text" name="mata_pelajaran" value="{{ old('mata_pelajaran') }}"
                               placeholder="Cth: Matematika, Fisika..."
                               class="w-full px-4 py-3 border border-[#becabc] rounded-xl text-sm text-[#171c1f]
                                      focus:outline-none focus:ring-2 focus:ring-[#005f2d] focus:border-[#005f2d] transition-all"
                               required>
                        @error('mata_pelajaran') <p class="mt-1 text-xs text-[#ba1a1a]">{{ $message }}</p> @enderror
                    </div>

                    {{-- Hari --}}
                    <div>
                        <label class="block text-sm font-semibold text-[#171c1f] mb-1.5">Hari <span class="text-[#ba1a1a]">*</span></label>
                        <select name="hari" required
                                class="w-full px-4 py-3 border border-[#becabc] rounded-xl text-sm text-[#171c1f] bg-white
                                       focus:outline-none focus:ring-2 focus:ring-[#005f2d] focus:border-[#005f2d] transition-all">
                            <option value="">Pilih Hari...</option>
                            @foreach(['Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'] as $h)
                                <option value="{{ $h }}" {{ old('hari') == $h ? 'selected' : '' }}>{{ $h }}</option>
                            @endforeach
                        </select>
                        @error('hari') <p class="mt-1 text-xs text-[#ba1a1a]">{{ $message }}</p> @enderror
                    </div>

                    {{-- Jam Mulai --}}
                    <div>
                        <label class="block text-sm font-semibold text-[#171c1f] mb-1.5">Jam Mulai <span class="text-[#ba1a1a]">*</span></label>
                        <input type="time" name="jam_mulai" value="{{ old('jam_mulai', '07:00') }}"
                               class="w-full px-4 py-3 border border-[#becabc] rounded-xl text-sm text-[#171c1f]
                                      focus:outline-none focus:ring-2 focus:ring-[#005f2d] focus:border-[#005f2d] transition-all"
                               required>
                        @error('jam_mulai') <p class="mt-1 text-xs text-[#ba1a1a]">{{ $message }}</p> @enderror
                    </div>

                    {{-- Jam Selesai --}}
                    <div>
                        <label class="block text-sm font-semibold text-[#171c1f] mb-1.5">Jam Selesai <span class="text-[#ba1a1a]">*</span></label>
                        <input type="time" name="jam_selesai" value="{{ old('jam_selesai', '08:30') }}"
                               class="w-full px-4 py-3 border border-[#becabc] rounded-xl text-sm text-[#171c1f]
                                      focus:outline-none focus:ring-2 focus:ring-[#005f2d] focus:border-[#005f2d] transition-all"
                               required>
                        @error('jam_selesai') <p class="mt-1 text-xs text-[#ba1a1a]">{{ $message }}</p> @enderror
                    </div>

                    {{-- Ruang --}}
                    <div>
                        <label class="block text-sm font-semibold text-[#171c1f] mb-1.5">Ruang</label>
                        <input type="text" name="ruang" value="{{ old('ruang') }}"
                               placeholder="Cth: Ruang 201, Lab IPA..."
                               class="w-full px-4 py-3 border border-[#becabc] rounded-xl text-sm text-[#171c1f]
                                      focus:outline-none focus:ring-2 focus:ring-[#005f2d] focus:border-[#005f2d] transition-all">
                        @error('ruang') <p class="mt-1 text-xs text-[#ba1a1a]">{{ $message }}</p> @enderror
                    </div>

                    {{-- Topik --}}
                    <div class="sm:col-span-2 lg:col-span-3">
                        <label class="block text-sm font-semibold text-[#171c1f] mb-1.5">Topik / Materi (opsional)</label>
                        <input type="text" name="topik" value="{{ old('topik') }}"
                               placeholder="Cth: Limit Fungsi, Hukum Newton..."
                               class="w-full px-4 py-3 border border-[#becabc] rounded-xl text-sm text-[#171c1f]
                                      focus:outline-none focus:ring-2 focus:ring-[#005f2d] focus:border-[#005f2d] transition-all">
                        @error('topik') <p class="mt-1 text-xs text-[#ba1a1a]">{{ $message }}</p> @enderror
                    </div>

                </div>

                <div class="flex items-center gap-3 mt-6 pt-5 border-t border-[#eaeef2]">
                    <button type="submit"
                            class="inline-flex items-center gap-2 px-6 py-3 bg-[#005f2d] text-white text-sm font-semibold
                                   rounded-xl hover:bg-[#0e7a3d] transition-all active:scale-95 shadow-soft">
                        <span class="material-symbols-outlined text-[18px]">save</span>
                        Simpan Jadwal
                    </button>
                    <button type="button" @click="showForm = false"
                            class="px-6 py-3 border border-[#becabc] text-[#5c5f61] text-sm font-semibold rounded-xl hover:bg-[#f0f4f8] transition-all">
                        Batal
                    </button>
                </div>
            </form>
        </div>

        {{-- ===== LAYOUT UTAMA: Kalender + Agenda ===== --}}
        <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">

            {{-- ===== KIRI: Kalender + Tabel Jadwal ===== --}}
            <div class="xl:col-span-2 flex flex-col gap-6">

                {{-- Kalender Mingguan --}}
                <div class="bg-white rounded-2xl shadow-soft border border-[#eaeef2] overflow-hidden">
                    <div class="flex items-center justify-between px-6 py-4 border-b border-[#eaeef2]">
                        <h3 class="font-bold text-[#171c1f]">{{ $today->translatedFormat('F Y') }}</h3>
                        <span class="text-xs text-[#5c5f61]">Minggu Ini</span>
                    </div>

                    <div class="overflow-x-auto">
                        <div class="min-w-[520px]">
                            {{-- Header hari --}}
                            <div class="grid grid-cols-5 border-b border-[#eaeef2]">
                                @foreach($weekDays as $i => $day)
                                    @php $isToday = $day->isToday(); @endphp
                                    <div class="flex flex-col items-center py-3 px-2
                                                {{ $isToday ? 'bg-[#f0fdf4]' : '' }}
                                                {{ $i < 4 ? 'border-r border-[#eaeef2]' : '' }}">
                                        <span class="text-[10px] font-semibold text-[#5c5f61] uppercase tracking-wider">
                                            {{ $hariNama[$i] }}
                                        </span>
                                        <span class="text-xl font-bold mt-0.5 {{ $isToday ? 'text-[#005f2d]' : 'text-[#171c1f]' }}">
                                            {{ $day->day }}
                                        </span>
                                    </div>
                                @endforeach
                            </div>

                            {{-- Body kalender --}}
                            <div class="relative grid grid-cols-5" style="min-height:320px;">
                                {{-- Garis jam --}}
                                <div class="absolute inset-0 pointer-events-none z-0 col-span-5">
                                    @foreach(['07:00','08:00','09:00','10:00','11:00','12:00','13:00'] as $jam)
                                        @php $pct = ((int)explode(':',$jam)[0] - 7) / 6 * 100; @endphp
                                        <div class="absolute left-0 right-0 flex items-center" style="top:{{ $pct }}%">
                                            <span class="text-[9px] text-[#becabc] w-10 text-right pr-1 shrink-0">{{ $jam }}</span>
                                            <div class="flex-1 border-t border-[#f0f4f8]"></div>
                                        </div>
                                    @endforeach
                                </div>

                                @foreach($weekDays as $colIdx => $day)
                                    @php $hariKolom = $hariNama[$colIdx]; @endphp
                                    <div class="relative px-1 pt-1 pb-2
                                                {{ $colIdx < 4 ? 'border-r border-[#eaeef2]' : '' }}
                                                {{ $day->isToday() ? 'bg-[#f0fdf4]/40' : '' }}"
                                         style="min-height:320px;">

                                        @foreach($jadwals->where('hari', $hariKolom) as $j)
                                            @php
                                                [$sh,$sm] = explode(':', substr($j->jam_mulai,0,5));
                                                [$eh,$em] = explode(':', substr($j->jam_selesai,0,5));
                                                $startMin = (int)$sh*60+(int)$sm - 7*60;
                                                $durMin   = (int)$eh*60+(int)$em - ((int)$sh*60+(int)$sm);
                                                $topPct   = $startMin / 360 * 100;
                                                $hgtPct   = max(8, $durMin / 360 * 100);
                                                $c        = $colorMap[$j->kelas_id] ?? ['style'=>'background:#005f2d;color:#fff;border-left:4px solid #003d1c;'];
                                            @endphp
                                            <div class="absolute left-1 right-1 rounded-lg px-1.5 py-1 text-[10px] leading-tight
                                                         hover:brightness-95 transition-all overflow-hidden z-10 cursor-pointer shadow-sm"
                                                 style="top:{{ $topPct }}%; height:{{ $hgtPct }}%; {{ $c['style'] }}">
                                                <p class="font-bold truncate">{{ $j->mata_pelajaran }}</p>
                                                <p class="text-[9px] opacity-75 truncate">{{ $j->jam_label }}</p>
                                            </div>
                                        @endforeach

                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Tabel Semua Jadwal --}}
                <div class="bg-white rounded-2xl shadow-soft border border-[#eaeef2] overflow-hidden">
                    <div class="px-6 py-4 border-b border-[#eaeef2] flex justify-between items-center">
                        <h3 class="font-bold text-[#171c1f]">Semua Jadwal Mengajar</h3>
                        <span class="text-xs text-[#5c5f61]">{{ $jadwals->count() }} jadwal terdaftar</span>
                    </div>

                    @if($jadwals->isEmpty())
                        <div class="p-12 text-center">
                            <span class="material-symbols-outlined text-[#dfe3e7] text-4xl">event_note</span>
                            <p class="text-sm font-medium text-[#171c1f] mt-3">Belum ada jadwal</p>
                            <p class="text-xs text-[#5c5f61] mt-1">Klik "+ Tambah Jadwal" untuk menambahkan jadwal pertama.</p>
                        </div>
                    @else
                        <div class="overflow-x-auto">
                            <table class="w-full text-left">
                                <thead>
                                    <tr class="bg-[#f6fafe] border-b border-[#eaeef2]">
                                        <th class="px-5 py-3 text-[10px] font-bold text-[#5c5f61] uppercase tracking-wider">Hari</th>
                                        <th class="px-5 py-3 text-[10px] font-bold text-[#5c5f61] uppercase tracking-wider">Jam</th>
                                        <th class="px-5 py-3 text-[10px] font-bold text-[#5c5f61] uppercase tracking-wider">Mata Pelajaran</th>
                                        <th class="px-5 py-3 text-[10px] font-bold text-[#5c5f61] uppercase tracking-wider">Kelas</th>
                                        <th class="px-5 py-3 text-[10px] font-bold text-[#5c5f61] uppercase tracking-wider">Ruang</th>
                                        <th class="px-5 py-3 text-[10px] font-bold text-[#5c5f61] uppercase tracking-wider">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-[#f0f4f8]">
                                    @foreach($jadwals as $j)
                                        @php $c = $colorMap[$j->kelas_id] ?? ['style'=>'background:#005f2d;color:#fff;border-left:4px solid #003d1c;', 'badge'=>'background:#005f2d;']; @endphp
                                        <tr class="hover:bg-[#f6fafe] transition-colors group">
                                            <td class="px-5 py-3.5">
                                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold uppercase"
                                                      style="{{ $c['style'] }}">
                                                    {{ $j->hari }}
                                                </span>
                                            </td>
                                            <td class="px-5 py-3.5 text-sm font-semibold text-[#171c1f] whitespace-nowrap">
                                                {{ $j->jam_label }}
                                            </td>
                                            <td class="px-5 py-3.5">
                                                <div class="flex items-start gap-2">
                                                    <span class="mt-1.5 w-2.5 h-2.5 rounded-full shrink-0"
                                                          style="{{ $c['badge'] }}"></span>
                                                    <div>
                                                        <p class="text-sm font-semibold text-[#171c1f]">{{ $j->mata_pelajaran }}</p>
                                                        @if($j->topik)
                                                            <p class="text-[10px] text-[#5c5f61] mt-0.5">{{ $j->topik }}</p>
                                                        @endif
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-5 py-3.5 text-sm text-[#5c5f61]">
                                                {{ $j->kelas->nama_kelas ?? '-' }}
                                            </td>
                                            <td class="px-5 py-3.5 text-sm text-[#5c5f61]">
                                                {{ $j->ruang ?: '—' }}
                                            </td>
                                            <td class="px-5 py-3.5">
                                                <div class="flex items-center gap-2 lg:opacity-0 lg:group-hover:opacity-100 transition-opacity">
                                                    <a href="{{ route('presensi.guru.qr', $j->kelas_id) }}"
                                                       class="inline-flex items-center gap-1 px-2.5 py-1.5 bg-[#f0fdf4] border border-[#0e7a3d]/20 rounded-lg text-[10px] font-semibold text-[#005f2d] hover:bg-[#0e7a3d] hover:text-white transition-all">
                                                        <span class="material-symbols-outlined text-[12px]">qr_code_scanner</span>
                                                        Presensi
                                                    </a>
                                                    <form action="{{ route('guru.jadwal.destroy', $j) }}" method="POST"
                                                          x-data
                                                          @submit.prevent="$dispatch('confirm', { title: 'Hapus Jadwal?', description: 'Jadwal {{ $j->mata_pelajaran }} ({{ $j->hari }}) akan dihapus permanen.', type: 'danger', confirmText: 'Hapus', onConfirm: () => $el.submit() })">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                                class="inline-flex items-center gap-1 px-2.5 py-1.5 bg-[#ffdad6] border border-[#ba1a1a]/20 rounded-lg text-[10px] font-semibold text-[#93000a] hover:bg-[#ba1a1a] hover:text-white transition-all">
                                                            <span class="material-symbols-outlined text-[12px]">delete</span>
                                                            Hapus
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>

            </div>

            {{-- ===== KANAN: Hari Ini + Agenda ===== --}}
            <div class="flex flex-col gap-5">

                {{-- Card Hari Ini --}}
                <div class="bg-[#005f2d] rounded-2xl p-6 text-white">
                    <p class="text-[9px] font-bold uppercase tracking-widest text-white/50 mb-1">HARI INI</p>
                    <p class="text-2xl font-bold mb-5">{{ $today->translatedFormat('l, d M') }}</p>
                    <div class="flex gap-8">
                        <div>
                            <p class="text-3xl font-extrabold">{{ $hariIni->count() }}</p>
                            <p class="text-[11px] text-white/60 mt-0.5">Kelas</p>
                        </div>
                        <div class="w-px bg-white/20"></div>
                        <div>
                            <p class="text-3xl font-extrabold">{{ number_format($totalJam, 1) }}</p>
                            <p class="text-[11px] text-white/60 mt-0.5">Jam</p>
                        </div>
                    </div>
                </div>

                {{-- Agenda Harian --}}
                <div class="bg-white rounded-2xl shadow-soft border border-[#eaeef2] flex flex-col overflow-hidden">
                    <div class="flex justify-between items-center px-5 py-4 border-b border-[#eaeef2]">
                        <h4 class="font-bold text-[#171c1f]">Agenda Harian</h4>
                        <span class="text-xs text-[#5c5f61]">{{ $today->translatedFormat('l') }}</span>
                    </div>

                    <div class="flex flex-col divide-y divide-[#f0f4f8]">
                        @forelse($hariIni->sortBy('jam_mulai') as $i => $agenda)
                            <div class="flex gap-4 px-5 py-4">
                                {{-- Waktu & dot --}}
                                <div class="flex flex-col items-center shrink-0 w-12">
                                    <span class="text-[10px] font-semibold text-[#5c5f61]">{{ substr($agenda->jam_mulai,0,5) }}</span>
                                    <div class="w-2 h-2 rounded-full mt-1.5 {{ $i === 0 ? 'bg-[#005f2d]' : 'bg-[#becabc]' }}"></div>
                                    @if(!$loop->last)
                                        <div class="w-px bg-[#eaeef2] flex-1 mt-1 min-h-[24px]"></div>
                                    @endif
                                </div>
                                {{-- Konten --}}
                                <div class="flex-1 min-w-0 pb-1">
                                    <div class="flex items-start justify-between gap-2 mb-1">
                                        <p class="font-bold text-sm text-[#171c1f] leading-tight">{{ $agenda->mata_pelajaran }}</p>
                                        @if($i === 0)
                                            <span class="shrink-0 px-2 py-0.5 bg-[#f0fdf4] text-[#005f2d] border border-[#0e7a3d]/20 text-[9px] font-bold rounded-full uppercase">
                                                Berlangsung
                                            </span>
                                        @endif
                                    </div>
                                    <p class="text-xs text-[#5c5f61]">
                                        {{ $agenda->kelas->nama_kelas ?? '-' }}
                                        @if($agenda->ruang) • {{ $agenda->ruang }} @endif
                                    </p>
                                    <div class="flex gap-2 mt-2.5">
                                        <a href="{{ route('presensi.guru.qr', $agenda->kelas_id) }}"
                                           class="inline-flex items-center gap-1 px-2.5 py-1 bg-[#f0fdf4] border border-[#0e7a3d]/20 rounded-lg text-[10px] font-semibold text-[#005f2d] hover:bg-[#0e7a3d] hover:text-white transition-all">
                                            <span class="material-symbols-outlined text-[12px]">qr_code_scanner</span> Presensi
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="p-8 text-center">
                                <span class="material-symbols-outlined text-[#dfe3e7] text-3xl">event_busy</span>
                                <p class="text-sm text-[#5c5f61] mt-2">Tidak ada kelas hari ini.</p>
                            </div>
                        @endforelse
                    </div>

                    {{-- Tambah Catatan --}}
                    <div class="px-5 py-3 border-t border-[#eaeef2]">
                        <button @click="showForm = true; $nextTick(() => window.scrollTo({top:0,behavior:'smooth'}))"
                                class="w-full flex items-center justify-center gap-2 py-2.5 border-2 border-dashed border-[#becabc] rounded-xl text-sm font-semibold text-[#5c5f61] hover:border-[#005f2d] hover:text-[#005f2d] transition-all">
                            <span class="material-symbols-outlined text-[18px]">add</span>
                            Tambah Jadwal Baru
                        </button>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
