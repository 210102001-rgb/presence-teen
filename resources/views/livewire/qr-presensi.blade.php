<div wire:poll.5s="refreshToken">
    @if (!$sesiAktif)
        <form wire:submit="mulaiSesi" class="space-y-3">
            <input type="text" wire:model="mataPelajaran" placeholder="Mata Pelajaran"
                   class="border rounded px-3 py-2 w-full">
            @error('mataPelajaran') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">
                Mulai Sesi Presensi
            </button>
        </form>
    @else
        <div class="text-center space-y-3">
            <p class="font-semibold">{{ $sesiAktif->mata_pelajaran }}</p>

            {{-- QR pakai package simple-qrcode --}}
            <div class="flex justify-center">
                {!! QrCode::size(250)->generate(route('presensi.scan.token', $sesiAktif->qr_token)) !!}
            </div>

            <p class="text-sm text-gray-500">
                Token refresh otomatis tiap {{ $durasiExpired }} detik
            </p>

            <button wire:click="akhiriSesi" class="bg-red-600 text-white px-4 py-2 rounded">
                Akhiri Sesi
            </button>
        </div>
    @endif
</div>
