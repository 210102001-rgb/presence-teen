<x-app-layout>
    <x-slot name="header">Ubah Password</x-slot>

    <div class="p-4 md:p-8 max-w-2xl mx-auto">
        <div class="mb-8">
            <a href="{{ route('account.index') }}" class="text-primary hover:text-primary-container flex items-center gap-2 text-sm font-medium mb-4">
                <span class="material-symbols-outlined text-[18px]">arrow_back</span>
                Kembali
            </a>
            <h1 class="text-2xl font-bold text-on-surface">Ubah Password</h1>
            <p class="text-xs text-secondary">Atur ulang password untuk {{ $user->name }}</p>
        </div>

        <div class="bg-white rounded-2xl shadow-soft border border-surface-container p-6">
            <form action="{{ route('account.update-password', $user) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                {{-- User Info --}}
                <div class="bg-primary-container/10 border border-primary/20 rounded-xl p-4 space-y-2">
                    <p class="text-sm font-semibold text-primary flex items-center gap-2">
                        <span class="material-symbols-outlined text-[18px]">person</span>
                        Informasi Pengguna
                    </p>
                    <p class="text-xs text-on-surface">
                        <span class="font-semibold">Nama:</span> {{ $user->name }}
                    </p>
                    <p class="text-xs text-on-surface">
                        <span class="font-semibold">Email:</span> {{ $user->email }}
                    </p>
                    <p class="text-xs text-on-surface">
                        <span class="font-semibold">Role:</span>
                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-semibold
                            @if($user->role === 'guru') bg-secondary/15 text-secondary
                            @elseif($user->role === 'siswa') bg-tertiary/15 text-tertiary
                            @elseif($user->role === 'orang_tua') bg-error/15 text-error
                            @endif">
                            @if($user->role === 'guru') Guru
                            @elseif($user->role === 'siswa') Siswa
                            @elseif($user->role === 'orang_tua') Orang Tua
                            @endif
                        </span>
                    </p>
                </div>

                {{-- Password --}}
                <div>
                    <label for="password" class="block text-xs font-semibold text-secondary uppercase tracking-wider mb-1.5">Password Baru</label>
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

                {{-- Warning --}}
                <div class="bg-error/10 border border-error/20 rounded-xl p-4">
                    <p class="text-xs text-error flex items-start gap-2">
                        <span class="material-symbols-outlined text-[18px] mt-0.5 shrink-0">warning</span>
                        <span>Pengguna harus menggunakan password baru ini untuk login berikutnya. Pastikan password kuat dan mudah diingat.</span>
                    </p>
                </div>

                {{-- Actions --}}
                <div class="flex gap-3 pt-4">
                    <button type="submit"
                            class="flex-1 bg-primary text-white py-2.5 rounded-xl text-sm font-semibold hover:bg-primary-container transition-colors flex items-center justify-center gap-2 shadow-soft">
                        <span class="material-symbols-outlined text-[18px]">key</span>
                        Ubah Password
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
