<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verificar Embarcación - RENET</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/html5-qrcode@2.3.8/html5-qrcode.min.js"></script>
</head>
<body class="bg-gray-100">
    <div class="min-h-screen flex items-center justify-center p-4">
        <div class="max-w-md w-full bg-white rounded-lg shadow-xl p-8">
            <div class="text-center mb-8">
                <h1 class="text-3xl font-bold text-gray-900 mb-2">RENET</h1>
                <p class="text-gray-600">Verificación de Embarcaciones</p>
            </div>

            <div class="mb-6">
                <button id="btnEscanear" onclick="iniciarEscaneo()" class="w-full bg-green-600 hover:bg-green-700 text-white font-medium py-3 rounded-lg transition flex items-center justify-center space-x-2">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"></path>
                    </svg>
                    <span>Escanear Código QR</span>
                </button>
                <div id="reader" class="mt-4 hidden"></div>
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

            <form action="{{ route('verificar') }}" method="GET" class="space-y-6 mt-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Matrícula de la Embarcación</label>
                    <input type="text" id="inputCodigo" name="matricula" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 uppercase" placeholder="CP-12-3456 o CP-12-3456-X" pattern="^CP-\d{2}-\d{4}(-[A-Z])?$" title="Formato: CP-##-#### o CP-##-####-X" maxlength="13" oninput="
                        let input = this.value.toUpperCase();
                        let clean = input.replace(/[^0-9A-Z]/g, '');
                        
                        if (!clean.startsWith('CP')) {
                            clean = 'CP' + clean.replace(/^CP/, '');
                        }
                        
                        let formatted = 'CP';
                        let rest = clean.substring(2);
                        
                        if (rest.length > 0) {
                            formatted += '-' + rest.substring(0, 2);
                        }
                        if (rest.length > 2) {
                            formatted += '-' + rest.substring(2, 6);
                        }
                        if (rest.length > 6) {
                            formatted += '-' + rest.substring(6, 7);
                        }
                        
                        this.value = formatted;
                    ">
                    <p class="text-xs text-gray-500 mt-1">Formato: CP-##-#### o CP-##-####-X</p>
                </div>
                <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-3 rounded-lg transition">
                    Verificar Embarcación
                </button>
            </form>
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
                    if (decodedText.includes('verificar/')) {
                        window.location.href = decodedText;
                    } else {
                        document.getElementById('inputCodigo').value = decodedText;
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
