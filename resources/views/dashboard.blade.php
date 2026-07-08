<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-lg font-semibold text-gray-800">{{ __('Dashboard') }}</h2>
                <p class="text-sm text-gray-500">{{ __('Selamat datang di Presence-Teen') }}</p>
            </div>
            <span class="px-3 py-1 text-xs font-medium bg-indigo-100 text-indigo-700 rounded-full">
                {{ ucfirst(Auth::user()->role) }}
            </span>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-8 text-center">
                <div class="w-16 h-16 bg-indigo-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900">{{ __("You're logged in!") }}</h3>
                <p class="mt-2 text-gray-500">{{ __('Silakan pilih menu sesuai peran Anda.') }}</p>
            </div>
        </div>
    </div>
</x-app-layout>
