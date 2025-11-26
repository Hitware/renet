<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Documentos de {{ $embarcacion->nombre }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                @if (session()->has('message'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                        {{ session('message') }}
                    </div>
                @endif

                <div class="mb-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Información de la Embarcación</h3>
                    <p class="text-gray-600">Matrícula: {{ $embarcacion->matricula }}</p>
                    <p class="text-gray-600">Empresa: {{ $embarcacion->empresa->razon_social }}</p>
                </div>

                <div class="space-y-4">
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
                        <div class="border rounded-lg p-4 {{ $doc && $doc->estaVigente() ? 'bg-green-50 border-green-200' : 'bg-red-50 border-red-200' }}">
                            <div class="flex justify-between items-start">
                                <div class="flex-1">
                                    <h4 class="font-semibold text-gray-900">{{ $nombre }}</h4>
                                    @if($doc)
                                        <p class="text-sm text-gray-600 mt-1">Número: {{ $doc->numero_documento }}</p>
                                        <p class="text-sm text-gray-600">Emisión: {{ $doc->fecha_emision->format('d/m/Y') }}</p>
                                        <p class="text-sm text-gray-600">Vencimiento: {{ $doc->fecha_vencimiento?->format('d/m/Y') ?? 'N/A' }}</p>
                                        <span class="inline-block mt-2 text-xs px-2 py-1 rounded-full {{ $doc->estado === 'vigente' ? 'bg-green-100 text-green-800' : ($doc->estado === 'por_vencer' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                            {{ ucfirst(str_replace('_', ' ', $doc->estado)) }}
                                        </span>
                                        @if($doc->archivo)
                                            <a href="{{ Storage::url($doc->archivo) }}" target="_blank" class="block mt-2 text-sm text-blue-600 hover:text-blue-800">
                                                Ver documento
                                            </a>
                                        @endif
                                    @else
                                        <p class="text-sm text-red-600 mt-1">No registrado</p>
                                    @endif
                                </div>
                                @if($doc)
                                    <button wire:click="solicitarActualizacion({{ $doc->id }})" class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded text-sm font-semibold">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                        Solicitar Actualización
                                    </button>
                                @else
                                    <button wire:click="solicitarActualizacion(null)" class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded text-sm font-semibold">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        Solicitar Registro
                                    </button>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-6">
                    <a href="{{ route('embarcaciones.show', $embarcacion) }}" class="text-blue-600 hover:text-blue-800">
                        ← Volver a detalles
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    @if($mostrarModal)
        <div class="fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center z-50">
            <div class="bg-white rounded-lg p-6 max-w-md w-full mx-4">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Solicitar Actualización de Documento</h3>
                
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Motivo de la solicitud *</label>
                    <textarea wire:model="motivo" rows="4" class="w-full border-gray-300 rounded-lg" placeholder="Describe la irregularidad o motivo de actualización..."></textarea>
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
