<x-guest-layout>
    <div class="w-full lg:w-1/2 flex items-center justify-center p-8 lg:p-12">
        <div class="w-full max-w-md">
            <div class="text-center lg:text-left mb-8">
                <h1 class="text-2xl font-bold text-gray-900">Reset Password</h1>
                <p class="mt-2 text-sm text-gray-600">Buat password baru untuk akun Anda.</p>
            </div>

            <form method="POST" action="{{ route('password.store') }}" class="space-y-5">
                @csrf

                <input type="hidden" name="token" value="{{ $request->route('token') }}">

                <div>
                    <x-input-label for="email" :value="__('Email')" />
                    <x-text-input id="email" class="block mt-1 w-full px-4 py-3 rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500" type="email" name="email" :value="old('email', $request->email)" required autofocus autocomplete="username" readonly />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="password" :value="__('Password Baru')" />
                    <x-text-input id="password" class="block mt-1 w-full px-4 py-3 rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500" type="password" name="password" required autocomplete="new-password" placeholder="Minimal 8 karakter" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="password_confirmation" :value="__('Konfirmasi Password')" />
                    <x-text-input id="password_confirmation" class="block mt-1 w-full px-4 py-3 rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500" type="password" name="password_confirmation" required autocomplete="new-password" placeholder="Ulangi password" />
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                </div>

                <x-primary-button class="w-full justify-center py-3 rounded-lg text-sm font-semibold shadow-lg hover:shadow-xl transition-all duration-200">
                    {{ __('Reset Password') }}
                </x-primary-button>
            </form>
        </div>
    </div>
</x-guest-layout>
