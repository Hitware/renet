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
                        <!-- Información del Armador -->
                        <div class="md:col-span-2">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4 pb-2 border-b border-gray-200">Información del Armador</h3>
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Dirección *</label>
                            <input wire:model="armador_direccion" type="text" class="w-full border-gray-300 rounded-lg" placeholder="Dirección del armador">
                            @error('armador_direccion') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Correo Electrónico *</label>
                            <input wire:model="armador_email" type="email" class="w-full border-gray-300 rounded-lg" placeholder="correo@ejemplo.com">
                            @error('armador_email') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Contacto *</label>
                            <input wire:model="armador_contacto" type="text" class="w-full border-gray-300 rounded-lg" placeholder="Nombre del contacto">
                            @error('armador_contacto') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Teléfono de Contacto *</label>
                            <input wire:model="armador_telefono" type="text" class="w-full border-gray-300 rounded-lg" placeholder="Teléfono del armador">
                            @error('armador_telefono') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <!-- Información de la Embarcación -->
                        <div class="md:col-span-2 mt-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4 pb-2 border-b border-gray-200">Información de la Embarcación</h3>
                        </div>

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
                            <input wire:model="matricula" type="text" class="w-full border-gray-300 rounded-lg uppercase" placeholder="CP-12-3456 o CP-12-3456-A" pattern="^CP-\d{2}-\d{4}(-[A-Z])?$" maxlength="13" x-data="{}" x-on:input="
                                let input = $event.target.value.toUpperCase();
                                let clean = input.replace(/[^CP0-9A-Z-]/g, '');
                                
                                if (clean.startsWith('CP')) {
                                    let parts = clean.substring(2).replace(/-/g, '');
                                    let formatted = 'CP';
                                    
                                    if (parts.length > 0) {
                                        formatted += '-' + parts.substring(0, 2);
                                    }
                                    if (parts.length > 2) {
                                        formatted += '-' + parts.substring(2, 6);
                                    }
                                    if (parts.length > 6) {
                                        formatted += '-' + parts.substring(6, 7);
                                    }
                                    
                                    $event.target.value = formatted;
                                    $wire.set('matricula', formatted);
                                } else {
                                    $event.target.value = clean;
                                    $wire.set('matricula', clean);
                                }
                            ">
                            <p class="text-xs text-gray-500 mt-1">Formato: CP-##-#### o CP-##-####-X</p>
                            @error('matricula') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Nombre *</label>
                            <input wire:model="nombre" type="text" class="w-full border-gray-300 rounded-lg">
                            @error('nombre') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Catalogación *</label>
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
                            <label class="block text-sm font-medium text-gray-700 mb-3">Imágenes de la Embarcación (5 Lados)</label>
                            
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

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <!-- Proa -->
                                    <div class="border-2 border-gray-300 rounded-lg p-4 bg-white">
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">Proa (Frente)</label>
                                        <input type="file" wire:model="imagen_proa" accept="image/*" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded file:border-0 file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                                        @error('imagen_proa') <span class="text-red-600 text-xs mt-1 block">{{ $message }}</span> @enderror
                                        @if($imagen_proa)
                                            <img src="{{ $imagen_proa->temporaryUrl() }}" class="mt-2 w-full h-32 object-cover rounded">
                                        @endif
                                    </div>

                                    <!-- Popa -->
                                    <div class="border-2 border-gray-300 rounded-lg p-4 bg-white">
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">Popa (Atrás)</label>
                                        <input type="file" wire:model="imagen_popa" accept="image/*" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded file:border-0 file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                                        @error('imagen_popa') <span class="text-red-600 text-xs mt-1 block">{{ $message }}</span> @enderror
                                        @if($imagen_popa)
                                            <img src="{{ $imagen_popa->temporaryUrl() }}" class="mt-2 w-full h-32 object-cover rounded">
                                        @endif
                                    </div>

                                    <!-- Estribor -->
                                    <div class="border-2 border-gray-300 rounded-lg p-4 bg-white">
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">Estribor (Derecha)</label>
                                        <input type="file" wire:model="imagen_estribor" accept="image/*" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded file:border-0 file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                                        @error('imagen_estribor') <span class="text-red-600 text-xs mt-1 block">{{ $message }}</span> @enderror
                                        @if($imagen_estribor)
                                            <img src="{{ $imagen_estribor->temporaryUrl() }}" class="mt-2 w-full h-32 object-cover rounded">
                                        @endif
                                    </div>

                                    <!-- Babor -->
                                    <div class="border-2 border-gray-300 rounded-lg p-4 bg-white">
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">Babor (Izquierda)</label>
                                        <input type="file" wire:model="imagen_babor" accept="image/*" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded file:border-0 file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                                        @error('imagen_babor') <span class="text-red-600 text-xs mt-1 block">{{ $message }}</span> @enderror
                                        @if($imagen_babor)
                                            <img src="{{ $imagen_babor->temporaryUrl() }}" class="mt-2 w-full h-32 object-cover rounded">
                                        @endif
                                    </div>

                                    <!-- Cubierta -->
                                    <div class="border-2 border-gray-300 rounded-lg p-4 bg-white md:col-span-2">
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">Cubierta (Superior)</label>
                                        <input type="file" wire:model="imagen_cubierta" accept="image/*" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded file:border-0 file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                                        @error('imagen_cubierta') <span class="text-red-600 text-xs mt-1 block">{{ $message }}</span> @enderror
                                        @if($imagen_cubierta)
                                            <img src="{{ $imagen_cubierta->temporaryUrl() }}" class="mt-2 w-full h-32 object-cover rounded">
                                        @endif
                                    </div>
                                </div>
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
