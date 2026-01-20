<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $pilotoId ? 'Editar Mi Perfil de Piloto' : 'Crear Mi Perfil de Piloto' }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <form wire:submit.prevent="save">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Datos Personales -->
                        <div class="md:col-span-2">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4 pb-2 border-b">Datos Personales</h3>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Nombres *</label>
                            <input wire:model="nombres" type="text" class="w-full border-gray-300 rounded-lg">
                            @error('nombres') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Apellidos *</label>
                            <input wire:model="apellidos" type="text" class="w-full border-gray-300 rounded-lg">
                            @error('apellidos') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Tipo de Documento *</label>
                            <select wire:model="tipo_documento" class="w-full border-gray-300 rounded-lg">
                                <option value="CC">Cédula de Ciudadanía</option>
                                <option value="CE">Cédula de Extranjería</option>
                                <option value="PAS">Pasaporte</option>
                            </select>
                            @error('tipo_documento') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Número de Documento *</label>
                            <input wire:model="numero_documento" type="text" class="w-full border-gray-300 rounded-lg">
                            @error('numero_documento') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Fecha de Nacimiento *</label>
                            <input wire:model="fecha_nacimiento" type="date" class="w-full border-gray-300 rounded-lg">
                            @error('fecha_nacimiento') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Teléfono *</label>
                            <input wire:model="telefono" type="text" class="w-full border-gray-300 rounded-lg">
                            @error('telefono') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Email *</label>
                            <input wire:model="email" type="email" class="w-full border-gray-300 rounded-lg">
                            @error('email') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Dirección *</label>
                            <input wire:model="direccion" type="text" class="w-full border-gray-300 rounded-lg">
                            @error('direccion') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Foto de Perfil</label>
                            <input wire:model="foto_perfil" type="file" accept="image/*" class="w-full border-gray-300 rounded-lg">
                            @error('foto_perfil') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            @if($foto_perfil)
                                <img src="{{ $foto_perfil->temporaryUrl() }}" class="mt-2 w-32 h-32 object-cover rounded-full">
                            @elseif($foto_actual)
                                <img src="{{ Storage::url($foto_actual) }}" class="mt-2 w-32 h-32 object-cover rounded-full">
                            @endif
                        </div>

                        <!-- Información de Licencia -->
                        <div class="md:col-span-2 mt-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4 pb-2 border-b">Información de Licencia</h3>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Número de Licencia *</label>
                            <input wire:model="licencia_numero" type="text" class="w-full border-gray-300 rounded-lg">
                            @error('licencia_numero') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Tipo de Licencia *</label>
                            <select wire:model="licencia_tipo" class="w-full border-gray-300 rounded-lg">
                                <option value="Capitán">Capitán</option>
                                <option value="Patrón">Patrón</option>
                                <option value="Marinero">Marinero</option>
                                <option value="Otro">Otro</option>
                            </select>
                            @error('licencia_tipo') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Fecha de Expedición *</label>
                            <input wire:model="licencia_fecha_expedicion" type="date" class="w-full border-gray-300 rounded-lg">
                            @error('licencia_fecha_expedicion') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Fecha de Vencimiento *</label>
                            <input wire:model="licencia_fecha_vencimiento" type="date" class="w-full border-gray-300 rounded-lg">
                            @error('licencia_fecha_vencimiento') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Años de Experiencia *</label>
                            <input wire:model="anos_experiencia" type="number" min="0" class="w-full border-gray-300 rounded-lg">
                            @error('anos_experiencia') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Estado *</label>
                            <select wire:model="estado" class="w-full border-gray-300 rounded-lg">
                                <option value="activo">Activo</option>
                                <option value="inactivo">Inactivo</option>
                                <option value="suspendido">Suspendido</option>
                            </select>
                            @error('estado') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="mt-6 flex justify-end space-x-3">
                        @if($pilotoId)
                            <a href="{{ route('pilotos.show', auth()->user()->piloto) }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-6 py-2 rounded-lg">
                                Cancelar
                            </a>
                        @endif
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg">
                            {{ $pilotoId ? 'Actualizar Perfil' : 'Crear Perfil' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
