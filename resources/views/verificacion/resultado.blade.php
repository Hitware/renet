<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultado Verificación - RENET</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-blue-50 to-gray-100 min-h-screen">
    <div class="py-8 px-4">
        <div class="max-w-5xl mx-auto">
            <!-- Header -->
            <div class="text-center mb-8">
                <h1 class="text-3xl font-bold text-gray-900 mb-2">Sistema de Verificación Marítima</h1>
                <p class="text-gray-600">RENET - Registro Nacional de Embarcaciones</p>
            </div>

            <!-- Estado Principal -->
            <div class="bg-white rounded-2xl shadow-2xl overflow-hidden mb-6">
                <!-- Foto Principal -->
                @if($embarcacion->imagenPrincipal)
                    <div class="w-full h-96 overflow-hidden bg-gradient-to-br from-blue-100 to-blue-50">
                        <img src="{{ Storage::url($embarcacion->imagenPrincipal->ruta) }}" class="w-full h-full object-cover object-center">
                    </div>
                @endif

                <!-- Badge de Estado -->
                <div class="p-6 {{ $puedeNavegar ? 'bg-gradient-to-r from-green-500 to-green-600' : 'bg-gradient-to-r from-red-500 to-red-600' }}">
                    <div class="flex items-center justify-center gap-4">
                        <div class="bg-white/20 p-3 rounded-full">
                            <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                @if($puedeNavegar)
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                @else
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                @endif
                            </svg>
                        </div>
                        <div class="text-left">
                            <h2 class="text-3xl font-bold text-white">
                                {{ $puedeNavegar ? 'AUTORIZADO PARA NAVEGAR' : 'NO AUTORIZADO PARA NAVEGAR' }}
                            </h2>
                            <p class="text-white/90 text-sm mt-1">
                                {{ $puedeNavegar ? 'Documentación completa y vigente' : 'Documentación incompleta o vencida' }}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Información de la Embarcación -->
                <div class="p-8">
                    <div class="border-b border-gray-200 pb-6 mb-6">
                        <h3 class="text-2xl font-bold text-gray-900 mb-4">{{ strtoupper($embarcacion->nombre) }}</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="flex items-center gap-3 p-3 bg-gray-50 rounded-lg">
                                <div class="bg-blue-100 p-2 rounded-lg">
                                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500 font-medium">Matrícula</p>
                                    <p class="text-sm font-bold text-gray-900">{{ $embarcacion->matricula }}</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-3 p-3 bg-gray-50 rounded-lg">
                                <div class="bg-blue-100 p-2 rounded-lg">
                                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500 font-medium">Empresa</p>
                                    <p class="text-sm font-bold text-gray-900">{{ $embarcacion->empresa->razon_social }}</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-3 p-3 bg-gray-50 rounded-lg">
                                <div class="bg-blue-100 p-2 rounded-lg">
                                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500 font-medium">Tipo</p>
                                    <p class="text-sm font-bold text-gray-900">{{ ucfirst(str_replace('_', ' ', $embarcacion->tipo)) }}</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-3 p-3 bg-gray-50 rounded-lg">
                                <div class="bg-blue-100 p-2 rounded-lg">
                                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500 font-medium">Capacidad</p>
                                    <p class="text-sm font-bold text-gray-900">{{ $embarcacion->capacidad_pasajeros }} pasajeros</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    @if(!$puedeNavegar && $motivos)
                        <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded-lg mb-6">
                            <div class="flex items-start gap-3">
                                <svg class="w-6 h-6 text-red-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                                </svg>
                                <div>
                                    <h3 class="font-bold text-red-900 mb-2">Razones por las que NO está autorizado:</h3>
                                    <ul class="list-disc list-inside text-red-700 space-y-1 text-sm">
                                        @foreach($motivos as $motivo)
                                            <li>{{ $motivo }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Documentos -->
                    <div class="mt-6">
                        <div class="flex items-center gap-2 mb-4">
                            <svg class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            <h3 class="text-lg font-bold text-gray-900">Estado de Documentación</h3>
                        </div>
                        <div class="space-y-2">
                            @php
                                $tiposDocumentos = [
                                    'matricula' => 'Matrícula',
                                    'certificado_navegacion' => 'Certificado de Navegación',
                                    'poliza_accidentes' => 'Póliza de Accidentes',
                                    'poliza_pandi' => 'Póliza PANDI',
                                    'resolucion_dimar' => 'Resolución DIMAR'
                                ];
                                $polizaPandi = $embarcacion->documentos->where('tipo_documento', 'poliza_pandi')->first();
                                $tienePandiVigente = $polizaPandi && $polizaPandi->estaVigente();
                            @endphp
                            @foreach($tiposDocumentos as $tipo => $nombre)
                                @php
                                    $doc = $embarcacion->documentos->where('tipo_documento', $tipo)->first();
                                    if ($tipo === 'poliza_accidentes' && $tienePandiVigente) {
                                        continue;
                                    }
                                    $vigente = $doc && $doc->estaVigente();
                                    $tieneArchivo = $doc && $doc->archivo_path;
                                @endphp
                                @if($vigente && $tieneArchivo)
                                    <a href="{{ Storage::url($doc->archivo_path) }}" target="_blank" class="flex items-center justify-between p-4 rounded-xl border-2 bg-gradient-to-r from-green-50 to-green-100 border-green-300 hover:border-green-400 hover:shadow-md transition-all cursor-pointer group">
                                        <div class="flex items-center gap-3 flex-1">
                                            <div class="bg-green-500 p-2 rounded-lg">
                                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                </svg>
                                            </div>
                                            <div>
                                                <span class="text-sm font-bold text-gray-900">{{ $nombre }}</span>
                                                @if($tipo === 'poliza_pandi')
                                                    <p class="text-xs text-gray-600 mt-0.5">Incluye accidentes personales</p>
                                                @endif
                                                <p class="text-xs text-blue-600 mt-1 font-medium group-hover:underline flex items-center gap-1">
                                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                                    </svg>
                                                    Clic para ver documento
                                                </p>
                                            </div>
                                        </div>
                                        <div class="flex items-center gap-2">
                                            <span class="text-xs px-3 py-1.5 rounded-full bg-green-500 text-white font-bold">
                                                VIGENTE
                                            </span>
                                            <svg class="w-5 h-5 text-blue-600 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                            </svg>
                                        </div>
                                    </a>
                                @else
                                    <div class="flex items-center justify-between p-4 rounded-xl border-2 bg-gradient-to-r from-red-50 to-red-100 border-red-300">
                                        <div class="flex items-center gap-3 flex-1">
                                            <div class="bg-red-500 p-2 rounded-lg">
                                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                </svg>
                                            </div>
                                            <div>
                                                <span class="text-sm font-bold text-gray-900">{{ $nombre }}</span>
                                                @if($tipo === 'poliza_pandi')
                                                    <p class="text-xs text-gray-600 mt-0.5">Incluye accidentes personales</p>
                                                @endif
                                            </div>
                                        </div>
                                        <span class="text-xs px-3 py-1.5 rounded-full bg-red-500 text-white font-bold">
                                            NO VIGENTE
                                        </span>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <!-- Formulario de Reporte -->
            <div class="bg-white rounded-2xl shadow-2xl overflow-hidden">
                <div class="bg-gradient-to-r from-gray-800 to-gray-900 p-6">
                    <div class="flex items-center gap-3">
                        <div class="bg-red-500 p-3 rounded-lg">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-2xl font-bold text-white">Reportar un Problema</h2>
                            <p class="text-gray-300 text-sm mt-1">Si observaste algún problema con esta embarcación, puedes reportarlo de forma anónima</p>
                        </div>
                    </div>
                </div>
                <form action="{{ route('reportes.store') }}" method="POST" enctype="multipart/form-data" class="p-6">
                    @csrf
                    <input type="hidden" name="embarcacion_id" value="{{ $embarcacion->id }}">
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Nombre *</label>
                            <input type="text" name="nombre_reportante" required class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-red-500 focus:border-red-500 transition">
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Email</label>
                            <input type="email" name="email_reportante" class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-red-500 focus:border-red-500 transition">
                        </div>
                    </div>
                    
                    <div class="mb-4">
                        <label class="block text-sm font-bold text-gray-700 mb-2">Teléfono</label>
                        <input type="text" name="telefono_reportante" class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-red-500 focus:border-red-500 transition">
                    </div>
                    
                    <div class="mb-4">
                        <label class="block text-sm font-bold text-gray-700 mb-2">Descripción del Problema *</label>
                        <textarea name="descripcion" required rows="4" class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-red-500 focus:border-red-500 transition"></textarea>
                    </div>
                    
                    <div class="mb-6">
                        <label class="block text-sm font-bold text-gray-700 mb-2">Imagen (opcional)</label>
                        <input type="file" name="imagen" accept="image/*" class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-red-500 focus:border-red-500 transition file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-red-50 file:text-red-700 file:font-medium hover:file:bg-red-100">
                    </div>
                    
                    <button type="submit" class="w-full bg-gradient-to-r from-red-500 to-red-600 hover:from-red-600 hover:to-red-700 text-white px-6 py-4 rounded-xl font-bold text-lg shadow-lg hover:shadow-xl transition-all transform hover:scale-[1.02]">
                        Enviar Reporte
                    </button>
                </form>
            </div>

            <div class="text-center mt-8">
                <a href="{{ route('verificar') }}" class="inline-flex items-center gap-2 bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white px-8 py-4 rounded-xl font-bold shadow-lg hover:shadow-xl transition-all transform hover:scale-[1.02]">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                    Verificar Otra Embarcación
                </a>
            </div>
        </div>
    </div>
</body>
</html>
