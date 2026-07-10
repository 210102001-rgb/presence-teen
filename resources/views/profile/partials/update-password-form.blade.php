<section>
    <form method="post" action="{{ route('password.update') }}" class="space-y-5">
        @csrf
        @method('put')

        <div>
            <label for="update_password_current_password" class="block text-sm font-semibold text-[#171c1f] mb-1.5">
                Password Saat Ini
            </label>
            <input id="update_password_current_password" name="current_password" type="password"
                   autocomplete="current-password"
                   placeholder="Password lama"
                   class="w-full px-4 py-3 border border-[#becabc] rounded-xl text-sm text-[#171c1f] bg-white
                          focus:outline-none focus:ring-2 focus:ring-[#005f2d] focus:border-[#005f2d] transition-all">
            @if ($errors->updatePassword->has('current_password'))
                <p class="mt-1 text-xs text-[#ba1a1a]">{{ $errors->updatePassword->first('current_password') }}</p>
            @endif
        </div>

        <div>
            <label for="update_password_password" class="block text-sm font-semibold text-[#171c1f] mb-1.5">
                Password Baru
            </label>
            <input id="update_password_password" name="password" type="password"
                   autocomplete="new-password"
                   placeholder="Minimal 8 karakter"
                   class="w-full px-4 py-3 border border-[#becabc] rounded-xl text-sm text-[#171c1f] bg-white
                          focus:outline-none focus:ring-2 focus:ring-[#005f2d] focus:border-[#005f2d] transition-all">
            @if ($errors->updatePassword->has('password'))
                <p class="mt-1 text-xs text-[#ba1a1a]">{{ $errors->updatePassword->first('password') }}</p>
            @endif
        </div>

        <div>
            <label for="update_password_password_confirmation" class="block text-sm font-semibold text-[#171c1f] mb-1.5">
                Konfirmasi Password Baru
            </label>
            <input id="update_password_password_confirmation" name="password_confirmation" type="password"
                   autocomplete="new-password"
                   placeholder="Ulangi password baru"
                   class="w-full px-4 py-3 border border-[#becabc] rounded-xl text-sm text-[#171c1f] bg-white
                          focus:outline-none focus:ring-2 focus:ring-[#005f2d] focus:border-[#005f2d] transition-all">
            @if ($errors->updatePassword->has('password_confirmation'))
                <p class="mt-1 text-xs text-[#ba1a1a]">{{ $errors->updatePassword->first('password_confirmation') }}</p>
            @endif
        </div>

        <div class="flex items-center gap-4 pt-2">
            <button type="submit"
                    class="inline-flex items-center gap-2 px-6 py-2.5 bg-[#005f2d] text-white text-sm font-semibold
                           rounded-xl hover:bg-[#0e7a3d] transition-all active:scale-95">
                <span class="material-symbols-outlined text-[18px]">lock_reset</span>
                Ubah Password
            </button>

            @if (session('status') === 'password-updated')
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
