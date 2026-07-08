<x-guest-layout>
    <div class="w-full lg:w-1/2 flex items-center justify-center p-8 lg:p-12">
        <div class="w-full max-w-md">
            <div class="text-center lg:text-left mb-8">
                <h1 class="text-2xl font-bold text-gray-900">Lupa Password</h1>
                <p class="mt-2 text-sm text-gray-600">Masukkan email Anda, kami akan kirim tautan reset password.</p>
            </div>

            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form method="POST" action="{{ route('password.email') }}" class="space-y-5">
                @csrf

                <div>
                    <x-input-label for="email" :value="__('Email')" />
                    <x-text-input id="email" class="block mt-1 w-full px-4 py-3 rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500" type="email" name="email" :value="old('email')" required autofocus placeholder="nama@email.com" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <x-primary-button class="w-full justify-center py-3 rounded-lg text-sm font-semibold shadow-lg hover:shadow-xl transition-all duration-200">
                    {{ __('Kirim Tautan Reset') }}
                </x-primary-button>

                <p class="text-center text-sm text-gray-500">
                    <a href="{{ route('login') }}" class="text-indigo-600 hover:text-indigo-800 font-medium">Kembali ke Login</a>
                </p>
            </form>
        </div>
    </div>
</x-guest-layout>
