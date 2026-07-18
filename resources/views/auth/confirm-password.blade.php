<x-guest-layout>
    <x-slot name="title">Konfirmasi Kata Sandi</x-slot>
    <div class="w-full lg:w-1/2 flex items-center justify-center p-8 lg:p-12">
        <div class="w-full max-w-md">
            <div class="text-center lg:text-left mb-8">
                <h1 class="text-2xl font-bold text-gray-900">Konfirmasi Password</h1>
                <p class="mt-2 text-sm text-gray-600">{{ __('Ini adalah area aman. Harap konfirmasi password Anda sebelum melanjutkan.') }}</p>
            </div>

            <form method="POST" action="{{ route('password.confirm') }}" class="space-y-5">
                @csrf

                <div>
                    <x-input-label for="password" :value="__('Password')" />
                    <x-text-input id="password" class="block mt-1 w-full px-4 py-3 rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500" type="password" name="password" required autocomplete="current-password" placeholder="Masukkan password" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <x-primary-button class="w-full justify-center py-3 rounded-lg text-sm font-semibold shadow-lg hover:shadow-xl transition-all duration-200">
                    {{ __('Konfirmasi') }}
                </x-primary-button>
            </form>
        </div>
    </div>
</x-guest-layout>
