<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="text-lg font-semibold text-gray-800">{{ __('Dashboard Orang Tua') }}</h2>
            <p class="text-sm text-gray-500">{{ __('Halo, ') }} <span class="font-semibold text-indigo-600">{{ Auth::user()->name }}</span> {{ __('— pantau perkembangan anak Anda') }}</p>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-xl shadow-sm p-6 text-white">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-emerald-100 text-sm font-medium">{{ __('Kehadiran Hari Ini') }}</p>
                            <p class="text-3xl font-bold mt-1">{{ __('Hadir') }}</p>
                            <p class="text-emerald-200 text-xs mt-1">{{ __('Hari ini, 07:45 WIB') }}</p>
                        </div>
                        <div class="w-12 h-12 bg-white/20 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl shadow-sm p-6 text-white">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-blue-100 text-sm font-medium">{{ __('Total Tugas') }}</p>
                            <p class="text-3xl font-bold mt-1">3</p>
                            <p class="text-blue-200 text-xs mt-1">{{ __('Tugas tersedia') }}</p>
                        </div>
                        <div class="w-12 h-12 bg-white/20 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="bg-gradient-to-br from-rose-500 to-rose-600 rounded-xl shadow-sm p-6 text-white">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-rose-100 text-sm font-medium">{{ __('Peringatan') }}</p>
                            <p class="text-3xl font-bold mt-1">0</p>
                            <p class="text-rose-200 text-xs mt-1">{{ __('Tidak ada peringatan') }}</p>
                        </div>
                        <div class="w-12 h-12 bg-white/20 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h4 class="font-semibold text-gray-900">{{ __('Tugas Anak') }}</h4>
                        <a href="{{ route('tugas.index') }}" class="text-xs font-medium text-indigo-600 hover:text-indigo-800">{{ __('Lihat Semua') }}</a>
                    </div>
                    <ul class="space-y-3">
                        <li class="flex items-center justify-between py-2 border-b border-gray-100">
                            <div class="flex items-center space-x-3">
                                <div class="w-8 h-8 bg-emerald-100 rounded-lg flex items-center justify-center">
                                    <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-900">Matematika</p>
                                    <p class="text-xs text-gray-500">Selesai</p>
                                </div>
                            </div>
                            <span class="px-2 py-1 text-xs font-medium bg-emerald-100 text-emerald-700 rounded-full">Selesai</span>
                        </li>
                        <li class="flex items-center justify-between py-2 border-b border-gray-100">
                            <div class="flex items-center space-x-3">
                                <div class="w-8 h-8 bg-amber-100 rounded-lg flex items-center justify-center">
                                    <svg class="w-4 h-4 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-900">IPA</p>
                                    <p class="text-xs text-gray-500">Belum dikumpulkan</p>
                                </div>
                            </div>
                            <span class="px-2 py-1 text-xs font-medium bg-amber-100 text-amber-700 rounded-full">Belum</span>
                        </li>
                        <li class="flex items-center justify-between py-2">
                            <div class="flex items-center space-x-3">
                                <div class="w-8 h-8 bg-emerald-100 rounded-lg flex items-center justify-center">
                                    <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-900">Bahasa Inggris</p>
                                    <p class="text-xs text-gray-500">Selesai</p>
                                </div>
                            </div>
                            <span class="px-2 py-1 text-xs font-medium bg-emerald-100 text-emerald-700 rounded-full">Selesai</span>
                        </li>
                    </ul>
                </div>

                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h4 class="font-semibold text-gray-900">{{ __('Laporan Peringatan') }}</h4>
                        <a href="{{ route('laporan.index') }}" class="text-xs font-medium text-indigo-600 hover:text-indigo-800">{{ __('Lihat Laporan') }}</a>
                    </div>
                    <div class="flex flex-col items-center py-4">
                        <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mb-3">
                            <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <p class="text-sm text-gray-600 text-center">{{ __('Tidak ada peringatan untuk anak Anda saat ini.') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
