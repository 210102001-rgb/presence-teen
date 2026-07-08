<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="text-lg font-semibold text-gray-800">{{ $materi->judul }}</h2>
            <p class="text-sm text-gray-500">{{ __('Oleh: ') }}{{ $materi->guru->name ?? 'Guru' }} &middot; {{ $materi->created_at->format('d M Y') }}</p>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-4 p-4 bg-green-50 border border-green-200 rounded-lg text-sm text-green-700">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="mb-4 p-4 bg-red-50 border border-red-200 rounded-lg text-sm text-red-700">
                    {{ session('error') }}
                </div>
            @endif

            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-sm font-semibold text-gray-900 uppercase tracking-wider">{{ __('Materi Asli') }}</h3>
                    @if($materi->file_path)
                        <a href="{{ Storage::url($materi->file_path) }}" target="_blank"
                           class="inline-flex items-center px-3 py-1.5 text-xs font-medium text-indigo-600 bg-indigo-50 rounded-lg hover:bg-indigo-100 transition">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                            </svg>
                            {{ __('Download File') }}
                        </a>
                    @endif
                </div>
                <div class="p-4 bg-gray-50 rounded-lg text-sm text-gray-700 leading-relaxed whitespace-pre-wrap max-h-96 overflow-y-auto">
                    {{ $materi->materi_asli }}
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-sm font-semibold text-gray-900 uppercase tracking-wider">{{ __('Ringkasan AI') }}</h3>
                    @if(!$materi->ringkasan_ai)
                        <form action="{{ route('materi.ringkas', $materi) }}" method="POST">
                            @csrf
                            <button type="submit"
                                    class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-indigo-600 to-purple-600 border border-transparent rounded-lg text-sm font-medium text-white hover:from-indigo-700 hover:to-purple-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                                </svg>
                                {{ __('Ringkas dengan AI') }}
                            </button>
                        </form>
                    @endif
                </div>

                @if($materi->ringkasan_ai)
                    <div class="p-4 bg-gradient-to-br from-indigo-50 to-purple-50 border border-indigo-100 rounded-lg text-sm text-gray-700 leading-relaxed whitespace-pre-wrap">
                        {{ $materi->ringkasan_ai }}
                    </div>
                @else
                    <div class="py-8 text-center">
                        <div class="w-12 h-12 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-3">
                            <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                            </svg>
                        </div>
                        <p class="text-sm text-gray-500">{{ __('Klik "Ringkas dengan AI" untuk membuat ringkasan dari materi ini.') }}</p>
                    </div>
                @endif
            </div>

            <div class="mt-6">
                <a href="{{ route('materi.index') }}" class="inline-flex items-center text-sm font-medium text-gray-600 hover:text-gray-800 transition">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                    {{ __('Kembali ke daftar materi') }}
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
