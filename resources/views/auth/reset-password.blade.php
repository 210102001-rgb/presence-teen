<x-guest-layout>
    <div class="w-full lg:w-[55%] flex items-center justify-center p-8 lg:p-12 bg-[#f6fafe]">
        <div class="w-full max-w-md">

            <div class="mb-8">
                <h1 class="text-2xl font-bold text-[#171c1f]">Reset Password</h1>
                <p class="mt-1.5 text-sm text-[#5c5f61]">Buat password baru untuk akun Anda.</p>
            </div>

            <form method="POST" action="{{ route('password.store') }}" class="space-y-5">
                @csrf
                <input type="hidden" name="token" value="{{ $request->route('token') }}">

                <div>
                    <label for="email" class="block text-sm font-semibold text-[#171c1f] mb-1.5">Email</label>
                    <input id="email" name="email" type="email"
                           value="{{ old('email', $request->email) }}"
                           required autocomplete="username" readonly
                           class="w-full px-4 py-3 border border-[#becabc] rounded-xl text-sm text-[#171c1f] bg-[#f0f4f8]
                                  cursor-not-allowed opacity-70">
                    @error('email')
                        <p class="mt-1.5 text-xs text-[#ba1a1a]">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password" class="block text-sm font-semibold text-[#171c1f] mb-1.5">Password Baru</label>
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

                <div>
                    <label for="password_confirmation" class="block text-sm font-semibold text-[#171c1f] mb-1.5">Konfirmasi Password</label>
                    <input id="password_confirmation" name="password_confirmation" type="password"
                           placeholder="Ulangi password baru"
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
                               hover:bg-[#0e7a3d] transition-all active:scale-[0.98] shadow-soft">
                    Reset Password
                </button>
            </form>
        </div>
    </div>
</x-guest-layout>
