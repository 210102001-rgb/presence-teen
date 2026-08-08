<x-app-layout>
    <x-slot name="header">Ubah Password Guru</x-slot>

    <div class="p-4 md:p-8 max-w-2xl mx-auto">
        {{-- Breadcrumb --}}
        <div class="flex items-center gap-2 text-xs text-secondary mb-6">
            <a href="{{ route('guru.kelola') }}" class="hover:text-primary transition-colors">Kelola Guru</a>
            <span class="material-symbols-outlined text-[14px]">chevron_right</span>
            <span class="text-on-surface font-medium">Ubah Password Guru</span>
        </div>

        <div class="mb-6">
            <h1 class="text-2xl font-bold text-on-surface">Ubah Password Guru</h1>
            <p class="text-xs text-secondary">Atur ulang password untuk {{ $user->name }}</p>
        </div>

        <div class="bg-white rounded-2xl shadow-soft border border-surface-container p-6">
            <form action="{{ route('guru.kelola.update-password', $user) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                {{-- User Info --}}
                <div class="bg-primary-container/10 border border-primary/20 rounded-xl p-4 space-y-2">
                    <p class="text-sm font-semibold text-primary flex items-center gap-2">
                        <span class="material-symbols-outlined text-[18px]">school</span>
                        Informasi Guru
                    </p>
                    <p class="text-xs text-on-surface">
                        <span class="font-semibold">Nama:</span> {{ $user->name }}
                    </p>
                    <p class="text-xs text-on-surface">
                        <span class="font-semibold">Email:</span> {{ $user->email }}
                    </p>
                    @if($user->mata_pelajaran)
                        <p class="text-xs text-on-surface">
                            <span class="font-semibold">Mata Pelajaran:</span> {{ $user->mata_pelajaran }}
                        </p>
                    @endif
                </div>

                {{-- Password with show/hide --}}
                <div x-data="{ show: false }">
                    <label for="password" class="block text-xs font-semibold text-secondary uppercase tracking-wider mb-1.5">Password Baru</label>
                    <div class="relative">
                        <input :type="show ? 'text' : 'password'" name="password" id="password"
                               class="w-full rounded-xl border-surface-container focus:border-primary focus:ring focus:ring-primary/20 text-sm pr-12"
                               required>
                        <button type="button" @click="show = !show"
                                class="absolute right-4 top-1/2 -translate-y-1/2 text-secondary hover:text-primary transition-colors">
                            <span class="material-symbols-outlined text-[20px]" x-show="!show">visibility_off</span>
                            <span class="material-symbols-outlined text-[20px]" x-show="show" x-cloak>visibility</span>
                        </button>
                    </div>
                    <p class="mt-1.5 text-xs text-secondary">Password minimal 8 karakter.</p>
                    @error('password')
                        <p class="mt-1 text-xs text-error">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Default password info --}}
                <div class="bg-secondary/10 border border-secondary/20 rounded-xl p-4">
                    <p class="text-xs text-secondary flex items-start gap-2">
                        <span class="material-symbols-outlined text-[18px] mt-0.5 shrink-0">info</span>
                        <span>Password default untuk akun baru adalah <span class="font-semibold">password</span>. Segera ubah setelah akun dibuat.</span>
                    </p>
                </div>

                {{-- Warning --}}
                <div class="bg-error/10 border border-error/20 rounded-xl p-4">
                    <p class="text-xs text-error flex items-start gap-2">
                        <span class="material-symbols-outlined text-[18px] mt-0.5 shrink-0">warning</span>
                        <span>Guru harus menggunakan password baru ini untuk login berikutnya. Pastikan password kuat dan mudah diingat.</span>
                    </p>
                </div>

                {{-- Actions --}}
                <div class="flex gap-3 pt-4">
                    <button type="submit"
                            class="flex-1 bg-primary text-white py-2.5 rounded-xl text-sm font-semibold hover:bg-primary-container transition-colors flex items-center justify-center gap-2 shadow-soft">
                        <span class="material-symbols-outlined text-[18px]">key</span>
                        Ubah Password
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
