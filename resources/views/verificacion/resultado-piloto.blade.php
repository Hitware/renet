<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultado Verificación Piloto - RENET</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-purple-50 to-blue-50">
    <div class="min-h-screen py-12 px-4">
        <div class="max-w-4xl mx-auto">
            <!-- Estado Principal -->
            <div class="bg-white rounded-lg shadow-xl overflow-hidden mb-6">
                <div class="p-8 text-center {{ ($piloto->estaActivo() && $licenciaVigente) ? 'bg-green-600' : 'bg-red-600' }}">
                    <svg class="w-24 h-24 mx-auto text-white mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        @if($piloto->estaActivo() && $licenciaVigente)
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        @else
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        @endif
                    </svg>
                    <h1 class="text-4xl font-bold text-white mb-2">
                        {{ ($piloto->estaActivo() && $licenciaVigente) ? 'PILOTO CERTIFICADO' : 'PILOTO NO CERTIFICADO' }}
                    </h1>
                    <p class="text-white text-lg">
                        {{ ($piloto->estaActivo() && $licenciaVigente) ? 'Credenciales vigentes y verificadas' : 'Licencia vencida o piloto inactivo' }}
                    </p>
                </div>

                <!-- Información del Piloto -->
                <div class="p-8">
                    <div class="flex flex-col md:flex-row gap-6 mb-6">
                        <!-- Foto del Piloto -->
                        <div class="flex-shrink-0">
                            <div class="w-32 h-40 rounded-lg overflow-hidden border-2 {{ $piloto->estaActivo() ? 'border-green-500' : 'border-red-500' }} shadow-lg">
                                @if($piloto->foto_perfil)
                                    <img src="{{ Storage::url($piloto->foto_perfil) }}" class="w-full h-full object-cover" alt="Foto del piloto">
                                @else
                                    <div class="w-full h-full bg-gray-200 flex items-center justify-center">
                                        <svg class="w-16 h-16 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                                        </svg>
                                    </div>
                                @endif
                            </div>
                            <div class="mt-2 text-center">
                                <span class="inline-block px-3 py-1 text-sm font-semibold rounded-full {{ $piloto->estaActivo() ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ strtoupper($piloto->estado) }}
                                </span>
                            </div>
                        </div>

                        <!-- Datos del Piloto -->
                        <div class="flex-1">
                            <h2 class="text-3xl font-bold text-gray-900 mb-1">{{ strtoupper($piloto->nombre_completo) }}</h2>
                            <p class="text-lg text-purple-600 font-semibold mb-4">{{ $piloto->licencia_tipo }}</p>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="bg-gray-50 p-3 rounded-lg">
                                    <span class="text-xs text-gray-600 block mb-1">Documento</span>
                                    <span class="font-semibold text-gray-900">{{ $piloto->tipo_documento }} {{ $piloto->numero_documento }}</span>
                                </div>
                                <div class="bg-gray-50 p-3 rounded-lg">
                                    <span class="text-xs text-gray-600 block mb-1">Licencia No.</span>
                                    <span class="font-semibold text-gray-900">{{ $piloto->licencia_numero }}</span>
                                </div>
                                <div class="bg-gray-50 p-3 rounded-lg">
                                    <span class="text-xs text-gray-600 block mb-1">Experiencia</span>
                                    <span class="font-semibold text-gray-900">{{ $piloto->anos_experiencia }} años</span>
                                </div>
                                <div class="bg-gray-50 p-3 rounded-lg">
                                    <span class="text-xs text-gray-600 block mb-1">Empresa</span>
                                    <span class="font-semibold text-gray-900">{{ $piloto->empresa->razon_social ?? 'No registrada' }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Estado de Licencia -->
                    <div class="mb-6">
                        <h3 class="font-semibold text-gray-900 mb-3 flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            Estado de Licencia:
                        </h3>
                        <div class="flex items-center justify-between p-4 rounded-lg border-2 {{ $licenciaVigente ? 'bg-green-50 border-green-300' : 'bg-red-50 border-red-300' }}">
                            <div>
                                <span class="text-sm font-medium text-gray-900">Licencia de {{ $piloto->licencia_tipo }}</span>
                                <p class="text-xs text-gray-600 mt-1">Expedición: {{ $piloto->licencia_fecha_expedicion->format('d/m/Y') }}</p>
                                <p class="text-xs text-gray-600">Vencimiento: {{ $piloto->licencia_fecha_vencimiento->format('d/m/Y') }}</p>
                            </div>
                            <div class="text-right">
                                @if($licenciaVigente)
                                    <span class="inline-flex items-center px-3 py-1 text-sm font-semibold text-green-800 bg-green-200 rounded-full">
                                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                        </svg>
                                        VIGENTE
                                    </span>
                                    <p class="text-xs text-green-700 mt-1">Válida por {{ $piloto->licencia_fecha_vencimiento->diffInDays(now()) }} días más</p>
                                @else
                                    <span class="inline-flex items-center px-3 py-1 text-sm font-semibold text-red-800 bg-red-200 rounded-full">
                                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                                        </svg>
                                        VENCIDA
                                    </span>
                                    <p class="text-xs text-red-700 mt-1">Vencida hace {{ now()->diffInDays($piloto->licencia_fecha_vencimiento) }} días</p>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Certificaciones Vigentes -->
                    <div class="mb-6">
                        <h3 class="font-semibold text-gray-900 mb-3 flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path>
                            </svg>
                            Certificaciones Vigentes:
                        </h3>
                        @if($certificacionesVigentes->count() > 0)
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                @foreach($certificacionesVigentes as $cert)
                                    <div class="flex items-center justify-between p-3 rounded border bg-green-50 border-green-200">
                                        <div>
                                            <span class="text-sm font-medium text-gray-900 block">{{ $cert->tipo_certificacion }}</span>
                                            <span class="text-xs text-gray-600">{{ $cert->institucion_emisora }}</span>
                                            <p class="text-xs text-green-700 mt-1">Vence: {{ $cert->fecha_vencimiento->format('d/m/Y') }}</p>
                                        </div>
                                        <svg class="w-6 h-6 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                        </svg>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-8 bg-gray-50 rounded-lg border border-gray-200">
                                <svg class="w-12 h-12 text-gray-400 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                <p class="text-gray-600">No hay certificaciones adicionales vigentes registradas</p>
                            </div>
                        @endif
                    </div>

                    <!-- Historial de Navegación (últimos 3) -->
                    <div>
                        <h3 class="font-semibold text-gray-900 mb-3 flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Experiencia Reciente:
                        </h3>
                        @if($piloto->historialNavegacion->count() > 0)
                            <div class="space-y-2">
                                @foreach($piloto->historialNavegacion->take(3) as $historial)
                                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg border border-gray-200">
                                        <div class="flex-1">
                                            <span class="text-sm font-medium text-gray-900 block">{{ $historial->embarcacion->nombre ?? 'Embarcación no registrada' }}</span>
                                            <span class="text-xs text-gray-600">Cargo: {{ $historial->cargo }}</span>
                                        </div>
                                        <div class="text-right text-xs text-gray-600">
                                            <p>{{ $historial->fecha_inicio->format('d/m/Y') }} - {{ $historial->fecha_fin ? $historial->fecha_fin->format('d/m/Y') : 'Activo' }}</p>
                                            @if(!$historial->fecha_fin)
                                                <span class="inline-block mt-1 px-2 py-0.5 text-xs font-semibold text-green-800 bg-green-200 rounded-full">ACTIVO</span>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-8 bg-gray-50 rounded-lg border border-gray-200">
                                <svg class="w-12 h-12 text-gray-400 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <p class="text-gray-600">No hay historial de navegación registrado</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Footer con información de verificación -->
                <div class="bg-gray-50 px-8 py-4 border-t border-gray-200">
                    <div class="flex flex-col md:flex-row justify-between items-center text-sm text-gray-600">
                        <div>
                            <strong>Código de Verificación:</strong> {{ strtoupper(substr($piloto->codigo_qr, 0, 12)) }}
                        </div>
                        <div>
                            <strong>Consultado:</strong> {{ now()->format('d/m/Y H:i:s') }}
                        </div>
                    </div>
                </div>
            </div>

            <!-- Botones de acción -->
            <div class="text-center space-x-4">
                <a href="{{ route('verificar.piloto') }}" class="inline-block bg-purple-600 hover:bg-purple-700 text-white font-medium px-6 py-3 rounded-lg transition">
                    Verificar Otro Piloto
                </a>
                <a href="{{ route('verificar') }}" class="inline-block bg-gray-200 hover:bg-gray-300 text-gray-800 font-medium px-6 py-3 rounded-lg transition">
                    Verificar Embarcación
                </a>
            </div>
        </div>
    </div>
</body>
</html>
