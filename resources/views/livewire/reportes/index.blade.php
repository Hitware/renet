<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Reportes de Embarcaciones
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
                    <label class="block text-sm font-medium text-gray-700 mb-2">Filtrar por estado:</label>
                    <select wire:model.live="estado" class="border-gray-300 rounded-lg">
                        <option value="">Todos</option>
                        <option value="pendiente">Pendiente</option>
                        <option value="revisado">Revisado</option>
                        <option value="resuelto">Resuelto</option>
                    </select>
                </div>

                <div class="space-y-4">
                    @forelse($reportes as $reporte)
                        <div class="border rounded-lg p-6 {{ $reporte->estado === 'pendiente' ? 'bg-red-50 border-red-200' : 'bg-gray-50' }}">
                            <div class="flex justify-between items-start mb-4">
                                <div>
                                    <h3 class="text-lg font-bold text-gray-900">{{ $reporte->embarcacion->nombre }}</h3>
                                    <p class="text-sm text-gray-600">Matrícula: {{ $reporte->embarcacion->matricula }}</p>
                                    <p class="text-xs text-gray-500 mt-1">{{ $reporte->created_at->format('d/m/Y H:i') }}</p>
                                </div>
                                <select wire:change="cambiarEstado({{ $reporte->id }}, $event.target.value)" class="text-sm border-gray-300 rounded">
                                    <option value="pendiente" {{ $reporte->estado === 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                                    <option value="revisado" {{ $reporte->estado === 'revisado' ? 'selected' : '' }}>Revisado</option>
                                    <option value="resuelto" {{ $reporte->estado === 'resuelto' ? 'selected' : '' }}>Resuelto</option>
                                </select>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                <div>
                                    <p class="text-sm font-medium text-gray-700">Reportante:</p>
                                    <p class="text-sm text-gray-900">{{ $reporte->nombre_reportante }}</p>
                                    @if($reporte->email_reportante)
                                        <p class="text-sm text-gray-600">{{ $reporte->email_reportante }}</p>
                                    @endif
                                    @if($reporte->telefono_reportante)
                                        <p class="text-sm text-gray-600">{{ $reporte->telefono_reportante }}</p>
                                    @endif
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-700">IP:</p>
                                    <p class="text-sm text-gray-600">{{ $reporte->ip_address }}</p>
                                </div>
                            </div>

                            <div class="mb-4">
                                <p class="text-sm font-medium text-gray-700 mb-2">Descripción:</p>
                                <p class="text-sm text-gray-900">{{ $reporte->descripcion }}</p>
                            </div>

                            @if($reporte->imagen)
                                <div>
                                    <p class="text-sm font-medium text-gray-700 mb-2">Imagen adjunta:</p>
                                    <img src="{{ Storage::url($reporte->imagen) }}" class="w-64 h-48 object-cover rounded-lg border">
                                </div>
                            @endif
                        </div>
                    @empty
                        <p class="text-center text-gray-500 py-8">No hay reportes registrados</p>
                    @endforelse
                </div>

                <div class="mt-6">
                    {{ $reportes->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
