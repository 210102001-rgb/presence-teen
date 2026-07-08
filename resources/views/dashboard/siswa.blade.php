<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="text-lg font-semibold text-gray-800">{{ __('Dashboard Siswa') }}</h2>
            <p class="text-sm text-gray-500">{{ __('Halo, ') }} <span class="font-semibold text-indigo-600">{{ Auth::user()->name }}</span> {{ __('— semangat belajar!') }}</p>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl shadow-sm p-6 text-white">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-blue-100 text-sm font-medium">{{ __('Presensi Hari Ini') }}</p>
                            <p class="text-3xl font-bold mt-1">12</p>
                            <p class="text-blue-200 text-xs mt-1">{{ __('Siswa hadir') }}</p>
                        </div>
                        <div class="w-12 h-12 bg-white/20 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-xl shadow-sm p-6 text-white">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-emerald-100 text-sm font-medium">{{ __('Total Tugas') }}</p>
                            <p class="text-3xl font-bold mt-1">3</p>
                            <p class="text-emerald-200 text-xs mt-1">{{ __('Tugas aktif') }}</p>
                        </div>
                        <div class="w-12 h-12 bg-white/20 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl shadow-sm p-6 text-white">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-purple-100 text-sm font-medium">{{ __('Ringkasan Materi') }}</p>
                            <p class="text-3xl font-bold mt-1">5</p>
                            <p class="text-purple-200 text-xs mt-1">{{ __('Materi tersedia') }}</p>
                        </div>
                        <div class="w-12 h-12 bg-white/20 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h4 class="font-semibold text-gray-900">{{ __('Tugas Mendatang') }}</h4>
                        <a href="{{ route('tugas.index') }}" class="text-xs font-medium text-indigo-600 hover:text-indigo-800">{{ __('Lihat Semua') }}</a>
                    </div>
                    <ul class="space-y-3">
                        <li class="flex items-center justify-between py-2 border-b border-gray-100">
                            <div>
                                <p class="text-sm font-medium text-gray-900">Matematika</p>
                                <p class="text-xs text-gray-500">Pengumpulan besok</p>
                            </div>
                            <span class="px-2 py-1 text-xs font-medium bg-yellow-100 text-yellow-700 rounded-full">Besok</span>
                        </li>
                        <li class="flex items-center justify-between py-2 border-b border-gray-100">
                            <div>
                                <p class="text-sm font-medium text-gray-900">IPA</p>
                                <p class="text-xs text-gray-500">Laporan praktikum</p>
                            </div>
                            <span class="px-2 py-1 text-xs font-medium bg-blue-100 text-blue-700 rounded-full">3 hari</span>
                        </li>
                        <li class="flex items-center justify-between py-2">
                            <div>
                                <p class="text-sm font-medium text-gray-900">Bahasa Indonesia</p>
                                <p class="text-xs text-gray-500">Esai</p>
                            </div>
                            <span class="px-2 py-1 text-xs font-medium bg-green-100 text-green-700 rounded-full">1 minggu</span>
                        </li>
                    </ul>
                </div>

                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h4 class="font-semibold text-gray-900">{{ __('Presensi') }}</h4>
                        <a href="{{ route('presensi.scan') }}" class="text-xs font-medium text-indigo-600 hover:text-indigo-800">{{ __('Scan QR') }}</a>
                    </div>
                    <div class="flex flex-col items-center py-4">
                        <div class="w-16 h-16 bg-indigo-100 rounded-full flex items-center justify-center mb-3">
                            <svg class="w-8 h-8 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/>
                            </svg>
                        </div>
                        <p class="text-sm text-gray-600 text-center">{{ __('Scan QR Code untuk melakukan presensi') }}</p>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h4 class="font-semibold text-gray-900">{{ __('Ringkasan Materi') }}</h4>
                        <a href="{{ route('materi.index') }}" class="text-xs font-medium text-indigo-600 hover:text-indigo-800">{{ __('Lihat Semua') }}</a>
                    </div>
                    <p class="text-sm text-gray-600 mb-4">{{ __('Akses ringkasan materi pelajaran berbasis AI. Upload file dan dapatkan ringkasan instan.') }}</p>
                    <a href="{{ route('materi.index') }}" class="inline-flex items-center text-sm font-medium text-indigo-600 hover:text-indigo-800">
                        {{ __('Lihat Materi') }}
                        <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
