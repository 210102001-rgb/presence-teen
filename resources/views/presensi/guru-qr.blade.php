<x-app-layout>
    <x-slot name="header">QR Presensi</x-slot>

    <div class="p-4 md:p-8">
        {{-- Page Header --}}
        <div class="mb-6">
            <p class="text-[11px] uppercase tracking-widest text-[#005f2d] font-semibold mb-1">Attendance Management</p>
            <h2 class="text-2xl font-bold text-[#171c1f]">Generate QR Presensi</h2>
            <p class="text-sm text-[#5c5f61] mt-1">Buat sesi presensi dengan QR Code yang auto-refresh setiap 30 detik.</p>
        </div>

        @if ($kelas->isEmpty())
            {{-- No kelas state --}}
            <div class="bg-white rounded-xl shadow-soft border border-[#eaeef2] p-16 text-center">
                <div class="w-16 h-16 bg-[#eaeef2] rounded-full flex items-center justify-center mx-auto mb-4">
                    <span class="material-symbols-outlined text-[#5c5f61] text-3xl">class</span>
                </div>
                <p class="text-base font-medium text-[#171c1f]">Belum ada kelas</p>
                <p class="text-sm text-[#5c5f61] mt-1">Anda belum memiliki kelas aktif. Hubungi administrator.</p>
            </div>
        @else
            {{-- Livewire QR Component --}}
            @livewire('qr-presensi', ['kelasId' => $selectedKelas?->id])
        @endif
    </div>

    @push('scripts')
    <style>
        @keyframes scan {
            0%   { transform: translateY(-100%); }
            100% { transform: translateY(300%); }
        }
        .animate-scan { animation: scan 3s infinite linear; }
    </style>
    @endpush
</x-app-layout>
