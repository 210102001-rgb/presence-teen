<section class="space-y-5">
    <div>
        <p class="text-sm text-[#5c5f61] leading-relaxed">
            Setelah akun dihapus, semua data akan dihapus secara permanen.
            Pastikan Anda telah menyimpan data penting sebelum melanjutkan.
        </p>
    </div>

    <button
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
        class="inline-flex items-center gap-2 px-5 py-2.5 bg-[#ffdad6] border border-[#ba1a1a]/20 text-[#93000a]
               text-sm font-semibold rounded-xl hover:bg-[#ba1a1a] hover:text-white transition-all active:scale-95">
        <span class="material-symbols-outlined text-[18px]">delete_forever</span>
        Hapus Akun
    </button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-6">
            @csrf
            @method('delete')

            <div class="flex items-center gap-3 mb-5">
                <div class="w-10 h-10 bg-[#ffdad6] rounded-xl flex items-center justify-center shrink-0">
                    <span class="material-symbols-outlined text-[#ba1a1a] filled-icon">warning</span>
                </div>
                <h2 class="text-base font-bold text-[#171c1f]">Konfirmasi Hapus Akun</h2>
            </div>

            <p class="text-sm text-[#5c5f61] mb-5 leading-relaxed">
                Tindakan ini tidak dapat dibatalkan. Semua data Anda akan dihapus secara permanen.
                Masukkan password untuk konfirmasi.
            </p>

            <div class="mb-5">
                <label for="password" class="block text-sm font-semibold text-[#171c1f] mb-1.5 sr-only">Password</label>
                <input id="password" name="password" type="password"
                       placeholder="Masukkan password Anda"
                       class="w-full px-4 py-3 border border-[#becabc] rounded-xl text-sm text-[#171c1f] bg-white
                              focus:outline-none focus:ring-2 focus:ring-[#ba1a1a] focus:border-[#ba1a1a] transition-all">
                @if ($errors->userDeletion->has('password'))
                    <p class="mt-1 text-xs text-[#ba1a1a]">{{ $errors->userDeletion->first('password') }}</p>
                @endif
            </div>

            <div class="flex justify-end gap-3">
                <button type="button"
                        x-on:click="$dispatch('close')"
                        class="px-5 py-2.5 border border-[#becabc] text-[#5c5f61] text-sm font-semibold
                               rounded-xl hover:bg-[#f0f4f8] transition-all">
                    Batal
                </button>
                <button type="submit"
                        class="inline-flex items-center gap-2 px-5 py-2.5 bg-[#ba1a1a] text-white text-sm font-semibold
                               rounded-xl hover:bg-[#93000a] transition-all active:scale-95">
                    <span class="material-symbols-outlined text-[18px]">delete_forever</span>
                    Hapus Akun
                </button>
            </div>
        </form>
    </x-modal>
</section>
