<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Detalles de Embarcación
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <div class="flex justify-between items-start mb-6">
                    <div>
                        <h3 class="text-2xl font-bold text-gray-900">{{ $embarcacion->nombre }}</h3>
                        <p class="text-gray-600">Matrícula: {{ $embarcacion->matricula }}</p>
                    </div>
                    <div class="flex space-x-2">
                        @if(auth()->user()->role !== 'inspector')
                            <a href="{{ route('embarcaciones.edit', $embarcacion) }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
                                Editar
                            </a>
                            <a href="{{ route('embarcaciones.documentos', $embarcacion) }}" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded">
                                Gestionar Documentos
                            </a>
                        @else
                            <a href="{{ route('embarcaciones.documentos.inspector', $embarcacion) }}" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded">
                                Ver Documentos
                            </a>
                        @endif
                        <a href="{{ route('embarcaciones.historial', $embarcacion) }}" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded">
                            Historial
                        </a>
                        <a href="{{ route('embarcaciones.carnet', $embarcacion) }}" class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded" target="_blank">
                            Descargar Carnet
                        </a>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <h4 class="font-semibold text-gray-700 mb-3">Información General</h4>
                        <dl class="space-y-2">
                            <div class="flex justify-between">
                                <dt class="text-gray-600">Empresa:</dt>
                                <dd class="font-medium">{{ $embarcacion->empresa->razon_social }}</dd>
                            </div>
                            <div class="flex justify-between">
                                <dt class="text-gray-600">Tipo:</dt>
                                <dd class="font-medium">{{ ucfirst(str_replace('_', ' ', $embarcacion->tipo)) }}</dd>
                            </div>
                            <div class="flex justify-between">
                                <dt class="text-gray-600">Estado:</dt>
                                <dd>
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full 
                                        @if($embarcacion->estado === 'disponible') bg-green-100 text-green-800
                                        @elseif($embarcacion->estado === 'mantenimiento') bg-yellow-100 text-yellow-800
                                        @else bg-red-100 text-red-800
                                        @endif">
                                        {{ ucfirst(str_replace('_', ' ', $embarcacion->estado)) }}
                                    </span>
                                </dd>
                            </div>
                            <div class="flex justify-between">
                                <dt class="text-gray-600">Capacidad:</dt>
                                <dd class="font-medium">{{ $embarcacion->capacidad_pasajeros ?? 'N/A' }} pasajeros</dd>
                            </div>
                        </dl>
                    </div>

                    <div class="bg-gray-50 p-4 rounded-lg">
                        <h4 class="font-semibold text-gray-700 mb-3">Especificaciones Técnicas</h4>
                        <dl class="space-y-2">
                            <div class="flex justify-between">
                                <dt class="text-gray-600">Eslora:</dt>
                                <dd class="font-medium">{{ $embarcacion->eslora ?? 'N/A' }} m</dd>
                            </div>
                            <div class="flex justify-between">
                                <dt class="text-gray-600">Manga:</dt>
                                <dd class="font-medium">{{ $embarcacion->manga ?? 'N/A' }} m</dd>
                            </div>
                            <div class="flex justify-between">
                                <dt class="text-gray-600">Tonelaje:</dt>
                                <dd class="font-medium">{{ $embarcacion->tonelaje ?? 'N/A' }}</dd>
                            </div>
                            <div class="flex justify-between">
                                <dt class="text-gray-600">Año:</dt>
                                <dd class="font-medium">{{ $embarcacion->ano_construccion ?? 'N/A' }}</dd>
                            </div>
                        </dl>
                    </div>
                </div>

                @if($embarcacion->imagenes->count() > 0)
                    <div class="mb-6">
                        <h4 class="font-semibold text-gray-700 mb-3">Imágenes de la Embarcación</h4>
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                            @foreach($embarcacion->imagenes as $imagen)
                                <div class="relative aspect-video bg-gray-100 rounded-lg overflow-hidden">
                                    <img src="{{ Storage::url($imagen->ruta) }}" class="w-full h-full object-cover">
                                    @if($imagen->es_principal)
                                        <span class="absolute top-2 left-2 bg-blue-600 text-white text-xs px-2 py-1 rounded">Principal</span>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <div class="bg-blue-50 border-l-4 border-blue-500 p-4 mb-6">
                    <h4 class="font-semibold text-blue-900 mb-2">Estado de Documentación</h4>
                    @if($embarcacion->puedeNavegar())
                        <p class="text-green-700 font-medium">✓ Todos los documentos están vigentes. La embarcación puede navegar.</p>
                    @else
                        <p class="text-red-700 font-medium">✗ Documentos faltantes o vencidos:</p>
                        <ul class="list-disc list-inside text-red-600 mt-2">
                            @foreach($embarcacion->getDocumentosFaltantes() as $faltante)
                                <li>{{ $faltante }}</li>
                            @endforeach
                        </ul>
                    @endif
                </div>

                <div class="bg-gray-50 p-4 rounded-lg">
                    <h4 class="font-semibold text-gray-700 mb-4">Documentos Registrados</h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
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
                            <div class="border rounded-lg p-4 {{ $doc && $doc->estaVigente() ? 'bg-white border-green-300' : 'bg-white border-red-300' }}">
                                <h5 class="font-semibold text-gray-900 mb-2">{{ $nombre }}</h5>
                                @if($doc)
                                    <div class="space-y-1 text-sm mb-3">
                                        <p><span class="text-gray-600">Número:</span> <span class="font-medium">{{ $doc->numero_documento }}</span></p>
                                        <p><span class="text-gray-600">Emisión:</span> {{ $doc->fecha_emision?->format('d/m/Y') ?? 'N/A' }}</p>
                                        <p><span class="text-gray-600">Vencimiento:</span> {{ $doc->fecha_vencimiento?->format('d/m/Y') ?? 'N/A' }}</p>
                                        <p><span class="text-gray-600">Entidad:</span> {{ $doc->entidad_emisora ?? 'N/A' }}</p>
                                        @if($doc->observaciones)
                                        <p><span class="text-gray-600">Obs:</span> {{ $doc->observaciones }}</p>
                                        @endif
                                    </div>
                                    <span class="inline-block text-xs px-2 py-1 rounded-full mb-2 {{ $doc->estado === 'vigente' ? 'bg-green-100 text-green-800' : ($doc->estado === 'por_vencer' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                        {{ ucfirst(str_replace('_', ' ', $doc->estado)) }}
                                    </span>
                                    <div class="space-y-2">
                                        @if($doc->archivo_path)
                                            <a href="{{ Storage::url($doc->archivo_path) }}" target="_blank" class="block text-center bg-blue-600 hover:bg-blue-700 text-white px-3 py-2 rounded text-xs font-semibold">
                                                Ver Documento
                                            </a>
                                        @endif
                                        @if(auth()->user()->role === 'inspector')
                                            <button wire:click="solicitarActualizacion({{ $doc->id }})" class="w-full text-center bg-orange-600 hover:bg-orange-700 text-white px-3 py-2 rounded text-xs font-semibold">
                                                Solicitar Actualización
                                            </button>
                                        @endif
                                    </div>
                                @else
                                    <p class="text-sm text-red-600 mb-2">No registrado</p>
                                    @if(auth()->user()->role === 'inspector')
                                        <button wire:click="solicitarActualizacion(null, '{{ $tipo }}')" class="w-full text-center bg-orange-600 hover:bg-orange-700 text-white px-3 py-2 rounded text-xs font-semibold">
                                            Solicitar Registro
                                        </button>
                                    @endif
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="mt-6 flex justify-between">
                    <a href="{{ route('embarcaciones.index') }}" class="text-blue-600 hover:text-blue-800">
                        ← Volver a la lista
                    </a>
                    @if(auth()->user()->role === 'admin' || auth()->user()->role === 'empresa')
                        <button wire:click="delete" wire:confirm="¿Está seguro de eliminar esta embarcación?" class="text-red-600 hover:text-red-800">
                            Eliminar embarcación
                        </button>
                    @endif
                </div>
            </div>
        </div>
    </div>

    @if($mostrarModal)
        <div class="fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center z-50">
            <div class="bg-white rounded-lg p-6 max-w-md w-full mx-4">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Solicitar Actualización de Documento</h3>
                
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Motivo de la solicitud *</label>
                    <textarea wire:model="motivo" rows="4" class="w-full border border-gray-300 rounded-lg px-4 py-2" placeholder="Describe la irregularidad o motivo de actualización..."></textarea>
                    @error('motivo') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div class="flex justify-end space-x-3">
                    <button wire:click="$set('mostrarModal', false)" class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded font-semibold">
                        Cancelar
                    </button>
                    <button wire:click="enviarSolicitud" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded font-semibold">
                        Enviar Solicitud
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>
