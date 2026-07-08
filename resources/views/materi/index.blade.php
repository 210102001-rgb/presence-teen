<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="text-lg font-semibold text-gray-800">{{ __('Materi Pembelajaran') }}</h2>
                <p class="text-sm text-gray-500">{{ __('Materi yang diupload oleh guru') }}</p>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            @if($materi->isEmpty())
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-12 text-center">
                    <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                        </svg>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900">{{ __('Belum ada materi') }}</h3>
                    <p class="mt-2 text-sm text-gray-500">{{ __('Guru belum mengupload materi pembelajaran.') }}</p>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($materi as $item)
                        <div class="bg-white rounded-xl shadow-sm border border-gray-200 hover:shadow-md transition overflow-hidden">
                            <div class="p-6">
                                <div class="w-10 h-10 bg-indigo-100 rounded-lg flex items-center justify-center mb-3">
                                    <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                </div>
                                <h4 class="font-semibold text-gray-900 mb-1">{{ $item->judul }}</h4>
                                <p class="text-xs text-gray-500 mb-3">{{ __('Oleh: ') }}{{ $item->guru->name ?? 'Guru' }} &middot; {{ $item->created_at->format('d M Y') }}</p>
                                <div class="flex items-center justify-between">
                                    <a href="{{ route('materi.show', $item) }}" class="inline-flex items-center text-sm font-medium text-indigo-600 hover:text-indigo-800">
                                        {{ __('Lihat') }}
                                        <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                        </svg>
                                    </a>
                                    @if($item->ringkasan_ai)
                                        <span class="px-2 py-1 text-xs font-medium bg-green-100 text-green-700 rounded-full">{{ __('Sudah diringkas') }}</span>
                                    @else
                                        <span class="px-2 py-1 text-xs font-medium bg-gray-100 text-gray-500 rounded-full">{{ __('Belum diringkas') }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
