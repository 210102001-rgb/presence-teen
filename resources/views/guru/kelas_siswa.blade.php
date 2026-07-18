<x-app-layout>
    <x-slot name="header">Kelola Siswa</x-slot>

    @php
        $siswaJson = $semuaSiswa->map(function($row) {
            $name = trim($row['siswa']->name);
            $words = explode(' ', $name);
            $initials = strtoupper(
                implode('', array_slice(array_map(fn($w) => $w[0] ?? '', $words), 0, 2))
            );
            return [
                'id'       => $row['siswa']->id,
                'name'     => $row['siswa']->name,
                'nis'      => $row['siswa']->nis ?? '-',
                'email'    => $row['siswa']->email,
                'initials' => $initials,
                'kelas'    => $row['kelas']->nama_kelas,
                'kelas_id' => (string) $row['kelas']->id,
                'rate'     => (int) $row['rate'],
            ];
        })->values()->toJson();
    @endphp

    <div class="p-6 md:p-8"
         x-data="studentDirectory()"
         x-init="allItems = JSON.parse(document.getElementById('siswa-data').textContent)">

        {{-- Hidden data container --}}
        <script id="siswa-data" type="application/json">{!! $siswaJson !!}</script>

        {{-- ===== Page Header ===== --}}
        <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4 mb-8">
            <div>
                <h1 class="text-2xl font-bold text-[#171c1f]">Kelola Siswa</h1>
                <p class="text-sm text-[#5c5f61] mt-0.5">Mengelola dan memantau kehadiran siswa dan perangkat yang digunakan.</p>
            </div>
            <div class="flex flex-wrap items-center gap-3 shrink-0">
                <button onclick="window.print()"
                        class="inline-flex items-center gap-2 px-4 py-2.5 border border-[#0e7a3d] text-[#005f2d] bg-[#f0fdf4] rounded-xl text-sm font-semibold hover:bg-[#0e7a3d] hover:text-white transition-all">
                    <span class="material-symbols-outlined text-[18px]">download</span>
                    Export
                </button>
                <a href="{{ route('dashboard.guru') }}"
                   class="inline-flex items-center gap-2 px-4 py-2.5 border border-[#becabc] text-[#5c5f61] rounded-xl text-sm font-semibold hover:bg-[#f0f4f8] transition-all">
                    <span class="material-symbols-outlined text-[18px]">upload</span>
                    Import
                </a>
                <a href="{{ route('presensi.guru') }}"
                   class="inline-flex items-center gap-2 px-5 py-2.5 bg-[#005f2d] text-white rounded-xl text-sm font-semibold hover:bg-[#0e7a3d] transition-all shadow-soft">
                    <span class="material-symbols-outlined text-[18px]">add</span>
                    Tambah Siswa
                </a>
            </div>
        </div>

        {{-- ===== Main Card ===== --}}
        <div class="bg-white rounded-2xl shadow-soft border border-[#eaeef2] overflow-hidden">

            {{-- Filter Bar --}}
            <div class="px-6 py-4 border-b border-[#eaeef2] flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                <div class="flex items-center gap-3 flex-wrap">
                    <span class="text-sm text-[#5c5f61] font-medium shrink-0">Filter :</span>

                    {{-- Filter Kelas --}}
                    <select x-model="filterKelas" @change="page=1"
                            class="px-3 py-2 border border-[#becabc] rounded-xl text-sm text-[#171c1f] bg-white
                                   focus:outline-none focus:ring-2 focus:ring-[#005f2d] focus:border-[#005f2d] transition-all">
                        <option value="all"> Semua Kelas </option>
                        @foreach($kelas as $k)
                            <option value="{{ $k->id }}">{{ $k->nama_kelas }}</option>
                        @endforeach
                    </select>

                    {{-- Search --}}
                    <div class="relative flex-1 min-w-[200px]">
                        <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-[#5c5f61] text-[18px]">search</span>
                        <input type="text" x-model="search" @input="page=1"
                               placeholder="Cari Siswa..."
                               class="w-full pl-9 pr-4 py-2 border border-[#becabc] rounded-xl text-sm text-[#171c1f]
                                      focus:outline-none focus:ring-2 focus:ring-[#005f2d] focus:border-[#005f2d] transition-all">
                    </div>
                </div>

                <p class="text-xs text-[#5c5f61] shrink-0">
                    Menampilkan
                    <span x-text="Math.min((page-1)*perPage+1, filtered.length)"></span>–<span x-text="Math.min(page*perPage, filtered.length)"></span>
                    dari <span x-text="filtered.length"></span> siswa
                </p>
            </div>

            {{-- Table --}}
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="bg-[#f6fafe] border-b border-[#eaeef2]">
                            <th class="px-6 py-3.5 text-xs font-semibold text-[#5c5f61]">NAMA SISWA</th>
                            <th class="px-6 py-3.5 text-xs font-semibold text-[#5c5f61] hidden sm:table-cell">KELAS</th>
                            <th class="px-6 py-3.5 text-xs font-semibold text-[#5c5f61] hidden md:table-cell">STATUS PERANGKAT</th>
                            <th class="px-6 py-3.5 text-xs font-semibold text-[#5c5f61] hidden sm:table-cell">KEHADIRAN %</th>
                            <th class="px-6 py-3.5 text-xs font-semibold text-[#5c5f61]">AKSI</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#f0f4f8]">
                        <template x-for="(item, idx) in paginated" :key="item.id + '_' + item.kelas_id">
                            <tr class="hover:bg-[#f6fafe] transition-colors">

                                {{-- Student Name --}}
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-full bg-[#0e7a3d] flex items-center justify-center text-white text-xs font-bold shrink-0"
                                             x-text="item.initials.substring(0,2)"></div>
                                        <div>
                                            <p class="text-sm font-semibold text-[#171c1f]" x-text="item.name"></p>
                                            <p class="text-[10px] text-[#5c5f61]" x-text="'NIS: ' + item.nis"></p>
                                        </div>
                                    </div>
                                </td>

                                {{-- Class --}}
                                <td class="px-6 py-4 text-sm text-[#5c5f61] hidden sm:table-cell" x-text="item.kelas"></td>

                                {{-- Device Status: aktif jika rate > 0, inactive jika 0 --}}
                                <td class="px-6 py-4 hidden md:table-cell">
                                    <span :class="item.rate > 0
                                        ? 'bg-[#f0fdf4] text-[#005f2d] border border-[#0e7a3d]/20'
                                        : 'bg-[#ffdad6] text-[#93000a] border border-[#ba1a1a]/20'"
                                          class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[11px] font-bold">
                                        <span :class="item.rate > 0 ? 'bg-[#0e7a3d]' : 'bg-[#ba1a1a]'"
                                              class="w-1.5 h-1.5 rounded-full"></span>
                                        <span x-text="item.rate > 0 ? 'Active' : 'Inactive'"></span>
                                    </span>
                                </td>

                                {{-- Attendance % with progress bar --}}
                                <td class="px-6 py-4 hidden sm:table-cell">
                                    <div class="flex items-center gap-3 min-w-[140px]">
                                        <span class="text-sm font-bold text-[#171c1f] w-10 shrink-0"
                                              x-text="item.rate + '%'"></span>
                                        <div class="flex-1 h-2 bg-[#eaeef2] rounded-full overflow-hidden">
                                            <div class="h-full rounded-full transition-all"
                                                 :style="`width: ${item.rate}%; background-color: ${
                                                     item.rate >= 90 ? '#005f2d' :
                                                     item.rate >= 75 ? '#f59e0b' : '#ba1a1a'
                                                 };`"></div>
                                        </div>
                                    </div>
                                </td>

                                {{-- Actions --}}
                                <td class="px-6 py-4">
                                    <div class="relative" x-data="{ open: false }">
                                        <button @click="open = !open" @click.away="open = false"
                                                class="w-8 h-8 flex items-center justify-center rounded-lg hover:bg-[#f0f4f8] transition-colors text-[#5c5f61]">
                                            <span class="material-symbols-outlined text-[20px]">more_vert</span>
                                        </button>
                                        <div x-show="open"
                                             x-transition:enter="transition ease-out duration-100"
                                             x-transition:enter-start="opacity-0 scale-95"
                                             x-transition:enter-end="opacity-100 scale-100"
                                             class="absolute right-0 mt-1 w-44 bg-white rounded-xl shadow-lg border border-[#eaeef2] z-20 py-1"
                                             style="display:none;">
                                            <a :href="'/profile/anak/' + item.id"
                                               class="flex items-center gap-2 px-4 py-2.5 text-sm text-[#171c1f] hover:bg-[#f6fafe] transition-colors">
                                                <span class="material-symbols-outlined text-[16px] text-[#005f2d]">person</span>
                                                Lihat Profil
                                            </a>
                                            <a :href="'/presensi/riwayat'"
                                               class="flex items-center gap-2 px-4 py-2.5 text-sm text-[#171c1f] hover:bg-[#f6fafe] transition-colors">
                                                <span class="material-symbols-outlined text-[16px] text-[#005f2d]">history</span>
                                                Riwayat Presensi
                                            </a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </template>

                        {{-- Empty state --}}
                        <tr x-show="filtered.length === 0">
                            <td colspan="5" class="px-6 py-16 text-center">
                                <span class="material-symbols-outlined text-[#dfe3e7] text-4xl">group_off</span>
                                <p class="text-sm text-[#5c5f61] mt-3">Tidak ada siswa ditemukan.</p>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            <div class="px-4 sm:px-6 py-4 border-t border-[#eaeef2] flex items-center justify-between gap-3"
                 x-show="totalPages > 1">
                <button @click="page = Math.max(1, page - 1)"
                        :disabled="page === 1"
                        class="px-3 sm:px-4 py-2 border border-[#becabc] rounded-lg text-sm font-semibold text-[#5c5f61]
                               hover:bg-[#f0f4f8] disabled:opacity-40 disabled:cursor-not-allowed transition-all flex items-center gap-1">
                    <span class="material-symbols-outlined text-[18px] sm:hidden">chevron_left</span>
                    <span class="hidden sm:inline">Previous</span>
                </button>

                <div class="flex items-center gap-1">
                    <template x-for="p in totalPages" :key="p">
                        <button @click="page = p"
                                :class="page === p
                                    ? 'bg-[#005f2d] text-white'
                                    : 'text-[#5c5f61] hover:bg-[#f0f4f8]'"
                                class="w-9 h-9 rounded-lg text-sm font-semibold transition-all"
                                x-text="p">
                        </button>
                    </template>
                </div>

                <button @click="page = Math.min(totalPages, page + 1)"
                        :disabled="page === totalPages"
                        class="px-3 sm:px-4 py-2 border border-[#becabc] rounded-lg text-sm font-semibold text-[#5c5f61]
                               hover:bg-[#f0f4f8] disabled:opacity-40 disabled:cursor-not-allowed transition-all flex items-center gap-1">
                    <span class="hidden sm:inline">Next</span>
                    <span class="material-symbols-outlined text-[18px] sm:hidden">chevron_right</span>
                </button>
            </div>

        </div>

        {{-- Summary Cards per Kelas --}}
        @if($kelas->isNotEmpty())
        <div class="mt-6 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
            @foreach($kelas as $k)
                <div class="bg-white rounded-2xl shadow-soft border border-[#eaeef2] p-5 flex items-center gap-4">
                    <div class="w-12 h-12 bg-[#f0fdf4] rounded-xl flex items-center justify-center shrink-0">
                        <span class="material-symbols-outlined text-[#0e7a3d] filled-icon">class</span>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="font-bold text-sm text-[#171c1f] truncate">{{ $k->nama_kelas }}</p>
                        <p class="text-xs text-[#5c5f61]">{{ $k->mata_pelajaran }}</p>
                    </div>
                    <div class="text-right shrink-0">
                        <p class="text-2xl font-bold text-[#005f2d]">{{ $k->siswa->count() }}</p>
                        <p class="text-[10px] text-[#5c5f61]">Siswa</p>
                    </div>
                </div>
            @endforeach
        </div>
        @endif

    </div>

    @push('scripts')
    <script>
        function studentDirectory() {
            return {
                search: '',
                filterKelas: 'all',
                page: 1,
                perPage: 10,
                allItems: [],
                get filtered() {
                    let items = this.allItems;
                    if (this.search) {
                        const q = this.search.toLowerCase();
                        items = items.filter(i =>
                            i.name.toLowerCase().includes(q) ||
                            String(i.nis).toLowerCase().includes(q)
                        );
                    }
                    if (this.filterKelas !== 'all') {
                        items = items.filter(i => String(i.kelas_id) === String(this.filterKelas));
                    }
                    return items;
                },
                get paginated() {
                    const start = (this.page - 1) * this.perPage;
                    return this.filtered.slice(start, start + this.perPage);
                },
                get totalPages() {
                    return Math.ceil(this.filtered.length / this.perPage) || 1;
                }
            };
        }
    </script>
    @endpush

</x-app-layout>
