<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Scan Presensi') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div id="qr-scanner" class="text-center space-y-4">
                    <p class="text-gray-600">Arahkan kamera ke QR Code yang ditampilkan guru</p>

                    <div id="reader" class="mx-auto" style="max-width: 400px;"></div>

                    <div id="result" class="mt-4"></div>

                    @isset($token)
                        <form id="auto-submit" method="POST" action="{{ route('presensi.validasi') }}">
                            @csrf
                            <input type="hidden" name="token" value="{{ $token }}">
                        </form>
                        <script>document.getElementById('auto-submit')?.submit();</script>
                    @endisset
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="https://unpkg.com/html5-qrcode@2.3.8/html5-qrcode.min.js"></script>
        <script>
            function onScanSuccess(decodedText) {
                document.getElementById('reader').innerHTML = '';
                const resultDiv = document.getElementById('result');
                resultDiv.innerHTML = '<p class="text-green-600 font-semibold">Memproses token...</p>';

                fetch('{{ route("presensi.validasi") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ token: decodedText })
                })
                .then(r => r.json())
                .then(data => {
                    if (data.success) {
                        resultDiv.innerHTML = '<p class="text-green-600 font-bold text-lg">' + data.message + '</p>';
                    } else {
                        resultDiv.innerHTML = '<p class="text-red-600 font-semibold">' + data.message + '</p>';
                    }
                })
                .catch(err => {
                    resultDiv.innerHTML = '<p class="text-red-600">Error: ' + err + '</p>';
                });
            }

            const html5QrCode = new Html5Qrcode("reader");
            html5QrCode.start(
                { facingMode: "environment" },
                { fps: 10, qrbox: { width: 250, height: 250 } },
                onScanSuccess
            ).catch(err => {
                document.getElementById('result').innerHTML = '<p class="text-red-600">Kamera tidak dapat diakses: ' + err + '</p>';
            });
        </script>
    @endpush
</x-app-layout>
