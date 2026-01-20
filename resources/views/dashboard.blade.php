<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight" style="font-family: 'Outfit', sans-serif;">
            Dashboard
        </h2>
    </x-slot>

    <div class="space-y-6">
        <!-- Welcome Message -->
        <div class="bg-gradient-to-r from-blue-600 via-blue-700 to-blue-800 rounded-xl shadow-lg overflow-hidden">
            <div class="p-8">
                <h3 class="text-3xl font-bold text-white mb-2" style="font-family: 'Outfit', sans-serif;">
                    Bienvenido, {{ Auth::user()->name }}!
                </h3>
                <p class="text-blue-100 text-lg">
                    @if(Auth::user()->isAdmin())
                        Panel de Administración - RENET
                    @elseif(Auth::user()->isInspector())
                        Panel de Inspector - DIMAR
                    @elseif(Auth::user()->isEmpresa())
                        Panel de Empresa - {{ Auth::user()->empresa?->nombre_comercial ?? Auth::user()->empresa?->razon_social }}
                    @else
                        Portal Público - RENET
                    @endif
                </p>
            </div>
        </div>

        @if(Auth::user()->isAdmin())
            <!-- Admin Dashboard -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-100 hover:shadow-xl transition-shadow">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl p-4 shadow-lg shadow-blue-500/30">
                                <svg class="h-8 w-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                </svg>
                            </div>
                            <div class="ml-5">
                                <p class="text-sm font-medium text-gray-500 mb-1">Empresas Registradas</p>
                                <p class="text-3xl font-bold text-gray-900" style="font-family: 'Outfit', sans-serif;">{{ \App\Models\Empresa::count() }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-100 hover:shadow-xl transition-shadow">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-gradient-to-br from-green-500 to-green-600 rounded-xl p-4 shadow-lg shadow-green-500/30">
                                <svg class="h-8 w-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 15a4 4 0 004 4h9a5 5 0 10-.1-9.999 5.002 5.002 0 10-9.78 2.096A4.001 4.001 0 003 15z"></path>
                                </svg>
                            </div>
                            <div class="ml-5">
                                <p class="text-sm font-medium text-gray-500 mb-1">Embarcaciones Totales</p>
                                <p class="text-3xl font-bold text-gray-900" style="font-family: 'Outfit', sans-serif;">{{ \App\Models\Embarcacion::count() }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-100 hover:shadow-xl transition-shadow">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl p-4 shadow-lg shadow-purple-500/30">
                                <svg class="h-8 w-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                </svg>
                            </div>
                            <div class="ml-5">
                                <p class="text-sm font-medium text-gray-500 mb-1">Usuarios del Sistema</p>
                                <p class="text-3xl font-bold text-gray-900" style="font-family: 'Outfit', sans-serif;">{{ \App\Models\User::count() }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        @elseif(Auth::user()->isInspector())
            <!-- Inspector Dashboard -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-100 hover:shadow-xl transition-shadow">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-gradient-to-br from-green-500 to-green-600 rounded-xl p-4 shadow-lg shadow-green-500/30">
                                <svg class="h-8 w-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                            </div>
                            <div class="ml-5">
                                <p class="text-sm font-medium text-gray-500 mb-1">Disponibles</p>
                                <p class="text-3xl font-bold text-green-600" style="font-family: 'Outfit', sans-serif;">{{ \App\Models\Embarcacion::where('estado', 'disponible')->count() }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-100 hover:shadow-xl transition-shadow">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-gradient-to-br from-red-500 to-red-600 rounded-xl p-4 shadow-lg shadow-red-500/30">
                                <svg class="h-8 w-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </div>
                            <div class="ml-5">
                                <p class="text-sm font-medium text-gray-500 mb-1">No Disponibles</p>
                                <p class="text-3xl font-bold text-red-600" style="font-family: 'Outfit', sans-serif;">{{ \App\Models\Embarcacion::where('estado', 'no_disponible')->count() }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-100 hover:shadow-xl transition-shadow">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-gradient-to-br from-yellow-500 to-yellow-600 rounded-xl p-4 shadow-lg shadow-yellow-500/30">
                                <svg class="h-8 w-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div class="ml-5">
                                <p class="text-sm font-medium text-gray-500 mb-1">Mantenimiento</p>
                                <p class="text-3xl font-bold text-yellow-600" style="font-family: 'Outfit', sans-serif;">{{ \App\Models\Embarcacion::where('estado', 'mantenimiento')->count() }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-100 hover:shadow-xl transition-shadow">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-gradient-to-br from-gray-500 to-gray-600 rounded-xl p-4 shadow-lg shadow-gray-500/30">
                                <svg class="h-8 w-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"></path>
                                </svg>
                            </div>
                            <div class="ml-5">
                                <p class="text-sm font-medium text-gray-500 mb-1">Suspendidas</p>
                                <p class="text-3xl font-bold text-gray-600" style="font-family: 'Outfit', sans-serif;">{{ \App\Models\Embarcacion::where('estado', 'suspendida')->count() }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        @elseif(Auth::user()->isEmpresa())
            <!-- Empresa Dashboard -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-100 hover:shadow-xl transition-shadow">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl p-4 shadow-lg shadow-blue-500/30">
                                <svg class="h-8 w-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 15a4 4 0 004 4h9a5 5 0 10-.1-9.999 5.002 5.002 0 10-9.78 2.096A4.001 4.001 0 003 15z"></path>
                                </svg>
                            </div>
                            <div class="ml-5">
                                <p class="text-sm font-medium text-gray-500 mb-1">Mi Flota</p>
                                <p class="text-3xl font-bold text-gray-900" style="font-family: 'Outfit', sans-serif;">{{ Auth::user()->empresa?->embarcaciones()->count() ?? 0 }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-100 hover:shadow-xl transition-shadow">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-gradient-to-br from-green-500 to-green-600 rounded-xl p-4 shadow-lg shadow-green-500/30">
                                <svg class="h-8 w-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                            </div>
                            <div class="ml-5">
                                <p class="text-sm font-medium text-gray-500 mb-1">Operativas</p>
                                <p class="text-3xl font-bold text-green-600" style="font-family: 'Outfit', sans-serif;">{{ Auth::user()->empresa?->embarcaciones()->where('estado', 'disponible')->count() ?? 0 }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-100 hover:shadow-xl transition-shadow">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-gradient-to-br from-yellow-500 to-yellow-600 rounded-xl p-4 shadow-lg shadow-yellow-500/30">
                                <svg class="h-8 w-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div class="ml-5">
                                <p class="text-sm font-medium text-gray-500 mb-1">En Mantenimiento</p>
                                <p class="text-3xl font-bold text-yellow-600" style="font-family: 'Outfit', sans-serif;">{{ Auth::user()->empresa?->embarcaciones()->where('estado', 'mantenimiento')->count() ?? 0 }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        @else
            <!-- Public Dashboard -->
            <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-100">
                <div class="p-8">
                    <h3 class="text-2xl font-bold text-gray-900 mb-4" style="font-family: 'Outfit', sans-serif;">Portal Público RENET</h3>
                    <p class="text-gray-600 mb-6 text-lg">
                        Bienvenido al Registro Nacional de Embarcaciones y Tripulantes. Desde aquí puedes verificar el estado de embarcaciones registradas.
                    </p>
                    <div class="bg-blue-50 border-l-4 border-blue-500 p-6 rounded-lg">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-6 w-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-blue-700 font-medium">
                                    Para verificar una embarcación, escanee el código QR que se encuentra en la tarjeta de propiedad de la motonave.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <!-- Quick Actions Section -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-100">
            <div class="p-8">
                <h3 class="text-xl font-bold text-gray-900 mb-6" style="font-family: 'Outfit', sans-serif;">Acciones Rápidas</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @if(Auth::user()->isAdmin() || Auth::user()->isInspector())
                        <a href="{{ route('embarcaciones.index') }}" class="flex items-center p-5 bg-gradient-to-br from-gray-50 to-gray-100 rounded-xl hover:from-blue-50 hover:to-blue-100 transition-all duration-200 border border-gray-200 hover:border-blue-300 group">
                            <div class="flex-shrink-0 bg-white p-3 rounded-lg shadow-sm group-hover:shadow-md transition-shadow">
                                <svg class="h-7 w-7 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="font-semibold text-gray-900">Buscar Embarcaciones</p>
                                <p class="text-sm text-gray-500">Buscar y filtrar</p>
                            </div>
                        </a>
                    @endif

                    @if(Auth::user()->isEmpresa())
                        <a href="{{ route('embarcaciones.create') }}" class="flex items-center p-5 bg-gradient-to-br from-gray-50 to-gray-100 rounded-xl hover:from-green-50 hover:to-green-100 transition-all duration-200 border border-gray-200 hover:border-green-300 group">
                            <div class="flex-shrink-0 bg-white p-3 rounded-lg shadow-sm group-hover:shadow-md transition-shadow">
                                <svg class="h-7 w-7 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="font-semibold text-gray-900">Registrar Embarcación</p>
                                <p class="text-sm text-gray-500">Agregar nueva</p>
                            </div>
                        </a>

                        <a href="{{ route('embarcaciones.index') }}" class="flex items-center p-5 bg-gradient-to-br from-gray-50 to-gray-100 rounded-xl hover:from-blue-50 hover:to-blue-100 transition-all duration-200 border border-gray-200 hover:border-blue-300 group">
                            <div class="flex-shrink-0 bg-white p-3 rounded-lg shadow-sm group-hover:shadow-md transition-shadow">
                                <svg class="h-7 w-7 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"></path>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="font-semibold text-gray-900">Mi Flota</p>
                                <p class="text-sm text-gray-500">Ver todas</p>
                            </div>
                        </a>

                        <a href="{{ route('pilotos.index') }}" class="flex items-center p-5 bg-gradient-to-br from-gray-50 to-gray-100 rounded-xl hover:from-purple-50 hover:to-purple-100 transition-all duration-200 border border-gray-200 hover:border-purple-300 group">
                            <div class="flex-shrink-0 bg-white p-3 rounded-lg shadow-sm group-hover:shadow-md transition-shadow">
                                <svg class="h-7 w-7 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2" />
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="font-semibold text-gray-900">Mi Perfil de Piloto</p>
                                <p class="text-sm text-gray-500">{{ Auth::user()->piloto ? 'Ver/Editar perfil' : 'Crear perfil' }}</p>
                            </div>
                        </a>

                        <a href="{{ route('pilotos.buscar') }}" class="flex items-center p-5 bg-gradient-to-br from-gray-50 to-gray-100 rounded-xl hover:from-indigo-50 hover:to-indigo-100 transition-all duration-200 border border-gray-200 hover:border-indigo-300 group">
                            <div class="flex-shrink-0 bg-white p-3 rounded-lg shadow-sm group-hover:shadow-md transition-shadow">
                                <svg class="h-7 w-7 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="font-semibold text-gray-900">Buscar Pilotos</p>
                                <p class="text-sm text-gray-500">Encontrar tripulación</p>
                            </div>
                        </a>
                    @endif

                    @if(Auth::user()->isPublico())
                        <a href="{{ route('pilotos.index') }}" class="flex items-center p-5 bg-gradient-to-br from-gray-50 to-gray-100 rounded-xl hover:from-purple-50 hover:to-purple-100 transition-all duration-200 border border-gray-200 hover:border-purple-300 group">
                            <div class="flex-shrink-0 bg-white p-3 rounded-lg shadow-sm group-hover:shadow-md transition-shadow">
                                <svg class="h-7 w-7 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2" />
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="font-semibold text-gray-900">Mi Perfil de Piloto</p>
                                <p class="text-sm text-gray-500">{{ Auth::user()->piloto ? 'Ver/Editar perfil' : 'Crear perfil' }}</p>
                            </div>
                        </a>

                        <a href="{{ route('verificar.piloto') }}" class="flex items-center p-5 bg-gradient-to-br from-gray-50 to-gray-100 rounded-xl hover:from-indigo-50 hover:to-indigo-100 transition-all duration-200 border border-gray-200 hover:border-indigo-300 group">
                            <div class="flex-shrink-0 bg-white p-3 rounded-lg shadow-sm group-hover:shadow-md transition-shadow">
                                <svg class="h-7 w-7 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="font-semibold text-gray-900">Verificar Piloto</p>
                                <p class="text-sm text-gray-500">Escanear credencial</p>
                            </div>
                        </a>
                    @endif

                    <a href="{{ route('verificar') }}" class="flex items-center p-5 bg-gradient-to-br from-gray-50 to-gray-100 rounded-xl hover:from-purple-50 hover:to-purple-100 transition-all duration-200 border border-gray-200 hover:border-purple-300 group">
                        <div class="flex-shrink-0 bg-white p-3 rounded-lg shadow-sm group-hover:shadow-md transition-shadow">
                            <svg class="h-7 w-7 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="font-semibold text-gray-900">Verificar con QR</p>
                            <p class="text-sm text-gray-500">Escanear código</p>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
