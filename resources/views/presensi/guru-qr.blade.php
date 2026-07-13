<x-app-layout>
    <x-slot name="header">Sesi Presensi</x-slot>

    <div class="p-4 md:p-8 max-w-7xl mx-auto">
        {{-- Page Header --}}
        <div class="mb-8">
            <h2 class="text-2xl font-bold text-on-surface">Manajemen Sesi Presensi</h2>
            <p class="text-sm text-secondary mt-1 font-medium">Buat, kelola, dan pantau kehadiran siswa secara real-time.</p>
        </div>

        {{-- Livewire unified component --}}
        @livewire('qr-presensi')
    </div>
</x-app-layout>
