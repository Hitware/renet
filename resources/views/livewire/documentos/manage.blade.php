<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Gestión de Documentos - {{ $embarcacion->nombre }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session()->has('message'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                    {{ session('message') }}
                </div>
            @endif

            @if (session()->has('error'))
                <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                    {{ session('error') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                @php
                    $solicitudesPendientes = $embarcacion->documentos->flatMap->solicitudesActualizacion->where('estado', 'pendiente');
                @endphp
                @if($solicitudesPendientes->count() > 0)
                    <div class="mb-6 bg-orange-50 border-l-4 border-orange-500 p-4 rounded">
                        <h3 class="text-lg font-semibold text-orange-900 mb-3">Solicitudes de Actualización Pendientes</h3>
                        <div class="space-y-3">
                            @foreach($solicitudesPendientes as $solicitud)
                                <div class="bg-white border border-orange-200 rounded p-3">
                                    <div class="flex justify-between items-start">
                                        <div class="flex-1">
                                            <p class="font-semibold text-gray-900">{{ $solicitud->documento->nombre_tipo }}</p>
                                            <p class="text-sm text-gray-600 mt-1">{{ $solicitud->motivo }}</p>
                                            <p class="text-xs text-gray-500 mt-1">Solicitado por: {{ $solicitud->inspector->name }} - {{ $solicitud->created_at->format('d/m/Y H:i') }}</p>
                                        </div>
                                        <button wire:click="marcarSolicitudAtendida({{ $solicitud->id }})" class="ml-4 bg-green-600 hover:bg-green-700 text-white px-3 py-1 rounded text-xs">
                                            Marcar como Atendida
                                        </button>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <div class="mb-6">
                    <h3 class="text-lg font-semibold mb-4">Documentos Requeridos</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        @php
                            $tiposDocumentos = [
                                'matricula' => ['nombre' => 'Matrícula', 'icon' => '📋'],
                                'certificado_navegacion' => ['nombre' => 'Certificado de Navegación', 'icon' => '⚓'],
                                'poliza_accidentes' => ['nombre' => 'Póliza de Accidentes Personales', 'icon' => '🏥'],
                                'poliza_pandi' => ['nombre' => 'Póliza Todo Riesgo PANDI', 'icon' => '🛡️'],
                                'resolucion_dimar' => ['nombre' => 'Resolución DIMAR', 'icon' => '📜']
                            ];
                        @endphp
                        @foreach($tiposDocumentos as $tipo => $info)
                            @php
                                $doc = $embarcacion->documentos->where('tipo_documento', $tipo)->first();
                            @endphp
                            <div class="bg-white rounded-lg shadow border {{ $doc && $doc->estaVigente() ? 'border-green-200' : 'border-red-200' }} hover:shadow-md transition">
                                <!-- Header -->
                                <div class="{{ $doc && $doc->estaVigente() ? 'bg-green-50 border-b border-green-100' : 'bg-red-50 border-b border-red-100' }} px-4 py-3">
                                    <div class="flex items-center justify-between">
                                        <h4 class="font-semibold text-gray-900 text-sm">{{ $info['nombre'] }}</h4>
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $doc && $doc->estaVigente() ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                            @if($doc)
                                                {{ $doc->estaVigente() ? 'Vigente' : 'Vencido' }}
                                            @else
                                                Sin registrar
                                            @endif
                                        </span>
                                    </div>
                                </div>

                                <!-- Contenido -->
                                <div class="p-4">
                                    @if($doc)
                                        <div class="space-y-2 mb-4">
                                            <div class="flex items-start">
                                                <span class="text-xs font-semibold text-gray-500 w-24">Número:</span>
                                                <span class="text-xs text-gray-900 font-medium flex-1">{{ $doc->numero_documento }}</span>
                                            </div>
                                            <div class="flex items-start">
                                                <span class="text-xs font-semibold text-gray-500 w-24">Emisor:</span>
                                                <span class="text-xs text-gray-900 flex-1">{{ $doc->entidad_emisora }}</span>
                                            </div>
                                            <div class="flex items-start">
                                                <span class="text-xs font-semibold text-gray-500 w-24">Expedición:</span>
                                                <span class="text-xs text-gray-900">{{ $doc->fecha_expedicion->format('d/m/Y') }}</span>
                                            </div>
                                            @if($doc->fecha_vencimiento)
                                                <div class="flex items-start">
                                                    <span class="text-xs font-semibold text-gray-500 w-24">Vencimiento:</span>
                                                    <span class="text-xs text-gray-900">{{ $doc->fecha_vencimiento->format('d/m/Y') }}</span>
                                                </div>
                                                @if($doc->diasParaVencer() !== null)
                                                    <div class="mt-2 p-2 rounded {{ $doc->diasParaVencer() < 0 ? 'bg-red-50 border border-red-200' : ($doc->diasParaVencer() <= 30 ? 'bg-yellow-50 border border-yellow-200' : 'bg-green-50 border border-green-200') }}">
                                                        <p class="text-xs font-medium text-center {{ $doc->diasParaVencer() < 0 ? 'text-red-700' : ($doc->diasParaVencer() <= 30 ? 'text-yellow-700' : 'text-green-700') }}">
                                                            {{ $doc->diasParaVencer() < 0 ? 'Vencido hace ' . abs($doc->diasParaVencer()) . ' días' : ($doc->diasParaVencer() <= 30 ? 'Vence en ' . $doc->diasParaVencer() . ' días' : 'Vigente por ' . $doc->diasParaVencer() . ' días') }}
                                                        </p>
                                                    </div>
                                                @endif
                                            @endif
                                            @if($doc->archivo_path)
                                                <a href="{{ Storage::url($doc->archivo_path) }}" target="_blank" class="mt-2 flex items-center justify-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-3 py-2 rounded text-xs font-semibold">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                                    </svg>
                                                    <span>Ver Documento</span>
                                                </a>
                                            @endif
                                        </div>
                                        @if(auth()->user()->role !== 'inspector')
                                            <div class="grid grid-cols-2 gap-2">
                                                <button wire:click.stop="edit({{ $doc->id }})" class="flex items-center justify-center space-x-1 bg-blue-600 hover:bg-blue-700 text-white px-3 py-2 rounded text-xs font-medium transition">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                    </svg>
                                                    <span>Editar</span>
                                                </button>
                                                <button wire:click.stop="delete({{ $doc->id }})" wire:confirm="¿Eliminar este documento?" class="flex items-center justify-center space-x-1 bg-red-600 hover:bg-red-700 text-white px-3 py-2 rounded text-xs font-medium transition">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                    </svg>
                                                    <span>Eliminar</span>
                                                </button>
                                            </div>
                                        @else
                                            <button wire:click.stop="solicitarActualizacion({{ $doc->id }})" class="w-full flex items-center justify-center space-x-1 bg-orange-600 hover:bg-orange-700 text-white px-3 py-2 rounded text-xs font-medium transition">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                                                </svg>
                                                <span>Solicitar Actualización</span>
                                            </button>
                                        @endif
                                    @else
                                        <div class="py-6">
                                            <div class="text-center mb-4">
                                                <div class="inline-flex items-center justify-center w-12 h-12 bg-gray-100 rounded-full mb-2">
                                                    <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                                    </svg>
                                                </div>
                                                <p class="text-sm font-semibold text-gray-700 mb-1">Documento Faltante</p>
                                                <p class="text-xs text-gray-500">Este documento es obligatorio</p>
                                            </div>
                                            @if(auth()->user()->role !== 'inspector')
                                                <button wire:click="openModal('{{ $tipo }}')" class="w-full flex items-center justify-center space-x-2 bg-blue-600 hover:bg-blue-700 text-white px-4 py-3 rounded text-sm font-medium transition">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                                    </svg>
                                                    <span>Cargar Documento</span>
                                                </button>
                                            @endif
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="mt-6">
                    <a href="{{ route('embarcaciones.show', $embarcacion) }}" class="text-blue-600 hover:text-blue-800">
                        ← Volver a detalles de embarcación
                    </a>
                </div>
            </div>
        </div>
    </div>

    @if($showModal)
        <div class="fixed inset-0 bg-gray-900 bg-opacity-50 overflow-y-auto h-full w-full z-50 flex items-center justify-center p-4" x-data="{ show: true }" x-show="show" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100">
            <div class="relative w-full max-w-3xl bg-white rounded-lg shadow-xl" x-show="show" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform scale-95" x-transition:enter-end="opacity-100 transform scale-100">
                <!-- Header del Modal -->
                <div class="bg-white border-b border-gray-200 px-6 py-4 rounded-t-lg">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900">{{ $documentoId ? 'Editar' : 'Nuevo' }} Documento</h3>
                            <p class="text-sm text-gray-500 mt-1">Complete la información requerida</p>
                        </div>
                        <button wire:click="$set('showModal', false)" class="text-gray-400 hover:text-gray-600 p-2 rounded hover:bg-gray-100 transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Contenido del Modal -->
                <form wire:submit.prevent="save" class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Tipo de Documento *</label>
                            <select wire:model="tipo_documento" class="w-full px-3 py-2 border border-gray-300 rounded focus:ring-blue-500 focus:border-blue-500" {{ $documentoId ? 'disabled' : '' }}>
                                <option value="">Seleccione...</option>
                                <option value="matricula">Matrícula</option>
                                <option value="certificado_navegacion">Certificado de Navegación</option>
                                <option value="poliza_accidentes">Póliza de Accidentes Personales</option>
                                <option value="poliza_pandi">Póliza Todo Riesgo PANDI</option>
                                <option value="resolucion_dimar">Resolución DIMAR</option>
                            </select>
                            @error('tipo_documento') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Número de Documento *</label>
                            <input wire:model="numero_documento" type="text" class="w-full px-3 py-2 border border-gray-300 rounded focus:ring-blue-500 focus:border-blue-500" placeholder="Ej: MAT-2024-001">
                            @error('numero_documento') <span class="text-red-600 text-sm mt-1">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Entidad Emisora *</label>
                            <input wire:model="entidad_emisora" type="text" class="w-full px-3 py-2 border border-gray-300 rounded focus:ring-blue-500 focus:border-blue-500" placeholder="Ej: DIMAR">
                            @error('entidad_emisora') <span class="text-red-600 text-sm mt-1">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Fecha de Expedición *</label>
                            <input wire:model="fecha_expedicion" type="date" class="w-full px-3 py-2 border border-gray-300 rounded focus:ring-blue-500 focus:border-blue-500">
                            @error('fecha_expedicion') <span class="text-red-600 text-sm mt-1">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Fecha de Vencimiento</label>
                            <input wire:model="fecha_vencimiento" type="date" class="w-full px-3 py-2 border border-gray-300 rounded focus:ring-blue-500 focus:border-blue-500">
                            @error('fecha_vencimiento') <span class="text-red-600 text-sm mt-1">{{ $message }}</span> @enderror
                        </div>

                        @if(in_array($tipo_documento, ['poliza_accidentes', 'poliza_pandi']))
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Aseguradora</label>
                                <input wire:model="aseguradora" type="text" class="w-full px-3 py-2 border border-gray-300 rounded focus:ring-blue-500 focus:border-blue-500" placeholder="Nombre de la aseguradora">
                                @error('aseguradora') <span class="text-red-600 text-sm mt-1">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Monto Asegurado</label>
                                <input wire:model="monto_asegurado" type="number" step="0.01" class="w-full px-3 py-2 border border-gray-300 rounded focus:ring-blue-500 focus:border-blue-500" placeholder="0.00">
                                @error('monto_asegurado') <span class="text-red-600 text-sm mt-1">{{ $message }}</span> @enderror
                            </div>

                            @if($tipo_documento === 'poliza_accidentes')
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Pasajeros Cubiertos</label>
                                    <input wire:model="pasajeros_cubiertos" type="number" class="w-full px-3 py-2 border border-gray-300 rounded focus:ring-blue-500 focus:border-blue-500" placeholder="Número de pasajeros">
                                    @error('pasajeros_cubiertos') <span class="text-red-600 text-sm mt-1">{{ $message }}</span> @enderror
                                </div>
                            @endif
                        @endif

                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Archivo del Documento</label>
                            <div class="mt-2 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded hover:border-gray-400 transition" x-data="{ uploading: false, progress: 0 }" x-on:livewire-upload-start="uploading = true" x-on:livewire-upload-finish="uploading = false" x-on:livewire-upload-error="uploading = false" x-on:livewire-upload-progress="progress = $event.detail.progress">
                                <div class="space-y-1 text-center w-full">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                        <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                    <div class="text-sm text-gray-600">
                                        <label for="file-upload" class="relative cursor-pointer bg-white rounded font-medium text-blue-600 hover:text-blue-500">
                                            <span>Seleccionar archivo</span>
                                            <input wire:model="archivo" id="file-upload" type="file" class="sr-only" accept=".pdf,.jpg,.jpeg,.png">
                                        </label>
                                        <p class="pl-1">o arrastrar y soltar</p>
                                    </div>
                                    <p class="text-xs text-gray-500">PDF, JPG, PNG hasta 10MB</p>
                                    <div x-show="uploading" class="mt-2">
                                        <div class="w-full bg-gray-200 rounded-full h-2">
                                            <div class="bg-blue-600 h-2 rounded-full transition-all" :style="`width: ${progress}%`"></div>
                                        </div>
                                        <p class="text-xs text-gray-600 mt-1">Cargando... <span x-text="progress"></span>%</p>
                                    </div>
                                </div>
                            </div>
                            @if($archivo)
                                <div class="mt-2 flex items-center space-x-2 bg-green-50 border border-green-200 rounded p-2">
                                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <span class="text-sm text-green-700">{{ $archivo->getClientOriginalName() }}</span>
                                </div>
                            @endif
                            @error('archivo') <span class="text-red-600 text-sm mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Observaciones</label>
                            <textarea wire:model="observaciones" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded focus:ring-blue-500 focus:border-blue-500" placeholder="Notas adicionales sobre el documento..."></textarea>
                            @error('observaciones') <span class="text-red-600 text-sm mt-1">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <!-- Footer del Modal -->
                    <div class="mt-6 pt-4 border-t border-gray-200 flex items-center justify-end space-x-3">
                        <button type="button" wire:click="$set('showModal', false)" class="px-4 py-2 bg-white border border-gray-300 hover:bg-gray-50 text-gray-700 font-medium rounded transition">
                            Cancelar
                        </button>
                        <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded transition disabled:opacity-50 disabled:cursor-not-allowed" wire:loading.attr="disabled" wire:target="archivo,save" @if($errors->has('archivo')) disabled @endif>
                            <span wire:loading.remove wire:target="archivo,save">{{ $documentoId ? 'Actualizar' : 'Guardar' }} Documento</span>
                            <span wire:loading wire:target="archivo">Cargando archivo...</span>
                            <span wire:loading wire:target="save">Guardando...</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif

    @if($showSolicitudModal)
        <div class="fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center z-50">
            <div class="bg-white rounded-lg p-6 max-w-md w-full mx-4">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Solicitar Actualización de Documento</h3>
                
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Motivo de la solicitud *</label>
                    <textarea wire:model="motivoSolicitud" rows="4" class="w-full border-gray-300 rounded-lg" placeholder="Describe la irregularidad o motivo de actualización..."></textarea>
                    @error('motivoSolicitud') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div class="flex justify-end space-x-3">
                    <button wire:click="$set('showSolicitudModal', false)" class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded">
                        Cancelar
                    </button>
                    <button wire:click="enviarSolicitud" class="bg-orange-600 hover:bg-orange-700 text-white px-4 py-2 rounded">
                        Enviar Solicitud
                    </button>
                </div>
            </div>
        </div>
    @endif

    @if($showViewModal && $viewingDocument)
        <div class="fixed inset-0 bg-gray-900 bg-opacity-50 overflow-y-auto h-full w-full z-50 flex items-center justify-center p-4" x-data="{ show: true }" x-show="show" x-transition>
            <div class="relative w-full max-w-4xl bg-white rounded-lg shadow-xl" x-show="show" x-transition>
                <div class="bg-white border-b border-gray-200 px-6 py-4 rounded-t-lg">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900">{{ $viewingDocument->tipo_documento }}</h3>
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
