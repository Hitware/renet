<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verificar Piloto - RENET</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/html5-qrcode@2.3.8/html5-qrcode.min.js"></script>
</head>
<body class="bg-gradient-to-br from-purple-50 to-blue-50">
    <div class="min-h-screen flex items-center justify-center p-4">
        <div class="max-w-md w-full bg-white rounded-lg shadow-xl p-8">
            <div class="text-center mb-8">
                <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-purple-100 mb-4">
                    <svg class="w-10 h-10 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"></path>
                    </svg>
                </div>
                <h1 class="text-3xl font-bold text-gray-900 mb-2">RENET</h1>
                <p class="text-gray-600">Verificación de Credenciales de Piloto</p>
            </div>

            <div class="mb-6">
                <button id="btnEscanear" onclick="iniciarEscaneo()" class="w-full bg-purple-600 hover:bg-purple-700 text-white font-medium py-3 rounded-lg transition flex items-center justify-center space-x-2">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"></path>
                    </svg>
                    <span>Escanear Credencial QR</span>
                </button>
                <div id="reader" class="mt-4 hidden rounded-lg overflow-hidden"></div>
                <button id="btnDetener" onclick="detenerEscaneo()" class="w-full mt-2 bg-red-600 hover:bg-red-700 text-white font-medium py-2 rounded-lg transition hidden">
                    Detener Escaneo
                </button>
            </div>

            <div class="relative">
                <div class="absolute inset-0 flex items-center">
                    <div class="w-full border-t border-gray-300"></div>
                </div>
                <div class="relative flex justify-center text-sm">
                    <span class="px-2 bg-white text-gray-500">O ingrese manualmente</span>
                </div>
            </div>

            <form action="{{ route('verificar.piloto') }}" method="GET" class="space-y-6 mt-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Número de Documento del Piloto</label>
                    <input type="text" name="documento" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500" placeholder="Ej: 1234567890" required>
                    <p class="text-xs text-gray-500 mt-1">Ingrese el número de cédula o documento del piloto</p>
                </div>
                <button type="submit" class="w-full bg-purple-600 hover:bg-purple-700 text-white font-medium py-3 rounded-lg transition">
                    Verificar Piloto
                </button>
            </form>

            <div class="mt-6 text-center">
                <a href="{{ route('verificar') }}" class="text-sm text-purple-600 hover:text-purple-700">
                    ← Verificar Embarcación
                </a>
            </div>
        </div>
    </div>

    <script>
        let html5QrCode;

        function iniciarEscaneo() {
            document.getElementById('reader').classList.remove('hidden');
            document.getElementById('btnEscanear').classList.add('hidden');
            document.getElementById('btnDetener').classList.remove('hidden');

            html5QrCode = new Html5Qrcode("reader");
            html5QrCode.start(
                { facingMode: "environment" },
                { fps: 10, qrbox: { width: 250, height: 250 } },
                (decodedText) => {
                    detenerEscaneo();
                    if (decodedText.includes('verificar-piloto/')) {
                        window.location.href = decodedText;
                    } else {
                        // Si es un código QR de piloto
                        window.location.href = '{{ route("verificar.piloto") }}?codigo=' + decodedText;
                    }
                }
            ).catch(err => {
                alert('Error al acceder a la cámara: ' + err);
                detenerEscaneo();
            });
        }

        function detenerEscaneo() {
            if (html5QrCode) {
                html5QrCode.stop().then(() => {
                    document.getElementById('reader').classList.add('hidden');
                    document.getElementById('btnEscanear').classList.remove('hidden');
                    document.getElementById('btnDetener').classList.add('hidden');
                }).catch(err => console.log(err));
            }
        }
    </script>
</body>
</html>
