<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultado Verificación - RENET</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="min-h-screen py-12 px-4">
        <div class="max-w-4xl mx-auto">
            <!-- Estado Principal -->
            <div class="bg-white rounded-lg shadow-xl overflow-hidden mb-6">
                <div class="p-8 text-center {{ $puedeNavegar ? 'bg-green-600' : 'bg-red-600' }}">
                    <svg class="w-24 h-24 mx-auto text-white mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        @if($puedeNavegar)
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        @else
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        @endif
                    </svg>
                    <h1 class="text-4xl font-bold text-white mb-2">
                        {{ $puedeNavegar ? 'EMBARCACIÓN DISPONIBLE' : 'EMBARCACIÓN NO DISPONIBLE' }}
                    </h1>
                    <p class="text-white text-lg">
                        {{ $puedeNavegar ? 'Todos los documentos están vigentes' : 'Documentación incompleta o vencida' }}
                    </p>
                </div>

                <!-- Información de la Embarcación -->
                <div class="p-8">
                    <div class="flex items-start space-x-6 mb-6">
                        @if($embarcacion->imagenPrincipal)
                            <img src="{{ Storage::url($embarcacion->imagenPrincipal->ruta) }}" class="w-48 h-32 object-cover rounded-lg border-2 border-gray-200">
                        @endif
                        <div class="flex-1">
                            <h2 class="text-2xl font-bold text-gray-900 mb-2">{{ $embarcacion->nombre }}</h2>
                            <div class="grid grid-cols-2 gap-4 text-sm">
                                <div>
                                    <span class="text-gray-600">Matrícula:</span>
                                    <span class="font-semibold text-gray-900 ml-2">{{ $embarcacion->matricula }}</span>
                                </div>
                                <div>
                                    <span class="text-gray-600">Empresa:</span>
                                    <span class="font-semibold text-gray-900 ml-2">{{ $embarcacion->empresa->razon_social }}</span>
                                </div>
                                <div>
                                    <span class="text-gray-600">Tipo:</span>
                                    <span class="font-semibold text-gray-900 ml-2">{{ ucfirst(str_replace('_', ' ', $embarcacion->tipo)) }}</span>
                                </div>
                                <div>
                                    <span class="text-gray-600">Capacidad:</span>
                                    <span class="font-semibold text-gray-900 ml-2">{{ $embarcacion->capacidad_pasajeros }} pasajeros</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    @if(!$puedeNavegar && $motivos)
                        <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded">
                            <h3 class="font-semibold text-red-900 mb-2">Motivos de No Disponibilidad:</h3>
                            <ul class="list-disc list-inside text-red-700 space-y-1">
                                @foreach($motivos as $motivo)
                                    <li>{{ $motivo }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <!-- Documentos -->
                    <div class="mt-6">
                        <h3 class="font-semibold text-gray-900 mb-4">Estado de Documentación:</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                            @php
                                $tiposDocumentos = [
                                    'matricula' => 'Matrícula',
                                    'certificado_navegacion' => 'Certificado de Navegación',
                                    'poliza_accidentes' => 'Póliza de Accidentes',
                                    'poliza_pandi' => 'Póliza PANDI',
                                    'resolucion_dimar' => 'Resolución DIMAR'
                                ];
                            @endphp
                            @foreach($tiposDocumentos as $tipo => $nombre)
                                @php
                                    $doc = $embarcacion->documentos->where('tipo_documento', $tipo)->first();
                                @endphp
                                <div class="flex items-center justify-between p-3 rounded border {{ $doc && $doc->estaVigente() ? 'bg-green-50 border-green-200' : 'bg-red-50 border-red-200' }}">
                                    <span class="text-sm font-medium text-gray-900">{{ $nombre }}</span>
                                    <span class="text-xs px-2 py-1 rounded-full {{ $doc && $doc->estaVigente() ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ $doc && $doc->estaVigente() ? 'Vigente' : 'No Vigente' }}
                                    </span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <!-- Formulario de Reporte -->
            <div class="bg-white rounded-lg shadow-xl overflow-hidden">
                <div class="bg-gray-800 p-6">
                    <h2 class="text-2xl font-bold text-white">Reportar un Problema</h2>
                    <p class="text-gray-300 mt-2">Si observaste algún problema con esta embarcación, puedes reportarlo de forma anónima</p>
                </div>
                <form action="{{ route('reportes.store') }}" method="POST" enctype="multipart/form-data" class="p-6">
                    @csrf
                    <input type="hidden" name="embarcacion_id" value="{{ $embarcacion->id }}">
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Nombre *</label>
                            <input type="text" name="nombre_reportante" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                            <input type="email" name="email_reportante" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500">
                        </div>
                    </div>
                    
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Teléfono</label>
                        <input type="text" name="telefono_reportante" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500">
                    </div>
                    
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Descripción del Problema *</label>
                        <textarea name="descripcion" required rows="4" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500"></textarea>
                    </div>
                    
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Imagen (opcional)</label>
                        <input type="file" name="imagen" accept="image/*" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 file:mr-4 file:py-2 file:px-4 file:rounded file:border-0 file:bg-red-50 file:text-red-700 hover:file:bg-red-100">
                    </div>
                    
                    <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white px-6 py-3 rounded-lg font-medium transition">
                        Enviar Reporte
                    </button>
                </form>
            </div>

            <div class="text-center mt-6">
                <a href="{{ route('verificar') }}" class="inline-block bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-medium transition">
                    Verificar Otra Embarcación
                </a>
            </div>
        </div>
    </div>
</body>
</html>
