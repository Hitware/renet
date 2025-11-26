<x-guest-layout>
    <div class="max-w-2xl mx-auto">
        <!-- Logo y Header -->
        <div class="text-center mb-8">
            <a href="/" class="inline-flex items-center space-x-3 mb-6">
                <div class="w-14 h-14 bg-blue-500 rounded-xl flex items-center justify-center shadow-lg">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 15a4 4 0 004 4h9a5 5 0 10-.1-9.999 5.002 5.002 0 10-9.78 2.096A4.001 4.001 0 003 15z"></path>
                    </svg>
                </div>
                <div class="text-left">
                    <h1 class="text-3xl font-bold text-white" style="font-family: 'Outfit', sans-serif;">RENET</h1>
                    <p class="text-sm text-blue-300">Sistema de Registro</p>
                </div>
            </a>
            <h2 class="text-2xl font-bold text-white mb-2" style="font-family: 'Outfit', sans-serif;">Crear Cuenta</h2>
            <p class="text-blue-200">Regístrate para acceder a RENET</p>
        </div>

        <!-- Card de Registro -->
        <div class="bg-white rounded-2xl shadow-2xl overflow-hidden">
            <div class="p-8">
                <x-validation-errors class="mb-6" />

                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <!-- Campo oculto para el rol -->
                    <input type="hidden" name="role" value="publico">

                    <!-- Datos Personales -->
                    <div class="mb-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4 pb-2 border-b" style="font-family: 'Outfit', sans-serif;">Datos Personales</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <!-- Nombre -->
                            <div class="md:col-span-2">
                                <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Nombre Completo <span class="text-red-500">*</span>
                                </label>
                                <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name"
                                       class="block w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all"
                                       placeholder="Juan Pérez González">
                            </div>

                            <!-- Tipo de Documento -->
                            <div>
                                <label for="tipo_documento" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Tipo de Documento <span class="text-red-500">*</span>
                                </label>
                                <select id="tipo_documento" name="tipo_documento" required
                                        class="block w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all">
                                    <option value="">Seleccione...</option>
                                    <option value="CC" {{ old('tipo_documento') == 'CC' ? 'selected' : '' }}>Cédula de Ciudadanía</option>
                                    <option value="CE" {{ old('tipo_documento') == 'CE' ? 'selected' : '' }}>Cédula de Extranjería</option>
                                    <option value="PAS" {{ old('tipo_documento') == 'PAS' ? 'selected' : '' }}>Pasaporte</option>
                                    <option value="NIT" {{ old('tipo_documento') == 'NIT' ? 'selected' : '' }}>NIT</option>
                                </select>
                            </div>

                            <!-- Número de Documento -->
                            <div>
                                <label for="documento" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Número de Documento <span class="text-red-500">*</span>
                                </label>
                                <input id="documento" type="text" name="documento" value="{{ old('documento') }}" required
                                       class="block w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all"
                                       placeholder="123456789">
                            </div>

                            <!-- Email -->
                            <div>
                                <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Correo Electrónico <span class="text-red-500">*</span>
                                </label>
                                <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="username"
                                       class="block w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all"
                                       placeholder="juan@example.com">
                            </div>

                            <!-- Teléfono -->
                            <div>
                                <label for="telefono" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Teléfono <span class="text-red-500">*</span>
                                </label>
                                <input id="telefono" type="tel" name="telefono" value="{{ old('telefono') }}" required
                                       class="block w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all"
                                       placeholder="+57 300 123 4567">
                            </div>

                            <!-- Password -->
                            <div>
                                <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Contraseña <span class="text-red-500">*</span>
                                </label>
                                <input id="password" type="password" name="password" required autocomplete="new-password"
                                       class="block w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all"
                                       placeholder="••••••••">
                            </div>

                            <!-- Confirm Password -->
                            <div>
                                <label for="password_confirmation" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Confirmar Contraseña <span class="text-red-500">*</span>
                                </label>
                                <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password"
                                       class="block w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all"
                                       placeholder="••••••••">
                            </div>
                        </div>
                    </div>

                    @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
                        <div class="mb-6">
                            <label for="terms" class="flex items-start">
                                <input type="checkbox" name="terms" id="terms" required class="rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500 h-4 w-4 mt-1">
                                <span class="ml-3 text-sm text-gray-600">
                                    {!! __('Acepto los :terms_of_service y la :privacy_policy', [
                                            'terms_of_service' => '<a target="_blank" href="'.route('terms.show').'" class="text-blue-600 hover:text-blue-700 font-medium underline">'.__('Términos de Servicio').'</a>',
                                            'privacy_policy' => '<a target="_blank" href="'.route('policy.show').'" class="text-blue-600 hover:text-blue-700 font-medium underline">'.__('Política de Privacidad').'</a>',
                                    ]) !!}
                                </span>
                            </label>
                        </div>
                    @endif

                    <!-- Submit Button -->
                    <button type="submit" class="w-full bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-semibold py-3 px-4 rounded-lg shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200">
                        Crear Cuenta
                    </button>
                </form>
            </div>

            <!-- Login Link -->
            <div class="px-8 py-6 bg-gray-50 border-t border-gray-100">
                <p class="text-center text-sm text-gray-600">
                    ¿Ya tienes una cuenta?
                    <a href="{{ route('login') }}" class="font-semibold text-blue-600 hover:text-blue-700 transition-colors">
                        Inicia sesión aquí
                    </a>
                </p>
            </div>
        </div>

        <!-- Back to Home -->
        <div class="text-center mt-6">
            <a href="/" class="inline-flex items-center text-blue-200 hover:text-white transition-colors">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Volver al inicio
            </a>
        </div>
    </div>
</x-guest-layout>
