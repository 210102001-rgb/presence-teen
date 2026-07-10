<x-guest-layout>
    <div class="w-full lg:w-[55%] flex items-center justify-center p-8 lg:p-12 bg-[#f6fafe]">
        <div class="w-full max-w-md">

            {{-- Mobile Logo --}}
            <div class="flex items-center gap-3 mb-8 lg:hidden">
                <div class="w-10 h-10 bg-[#0e7a3d] rounded-xl flex items-center justify-center">
                    <span class="material-symbols-outlined text-white filled-icon">school</span>
                </div>
                <span class="font-bold text-lg text-[#171c1f]">Presence-Teen</span>
            </div>

            {{-- Heading --}}
            <div class="mb-8">
                <h1 class="text-2xl font-bold text-[#171c1f]">Selamat Datang</h1>
                <p class="mt-1.5 text-sm text-[#5c5f61]">Masuk ke akun Anda untuk melanjutkan</p>
            </div>

            {{-- Session Status --}}
            @if(session('status'))
                <div class="mb-5 p-4 bg-[#f0fdf4] border border-[#0e7a3d]/20 rounded-xl flex items-center gap-2 text-sm text-[#005f2d]">
                    <span class="material-symbols-outlined filled-icon text-[18px]">check_circle</span>
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="space-y-5">
                @csrf

                {{-- Email --}}
                <div>
                    <label for="email" class="block text-sm font-semibold text-[#171c1f] mb-1.5">Email</label>
                    <input id="email" name="email" type="email"
                           value="{{ old('email') }}"
                           placeholder="nama@email.com"
                           required autofocus autocomplete="username"
                           class="w-full px-4 py-3 border border-[#becabc] rounded-xl text-sm text-[#171c1f] bg-white
                                  focus:outline-none focus:ring-2 focus:ring-[#005f2d] focus:border-[#005f2d] transition-all
                                  @error('email') border-[#ba1a1a] @enderror">
                    @error('email')
                        <p class="mt-1.5 text-xs text-[#ba1a1a]">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Password --}}
                <div>
                    <div class="flex justify-between items-center mb-1.5">
                        <label for="password" class="text-sm font-semibold text-[#171c1f]">Password</label>
                        @if(Route::has('password.request'))
                            <a href="{{ route('password.request') }}"
                               class="text-xs text-[#005f2d] hover:text-[#0e7a3d] font-medium transition-colors">
                                Lupa password?
                            </a>
                        @endif
                    </div>
                    <input id="password" name="password" type="password"
                           placeholder="••••••••"
                           required autocomplete="current-password"
                           class="w-full px-4 py-3 border border-[#becabc] rounded-xl text-sm text-[#171c1f] bg-white
                                  focus:outline-none focus:ring-2 focus:ring-[#005f2d] focus:border-[#005f2d] transition-all
                                  @error('password') border-[#ba1a1a] @enderror">
                    @error('password')
                        <p class="mt-1.5 text-xs text-[#ba1a1a]">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Remember Me --}}
                <div class="flex items-center gap-2">
                    <input id="remember_me" name="remember" type="checkbox"
                           class="w-4 h-4 rounded border-[#becabc] text-[#005f2d] focus:ring-[#005f2d] cursor-pointer">
                    <label for="remember_me" class="text-sm text-[#5c5f61] cursor-pointer">Ingat saya</label>
                </div>

                {{-- Submit --}}
                <button type="submit"
                        class="w-full py-3 bg-[#005f2d] text-white text-sm font-semibold rounded-xl
                               hover:bg-[#0e7a3d] transition-all active:scale-[0.98] shadow-soft
                               focus:outline-none focus:ring-2 focus:ring-[#005f2d] focus:ring-offset-2">
                    Masuk
                </button>
            </form>

            @if(Route::has('register'))
                <p class="mt-7 text-center text-sm text-[#5c5f61]">
                    Belum punya akun?
                    <a href="{{ route('register') }}" class="text-[#005f2d] hover:text-[#0e7a3d] font-semibold transition-colors">
                        Daftar Sekarang
                    </a>
                </p>
            @endif

            {{-- Demo Accounts --}}
            <div class="mt-8 p-4 bg-white rounded-xl border border-[#eaeef2] shadow-soft">
                <p class="text-[11px] font-semibold text-[#5c5f61] uppercase tracking-wider mb-3">Akun Demo</p>
                <div class="space-y-2">
                    <div class="flex justify-between text-xs">
                        <span class="text-[#5c5f61]">Guru</span>
                        <span class="font-mono text-[#171c1f]">guru@presensi.test</span>
                    </div>
                    <div class="flex justify-between text-xs">
                        <span class="text-[#5c5f61]">Siswa</span>
                        <span class="font-mono text-[#171c1f]">siswa@presensi.test</span>
                    </div>
                    <div class="flex justify-between text-xs">
                        <span class="text-[#5c5f61]">Orang Tua</span>
                        <span class="font-mono text-[#171c1f]">ortu@presensi.test</span>
                    </div>
                    <div class="flex justify-between text-xs border-t border-[#eaeef2] pt-2 mt-1">
                        <span class="text-[#5c5f61]">Password</span>
                        <span class="font-mono text-[#171c1f]">password</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
