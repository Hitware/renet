<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Piloto No Encontrado - RENET</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-purple-50 to-blue-50">
    <div class="min-h-screen flex items-center justify-center p-4">
        <div class="max-w-md w-full bg-white rounded-lg shadow-xl p-8 text-center">
            <svg class="w-24 h-24 mx-auto text-red-500 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
            </svg>
            <h1 class="text-2xl font-bold text-gray-900 mb-2">Piloto No Encontrado</h1>
            <p class="text-gray-600 mb-6">
                No se encontró ningún piloto con los datos proporcionados en el sistema RENET.
            </p>
            <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 mb-6 text-left">
                <p class="text-sm text-yellow-700">
                    <strong>Posibles razones:</strong>
                </p>
                <ul class="list-disc list-inside text-sm text-yellow-700 mt-2 space-y-1">
                    <li>El número de documento es incorrecto</li>
                    <li>El piloto no está registrado en el sistema</li>
                    <li>El código QR escaneado no es válido</li>
                </ul>
            </div>
            <div class="space-y-3">
                <a href="{{ route('verificar.piloto') }}" class="block w-full bg-purple-600 hover:bg-purple-700 text-white font-medium py-3 rounded-lg transition">
                    Intentar de Nuevo
                </a>
                <a href="{{ route('verificar') }}" class="block w-full bg-gray-200 hover:bg-gray-300 text-gray-800 font-medium py-3 rounded-lg transition">
                    Verificar Embarcación
                </a>
            </div>
        </div>
    </div>
</body>
</html>
