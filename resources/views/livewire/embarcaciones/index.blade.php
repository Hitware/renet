<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Mis Embarcaciones
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session()->has('message'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                    {{ session('message') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-lg font-semibold">Lista de Embarcaciones</h3>
                    <a href="{{ route('embarcaciones.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">
                        + Nueva Embarcación 
                    </a>
                </div>

                <div class="mb-6 grid grid-cols-1 md:grid-cols-3 gap-4">
                    <input wire:model.live="search" type="text" placeholder="Buscar por nombre o matrícula..." class="border rounded-lg px-4 py-2">
                    
                    <select wire:model.live="estadoFilter" class="border rounded-lg px-4 py-2">
                        <option value="">Todos los estados</option>
                        <option value="disponible">Disponible</option>
                        <option value="no_disponible">No Disponible</option>
                        <option value="mantenimiento">Mantenimiento</option>
                        <option value="suspendida">Suspendida</option>
                    </select>

                    <select wire:model.live="tipoFilter" class="border rounded-lg px-4 py-2">
                        <option value="">Todos los tipos</option>
                        <option value="motonave_pasaje">Motonave de Pasaje</option>
                        <option value="carga">Carga</option>
                        <option value="pesquera">Pesquera</option>
                        <option value="recreativa">Recreativa</option>
                    </select>
                </div>

                <div class="overflow-x-auto rounded-lg border border-gray-200 shadow-sm">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gradient-to-r from-blue-600 to-blue-700">
                            <tr>
                                <th class="px-4 py-2 text-left text-xs font-semibold text-white uppercase">Matrícula</th>
                                <th class="px-4 py-2 text-left text-xs font-semibold text-white uppercase">Embarcación</th>
                                <th class="px-4 py-2 text-left text-xs font-semibold text-white uppercase">Empresa</th>
                                <th class="px-4 py-2 text-center text-xs font-semibold text-white uppercase">Cap.</th>
                                <th class="px-4 py-2 text-center text-xs font-semibold text-white uppercase">Docs</th>
                                <th class="px-4 py-2 text-left text-xs font-semibold text-white uppercase">Estado</th>
                                <th class="px-4 py-2 text-center text-xs font-semibold text-white uppercase">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-100">
                            @forelse ($embarcaciones as $embarcacion)
                                <tr class="hover:bg-blue-50 transition-colors">
                                    <td class="px-4 py-2 whitespace-nowrap text-sm font-bold text-gray-900">
                                        {{ $embarcacion->matricula }}
                                    </td>
                                    <td class="px-4 py-2">
                                        <div class="text-sm font-semibold text-gray-900">{{ $embarcacion->nombre }}</div>
                                        <div class="text-xs text-gray-500">{{ ucfirst(str_replace('_', ' ', $embarcacion->tipo)) }}</div>
                                    </td>
                                    <td class="px-4 py-2 text-sm text-gray-600">
                                        {{ $embarcacion->empresa->razon_social }}
                                    </td>
                                    <td class="px-4 py-2 whitespace-nowrap text-center">
                                        <span class="text-sm font-semibold text-blue-800">{{ $embarcacion->capacidad_pasajeros ?? 'N/A' }}</span>
                                    </td>
                                    <td class="px-4 py-2 whitespace-nowrap text-center">
                                        @if($embarcacion->puedeNavegar())
                                            <span class="inline-flex items-center px-2 py-1 rounded text-xs font-bold bg-green-100 text-green-800">
                                                ✓
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2 py-1 rounded text-xs font-bold bg-red-100 text-red-800">
                                                ✗
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-2 whitespace-nowrap">
                                        @if(auth()->user()->role !== 'inspector')
                                            <select wire:change="cambiarEstado({{ $embarcacion->id }}, $event.target.value)" class="text-xs font-semibold rounded border px-2 py-1 focus:ring-1 focus:ring-blue-500
                                                @if($embarcacion->estado === 'disponible') bg-green-50 text-green-800 border-green-300
                                                @elseif($embarcacion->estado === 'mantenimiento') bg-yellow-50 text-yellow-800 border-yellow-300
                                                @elseif($embarcacion->estado === 'suspendida') bg-red-50 text-red-800 border-red-300
                                                @else bg-gray-50 text-gray-800 border-gray-300
                                                @endif">
                                                <option value="disponible" {{ $embarcacion->estado === 'disponible' ? 'selected' : '' }}>✓ Disponible</option>
                                                <option value="no_disponible" {{ $embarcacion->estado === 'no_disponible' ? 'selected' : '' }}>✗ No Disponible</option>
                                                <option value="mantenimiento" {{ $embarcacion->estado === 'mantenimiento' ? 'selected' : '' }}>⚙ Mantenimiento</option>
                                                <option value="suspendida" {{ $embarcacion->estado === 'suspendida' ? 'selected' : '' }}>⊘ Suspendida</option>
                                            </select>
                                        @else
                                            <span class="inline-flex px-2 py-1 rounded text-xs font-bold
                                                @if($embarcacion->estado === 'disponible') bg-green-100 text-green-800
                                                @elseif($embarcacion->estado === 'mantenimiento') bg-yellow-100 text-yellow-800
                                                @else bg-red-100 text-red-800
                                                @endif">
                                                {{ ucfirst(str_replace('_', ' ', $embarcacion->estado)) }}
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-2">
                                        <div class="flex items-center justify-center gap-2">
                                            <a href="{{ route('embarcaciones.show', $embarcacion) }}" class="inline-flex items-center gap-1 px-3 py-1.5 bg-blue-600 text-white text-xs font-semibold rounded hover:bg-blue-700">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                </svg>
                                                Ver
                                            </a>
                                            <a href="{{ route('embarcaciones.documentos', $embarcacion) }}" class="inline-flex items-center gap-1 px-3 py-1.5 bg-blue-600 text-white text-xs font-semibold rounded hover:bg-blue-700">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                                </svg>
                                                Docs
                                            </a>
                                            <a href="{{ route('qr.generar', $embarcacion->codigo_qr) }}" download class="inline-flex items-center gap-1 px-3 py-1.5 bg-blue-600 text-white text-xs font-semibold rounded hover:bg-blue-700">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"></path>
                                                </svg>
                                                QR
                                            </a>
                                            <a href="{{ route('embarcaciones.carnet', $embarcacion) }}" target="_blank" class="inline-flex items-center gap-1 px-3 py-1.5 bg-blue-600 text-white text-xs font-semibold rounded hover:bg-blue-700">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3 3m0 0l-3-3m3 3V8"></path>
                                                </svg>
                                                PDF
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-6 py-4 text-center text-gray-500">
                                        No se encontraron embarcaciones
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    {{ $embarcaciones->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
