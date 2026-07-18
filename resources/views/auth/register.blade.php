<x-guest-layout>
    <x-slot name="title">Daftar</x-slot>
    <div class="w-full lg:w-[55%] flex items-center justify-center p-8 lg:p-12 bg-[#f6fafe]">
        <div class="w-full max-w-md">

            {{-- Mobile Logo --}}
            <div class="flex items-center gap-3 mb-8 lg:hidden">
                <div class="w-10 h-10 bg-[#0e7a3d] rounded-xl flex items-center justify-center">
                    <span class="material-symbols-outlined text-white filled-icon">school</span>
                </div>
                <span class="font-bold text-lg text-[#171c1f]">Presence-Teen</span>
            </div>

            <div class="mb-8">
                <h1 class="text-2xl font-bold text-[#171c1f]">Buat Akun Baru</h1>
                <p class="mt-1.5 text-sm text-[#5c5f61]">Daftar untuk mulai menggunakan {{ config('app.name', 'Presence-Teen') }}</p>
            </div>

            <form method="POST" action="{{ route('register') }}" class="space-y-5">
                @csrf

                {{-- Nama --}}
                <div>
                    <label for="name" class="block text-sm font-semibold text-[#171c1f] mb-1.5">Nama Lengkap</label>
                    <input id="name" name="name" type="text"
                           value="{{ old('name') }}"
                           placeholder="Nama lengkap Anda"
                           required autofocus autocomplete="name"
                           class="w-full px-4 py-3 border border-[#becabc] rounded-xl text-sm text-[#171c1f] bg-white
                                  focus:outline-none focus:ring-2 focus:ring-[#005f2d] focus:border-[#005f2d] transition-all
                                  @error('name') border-[#ba1a1a] @enderror">
                    @error('name')
                        <p class="mt-1.5 text-xs text-[#ba1a1a]">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Email --}}
                <div>
                    <label for="email" class="block text-sm font-semibold text-[#171c1f] mb-1.5">Email</label>
                    <input id="email" name="email" type="email"
                           value="{{ old('email') }}"
                           placeholder="nama@email.com"
                           required autocomplete="username"
                           class="w-full px-4 py-3 border border-[#becabc] rounded-xl text-sm text-[#171c1f] bg-white
                                  focus:outline-none focus:ring-2 focus:ring-[#005f2d] focus:border-[#005f2d] transition-all
                                  @error('email') border-[#ba1a1a] @enderror">
                    @error('email')
                        <p class="mt-1.5 text-xs text-[#ba1a1a]">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Password --}}
                <div>
                    <label for="password" class="block text-sm font-semibold text-[#171c1f] mb-1.5">Password</label>
                    <input id="password" name="password" type="password"
                           placeholder="Minimal 8 karakter"
                           required autocomplete="new-password"
                           class="w-full px-4 py-3 border border-[#becabc] rounded-xl text-sm text-[#171c1f] bg-white
                                  focus:outline-none focus:ring-2 focus:ring-[#005f2d] focus:border-[#005f2d] transition-all
                                  @error('password') border-[#ba1a1a] @enderror">
                    @error('password')
                        <p class="mt-1.5 text-xs text-[#ba1a1a]">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Confirm Password --}}
                <div>
                    <label for="password_confirmation" class="block text-sm font-semibold text-[#171c1f] mb-1.5">Konfirmasi Password</label>
                    <input id="password_confirmation" name="password_confirmation" type="password"
                           placeholder="Ulangi password"
                           required autocomplete="new-password"
                           class="w-full px-4 py-3 border border-[#becabc] rounded-xl text-sm text-[#171c1f] bg-white
                                  focus:outline-none focus:ring-2 focus:ring-[#005f2d] focus:border-[#005f2d] transition-all
                                  @error('password_confirmation') border-[#ba1a1a] @enderror">
                    @error('password_confirmation')
                        <p class="mt-1.5 text-xs text-[#ba1a1a]">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit"
                        class="w-full py-3 bg-[#005f2d] text-white text-sm font-semibold rounded-xl
                               hover:bg-[#0e7a3d] transition-all active:scale-[0.98] shadow-soft
                               focus:outline-none focus:ring-2 focus:ring-[#005f2d] focus:ring-offset-2">
                    Daftar Sekarang
                </button>
            </form>

            <p class="mt-7 text-center text-sm text-[#5c5f61]">
                Sudah punya akun?
                <a href="{{ route('login') }}" class="text-[#005f2d] hover:text-[#0e7a3d] font-semibold transition-colors">
                    Masuk
                </a>
            </p>
        </div>
    </div>
</x-guest-layout>
