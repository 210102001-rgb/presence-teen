<x-guest-layout>
    <x-slot name="title">Verifikasi Email</x-slot>
    <div class="w-full lg:w-1/2 flex items-center justify-center p-8 lg:p-12">
        <div class="w-full max-w-md">
            <div class="text-center lg:text-left mb-8">
                <h1 class="text-2xl font-bold text-gray-900">Verifikasi Email</h1>
                <p class="mt-2 text-sm text-gray-600">{{ __('Terima kasih sudah mendaftar! Sebelum memulai, verifikasi email Anda dengan mengklik tautan yang kami kirim.') }}</p>
            </div>

            @if (session('status') == 'verification-link-sent')
                <div class="mb-4 p-4 bg-green-50 border border-green-200 rounded-lg text-sm text-green-700">
                    {{ __('Tautan verifikasi baru telah dikirim ke email Anda.') }}
                </div>
            @endif

            <div class="space-y-4">
                <form method="POST" action="{{ route('verification.send') }}">
                    @csrf
                    <x-primary-button class="w-full justify-center py-3 rounded-lg text-sm font-semibold shadow-lg hover:shadow-xl transition-all duration-200">
                        {{ __('Kirim Ulang Email Verifikasi') }}
                    </x-primary-button>
                </form>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full text-center text-sm text-gray-500 hover:text-gray-700 font-medium">
                        {{ __('Log Out') }}
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-guest-layout>
