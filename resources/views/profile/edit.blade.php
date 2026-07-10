<x-app-layout>
    <x-slot name="header">Profil Saya</x-slot>

    <div class="p-8">
        <div class="max-w-2xl mx-auto space-y-6">
            {{-- Update Profile --}}
            <div class="bg-white rounded-xl shadow-soft border border-[#eaeef2] overflow-hidden">
                <div class="px-6 py-4 border-b border-[#eaeef2] flex items-center gap-3">
                    <div class="w-9 h-9 bg-[#f0fdf4] rounded-xl flex items-center justify-center">
                        <span class="material-symbols-outlined text-[#0e7a3d] text-[20px]">manage_accounts</span>
                    </div>
                    <h4 class="font-semibold text-[#171c1f]">Informasi Profil</h4>
                </div>
                <div class="p-6">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            {{-- Update Password --}}
            <div class="bg-white rounded-xl shadow-soft border border-[#eaeef2] overflow-hidden">
                <div class="px-6 py-4 border-b border-[#eaeef2] flex items-center gap-3">
                    <div class="w-9 h-9 bg-[#f0fdf4] rounded-xl flex items-center justify-center">
                        <span class="material-symbols-outlined text-[#0e7a3d] text-[20px]">lock</span>
                    </div>
                    <h4 class="font-semibold text-[#171c1f]">Ubah Password</h4>
                </div>
                <div class="p-6">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            {{-- Delete Account --}}
            <div class="bg-white rounded-xl shadow-soft border border-[#ba1a1a]/20 overflow-hidden">
                <div class="px-6 py-4 border-b border-[#ba1a1a]/15 flex items-center gap-3">
                    <div class="w-9 h-9 bg-[#ffdad6]/50 rounded-xl flex items-center justify-center">
                        <span class="material-symbols-outlined text-[#ba1a1a] text-[20px]">delete_forever</span>
                    </div>
                    <h4 class="font-semibold text-[#93000a]">Hapus Akun</h4>
                </div>
                <div class="p-6">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
