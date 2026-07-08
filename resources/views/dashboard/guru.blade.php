<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="text-lg font-semibold text-gray-800">{{ __('Dashboard Guru') }}</h2>
            <p class="text-sm text-gray-500">{{ __('Halo, ') }} <span class="font-semibold text-indigo-600">{{ Auth::user()->name }}</span> {{ __('— selamat mengajar!') }}</p>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="bg-gradient-to-br from-indigo-500 to-indigo-600 rounded-xl shadow-sm p-6 text-white">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-indigo-100 text-sm font-medium">{{ __('Total Kelas') }}</p>
                            <p class="text-3xl font-bold mt-1">1</p>
                            <p class="text-indigo-200 text-xs mt-1">{{ __('Kelas aktif') }}</p>
                        </div>
                        <div class="w-12 h-12 bg-white/20 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-xl shadow-sm p-6 text-white">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-emerald-100 text-sm font-medium">{{ __('Total Siswa') }}</p>
                            <p class="text-3xl font-bold mt-1">30</p>
                            <p class="text-emerald-200 text-xs mt-1">{{ __('Seluruh siswa') }}</p>
                        </div>
                        <div class="w-12 h-12 bg-white/20 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="bg-gradient-to-br from-amber-500 to-amber-600 rounded-xl shadow-sm p-6 text-white">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-amber-100 text-sm font-medium">{{ __('Total Tugas') }}</p>
                            <p class="text-3xl font-bold mt-1">5</p>
                            <p class="text-amber-200 text-xs mt-1">{{ __('Tugas dibuat') }}</p>
                        </div>
                        <div class="w-12 h-12 bg-white/20 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h4 class="font-semibold text-gray-900">{{ __('QR Presensi') }}</h4>
                        <a href="{{ route('presensi.guru') }}" class="text-xs font-medium text-indigo-600 hover:text-indigo-800">{{ __('Generate') }}</a>
                    </div>
                    <p class="text-sm text-gray-600 mb-4">{{ __('Buat QR Code untuk presensi kelas dengan mudah.') }}</p>
                    <a href="{{ route('presensi.guru') }}" class="inline-flex items-center text-sm font-medium text-indigo-600 hover:text-indigo-800">
                        {{ __('Generate QR') }}
                        <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </a>
                </div>

                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h4 class="font-semibold text-gray-900">{{ __('Kelola Tugas') }}</h4>
                        <a href="{{ route('tugas.index') }}" class="text-xs font-medium text-indigo-600 hover:text-indigo-800">{{ __('Atur') }}</a>
                    </div>
                    <p class="text-sm text-gray-600 mb-4">{{ __('Buat, edit, dan kelola tugas untuk siswa.') }}</p>
                    <a href="{{ route('tugas.index') }}" class="inline-flex items-center text-sm font-medium text-indigo-600 hover:text-indigo-800">
                        {{ __('Kelola Tugas') }}
                        <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </a>
                </div>

                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h4 class="font-semibold text-gray-900">{{ __('Laporan Siswa') }}</h4>
                        <a href="{{ route('laporan.index') }}" class="text-xs font-medium text-indigo-600 hover:text-indigo-800">{{ __('Lihat') }}</a>
                    </div>
                    <p class="text-sm text-gray-600 mb-4">{{ __('Pantau laporan kehadiran dan peringatan siswa.') }}</p>
                    <a href="{{ route('laporan.index') }}" class="inline-flex items-center text-sm font-medium text-indigo-600 hover:text-indigo-800">
                        {{ __('Lihat Laporan') }}
                        <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
