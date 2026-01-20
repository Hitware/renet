<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Mi Perfil de Piloto
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session()->has('message'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                    {{ session('message') }}
                </div>
            @endif

            <!-- Información del Piloto -->
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6 mb-6">
                <div class="flex justify-between items-start mb-6">
                    <div class="flex items-center space-x-4">
                        @if($piloto->foto_perfil)
                            <img src="{{ Storage::url($piloto->foto_perfil) }}" class="w-24 h-24 rounded-full object-cover">
                        @else
                            <div class="w-24 h-24 rounded-full bg-gray-300 flex items-center justify-center">
                                <span class="text-gray-600 text-2xl font-bold">{{ substr($piloto->nombres, 0, 1) }}</span>
                            </div>
                        @endif
                        <div>
                            <h3 class="text-2xl font-bold text-gray-900">{{ $piloto->nombre_completo }}</h3>
                            <p class="text-gray-600">{{ $piloto->licencia_tipo }}</p>
                            <span class="px-3 py-1 text-sm rounded-full {{ $piloto->estado === 'activo' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ ucfirst($piloto->estado) }}
                            </span>
                        </div>
                    </div>
                    <div class="flex flex-wrap gap-2">
                        <a href="{{ route('pilotos.credencial', $piloto) }}" class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-lg inline-flex items-center gap-2" target="_blank">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2" />
                            </svg>
                            Credencial
                        </a>
                        <a href="{{ route('pilotos.hoja-vida', $piloto) }}" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg inline-flex items-center gap-2" target="_blank">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            Hoja de Vida
                        </a>
                        <a href="{{ route('pilotos.editar', $piloto) }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">
                            Editar Perfil
                        </a>
                        <a href="{{ route('dashboard') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded-lg">
                            Volver
                        </a>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <h4 class="font-semibold text-gray-700 mb-2">Información Personal</h4>
                        <dl class="space-y-2">
                            <div><dt class="text-sm text-gray-600">Documento:</dt><dd class="font-medium">{{ $piloto->tipo_documento }} {{ $piloto->numero_documento }}</dd></div>
                            <div><dt class="text-sm text-gray-600">Fecha de Nacimiento:</dt><dd class="font-medium">{{ $piloto->fecha_nacimiento->format('d/m/Y') }}</dd></div>
                            <div><dt class="text-sm text-gray-600">Teléfono:</dt><dd class="font-medium">{{ $piloto->telefono }}</dd></div>
                            <div><dt class="text-sm text-gray-600">Email:</dt><dd class="font-medium">{{ $piloto->email }}</dd></div>
                            <div><dt class="text-sm text-gray-600">Dirección:</dt><dd class="font-medium">{{ $piloto->direccion }}</dd></div>
                        </dl>
                    </div>

                    <div>
                        <h4 class="font-semibold text-gray-700 mb-2">Información de Licencia</h4>
                        <dl class="space-y-2">
                            <div><dt class="text-sm text-gray-600">Número de Licencia:</dt><dd class="font-medium">{{ $piloto->licencia_numero }}</dd></div>
                            <div><dt class="text-sm text-gray-600">Tipo:</dt><dd class="font-medium">{{ $piloto->licencia_tipo }}</dd></div>
                            <div><dt class="text-sm text-gray-600">Expedición:</dt><dd class="font-medium">{{ $piloto->licencia_fecha_expedicion->format('d/m/Y') }}</dd></div>
                            <div>
                                <dt class="text-sm text-gray-600">Vencimiento:</dt>
                                <dd class="font-medium {{ $piloto->licenciaVigente() ? 'text-green-600' : 'text-red-600' }}">
                                    {{ $piloto->licencia_fecha_vencimiento->format('d/m/Y') }}
                                    @if(!$piloto->licenciaVigente())
                                        <span class="text-xs">(Vencida)</span>
                                    @endif
                                </dd>
                            </div>
                            <div><dt class="text-sm text-gray-600">Experiencia:</dt><dd class="font-medium">{{ $piloto->anos_experiencia }} años</dd></div>
                        </dl>
                    </div>
                </div>
            </div>

            <!-- Certificaciones -->
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6 mb-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold text-gray-900">Certificaciones</h3>
                    <button wire:click="openCertificacionModal" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm">
                        Agregar Certificación
                    </button>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Tipo</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Número</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Institución</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Vencimiento</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Estado</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($piloto->certificaciones as $cert)
                                <tr>
                                    <td class="px-4 py-2 text-sm">{{ $cert->tipo_certificacion }}</td>
                                    <td class="px-4 py-2 text-sm">{{ $cert->numero_certificado }}</td>
                                    <td class="px-4 py-2 text-sm">{{ $cert->institucion_emisora }}</td>
                                    <td class="px-4 py-2 text-sm">{{ $cert->fecha_vencimiento->format('d/m/Y') }}</td>
                                    <td class="px-4 py-2">
                                        <span class="px-2 py-1 text-xs rounded-full {{ $cert->estaVigente() ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                            {{ $cert->estaVigente() ? 'Vigente' : 'Vencida' }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-2 text-sm space-x-2">
                                        @if($cert->documento_ruta)
                                            <a href="{{ Storage::url($cert->documento_ruta) }}" target="_blank" class="text-blue-600 hover:text-blue-900">Ver</a>
                                        @endif
                                        <button wire:click="openCertificacionModal({{ $cert->id }})" class="text-green-600 hover:text-green-900">Editar</button>
                                        <button wire:click="deleteCertificacion({{ $cert->id }})" wire:confirm="¿Eliminar certificación?" class="text-red-600 hover:text-red-900">Eliminar</button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-4 py-4 text-center text-gray-500">No hay certificaciones registradas</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Historial de Navegación -->
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold text-gray-900">Historial de Navegación</h3>
                    <button wire:click="openHistorialModal" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm">
                        Agregar Historial
                    </button>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Embarcación</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Cargo</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Fecha Inicio</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Fecha Fin</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($piloto->historialNavegacion as $hist)
                                <tr>
                                    <td class="px-4 py-2 text-sm">{{ $hist->embarcacion->nombre }}</td>
                                    <td class="px-4 py-2 text-sm">{{ $hist->cargo }}</td>
                                    <td class="px-4 py-2 text-sm">{{ $hist->fecha_inicio->format('d/m/Y') }}</td>
                                    <td class="px-4 py-2 text-sm">
                                        @if($hist->fecha_fin)
                                            {{ $hist->fecha_fin->format('d/m/Y') }}
                                        @else
                                            <span class="text-green-600 font-medium">Activo</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-2 text-sm space-x-2">
                                        <button wire:click="openHistorialModal({{ $hist->id }})" class="text-green-600 hover:text-green-900">Editar</button>
                                        <button wire:click="deleteHistorial({{ $hist->id }})" wire:confirm="¿Eliminar historial?" class="text-red-600 hover:text-red-900">Eliminar</button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-4 py-4 text-center text-gray-500">No hay historial registrado</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Certificación -->
    @if($showCertificacionModal)
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center z-50">
            <div class="bg-white rounded-lg p-6 max-w-md w-full">
                <h3 class="text-lg font-semibold mb-4">{{ $certificacionId ? 'Editar' : 'Nueva' }} Certificación</h3>
                <form wire:submit.prevent="saveCertificacion">
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Tipo de Certificación *</label>
                            <input wire:model="tipo_certificacion" type="text" class="w-full border-gray-300 rounded-lg">
                            @error('tipo_certificacion') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Número de Certificado</label>
                            <input wire:model="numero_certificado" type="text" class="w-full border-gray-300 rounded-lg">
                            @error('numero_certificado') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Institución Emisora *</label>
                            <input wire:model="institucion_emisora" type="text" class="w-full border-gray-300 rounded-lg">
                            @error('institucion_emisora') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Fecha de Expedición *</label>
                            <input wire:model="fecha_expedicion_cert" type="date" class="w-full border-gray-300 rounded-lg">
                            @error('fecha_expedicion_cert') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Fecha de Vencimiento *</label>
                            <input wire:model="fecha_vencimiento_cert" type="date" class="w-full border-gray-300 rounded-lg">
                            @error('fecha_vencimiento_cert') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Documento</label>
                            <input wire:model="documento_cert" type="file" accept=".pdf,.jpg,.jpeg,.png" class="w-full border-gray-300 rounded-lg">
                            @error('documento_cert') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="mt-6 flex justify-end space-x-2">
                        <button type="button" wire:click="$set('showCertificacionModal', false)" class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded-lg">Cancelar</button>
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    @endif

    <!-- Modal Historial -->
    @if($showHistorialModal)
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center z-50">
            <div class="bg-white rounded-lg p-6 max-w-md w-full">
                <h3 class="text-lg font-semibold mb-4">{{ $historialId ? 'Editar' : 'Nuevo' }} Historial</h3>
                <form wire:submit.prevent="saveHistorial">
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Embarcación *</label>
                            <select wire:model="embarcacion_id" class="w-full border-gray-300 rounded-lg">
                                <option value="">Seleccione...</option>
                                @foreach($embarcaciones as $emb)
                                    <option value="{{ $emb->id }}">{{ $emb->nombre }} ({{ $emb->matricula }})</option>
                                @endforeach
                            </select>
                            @error('embarcacion_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Cargo *</label>
                            <input wire:model="cargo" type="text" class="w-full border-gray-300 rounded-lg">
                            @error('cargo') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Fecha de Inicio *</label>
                            <input wire:model="fecha_inicio" type="date" class="w-full border-gray-300 rounded-lg">
                            @error('fecha_inicio') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Fecha de Fin</label>
                            <input wire:model="fecha_fin" type="date" class="w-full border-gray-300 rounded-lg">
                            @error('fecha_fin') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            <p class="text-xs text-gray-500 mt-1">Dejar vacío si está actualmente en esta embarcación</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Observaciones</label>
                            <textarea wire:model="observaciones" rows="3" class="w-full border-gray-300 rounded-lg"></textarea>
                            @error('observaciones') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="mt-6 flex justify-end space-x-2">
                        <button type="button" wire:click="$set('showHistorialModal', false)" class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded-lg">Cancelar</button>
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    @endif
</div>
