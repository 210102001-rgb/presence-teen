<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detail Laporan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 space-y-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900">{{ $laporan->siswa->name ?? '-' }}</h3>
                            <p class="text-sm text-gray-500">{{ $laporan->periode }}</p>
                        </div>
                        @php
                            $colors = [
                                'ringan' => 'bg-green-100 text-green-800',
                                'sedang' => 'bg-yellow-100 text-yellow-800',
                                'berat' => 'bg-red-100 text-red-800',
                            ];
                            $level = $laporan->level_peringatan ?? 'ringan';
                        @endphp
                        <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full {{ $colors[$level] ?? 'bg-gray-100 text-gray-800' }}">
                            {{ ucfirst($level) }}
                        </span>
                    </div>

                    <hr>

                    <div>
                        <h4 class="font-semibold text-gray-900">{{ __('Hasil Analisis') }}</h4>
                        <div class="mt-2 p-4 bg-gray-50 rounded-lg text-sm text-gray-700 leading-relaxed whitespace-pre-wrap">
                            {{ $laporan->hasil_analisis ?? __('Tidak ada analisis') }}
                        </div>
                    </div>

                    <div>
                        <a href="{{ route('laporan.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            {{ __('Kembali') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
