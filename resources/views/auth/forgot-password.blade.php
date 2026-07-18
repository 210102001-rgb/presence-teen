<x-guest-layout>
    <x-slot name="title">Lupa Kata Sandi</x-slot>
    <div class="w-full lg:w-[55%] flex items-center justify-center p-8 lg:p-12 bg-[#f6fafe]">
        <div class="w-full max-w-md">

            <div class="mb-8">
                <h1 class="text-2xl font-bold text-[#171c1f]">Lupa Password?</h1>
                <p class="mt-1.5 text-sm text-[#5c5f61]">
                    Masukkan email Anda dan kami akan mengirimkan tautan untuk mereset password.
                </p>
            </div>

            @if(session('status'))
                <div class="mb-5 p-4 bg-[#f0fdf4] border border-[#0e7a3d]/20 rounded-xl flex items-center gap-2 text-sm text-[#005f2d]">
                    <span class="material-symbols-outlined filled-icon text-[18px]">check_circle</span>
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('password.email') }}" class="space-y-5">
                @csrf

                <div>
                    <label for="email" class="block text-sm font-semibold text-[#171c1f] mb-1.5">Email</label>
                    <input id="email" name="email" type="email"
                           value="{{ old('email') }}"
                           placeholder="nama@email.com"
                           required autofocus
                           class="w-full px-4 py-3 border border-[#becabc] rounded-xl text-sm text-[#171c1f] bg-white
                                  focus:outline-none focus:ring-2 focus:ring-[#005f2d] focus:border-[#005f2d] transition-all
                                  @error('email') border-[#ba1a1a] @enderror">
                    @error('email')
                        <p class="mt-1.5 text-xs text-[#ba1a1a]">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit"
                        class="w-full py-3 bg-[#005f2d] text-white text-sm font-semibold rounded-xl
                               hover:bg-[#0e7a3d] transition-all active:scale-[0.98] shadow-soft">
                    Kirim Tautan Reset
                </button>
            </form>

            <p class="mt-6 text-center text-sm text-[#5c5f61]">
                <a href="{{ route('login') }}"
                   class="inline-flex items-center gap-1 text-[#005f2d] hover:text-[#0e7a3d] font-semibold transition-colors">
                    <span class="material-symbols-outlined text-[16px]">arrow_back</span>
                    Kembali ke Login
                </a>
            </p>
        </div>
    </div>
</x-guest-layout>
