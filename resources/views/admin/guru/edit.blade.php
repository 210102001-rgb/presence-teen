<x-app-layout>
    <x-slot name="header">Edit Guru</x-slot>

    <div class="p-4 md:p-8 max-w-2xl mx-auto">
        {{-- Breadcrumb --}}
        <div class="flex items-center gap-2 text-xs text-secondary mb-6">
            <a href="{{ route('guru.kelola') }}" class="hover:text-primary transition-colors">Kelola Guru</a>
            <span class="material-symbols-outlined text-[14px]">chevron_right</span>
            <span class="text-on-surface font-medium">Edit Guru</span>
        </div>

        <div class="mb-6">
            <h1 class="text-2xl font-bold text-on-surface">Edit Guru</h1>
            <p class="text-xs text-secondary">Perbarui informasi data guru</p>
        </div>

        <div class="bg-white rounded-2xl shadow-soft border border-surface-container p-6">
            <form action="{{ route('guru.kelola.update', $user) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                {{-- Nama Lengkap --}}
                <div>
                    <label for="name" class="block text-xs font-semibold text-secondary uppercase tracking-wider mb-1.5">Nama Lengkap</label>
                    <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}"
                           class="w-full rounded-xl border-surface-container focus:border-primary focus:ring focus:ring-primary/20 text-sm" required>
                    @error('name')
                        <p class="mt-1 text-xs text-error">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Email --}}
                <div>
                    <label for="email" class="block text-xs font-semibold text-secondary uppercase tracking-wider mb-1.5">Email</label>
                    <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}"
                           class="w-full rounded-xl border-surface-container focus:border-primary focus:ring focus:ring-primary/20 text-sm" required>
                    @error('email')
                        <p class="mt-1 text-xs text-error">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Mata Pelajaran --}}
                <div>
                    <label for="mata_pelajaran" class="block text-xs font-semibold text-secondary uppercase tracking-wider mb-1.5">Mata Pelajaran yang Diampu <span class="normal-case font-normal">(opsional)</span></label>
                    <input type="text" name="mata_pelajaran" id="mata_pelajaran" value="{{ old('mata_pelajaran', $user->mata_pelajaran) }}"
                           class="w-full rounded-xl border-surface-container focus:border-primary focus:ring focus:ring-primary/20 text-sm"
                           placeholder="Contoh: Matematika, Fisika, ...">
                    @error('mata_pelajaran')
                        <p class="mt-1 text-xs text-error">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Info Box --}}
                <div class="bg-secondary/10 border border-secondary/20 rounded-xl p-4">
                    <p class="text-xs text-secondary flex items-start gap-2">
                        <span class="material-symbols-outlined text-[18px] mt-0.5 shrink-0">info</span>
                        <span>Untuk mengubah password guru, gunakan tombol "Password" di halaman daftar guru.</span>
                    </p>
                </div>

                {{-- Actions --}}
                <div class="flex gap-3 pt-4">
                    <button type="submit"
                            class="flex-1 bg-primary text-white py-2.5 rounded-xl text-sm font-semibold hover:bg-primary-container transition-colors flex items-center justify-center gap-2 shadow-soft">
                        <span class="material-symbols-outlined text-[18px]">save</span>
                        Simpan Perubahan
                    </button>
                    <a href="{{ route('guru.kelola') }}"
                       class="flex-1 bg-surface-container text-on-surface py-2.5 rounded-xl text-sm font-semibold hover:bg-surface-container/80 transition-colors flex items-center justify-center gap-2 shadow-soft">
                        <span class="material-symbols-outlined text-[18px]">close</span>
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
