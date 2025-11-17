<x-tutor-layout>
    <div class="space-y-6">
        <!-- Header -->
        <div class="bg-gradient-to-r from-green-600 to-emerald-600 rounded-xl shadow-lg p-8 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-4xl font-bold mb-2">Cambiar Contraseña</h1>
                    <p class="text-green-100 text-lg">Actualiza tu contraseña de acceso</p>
                </div>
                <div class="hidden md:block">
                    <svg class="w-20 h-20 text-green-200 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Mensajes -->
        @if(session('error'))
            <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded-r-lg">
                <div class="flex items-center">
                    <svg class="w-5 h-5 text-red-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                    </svg>
                    <p class="text-red-700 font-medium">{{ session('error') }}</p>
                </div>
            </div>
        @endif

        @if($errors->any())
            <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded-r-lg">
                <div class="flex items-start">
                    <svg class="w-5 h-5 text-red-500 mr-3 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                    </svg>
                    <div>
                        <p class="text-red-700 font-medium mb-2">Por favor corrige los siguientes errores:</p>
                        <ul class="list-disc list-inside text-red-600 space-y-1">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif

        <!-- Formulario -->
        <div class="bg-white rounded-xl shadow-md p-8 max-w-2xl mx-auto">
            <form action="{{ route('tutor.perfil.actualizar-contrasena') }}" method="POST">
                @csrf
                @method('PUT')

                <div class="space-y-6">
                    <!-- Contraseña Actual -->
                    <div>
                        <label for="contrasena_actual" class="block text-sm font-semibold text-gray-700 mb-2">
                            Contraseña Actual <span class="text-red-500">*</span>
                        </label>
                        <input type="password" id="contrasena_actual" name="contrasena_actual" required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all @error('contrasena_actual') border-red-500 @enderror">
                        @error('contrasena_actual')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Nueva Contraseña -->
                    <div>
                        <label for="contrasena_nueva" class="block text-sm font-semibold text-gray-700 mb-2">
                            Nueva Contraseña <span class="text-red-500">*</span>
                        </label>
                        <input type="password" id="contrasena_nueva" name="contrasena_nueva" required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all @error('contrasena_nueva') border-red-500 @enderror">
                        <p class="text-xs text-gray-500 mt-1">Mínimo 6 caracteres</p>
                        @error('contrasena_nueva')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Confirmar Nueva Contraseña -->
                    <div>
                        <label for="contrasena_nueva_confirmation" class="block text-sm font-semibold text-gray-700 mb-2">
                            Confirmar Nueva Contraseña <span class="text-red-500">*</span>
                        </label>
                        <input type="password" id="contrasena_nueva_confirmation" name="contrasena_nueva_confirmation" required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all">
                        <p class="text-xs text-gray-500 mt-1">Debe coincidir con la nueva contraseña</p>
                    </div>
                </div>

                <!-- Botones -->
                <div class="flex items-center justify-end gap-4 mt-8 pt-6 border-t border-gray-200">
                    <a href="{{ route('tutor.perfil.index') }}" 
                        class="px-6 py-3 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-colors font-medium">
                        Cancelar
                    </a>
                    <button type="submit" 
                        class="px-6 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors font-medium flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Actualizar Contraseña
                    </button>
                </div>
            </form>

            <!-- Información de Seguridad -->
            <div class="mt-8 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                <div class="flex items-start gap-3">
                    <svg class="w-5 h-5 text-blue-600 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                    </svg>
                    <div>
                        <h3 class="text-sm font-semibold text-blue-900 mb-1">Consejos de Seguridad</h3>
                        <ul class="text-xs text-blue-800 space-y-1">
                            <li>• Usa una contraseña única que no uses en otros sitios</li>
                            <li>• Combina letras mayúsculas, minúsculas, números y símbolos</li>
                            <li>• Evita usar información personal fácil de adivinar</li>
                            <li>• Cambia tu contraseña regularmente</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-tutor-layout>
