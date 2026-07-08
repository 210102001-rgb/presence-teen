<x-guest-layout>
    <div class="w-full lg:w-1/2 flex items-center justify-center p-8 lg:p-12">
        <div class="w-full max-w-md">
            <div class="text-center lg:text-left mb-8">
                <h1 class="text-2xl font-bold text-gray-900">Selamat Datang</h1>
                <p class="mt-2 text-sm text-gray-600">Silakan masuk ke akun Anda untuk melanjutkan</p>
            </div>

            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form method="POST" action="{{ route('login') }}" class="space-y-5">
                @csrf

                <div>
                    <x-input-label for="email" :value="__('Email')" />
                    <x-text-input id="email" class="block mt-1 w-full px-4 py-3 rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="nama@email.com" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="password" :value="__('Password')" />
                    <x-text-input id="password" class="block mt-1 w-full px-4 py-3 rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500" type="password" name="password" required autocomplete="current-password" placeholder="••••••••" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <div class="flex items-center justify-between">
                    <label for="remember_me" class="inline-flex items-center">
                        <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                        <span class="ms-2 text-sm text-gray-600">{{ __('Ingat saya') }}</span>
                    </label>

                    @if (Route::has('password.request'))
                        <a class="text-sm text-indigo-600 hover:text-indigo-800 font-medium" href="{{ route('password.request') }}">
                            {{ __('Lupa password?') }}
                        </a>
                    @endif
                </div>

                <x-primary-button class="w-full justify-center py-3 rounded-lg text-sm font-semibold shadow-lg hover:shadow-xl transition-all duration-200">
                    {{ __('Masuk') }}
                </x-primary-button>
            </form>

            <p class="mt-8 text-center text-sm text-gray-500">
                Belum punya akun?
                <a href="{{ route('register') }}" class="text-indigo-600 hover:text-indigo-800 font-medium">Daftar</a>
            </p>
        </div>
    </div>
</x-guest-layout>
