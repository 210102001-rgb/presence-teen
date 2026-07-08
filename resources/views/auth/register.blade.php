<x-guest-layout>
    <div class="w-full lg:w-1/2 flex items-center justify-center p-8 lg:p-12">
        <div class="w-full max-w-md">
            <div class="text-center lg:text-left mb-8">
                <h1 class="text-2xl font-bold text-gray-900">Buat Akun</h1>
                <p class="mt-2 text-sm text-gray-600">Daftar untuk mulai menggunakan {{ config('app.name', 'PRESENCE-TEEN') }}</p>
            </div>

            <form method="POST" action="{{ route('register') }}" class="space-y-5">
                @csrf

                <div>
                    <x-input-label for="name" :value="__('Nama')" />
                    <x-text-input id="name" class="block mt-1 w-full px-4 py-3 rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" placeholder="Nama lengkap" />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="email" :value="__('Email')" />
                    <x-text-input id="email" class="block mt-1 w-full px-4 py-3 rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500" type="email" name="email" :value="old('email')" required autocomplete="username" placeholder="nama@email.com" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="password" :value="__('Password')" />
                    <x-text-input id="password" class="block mt-1 w-full px-4 py-3 rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500" type="password" name="password" required autocomplete="new-password" placeholder="Minimal 8 karakter" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="password_confirmation" :value="__('Konfirmasi Password')" />
                    <x-text-input id="password_confirmation" class="block mt-1 w-full px-4 py-3 rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500" type="password" name="password_confirmation" required autocomplete="new-password" placeholder="Ulangi password" />
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                </div>

                <x-primary-button class="w-full justify-center py-3 rounded-lg text-sm font-semibold shadow-lg hover:shadow-xl transition-all duration-200">
                    {{ __('Daftar') }}
                </x-primary-button>

                <p class="text-center text-sm text-gray-500">
                    Sudah punya akun?
                    <a href="{{ route('login') }}" class="text-indigo-600 hover:text-indigo-800 font-medium">Masuk</a>
                </p>
            </form>
        </div>
    </div>
</x-guest-layout>
