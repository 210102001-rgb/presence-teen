<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $materi->judul }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900">{{ __('Materi Asli') }}</h3>
                    <div class="mt-2 p-4 bg-gray-50 rounded-lg text-sm text-gray-700 leading-relaxed whitespace-pre-wrap">
                        {{ $materi->materi_asli }}
                    </div>

                    <hr class="my-6">

                    <h3 class="text-lg font-semibold text-gray-900">{{ __('Ringkasan AI') }}</h3>
                    <div class="mt-2 p-4 bg-blue-50 border border-blue-200 rounded-lg text-sm text-gray-700 leading-relaxed whitespace-pre-wrap">
                        {{ $materi->ringkasan_ai ?? __('Ringkasan belum tersedia') }}
                    </div>

                    <div class="mt-6">
                        <a href="{{ route('materi.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            {{ __('Kembali') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
