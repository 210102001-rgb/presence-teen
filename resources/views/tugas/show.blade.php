<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $tugas->judul }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900">{{ $tugas->judul }}</h3>
                    <p class="mt-2 text-sm text-gray-600">{{ $tugas->deskripsi }}</p>
                    <p class="mt-2 text-sm text-gray-500">
                        <span class="font-medium">{{ __('Deadline') }}:</span>
                        {{ $tugas->deadline->format('d M Y H:i') }}
                    </p>

                    <hr class="my-6">

                    <h4 class="font-semibold text-gray-900">{{ __('Pengumpulan') }}</h4>
                    @if($tugas->pengumpulan && $tugas->pengumpulan->count())
                        <table class="mt-4 min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama Siswa</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nilai</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($tugas->pengumpulan as $pengumpulan)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $pengumpulan->siswa->name ?? '-' }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $pengumpulan->created_at->format('d M Y H:i') }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $pengumpulan->nilai ?? '-' }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <p class="mt-4 text-sm text-gray-500">{{ __('Belum ada pengumpulan') }}</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
