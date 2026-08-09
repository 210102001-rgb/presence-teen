<x-app-layout>
    <x-slot name="header">Tambah Siswa</x-slot>

    <div class="p-4 md:p-8 max-w-2xl mx-auto" x-data="{ tab: '{{ $errors->has('siswa_ids') ? 'existing' : 'new' }}' }">

        {{-- Breadcrumb --}}
        <div class="flex items-center gap-1.5 text-xs text-secondary mb-6">
            <a href="{{ route('guru.kelas_siswa') }}" class="hover:text-primary transition-colors">Kelola Siswa</a>
            <span class="material-symbols-outlined text-[14px]">chevron_right</span>
            <span class="text-on-surface font-medium">Tambah Siswa</span>
        </div>

        <div class="mb-6">
            <h1 class="text-2xl font-bold text-on-surface">Tambah Siswa ke Kelas</h1>
            <p class="text-sm text-secondary mt-1">Daftarkan siswa yang sudah ada atau buat akun baru.</p>
        </div>

        @if($errors->any())
            <div class="mb-6 p-4 bg-error-container border border-error/20 rounded-xl space-y-1">
                @foreach($errors->all() as $error)
                    <p class="text-sm text-on-error-container flex items-center gap-2">
                        <span class="material-symbols-outlined text-[16px]">error</span>
                        {{ $error }}
                    </p>
                @endforeach
            </div>
        @endif

        {{-- Tab Toggle --}}
        <div class="flex gap-1 p-1 bg-surface-container rounded-xl mb-6">
            <button type="button" @click="tab = 'existing'"
                    :class="tab === 'existing' ? 'bg-white shadow-soft text-primary font-semibold' : 'text-secondary hover:text-on-surface'"
                    class="flex-1 flex items-center justify-center gap-2 py-2.5 rounded-lg text-sm transition-all">
                <span class="material-symbols-outlined text-[18px]">person_search</span>
                Siswa yang Sudah Ada
                @if($siswaAda->isNotEmpty())
                    <span class="bg-primary text-white text-[10px] font-bold px-1.5 py-0.5 rounded-full">{{ $siswaAda->count() }}</span>
                @endif
            </button>
            <button type="button" @click="tab = 'new'"
                    :class="tab === 'new' ? 'bg-white shadow-soft text-primary font-semibold' : 'text-secondary hover:text-on-surface'"
                    class="flex-1 flex items-center justify-center gap-2 py-2.5 rounded-lg text-sm transition-all">
                <span class="material-symbols-outlined text-[18px]">person_add</span>
                Buat Akun Baru
            </button>
        </div>

        {{-- TAB 1: Daftarkan siswa existing --}}
        <div x-show="tab === 'existing'" x-transition>
            <div class="bg-white rounded-2xl shadow-soft border border-surface-container p-6">
                @if($siswaAda->isEmpty())
                    <div class="text-center py-8">
                        <span class="material-symbols-outlined text-4xl text-secondary/30">people</span>
                        <p class="text-sm font-semibold text-on-surface mt-3">Semua siswa sudah terdaftar di kelas</p>
                        <p class="text-xs text-secondary mt-1">Buat akun baru atau tambahkan siswa dari halaman Kelola Akun.</p>
                    </div>
                @else
                    <form action="{{ route('guru.kelas_siswa.daftarkan') }}" method="POST" class="space-y-5"
                          x-data="{ selected: [], search: '' }">
                        @csrf

                        {{-- Pilih Kelas --}}
                        <div>
                            <label class="block text-xs font-semibold text-secondary uppercase tracking-wider mb-1.5">
                                Kelas Tujuan <span class="text-error">*</span>
                            </label>
                            <select name="kelas_id" required
                                    class="w-full px-4 py-2.5 border border-outline-variant rounded-xl text-sm text-on-surface
                                           focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary transition-all">
                                <option value="">-- Pilih Kelas --</option>
                                @foreach($kelas as $k)
                                    <option value="{{ $k->id }}" @selected(old('kelas_id') == $k->id)>
                                        {{ $k->nama_kelas }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Search --}}
                        <div>
                            <label class="block text-xs font-semibold text-secondary uppercase tracking-wider mb-1.5">
                                Pilih Siswa
                                <span class="font-normal normal-case text-secondary ml-1">
                                    (<span x-text="selected.length"></span> dipilih)
                                </span>
                            </label>
                            <div class="flex items-center gap-2 mb-3 border border-outline-variant rounded-xl px-3 py-2 focus-within:ring-2 focus-within:ring-primary">
                                <span class="material-symbols-outlined text-secondary text-[18px]">search</span>
                                <input type="text" x-model="search" placeholder="Cari nama atau email siswa..."
                                       class="flex-1 text-sm bg-transparent border-none outline-none ring-0 shadow-none p-0 focus:ring-0">
                            </div>

                            <div class="border border-outline-variant rounded-xl overflow-hidden max-h-60 overflow-y-auto">
                                @foreach($siswaAda as $s)
                                    <label class="flex items-center gap-3 px-4 py-3 hover:bg-surface-container cursor-pointer border-b border-surface-container last:border-0 transition-colors"
                                           x-show="!search || '{{ strtolower($s->name) }}'.includes(search.toLowerCase()) || '{{ strtolower($s->email) }}'.includes(search.toLowerCase())">
                                        <input type="checkbox" name="siswa_ids[]" value="{{ $s->id }}"
                                               @change="$event.target.checked ? selected.push('{{ $s->id }}') : selected.splice(selected.indexOf('{{ $s->id }}'), 1)"
                                               class="w-4 h-4 rounded accent-primary">
                                        <div class="w-8 h-8 rounded-full bg-primary/10 flex items-center justify-center text-primary text-xs font-bold shrink-0">
                                            {{ substr($s->name, 0, 1) }}
                                        </div>
                                        <div class="min-w-0">
                                            <p class="text-sm font-semibold text-on-surface truncate">{{ $s->name }}</p>
                                            <p class="text-xs text-secondary truncate">{{ $s->email }} @if($s->nis) • NIS: {{ $s->nis }} @endif</p>
                                        </div>
                                    </label>
                                @endforeach
                            </div>
                        </div>

                        <div class="flex gap-3 pt-2">
                            <button type="submit" :disabled="selected.length === 0"
                                    class="flex-1 bg-primary text-white py-2.5 rounded-xl text-sm font-semibold
                                           hover:bg-primary-container transition-colors flex items-center justify-center gap-2 shadow-soft
                                           disabled:opacity-50 disabled:cursor-not-allowed">
                                <span class="material-symbols-outlined text-[18px]">how_to_reg</span>
                                Daftarkan ke Kelas
                            </button>
                            <a href="{{ route('guru.kelas_siswa') }}"
                               class="flex-1 bg-surface-container text-on-surface py-2.5 rounded-xl text-sm font-semibold
                                      hover:bg-surface-container-high transition-colors flex items-center justify-center gap-2">
                                <span class="material-symbols-outlined text-[18px]">close</span>
                                Batal
                            </a>
                        </div>
                    </form>
                @endif
            </div>
        </div>

        {{-- TAB 2: Buat akun baru --}}
        <div x-show="tab === 'new'" x-transition>
            <div class="bg-white rounded-2xl shadow-soft border border-surface-container p-6">
                <form action="{{ route('guru.kelas_siswa.tambah') }}" method="POST" class="space-y-5">
                    @csrf

                    {{-- Pilih Kelas --}}
                    <div>
                        <label for="kelas_id_new" class="block text-xs font-semibold text-secondary uppercase tracking-wider mb-1.5">
                            Kelas <span class="text-error">*</span>
                        </label>
                        <select name="kelas_id" id="kelas_id_new" required
                                class="w-full px-4 py-2.5 border border-outline-variant rounded-xl text-sm text-on-surface
                                       focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary transition-all">
                            <option value="">-- Pilih Kelas --</option>
                            @forelse($kelas as $k)
                                <option value="{{ $k->id }}" @selected(old('kelas_id') == $k->id)>
                                    {{ $k->nama_kelas }}
                                </option>
                            @empty
                                <option value="" disabled>Belum ada kelas. Buat kelas dulu.</option>
                            @endforelse
                        </select>
                        @error('kelas_id')
                            <p class="mt-1 text-xs text-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="border-t border-surface-container pt-5 space-y-5">
                        <p class="text-xs font-semibold text-secondary uppercase tracking-wider">Data Akun Siswa Baru</p>

                        <div>
                            <label for="name" class="block text-xs font-semibold text-secondary uppercase tracking-wider mb-1.5">
                                Nama Lengkap <span class="text-error">*</span>
                            </label>
                            <input type="text" name="name" id="name" value="{{ old('name') }}" required
                                   placeholder="Contoh: Ahmad Rizky Pratama"
                                   class="w-full px-4 py-2.5 border border-outline-variant rounded-xl text-sm text-on-surface
                                          focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary transition-all">
                            @error('name') <p class="mt-1 text-xs text-error">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="email" class="block text-xs font-semibold text-secondary uppercase tracking-wider mb-1.5">
                                Email <span class="text-error">*</span>
                            </label>
                            <input type="email" name="email" id="email" value="{{ old('email') }}" required
                                   placeholder="siswa@sekolah.sch.id"
                                   class="w-full px-4 py-2.5 border border-outline-variant rounded-xl text-sm text-on-surface
                                          focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary transition-all">
                            @error('email') <p class="mt-1 text-xs text-error">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="nis" class="block text-xs font-semibold text-secondary uppercase tracking-wider mb-1.5">
                                NIS <span class="text-secondary font-normal normal-case">(Opsional)</span>
                            </label>
                            <input type="text" name="nis" id="nis" value="{{ old('nis') }}" maxlength="20"
                                   placeholder="Nomor Induk Siswa"
                                   class="w-full px-4 py-2.5 border border-outline-variant rounded-xl text-sm text-on-surface
                                          focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary transition-all">
                        </div>

                        <div>
                            <label for="password" class="block text-xs font-semibold text-secondary uppercase tracking-wider mb-1.5">
                                Password <span class="text-error">*</span>
                            </label>
                            <input type="text" name="password" id="password"
                                   value="{{ old('password', 'password') }}" required
                                   class="w-full px-4 py-2.5 border border-outline-variant rounded-xl text-sm text-on-surface
                                          focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary transition-all">
                            <p class="mt-1.5 text-xs text-secondary">
                                Default: <span class="font-semibold text-on-surface">password</span> — siswa bisa ubah setelah login.
                            </p>
                        </div>
                    </div>

                    <div class="flex gap-3 pt-2">
                        <button type="submit"
                                class="flex-1 bg-primary text-white py-2.5 rounded-xl text-sm font-semibold
                                       hover:bg-primary-container transition-colors flex items-center justify-center gap-2 shadow-soft">
                            <span class="material-symbols-outlined text-[18px]">person_add</span>
                            Buat & Daftarkan
                        </button>
                        <a href="{{ route('guru.kelas_siswa') }}"
                           class="flex-1 bg-surface-container text-on-surface py-2.5 rounded-xl text-sm font-semibold
                                  hover:bg-surface-container-high transition-colors flex items-center justify-center gap-2">
                            <span class="material-symbols-outlined text-[18px]">close</span>
                            Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>

    </div>
</x-app-layout>
