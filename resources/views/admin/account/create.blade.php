<x-app-layout>
    <x-slot name="header">Tambah Akun Baru</x-slot>

    <div class="p-4 md:p-8 max-w-2xl mx-auto">
        <div class="mb-8">
            <a href="{{ route('account.index') }}" class="text-primary hover:text-primary-container flex items-center gap-2 text-sm font-medium mb-4">
                <span class="material-symbols-outlined text-[18px]">arrow_back</span>
                Kembali
            </a>
            <h1 class="text-2xl font-bold text-on-surface">Tambah Akun Baru</h1>
            <p class="text-xs text-secondary">Buat akun pengguna baru untuk sistem</p>
        </div>

        <div class="bg-white rounded-2xl shadow-soft border border-surface-container p-6">
            <form action="{{ route('account.store') }}" method="POST" class="space-y-6">
                @csrf

                {{-- Nama --}}
                <div>
                    <label for="name" class="block text-xs font-semibold text-secondary uppercase tracking-wider mb-1.5">Nama Lengkap</label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}"
                           class="w-full rounded-xl border-surface-container focus:border-primary focus:ring focus:ring-primary/20 text-sm" required>
                    @error('name')
                        <p class="mt-1 text-xs text-error">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Email --}}
                <div>
                    <label for="email" class="block text-xs font-semibold text-secondary uppercase tracking-wider mb-1.5">Email</label>
                    <input type="email" name="email" id="email" value="{{ old('email') }}"
                           class="w-full rounded-xl border-surface-container focus:border-primary focus:ring focus:ring-primary/20 text-sm" required>
                    @error('email')
                        <p class="mt-1 text-xs text-error">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Role --}}
                <div>
                    <label for="role" class="block text-xs font-semibold text-secondary uppercase tracking-wider mb-1.5">Role</label>
                    <select name="role" id="role"
                            class="w-full rounded-xl border-surface-container focus:border-primary focus:ring focus:ring-primary/20 text-sm" required>
                        <option value="">-- Pilih Role --</option>
                        <option value="siswa" @selected(old('role') === 'siswa')>Siswa</option>
                        <option value="guru" @selected(old('role') === 'guru')>Guru</option>
                        <option value="orang_tua" @selected(old('role') === 'orang_tua')>Orang Tua</option>
                    </select>
                    @error('role')
                        <p class="mt-1 text-xs text-error">{{ $message }}</p>
                    @enderror
                </div>

                {{-- NIS (optional, for siswa only) --}}
                <div>
                    <label for="nis" class="block text-xs font-semibold text-secondary uppercase tracking-wider mb-1.5">NIS (Opsional)</label>
                    <input type="text" name="nis" id="nis" value="{{ old('nis') }}" maxlength="20"
                           class="w-full rounded-xl border-surface-container focus:border-primary focus:ring focus:ring-primary/20 text-sm"
                           placeholder="Nomor Induk Siswa">
                    @error('nis')
                        <p class="mt-1 text-xs text-error">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Password --}}
                <div>
                    <label for="password" class="block text-xs font-semibold text-secondary uppercase tracking-wider mb-1.5">Password</label>
                    <div class="relative">
                        <input type="password" name="password" id="password"
                               class="w-full rounded-xl border-surface-container focus:border-primary focus:ring focus:ring-primary/20 text-sm" 
                               required x-data="{ show: false }" :type="show ? 'text' : 'password'">
                        <button type="button" @click="show = !show"
                                class="absolute right-4 top-1/2 -translate-y-1/2 text-secondary hover:text-primary transition-colors">
                            <span class="material-symbols-outlined text-[20px]" x-show="!show">visibility_off</span>
                            <span class="material-symbols-outlined text-[20px]" x-show="show">visibility</span>
                        </button>
                    </div>
                    <p class="mt-1.5 text-xs text-secondary">Password minimal 8 karakter, harus mengandung angka, huruf besar, dan simbol.</p>
                    @error('password')
                        <p class="mt-1 text-xs text-error">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Actions --}}
                <div class="flex gap-3 pt-4">
                    <button type="submit"
                            class="flex-1 bg-primary text-white py-2.5 rounded-xl text-sm font-semibold hover:bg-primary-container transition-colors flex items-center justify-center gap-2 shadow-soft">
                        <span class="material-symbols-outlined text-[18px]">add</span>
                        Buat Akun
                    </button>
                    <a href="{{ route('account.index') }}"
                       class="flex-1 bg-surface-container text-on-surface py-2.5 rounded-xl text-sm font-semibold hover:bg-surface-container/80 transition-colors flex items-center justify-center gap-2 shadow-soft">
                        <span class="material-symbols-outlined text-[18px]">close</span>
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
