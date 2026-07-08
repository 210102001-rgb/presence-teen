<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="text-lg font-semibold text-gray-800">{{ __('Upload Materi') }}</h2>
            <p class="text-sm text-gray-500">{{ __('Upload materi pembelajaran untuk siswa') }}</p>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <form action="{{ route('materi.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf

                    <div>
                        <x-input-label for="judul" :value="__('Judul Materi')" />
                        <x-text-input id="judul" name="judul" type="text" class="mt-1 block w-full" placeholder="Contoh: Bab 1 - Sistem Persamaan Linear" required />
                        <x-input-error class="mt-2" :messages="$errors->get('judul')" />
                    </div>

                    <div>
                        <x-input-label for="file" :value="__('File Materi')" />
                        <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg hover:border-indigo-400 transition">
                            <div class="space-y-2 text-center">
                                <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                    <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                                <div class="text-sm text-gray-600">
                                    <label for="file" class="relative cursor-pointer rounded-md font-medium text-indigo-600 hover:text-indigo-500">
                                        <span>Upload file</span>
                                        <input id="file" name="file" type="file" class="sr-only" required accept=".txt,.pdf,.docx">
                                    </label>
                                    <p class="ps-1">atau drag & drop</p>
                                </div>
                                <p class="text-xs text-gray-500">TXT, PDF, DOCX maksimal 10 MB</p>
                            </div>
                        </div>
                        <x-input-error class="mt-2" :messages="$errors->get('file')" />
                    </div>

                    <div class="flex items-center gap-4">
                        <x-primary-button>{{ __('Upload Materi') }}</x-primary-button>
                        <a href="{{ route('dashboard') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                            {{ __('Batal') }}
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
