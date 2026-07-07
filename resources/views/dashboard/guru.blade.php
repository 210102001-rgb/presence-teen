<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Guru') }}
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
                        <h4 class="font-semibold text-lg text-gray-900">{{ __('Generate QR Presensi') }}</h4>
                        <p class="mt-2 text-sm text-gray-600">{{ __('Buat QR Code untuk presensi kelas') }}</p>
                        <a href="{{ route('presensi.guru') }}" class="mt-4 inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            {{ __('Generate QR') }}
                        </a>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h4 class="font-semibold text-lg text-gray-900">{{ __('Kelola Tugas') }}</h4>
                        <p class="mt-2 text-sm text-gray-600">{{ __('Atur dan kelola tugas siswa') }}</p>
                        <a href="{{ route('tugas.index') }}" class="mt-4 inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            {{ __('Kelola Tugas') }}
                        </a>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h4 class="font-semibold text-lg text-gray-900">{{ __('Laporan Siswa') }}</h4>
                        <p class="mt-2 text-sm text-gray-600">{{ __('Lihat laporan dan peringatan siswa') }}</p>
                        <a href="{{ route('laporan.index') }}" class="mt-4 inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            {{ __('Lihat Laporan') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
