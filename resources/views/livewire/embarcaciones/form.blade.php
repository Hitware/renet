<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $embarcacionId ? 'Editar Embarcación' : 'Nueva Embarcación' }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <form wire:submit.prevent="save">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        @if(auth()->user()->role === 'admin' || auth()->user()->role === 'inspector')
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Empresa *</label>
                            <select wire:model="empresa_id" class="w-full border-gray-300 rounded-lg">
                                <option value="">Seleccione una empresa</option>
                                @foreach($empresas as $empresa)
                                    <option value="{{ $empresa->id }}">{{ $empresa->razon_social }}</option>
                                @endforeach
                            </select>
                            @error('empresa_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                        @endif

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Matrícula *</label>
                            <input wire:model="matricula" type="text" class="w-full border-gray-300 rounded-lg">
                            @error('matricula') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Nombre *</label>
                            <input wire:model="nombre" type="text" class="w-full border-gray-300 rounded-lg">
                            @error('nombre') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Tipo *</label>
                            <select wire:model="tipo" class="w-full border-gray-300 rounded-lg">
                                <option value="motonave_pasaje">Motonave de Pasaje</option>
                                <option value="carga">Carga</option>
                                <option value="pesquera">Pesquera</option>
                                <option value="recreativa">Recreativa</option>
                            </select>
                            @error('tipo') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Capacidad de Pasajeros</label>
                            <input wire:model="capacidad_pasajeros" type="number" class="w-full border-gray-300 rounded-lg">
                            @error('capacidad_pasajeros') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Eslora (m)</label>
                            <input wire:model="eslora" type="number" step="0.01" class="w-full border-gray-300 rounded-lg">
                            @error('eslora') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Manga (m)</label>
                            <input wire:model="manga" type="number" step="0.01" class="w-full border-gray-300 rounded-lg">
                            @error('manga') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Tonelaje</label>
                            <input wire:model="tonelaje" type="number" step="0.01" class="w-full border-gray-300 rounded-lg">
                            @error('tonelaje') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Año de Construcción</label>
                            <input wire:model="ano_construccion" type="number" class="w-full border-gray-300 rounded-lg">
                            @error('ano_construccion') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Material del Casco</label>
                            <input wire:model="material_casco" type="text" class="w-full border-gray-300 rounded-lg">
                            @error('material_casco') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Marca del Motor</label>
                            <input wire:model="motor_marca" type="text" class="w-full border-gray-300 rounded-lg">
                            @error('motor_marca') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Modelo del Motor</label>
                            <input wire:model="motor_modelo" type="text" class="w-full border-gray-300 rounded-lg">
                            @error('motor_modelo') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Potencia del Motor (HP)</label>
                            <input wire:model="motor_potencia" type="number" class="w-full border-gray-300 rounded-lg">
                            @error('motor_potencia') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Observaciones</label>
                            <textarea wire:model="observaciones" rows="3" class="w-full border-gray-300 rounded-lg"></textarea>
                            @error('observaciones') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-3">Imágenes de la Embarcación</label>
                            
                            <div class="bg-gray-50 rounded-lg p-6 border border-gray-200">
                                @if($imagenesExistentes && count($imagenesExistentes) > 0)
                                    <div class="mb-6">
                                        <div class="flex items-center justify-between mb-3">
                                            <h4 class="text-sm font-medium text-gray-700">Imágenes actuales ({{ count($imagenesExistentes) }})</h4>
                                        </div>
                                        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                                            @foreach($imagenesExistentes as $imagen)
                                                <div class="relative aspect-video bg-white rounded-lg overflow-hidden border-2 border-gray-200">
                                                    <img src="{{ Storage::url($imagen->ruta) }}" class="w-full h-full object-cover">
                                                    @if($imagen->es_principal)
                                                        <div class="absolute top-2 left-2 bg-blue-600 text-white text-xs px-2 py-1 rounded font-medium shadow-lg">
                                                            Principal
                                                        </div>
                                                    @endif
                                                    <button type="button" wire:click="deleteImagen({{ $imagen->id }})" wire:confirm="¿Eliminar esta imagen?" class="absolute top-2 right-2 bg-red-600 hover:bg-red-700 text-white p-2 rounded-lg shadow-lg transition">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                        </svg>
                                                    </button>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif

                                <div class="border-2 border-dashed border-gray-300 rounded-lg p-8 text-center hover:border-blue-400 transition bg-white" x-data="{ uploading: false }" x-on:livewire-upload-start="uploading = true" x-on:livewire-upload-finish="uploading = false">
                                    <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    <label for="file-upload" class="cursor-pointer">
                                        <span class="inline-block bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-medium transition">Seleccionar imágenes</span>
                                        <input id="file-upload" type="file" wire:model="imagenes" multiple accept="image/*" class="sr-only">
                                    </label>
                                    <p class="text-sm text-gray-500 mt-3">o arrastra y suelta aquí</p>
                                    <p class="text-xs text-gray-400 mt-2">JPG, PNG hasta 5MB cada una</p>
                                    
                                    <div x-show="uploading" class="mt-6">
                                        <div class="w-full bg-gray-200 rounded-full h-2 max-w-xs mx-auto">
                                            <div class="bg-blue-600 h-2 rounded-full animate-pulse" style="width: 100%"></div>
                                        </div>
                                        <p class="text-sm text-gray-600 mt-3 font-medium">Cargando imágenes...</p>
                                    </div>
                                </div>
                                @error('imagenes.*') <span class="text-red-600 text-sm mt-2 block">{{ $message }}</span> @enderror

                                @if($imagenes)
                                    <div class="mt-6">
                                        <div class="flex items-center justify-between mb-3">
                                            <h4 class="text-sm font-medium text-green-700 flex items-center">
                                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                                Listas para subir ({{ count($imagenes) }} {{ count($imagenes) == 1 ? 'imagen' : 'imágenes' }})
                                            </h4>
                                        </div>
                                        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                                            @foreach($imagenes as $index => $imagen)
                                                <div class="relative aspect-video bg-white rounded-lg overflow-hidden border-2 border-green-400 shadow-sm">
                                                    <img src="{{ $imagen->temporaryUrl() }}" class="w-full h-full object-cover">
                                                    <div class="absolute top-2 right-2 bg-green-600 text-white text-xs px-2 py-1 rounded font-medium shadow-lg">
                                                        Nueva
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="mt-6 flex justify-end space-x-3">
                        <a href="{{ route('embarcaciones.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-6 py-2 rounded-lg">
                            Cancelar
                        </a>
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg">
                            {{ $embarcacionId ? 'Actualizar' : 'Crear' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
