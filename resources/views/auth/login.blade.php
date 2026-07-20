<x-guest-layout>
    <x-slot name="title">Masuk</x-slot>
    <div class="w-full lg:w-[50%] flex items-center justify-center p-8 lg:p-12 bg-white">
    <div class="w-full max-w-md flex flex-col items-center">

        {{-- Logo (Figma style green crest logo) --}}
        <div class="mb-4">
            <div class="w-16 h-16 bg-white rounded-2xl flex items-center justify-center border border-[#005f2d]/20 shadow-soft overflow-hidden">
                <img src="{{ asset('smansa.png') }}" class="w-full h-full object-contain" alt="Smansa Logo">
            </div>
        </div>

        {{-- Heading --}}
        <div class="text-center mb-8">
            <h1 class="text-2xl font-bold text-[#005f2d]">Presence Teen</h1>
            <p class="mt-1 text-xs text-[#5c5f61]">Masuk untuk mengelola sekolah Anda</p>
        </div>

        {{-- Session Status --}}
        @if(session('status'))
            <div class="w-full mb-5 p-4 bg-[#f0fdf4] border border-[#0e7a3d]/20 rounded-xl flex items-center gap-2 text-xs text-[#005f2d]">
                <span class="material-symbols-outlined text-[16px]">check_circle</span>
                {{ session('status') }}
            </div>
        @endif

        {{-- Login Error Popup --}}
        @if($errors->has('email') || $errors->has('password'))
            <div x-data="{ show: true }"
                 x-show="show"
                 x-transition
                 @click.away="show = false"
                 class="w-full mb-5 p-4 bg-[#ffdad6] border border-[#ba1a1a]/20 rounded-xl flex items-start gap-3 text-xs text-[#93000a] relative">
                <span class="material-symbols-outlined text-[18px] shrink-0 mt-0.5">error</span>
                <div class="flex-1">
                    <p class="font-bold mb-1">Login Gagal</p>
                    <ul class="space-y-0.5 text-[11px]">
                        @error('email')
                            <li>{{ $message }}</li>
                        @enderror
                        @error('password')
                            <li>{{ $message }}</li>
                        @enderror
                    </ul>
                </div>
                <button @click="show = false" class="text-[#93000a] hover:text-[#ba1a1a] transition-colors">
                    <span class="material-symbols-outlined text-[18px]">close</span>
                </button>
            </div>
        @endif

        {{-- Login Card Container --}}
        <div class="w-full bg-[#f6fafe] p-6 rounded-2xl border border-[#eaeef2] shadow-[0_4px_12px_rgba(0,0,0,0.02)]">
            <form method="POST" action="{{ route('login') }}" class="space-y-4">
                @csrf

                {{-- Email --}}
                <div>
                    <label for="email" class="block text-[10px] font-bold text-[#5c5f61] uppercase tracking-wider mb-1">Nama Pengguna / Email</label>
                    <div class="relative">
                        <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-[18px]">person</span>
                        <input id="email" name="email" type="email"
                               value="{{ old('email') }}"
                               placeholder="Masukkan nama pengguna Anda"
                               required autofocus autocomplete="username"
                               class="w-full pl-10 pr-4 py-2.5 border border-[#becabc] rounded-xl text-sm text-[#171c1f] bg-white
                                      focus:outline-none focus:ring-2 focus:ring-[#005f2d] focus:border-transparent transition-all
                                      @error('email') border-[#ba1a1a] @enderror">
                    </div>
                    @error('email')
                        <p class="mt-1 text-xs text-[#ba1a1a]">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Password --}}
                <div x-data="{ showPassword: false }">
                    <label for="password" class="block text-[10px] font-bold text-[#5c5f61] uppercase tracking-wider mb-1">Kata Sandi</label>
                    <div class="relative">
                        <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-[18px]">lock</span>
                        <input id="password" 
                               name="password" 
                               :type="showPassword ? 'text' : 'password'"
                               placeholder="Masukkan kata sandi Anda"
                               required autocomplete="current-password"
                               class="w-full pl-10 pr-10 py-2.5 border border-[#becabc] rounded-xl text-sm text-[#171c1f] bg-white
                                      focus:outline-none focus:ring-2 focus:ring-[#005f2d] focus:border-transparent transition-all
                                      @error('password') border-[#ba1a1a] @enderror">
                        <button 
                            type="button"
                            @click="showPassword = !showPassword"
                            class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 transition-colors">
                            <span class="material-symbols-outlined text-[18px]" x-text="showPassword ? 'visibility_off' : 'visibility'"></span>
                        </button>
                    </div>
                    @error('password')
                        <p class="mt-1 text-xs text-[#ba1a1a]">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Remember Me & Forgot Password --}}
                <div class="flex justify-between items-center text-xs">
                    <div class="flex items-center gap-2">
                        <input id="remember_me" name="remember" type="checkbox"
                               class="w-4 h-4 rounded border-[#becabc] text-[#005f2d] focus:ring-[#005f2d] cursor-pointer">
                        <label for="remember_me" class="text-[#5c5f61] cursor-pointer">Ingat saya</label>
                    </div>
                    @if(Route::has('password.request'))
                        <a href="{{ route('password.request') }}"
                           class="text-[#005f2d] font-bold hover:underline">
                            Lupa kata sandi?
                        </a>
                    @endif
                </div>

                {{-- Submit Button --}}
                <button type="submit"
                        class="w-full py-3 bg-[#005f2d] text-white text-xs font-bold rounded-xl
                               hover:bg-[#0e7a3d] transition-all active:scale-[0.98] shadow-soft mt-2">
                    Masuk
                </button>
            </form>
        </div>

        {{-- Footer Links --}}
        <footer class="mt-12 flex gap-4 text-[10px] text-[#5c5f61] font-bold">
            <a href="/" class="hover:underline">Beranda</a>
            <span>•</span>
            <a href="{{ route('login') }}" class="hover:underline">Login</a>
            <span>•</span>
            <a href="/" class="hover:underline">Fitur</a>
        </footer>
    </div>
</div>
</x-guest-layout>
