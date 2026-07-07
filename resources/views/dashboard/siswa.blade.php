<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Siswa') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-6">
                <h3 class="text-2xl font-bold text-gray-900">
                    {{ __('Halo, ') }} {{ Auth::user()->name }}!
                </h3>
                <p class="mt-1 text-gray-600">{{ __('Selamat datang di Presence-Teen') }}</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h4 class="font-semibold text-lg text-gray-900">{{ __('Presensi Hari Ini') }}</h4>
                        <p class="mt-2 text-4xl font-bold text-blue-600">12</p>
                        <p class="mt-1 text-sm text-gray-500">{{ __('Siswa hadir hari ini') }}</p>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h4 class="font-semibold text-lg text-gray-900">{{ __('Tugas Mendatang') }}</h4>
                        <ul class="mt-2 space-y-2">
                            <li class="text-sm text-gray-700">Matematika - Pengumpulan besok</li>
                            <li class="text-sm text-gray-700">IPA - Laporan praktikum</li>
                            <li class="text-sm text-gray-700">Bahasa Indonesia - Esai</li>
                        </ul>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h4 class="font-semibold text-lg text-gray-900">{{ __('Ringkasan Materi') }}</h4>
                        <p class="mt-2 text-sm text-gray-600">{{ __('Akses ringkasan materi pelajaran') }}</p>
                        <a href="{{ route('materi.index') }}" class="mt-4 inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            {{ __('Lihat Materi') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
