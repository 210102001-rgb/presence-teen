<section>
    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="space-y-5">
        @csrf
        @method('patch')

        <div>
            <label for="name" class="block text-sm font-semibold text-[#171c1f] mb-1.5">Nama</label>
            <input id="name" name="name" type="text"
                   value="{{ old('name', $user->name) }}"
                   required autofocus autocomplete="name"
                   class="w-full px-4 py-3 border border-[#becabc] rounded-xl text-sm text-[#171c1f] bg-white
                          focus:outline-none focus:ring-2 focus:ring-[#005f2d] focus:border-[#005f2d] transition-all">
            @error('name')
                <p class="mt-1 text-xs text-[#ba1a1a]">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="email" class="block text-sm font-semibold text-[#171c1f] mb-1.5">Email</label>
            <input id="email" name="email" type="email"
                   value="{{ old('email', $user->email) }}"
                   required autocomplete="username"
                   class="w-full px-4 py-3 border border-[#becabc] rounded-xl text-sm text-[#171c1f] bg-white
                          focus:outline-none focus:ring-2 focus:ring-[#005f2d] focus:border-[#005f2d] transition-all">
            @error('email')
                <p class="mt-1 text-xs text-[#ba1a1a]">{{ $message }}</p>
            @enderror

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div class="mt-2">
                    <p class="text-sm text-[#5c5f61]">
                        {{ __('Email belum terverifikasi.') }}
                        <button form="send-verification"
                                class="text-[#005f2d] font-medium underline hover:text-[#0e7a3d] transition-colors">
                            Kirim ulang verifikasi
                        </button>
                    </p>
                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-1 text-sm text-[#005f2d] font-medium">
                            Tautan verifikasi telah dikirim ke email Anda.
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div class="flex items-center gap-4 pt-2">
            <button type="submit"
                    class="inline-flex items-center gap-2 px-6 py-2.5 bg-[#005f2d] text-white text-sm font-semibold
                           rounded-xl hover:bg-[#0e7a3d] transition-all active:scale-95">
                <span class="material-symbols-outlined text-[18px]">save</span>
                Simpan Perubahan
            </button>

            @if (session('status') === 'profile-updated')
                <p x-data="{ show: true }"
                   x-show="show"
                   x-transition
                   x-init="setTimeout(() => show = false, 2000)"
                   class="text-sm text-[#005f2d] font-medium flex items-center gap-1">
                    <span class="material-symbols-outlined text-[16px] filled-icon">check_circle</span>
                    Tersimpan
                </p>
            @endif
        </div>
    </form>
</section>
