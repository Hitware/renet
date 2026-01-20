<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Búsqueda de Pilotos Disponibles
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Filtros de Búsqueda -->
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6 mb-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Filtrar Pilotos</h3>

                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <!-- Búsqueda por nombre/documento -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Buscar</label>
                        <input type="text" wire:model.live.debounce.300ms="buscar" class="w-full border-gray-300 rounded-lg" placeholder="Nombre o documento...">
                    </div>

                    <!-- Tipo de Licencia -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Tipo de Licencia</label>
                        <select wire:model.live="licencia_tipo" class="w-full border-gray-300 rounded-lg">
                            <option value="">Todos</option>
                            @foreach($tiposLicencia as $tipo)
                                <option value="{{ $tipo }}">{{ $tipo }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Experiencia Mínima -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Experiencia Mínima (años)</label>
                        <select wire:model.live="anos_experiencia_min" class="w-full border-gray-300 rounded-lg">
                            <option value="0">Sin mínimo</option>
                            <option value="1">1 año</option>
                            <option value="2">2 años</option>
                            <option value="3">3 años</option>
                            <option value="5">5 años</option>
                            <option value="10">10 años</option>
                        </select>
                    </div>

                    <!-- Botón Limpiar -->
                    <div class="flex items-end">
                        <button wire:click="limpiarFiltros" class="w-full bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg">
                            Limpiar Filtros
                        </button>
                    </div>
                </div>

                <div class="mt-4 text-sm text-gray-600">
                    Mostrando <strong>{{ $pilotos->total() }}</strong> pilotos disponibles
                </div>
            </div>

            <!-- Resultados -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($pilotos as $piloto)
                    <div class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition">
                        <!-- Foto del piloto -->
                        <div class="h-48 bg-gradient-to-br from-purple-500 to-blue-500 relative">
                            @if($piloto->foto_perfil)
                                <img src="{{ Storage::url($piloto->foto_perfil) }}" class="w-full h-full object-cover" alt="Foto">
                            @else
                                <div class="w-full h-full flex items-center justify-center">
                                    <svg class="w-24 h-24 text-white opacity-50" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                            @endif
                            <!-- Badge de estado -->
                            <div class="absolute top-2 right-2">
                                <span class="px-3 py-1 text-xs font-semibold rounded-full {{ $piloto->licenciaVigente() ? 'bg-green-500 text-white' : 'bg-red-500 text-white' }}">
                                    {{ $piloto->licenciaVigente() ? 'Licencia Vigente' : 'Licencia Vencida' }}
                                </span>
                            </div>
                        </div>

                        <!-- Información del piloto -->
                        <div class="p-5">
                            <h3 class="text-xl font-bold text-gray-900 mb-1">{{ $piloto->nombre_completo }}</h3>
                            <p class="text-purple-600 font-semibold mb-3">{{ $piloto->licencia_tipo }}</p>

                            <div class="space-y-2 mb-4">
                                <div class="flex items-center text-sm text-gray-600">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                    </svg>
                                    <span><strong>{{ $piloto->anos_experiencia }}</strong> años de experiencia</span>
                                </div>

                                <div class="flex items-center text-sm text-gray-600">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                    </svg>
                                    <span>{{ $piloto->empresa->razon_social ?? 'Sin empresa' }}</span>
                                </div>

                                @if($piloto->getCertificacionesVigentes()->count() > 0)
                                    <div class="flex items-center text-sm text-gray-600">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path>
                                        </svg>
                                        <span>{{ $piloto->getCertificacionesVigentes()->count() }} certificaciones</span>
                                    </div>
                                @endif
                            </div>

                            <!-- Botón para verificar credencial -->
                            <a href="{{ route('verificar.piloto', ['codigo' => $piloto->codigo_qr]) }}" target="_blank" class="block w-full text-center bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-lg transition">
                                Ver Perfil Público
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center py-12">
                        <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">No se encontraron pilotos</h3>
                        <p class="text-gray-600 mb-4">Intenta ajustar los filtros de búsqueda</p>
                        <button wire:click="limpiarFiltros" class="bg-purple-600 hover:bg-purple-700 text-white px-6 py-2 rounded-lg">
                            Limpiar Filtros
                        </button>
                    </div>
                @endforelse
            </div>

            <!-- Paginación -->
            @if($pilotos->hasPages())
                <div class="mt-6">
                    {{ $pilotos->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
