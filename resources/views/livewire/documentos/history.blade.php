<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Historial de Documentos - {{ $embarcacion->nombre }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-semibold">Historial Completo de Documentos</h3>
                    <div class="flex items-center space-x-4">
                        <select wire:model.live="tipoFiltro" class="px-3 py-2 border border-gray-300 rounded focus:ring-blue-500 focus:border-blue-500">
                            <option value="todos">Todos los tipos</option>
                            <option value="matricula">Matrícula</option>
                            <option value="certificado_navegacion">Certificado de Navegación</option>
                            <option value="poliza_accidentes">Póliza de Accidentes</option>
                            <option value="poliza_pandi">Póliza PANDI</option>
                            <option value="resolucion_dimar">Resolución DIMAR</option>
                        </select>
                        <a href="{{ route('embarcaciones.documentos', $embarcacion) }}" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded transition">
                            Gestionar Documentos
                        </a>
                    </div>
                </div>

                @if($documentos->isEmpty())
                    <div class="text-center py-12">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        <p class="mt-2 text-gray-500">No hay documentos registrados</p>
                    </div>
                @else
                    @foreach($documentos as $tipo => $docs)
                        <div class="mb-8">
                            <h4 class="text-md font-semibold text-gray-700 mb-4 flex items-center">
                                <span class="w-2 h-2 bg-blue-600 rounded-full mr-2"></span>
                                {{ $docs->first()->nombre_tipo }}
                            </h4>
                            <div class="space-y-3">
                                @foreach($docs as $doc)
                                    <div class="border rounded-lg p-4 hover:shadow-md transition {{ $doc->deleted_at ? 'bg-gray-50 border-gray-300' : 'bg-white border-gray-200' }}">
                                        <div class="flex items-start justify-between">
                                            <div class="flex-1">
                                                <div class="flex items-center space-x-3 mb-2">
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $doc->deleted_at ? 'bg-gray-200 text-gray-700' : ($doc->estaVigente() ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800') }}">
                                                        @if($doc->deleted_at)
                                                            Reemplazado
                                                        @else
                                                            {{ $doc->estaVigente() ? 'Vigente' : 'Vencido' }}
                                                        @endif
                                                    </span>
                                                    <span class="text-sm font-medium text-gray-900">{{ $doc->numero_documento }}</span>
                                                </div>
                                                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm">
                                                    <div>
                                                        <span class="text-gray-500">Emisor:</span>
                                                        <span class="text-gray-900 ml-1">{{ $doc->entidad_emisora }}</span>
                                                    </div>
                                                    <div>
                                                        <span class="text-gray-500">Expedición:</span>
                                                        <span class="text-gray-900 ml-1">{{ $doc->fecha_expedicion->format('d/m/Y') }}</span>
                                                    </div>
                                                    @if($doc->fecha_vencimiento)
                                                        <div>
                                                            <span class="text-gray-500">Vencimiento:</span>
                                                            <span class="text-gray-900 ml-1">{{ $doc->fecha_vencimiento->format('d/m/Y') }}</span>
                                                        </div>
                                                    @endif
                                                    <div>
                                                        <span class="text-gray-500">Registrado:</span>
                                                        <span class="text-gray-900 ml-1">{{ $doc->created_at->format('d/m/Y H:i') }}</span>
                                                    </div>
                                                </div>
                                                @if($doc->deleted_at)
                                                    <div class="mt-2 text-sm">
                                                        <span class="text-gray-500">Reemplazado el:</span>
                                                        <span class="text-gray-900 ml-1">{{ $doc->deleted_at->format('d/m/Y H:i') }}</span>
                                                        @if($doc->motivo_reemplazo)
                                                            <span class="text-gray-500 ml-3">Motivo:</span>
                                                            <span class="text-gray-900 ml-1">{{ $doc->motivo_reemplazo }}</span>
                                                        @endif
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="flex items-center space-x-2">
                                                @if($doc->archivo_path)
                                                    <button wire:click="viewDocument({{ $doc->id }})" class="px-3 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded text-sm transition">
                                                        Ver Archivo
                                                    </button>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                @endif

                <div class="mt-6">
                    <a href="{{ route('embarcaciones.show', $embarcacion) }}" class="text-blue-600 hover:text-blue-800">
                        ← Volver a detalles de embarcación
                    </a>
                </div>
            </div>
        </div>
    </div>

    @if($showViewModal && $viewingDocument)
        <div class="fixed inset-0 bg-gray-900 bg-opacity-50 overflow-y-auto h-full w-full z-50 flex items-center justify-center p-4" x-data="{ show: true }">
            <div class="relative w-full max-w-4xl bg-white rounded-lg shadow-xl">
                <div class="bg-white border-b border-gray-200 px-6 py-4 rounded-t-lg">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900">{{ $viewingDocument->nombre_tipo }}</h3>
                            <p class="text-sm text-gray-500 mt-1">{{ $viewingDocument->numero_documento }}</p>
                        </div>
                        <button wire:click="$set('showViewModal', false)" class="text-gray-400 hover:text-gray-600 p-2 rounded hover:bg-gray-100 transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                </div>
                <div class="p-6">
                    @if($viewingDocument->archivo_path)
                        @php
                            $extension = pathinfo($viewingDocument->archivo_path, PATHINFO_EXTENSION);
                        @endphp
                        @if(in_array(strtolower($extension), ['jpg', 'jpeg', 'png']))
                            <img src="{{ Storage::url($viewingDocument->archivo_path) }}" alt="Documento" class="w-full h-auto rounded border border-gray-200">
                        @elseif(strtolower($extension) === 'pdf')
                            <iframe src="{{ Storage::url($viewingDocument->archivo_path) }}" class="w-full h-[600px] rounded border border-gray-200"></iframe>
                        @else
                            <div class="text-center py-12">
                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                <p class="mt-2 text-sm text-gray-500">Vista previa no disponible</p>
                                <a href="{{ Storage::url($viewingDocument->archivo_path) }}" target="_blank" class="mt-4 inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded transition">
                                    Descargar archivo
                                </a>
                            </div>
                        @endif
                    @else
                        <div class="text-center py-12">
                            <p class="text-gray-500">No hay archivo adjunto</p>
                        </div>
                    @endif
                </div>
                <div class="bg-gray-50 px-6 py-4 border-t border-gray-200 rounded-b-lg flex justify-end">
                    <button wire:click="$set('showViewModal', false)" class="px-4 py-2 bg-white border border-gray-300 hover:bg-gray-50 text-gray-700 font-medium rounded transition">
                        Cerrar
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>
