<x-app-layout>
    <x-slot name="header">Manajemen Kelas</x-slot>

    <div class="p-6 md:p-8">

        @if(session('success'))
            <div x-data x-init="$dispatch('toast', { type: 'success', message: '{{ session('success') }}' })"></div>
        @endif

        {{-- Header --}}
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-[#171c1f]">Manajemen Kelas</h1>
            <p class="text-sm text-[#5c5f61] mt-1">Kelola daftar kelas, guru wali, dan jumlah siswa.</p>
        </div>

        {{-- Action Bar --}}
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
            <div class="flex items-center gap-2">
                <span class="material-symbols-outlined text-[#5c5f61]">search</span>
                <input type="text" placeholder="Cari kelas..."
                       x-model="search"
                       class="flex-1 min-w-0 px-4 py-2.5 border border-[#becabc] rounded-xl text-sm text-[#171c1f]
                              focus:outline-none focus:ring-2 focus:ring-[#005f2d] focus:border-[#005f2d]">
            </div>
            <div class="flex items-center gap-3">
                <button class="inline-flex items-center gap-2 px-4 py-2.5 border border-[#becabc] text-[#5c5f61] rounded-xl text-sm font-semibold hover:bg-[#f0f4f8] transition-all">
                    <span class="material-symbols-outlined text-[18px]">tune</span>
                    Filter
                </button>
                <button type="button" onclick="document.getElementById('tambah-kelas-modal').showModal()"
                        class="inline-flex items-center gap-2 bg-[#005f2d] text-white px-5 py-2.5 rounded-xl text-sm font-semibold hover:bg-[#0e7a3d] transition-all">
                    <span class="material-symbols-outlined text-[18px]">add</span>
                    Tambah Kelas
                </button>
            </div>
        </div>

        {{-- Table --}}
        <div class="bg-white rounded-2xl shadow-soft border border-[#eaeef2] overflow-hidden">

            @if($kelas->isEmpty())
                {{-- Empty State --}}
                <div class="p-12 text-center">
                    <div class="w-16 h-16 bg-[#eaeef2] rounded-full flex items-center justify-center mx-auto mb-4">
                        <span class="material-symbols-outlined text-[#5c5f61] text-3xl">class</span>
                    </div>
                    <p class="text-base font-medium text-[#171c1f]">Belum ada kelas</p>
                    <p class="text-sm text-[#5c5f61] mt-2 mb-5">Buat kelas pertama untuk memulai mengelola siswa dan presensi.</p>
                    <button type="button" onclick="document.getElementById('tambah-kelas-modal').showModal()"
                            class="inline-flex items-center gap-2 bg-[#005f2d] text-white px-5 py-3 rounded-xl text-sm font-semibold hover:bg-[#0e7a3d] transition-all">
                        <span class="material-symbols-outlined text-[18px]">add</span>
                        Buat Kelas Pertama
                    </button>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="bg-[#f6fafe] border-b border-[#eaeef2]">
                                <th class="px-6 py-4 text-xs font-semibold text-[#5c5f61] uppercase tracking-wider">Nama Kelas</th>
                                <th class="px-6 py-4 text-xs font-semibold text-[#5c5f61] uppercase tracking-wider">Wali Kelas</th>
                                <th class="px-6 py-4 text-xs font-semibold text-[#5c5f61] uppercase tracking-wider">Jumlah Siswa</th>
                                <th class="px-6 py-4 text-xs font-semibold text-[#5c5f61] uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-[#eaeef2]">
                            @foreach($kelas as $k)
                                <tr class="hover:bg-[#f6fafe] transition-colors">
                                    {{-- Nama Kelas --}}
                                    <td class="px-6 py-4">
                                        <div>
                                            <p class="text-sm font-semibold text-[#171c1f]">{{ $k->nama_kelas }}</p>
                                            <p class="text-xs text-[#5c5f61] mt-0.5">Tahun Ajaran {{ $k->tahun_ajaran }}</p>
                                        </div>
                                    </td>

                                    {{-- Wali Kelas (Guru) --}}
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-2">
                                            <div class="w-8 h-8 rounded-full bg-[#005f2d] flex items-center justify-center text-white text-xs font-bold shrink-0">
                                                {{ substr($k->waliKelas->name, 0, 2) }}
                                            </div>
                                            <div>
                                                <p class="text-sm font-medium text-[#171c1f]">{{ $k->waliKelas->name }}</p>
                                            </div>
                                        </div>
                                    </td>

                                    {{-- Jumlah Siswa --}}
                                    <td class="px-6 py-4">
                                        <span class="inline-flex items-center gap-1 px-3 py-1.5 bg-[#e8f5e9] text-[#005f2d] rounded-full text-sm font-semibold">
                                            {{ $k->siswa_count ?? 0 }} Siswa
                                        </span>
                                    </td>

                                    {{-- Aksi --}}
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-2">
                                            <button type="button" x-data="{}"
                                                    @click="window.dispatchEvent(new CustomEvent('edit-kelas-open', { detail: { id: {{ $k->id }}, nama_kelas: @js($k->nama_kelas), tahun_ajaran: @js($k->tahun_ajaran), guru_id: @js($k->guru_id) } }))"
                                                    class="p-2 text-[#005f2d] hover:bg-[#f0fdf4] rounded-lg transition-colors">
                                                <span class="material-symbols-outlined text-[18px]">edit</span>
                                            </button>
                                            <form action="{{ route('guru.kelas.destroy', $k) }}" method="POST" class="inline"
                                                  x-data
                                                  @submit.prevent="$dispatch('confirm', { title: 'Hapus Kelas?', description: 'Kelas {{ $k->nama_kelas }} akan dihapus permanen.', type: 'danger', confirmText: 'Hapus', onConfirm: () => $el.submit() })">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="p-2 text-[#ba1a1a] hover:bg-[#ffdad6] rounded-lg transition-colors">
                                                    <span class="material-symbols-outlined text-[18px]">delete</span>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>

                                @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- Pagination Footer --}}
                <div class="px-6 py-4 border-t border-[#eaeef2] flex items-center justify-between">
                    <p class="text-xs text-[#5c5f61]">Menampilkan 1-3 dari 15 Kelas</p>
                    <div class="flex items-center gap-2">
                        <button class="w-9 h-9 flex items-center justify-center rounded-lg border border-[#becabc] text-[#5c5f61] hover:bg-[#f0f4f8] transition-all">
                            <span class="material-symbols-outlined text-[18px]">chevron_left</span>
                        </button>
                        <button class="w-9 h-9 flex items-center justify-center rounded-lg bg-[#005f2d] text-white font-semibold">1</button>
                        <button class="w-9 h-9 flex items-center justify-center rounded-lg border border-[#becabc] text-[#5c5f61] hover:bg-[#f0f4f8] transition-all">2</button>
                        <button class="w-9 h-9 flex items-center justify-center rounded-lg border border-[#becabc] text-[#5c5f61] hover:bg-[#f0f4f8] transition-all">3</button>
                        <button class="w-9 h-9 flex items-center justify-center rounded-lg border border-[#becabc] text-[#5c5f61] hover:bg-[#f0f4f8] transition-all">
                            <span class="material-symbols-outlined text-[18px]">chevron_right</span>
                        </button>
                    </div>
                </div>
            @endif
        </div>
    </div>

    {{-- Modal Edit Kelas (satu instance, di luar tabel agar HTML valid) --}}
    <dialog id="edit-kelas-modal"
            class="modal backdrop:bg-black/50 rounded-2xl shadow-2xl max-w-md"
            x-data="editKelasModal"
            x-on:edit-kelas-open.window="open($event.detail)">
        <form method="POST" :action="'{{ route('guru.kelas.update', ['kelas' => '__KID__']) }}'.replace('__KID__', editId)" class="p-6">
            @csrf
            @method('PUT')

            <h3 class="text-lg font-bold text-[#171c1f] mb-5">Edit Kelas</h3>

            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-semibold text-[#171c1f] mb-1.5">Nama Kelas</label>
                    <input type="text" name="nama_kelas" x-model="namaKelas"
                           class="w-full px-4 py-2 border border-[#becabc] rounded-xl focus:outline-none focus:ring-2 focus:ring-[#005f2d] focus:border-[#005f2d]"
                           required>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-[#171c1f] mb-1.5">Tahun Ajaran</label>
                    <input type="text" name="tahun_ajaran" x-model="tahunAjaran"
                           class="w-full px-4 py-2 border border-[#becabc] rounded-xl focus:outline-none focus:ring-2 focus:ring-[#005f2d] focus:border-[#005f2d]"
                           required>
                </div>
                @if($gurus->isNotEmpty())
                    <div>
                        <label class="block text-sm font-semibold text-[#171c1f] mb-1.5">Wali Kelas</label>
                        <select name="guru_id" x-model="guruId"
                                class="w-full px-4 py-2 border border-[#becabc] rounded-xl focus:outline-none focus:ring-2 focus:ring-[#005f2d] focus:border-[#005f2d] bg-white"
                                required>
                            <option value="">Pilih Guru...</option>
                            @foreach($gurus as $g)
                                <option value="{{ $g->id }}">{{ $g->name }}</option>
                            @endforeach
                        </select>
                    </div>
                @endif
            </div>

            <div class="flex gap-3 mt-6 pt-5 border-t border-[#eaeef2]">
                <button type="button" @click="this.$el.closest('dialog').close()"
                        class="flex-1 px-4 py-2 border border-[#becabc] text-[#5c5f61] rounded-xl font-semibold hover:bg-[#f0f4f8] transition-all">
                    Batal
                </button>
                <button type="submit"
                        class="flex-1 px-4 py-2 bg-[#005f2d] text-white rounded-xl font-semibold hover:bg-[#0e7a3d] transition-all">
                    Simpan
                </button>
            </div>
        </form>
    </dialog>

    {{-- Modal Tambah Kelas --}}
    <dialog id="tambah-kelas-modal" class="modal backdrop:bg-black/50 rounded-2xl shadow-2xl max-w-md">
        <form method="POST" action="{{ route('guru.kelas.store') }}" class="p-6">
            @csrf

            <h3 class="text-lg font-bold text-[#171c1f] mb-5">Tambah Kelas Baru</h3>

            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-semibold text-[#171c1f] mb-1.5">Nama Kelas</label>
                    <input type="text" name="nama_kelas" value="{{ old('nama_kelas') }}"
                           placeholder="Cth: XII IPA 1"
                           class="w-full px-4 py-2 border border-[#becabc] rounded-xl focus:outline-none focus:ring-2 focus:ring-[#005f2d] focus:border-[#005f2d]"
                           required>
                    @error('nama_kelas') <p class="mt-1 text-xs text-[#ba1a1a]">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-semibold text-[#171c1f] mb-1.5">Tahun Ajaran</label>
                    <input type="text" name="tahun_ajaran" value="{{ old('tahun_ajaran', date('Y') . '/' . (date('Y')+1)) }}"
                           placeholder="Cth: 2025/2026"
                           class="w-full px-4 py-2 border border-[#becabc] rounded-xl focus:outline-none focus:ring-2 focus:ring-[#005f2d] focus:border-[#005f2d]"
                           required>
                    @error('tahun_ajaran') <p class="mt-1 text-xs text-[#ba1a1a]">{{ $message }}</p> @enderror
                </div>
                @if($gurus->isNotEmpty())
                    <div>
                        <label class="block text-sm font-semibold text-[#171c1f] mb-1.5">Wali Kelas</label>
                        <select name="guru_id"
                                class="w-full px-4 py-2 border border-[#becabc] rounded-xl focus:outline-none focus:ring-2 focus:ring-[#005f2d] focus:border-[#005f2d] bg-white"
                                required>
                            <option value="">Pilih Guru...</option>
                            @foreach($gurus as $g)
                                <option value="{{ $g->id }}" {{ old('guru_id') == $g->id ? 'selected' : '' }}>
                                    {{ $g->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                @endif
            </div>

            <div class="flex gap-3 mt-6 pt-5 border-t border-[#eaeef2]">
                <button type="button" onclick="this.closest('dialog').close()"
                        class="flex-1 px-4 py-2 border border-[#becabc] text-[#5c5f61] rounded-xl font-semibold hover:bg-[#f0f4f8] transition-all">
                    Batal
                </button>
                <button type="submit"
                        class="flex-1 px-4 py-2 bg-[#005f2d] text-white rounded-xl font-semibold hover:bg-[#0e7a3d] transition-all">
                    Buat Kelas
                </button>
            </div>
        </form>
    </dialog>

@push('scripts')
<script>
    window.editKelasModal = function () {
        return {
            editId: 0,
            namaKelas: '',
            tahunAjaran: '',
            guruId: '',
            open(k) {
                this.editId = k.id;
                this.namaKelas = k.nama_kelas;
                this.tahunAjaran = k.tahun_ajaran;
                this.guruId = k.guru_id;
                this.$nextTick(() => this.$el.showModal());
            },
        };
    };
</script>
@endpush

</x-app-layout>
