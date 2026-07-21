<x-app-layout>
    <x-slot name="header">Tambah Siswa</x-slot>

    <div class="p-4 md:p-8 max-w-2xl mx-auto">

        {{-- Breadcrumb --}}
        <div class="flex items-center gap-1.5 text-xs text-secondary mb-6">
            <a href="{{ route('guru.kelas_siswa') }}" class="hover:text-primary transition-colors">Kelola Siswa</a>
            <span class="material-symbols-outlined text-[14px]">chevron_right</span>
            <span class="text-on-surface font-medium">Tambah Siswa</span>
        </div>

        <div class="mb-6">
            <h1 class="text-2xl font-bold text-on-surface">Tambah Siswa Baru</h1>
            <p class="text-sm text-secondary mt-1">Buat akun dan daftarkan siswa ke kelas secara langsung.</p>
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

        <div class="bg-white rounded-2xl shadow-soft border border-surface-container p-6">
            <form action="{{ route('guru.kelas_siswa.tambah') }}" method="POST" class="space-y-5">
                @csrf

                {{-- Pilih Kelas --}}
                <div>
                    <label for="kelas_id" class="block text-xs font-semibold text-secondary uppercase tracking-wider mb-1.5">
                        Kelas <span class="text-error">*</span>
                    </label>
                    <select name="kelas_id" id="kelas_id" required
                            class="w-full px-4 py-2.5 border border-outline-variant rounded-xl text-sm text-on-surface
                                   focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary transition-all">
                        <option value="">-- Pilih Kelas --</option>
                        @forelse($kelas as $k)
                            <option value="{{ $k->id }}" @selected(old('kelas_id') == $k->id)>
                                {{ $k->nama_kelas }} — {{ $k->mata_pelajaran }}
                            </option>
                        @empty
                            <option value="" disabled>Belum ada kelas. Buat kelas dulu.</option>
                        @endforelse
                    </select>
                    @error('kelas_id')
                        <p class="mt-1 text-xs text-error">{{ $message }}</p>
                    @enderror
                </div>

                <div class="border-t border-surface-container pt-5">
                    <p class="text-xs font-semibold text-secondary uppercase tracking-wider mb-4">Data Akun Siswa</p>

                    {{-- Nama Lengkap --}}
                    <div class="space-y-5">
                        <div>
                            <label for="name" class="block text-xs font-semibold text-secondary uppercase tracking-wider mb-1.5">
                                Nama Lengkap <span class="text-error">*</span>
                            </label>
                            <input type="text" name="name" id="name" value="{{ old('name') }}" required
                                   placeholder="Contoh: Ahmad Rizky Pratama"
                                   class="w-full px-4 py-2.5 border border-outline-variant rounded-xl text-sm text-on-surface
                                          focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary transition-all">
                            @error('name')
                                <p class="mt-1 text-xs text-error">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Email --}}
                        <div>
                            <label for="email" class="block text-xs font-semibold text-secondary uppercase tracking-wider mb-1.5">
                                Email <span class="text-error">*</span>
                            </label>
                            <input type="email" name="email" id="email" value="{{ old('email') }}" required
                                   placeholder="siswa@sekolah.sch.id"
                                   class="w-full px-4 py-2.5 border border-outline-variant rounded-xl text-sm text-on-surface
                                          focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary transition-all">
                            @error('email')
                                <p class="mt-1 text-xs text-error">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- NIS --}}
                        <div>
                            <label for="nis" class="block text-xs font-semibold text-secondary uppercase tracking-wider mb-1.5">
                                NIS <span class="text-secondary font-normal normal-case">(Opsional)</span>
                            </label>
                            <input type="text" name="nis" id="nis" value="{{ old('nis') }}" maxlength="20"
                                   placeholder="Nomor Induk Siswa"
                                   class="w-full px-4 py-2.5 border border-outline-variant rounded-xl text-sm text-on-surface
                                          focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary transition-all">
                            @error('nis')
                                <p class="mt-1 text-xs text-error">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Password --}}
                        <div>
                            <label for="password" class="block text-xs font-semibold text-secondary uppercase tracking-wider mb-1.5">
                                Password <span class="text-error">*</span>
                            </label>
                            <input type="text" name="password" id="password"
                                   value="{{ old('password', 'password') }}" required
                                   placeholder="Minimal 8 karakter"
                                   class="w-full px-4 py-2.5 border border-outline-variant rounded-xl text-sm text-on-surface
                                          focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary transition-all">
                            <p class="mt-1.5 text-xs text-secondary">
                                Default: <span class="font-semibold text-on-surface">password</span>
                                — siswa bisa ubah setelah login pertama.
                            </p>
                            @error('password')
                                <p class="mt-1 text-xs text-error">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                {{-- Info box --}}
                <div class="bg-primary/5 border border-primary/20 rounded-xl p-4 flex gap-3">
                    <span class="material-symbols-outlined text-primary text-[20px] shrink-0 mt-0.5">info</span>
                    <div class="text-xs text-on-surface space-y-1">
                        <p class="font-semibold text-primary">Akun akan dibuat otomatis</p>
                        <p>Siswa dapat langsung login menggunakan email dan password yang Anda isi di atas.</p>
                    </div>
                </div>

                {{-- Actions --}}
                <div class="flex gap-3 pt-2">
                    <button type="submit"
                            class="flex-1 bg-primary text-white py-2.5 rounded-xl text-sm font-semibold
                                   hover:bg-primary-container transition-colors flex items-center justify-center gap-2 shadow-soft">
                        <span class="material-symbols-outlined text-[18px]">person_add</span>
                        Tambah Siswa
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
</x-app-layout>
