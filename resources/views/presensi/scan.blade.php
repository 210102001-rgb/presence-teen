<x-app-layout>
    <x-slot name="header">Scan Presensi</x-slot>

    <div class="p-4 md:p-8">
        <div class="max-w-xl mx-auto">
            @if(session('success'))
                <div x-data x-init="$dispatch('toast', { type: 'success', message: '{{ session('success') }}' })"></div>
            @endif
            @if(session('error'))
                <div x-data x-init="$dispatch('toast', { type: 'error', message: '{{ session('error') }}' })"></div>
            @endif

            {{-- Scanner Card --}}
            <div class="bg-white rounded-xl shadow-soft border border-[#eaeef2] overflow-hidden">
                {{-- Header --}}
                <div class="bg-[#f0fdf4] border-b border-[#0e7a3d]/15 px-6 py-4 flex items-center gap-3">
                    <span class="material-symbols-outlined text-[#0e7a3d] filled-icon">qr_code_scanner</span>
                    <div>
                        <h3 class="font-semibold text-[#005f2d]">Scan QR Presensi</h3>
                        <p class="text-xs text-[#3f493f]">Arahkan kamera ke QR Code yang ditampilkan guru</p>
                    </div>
                </div>

                <div class="p-6 space-y-5 text-center">
                    {{-- QR Reader --}}
                    <div id="reader" class="mx-auto overflow-hidden rounded-xl" style="max-width: 380px;"></div>

                    {{-- Result --}}
                    <div id="result" class="empty:hidden"></div>

                    {{-- Auto-submit form for URL token --}}
                    @isset($token)
                        <form id="auto-submit" method="POST" action="{{ route('presensi.validasi') }}">
                            @csrf
                            <input type="hidden" name="token" value="{{ $token }}">
                        </form>
                        <script>document.getElementById('auto-submit')?.submit();</script>
                    @endisset

                    {{-- Manual Input fallback --}}
                    <div class="pt-4 border-t border-[#eaeef2]">
                        <p class="text-xs text-[#5c5f61] mb-3">Atau masukkan token secara manual:</p>
                        <form id="manual-form" class="flex gap-2">
                            <input type="text" id="manual-token" placeholder="Masukkan token..."
                                   class="flex-1 px-4 py-2.5 border border-[#becabc] rounded-xl text-sm
                                          focus:outline-none focus:ring-2 focus:ring-[#005f2d] focus:border-[#005f2d] transition-all">
                            <button type="submit"
                                    class="px-4 py-2.5 bg-[#005f2d] text-white text-sm font-semibold rounded-xl
                                           hover:bg-[#0e7a3d] transition-all active:scale-95">
                                Kirim
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            {{-- Info --}}
            <div class="mt-5 ai-glow rounded-xl p-4 flex items-center gap-3">
                <span class="material-symbols-outlined text-[#0e7a3d] shrink-0">info</span>
                <p class="text-xs text-[#3f493f]">
                    Presensi hanya dapat dilakukan selama sesi QR aktif. Pastikan koneksi internet stabil.
                </p>
            </div>
        </div>
    </div>

    @push('scripts')
    <script src="https://unpkg.com/html5-qrcode@2.3.8/html5-qrcode.min.js"></script>
    <script>
        const resultDiv = document.getElementById('result');

        function showResult(success, message) {
            resultDiv.innerHTML = `
                <div class="flex items-center justify-center gap-2 p-3 rounded-xl
                     ${success
                        ? 'bg-[#f0fdf4] border border-[#0e7a3d]/20 text-[#005f2d]'
                        : 'bg-[#ffdad6] border border-[#ba1a1a]/20 text-[#93000a]'}">
                    <span class="material-symbols-outlined filled-icon text-[20px]">
                        ${success ? 'check_circle' : 'error'}
                    </span>
                    <span class="text-sm font-semibold">${message}</span>
                </div>`;
        }

        function sendToken(token) {
            fetch('{{ route("presensi.validasi") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ token })
            })
            .then(r => r.json())
            .then(data => showResult(data.success, data.message))
            .catch(err => showResult(false, 'Koneksi error: ' + err));
        }

        function onScanSuccess(decodedText) {
            // Stop scanner
            try { html5QrCode.stop(); } catch(e) {}
            document.getElementById('reader').innerHTML = '';
            showResult(true, 'Memproses token...');
            sendToken(decodedText);
        }

        const html5QrCode = new Html5Qrcode("reader");
        html5QrCode.start(
            { facingMode: "environment" },
            { fps: 10, qrbox: { width: 260, height: 260 } },
            onScanSuccess
        ).catch(err => {
            document.getElementById('reader').innerHTML =
                `<div class="p-6 text-sm text-[#5c5f61]">
                    <span class="material-symbols-outlined text-3xl text-[#dfe3e7] block mx-auto mb-2">videocam_off</span>
                    Kamera tidak dapat diakses. Gunakan input manual.
                </div>`;
        });

        // Manual token form
        document.getElementById('manual-form').addEventListener('submit', function(e) {
            e.preventDefault();
            const token = document.getElementById('manual-token').value.trim();
            if (token) sendToken(token);
        });
    </script>
    @endpush
</x-app-layout>
