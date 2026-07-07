<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Generate QR Presensi') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                @if ($kelas->isEmpty())
                    <p class="text-gray-500 text-center">Anda belum memiliki kelas. Buat kelas terlebih dahulu.</p>
                @else
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                        @foreach ($kelas as $k)
                            <div class="border rounded-lg p-4 hover:bg-gray-50 cursor-pointer"
                                 onclick="document.getElementById('kelas-{{ $k->id }}').click()">
                                <h3 class="font-semibold">{{ $k->nama_kelas }}</h3>
                                <p class="text-sm text-gray-500">{{ $k->mata_pelajaran }}</p>
                                <a id="kelas-{{ $k->id }}"
                                   href="{{ route('presensi.guru.qr', $k->id) }}"
                                   class="mt-2 inline-block text-blue-600 text-sm">Generate QR &rarr;</a>
                            </div>
                        @endforeach
                    </div>

                    @if ($selectedKelas)
                        <hr class="my-6">
                        <h3 class="text-lg font-semibold mb-4">Presensi: {{ $selectedKelas->nama_kelas }}</h3>
                        @livewire('qr-presensi', ['kelasId' => $selectedKelas->id], key($selectedKelas->id))
                    @endif
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
