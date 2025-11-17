<x-admin-layout>
    <div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 py-8 px-4 sm:px-6 lg:px-8">
        <div class="max-w-4xl mx-auto">
            <!-- Header -->
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-900 mb-2">Editar Persona</h1>
                <p class="text-gray-600">Actualiza la información de la persona</p>
            </div>

            <!-- Errores -->
            @if ($errors->any())
                <div class="mb-6 bg-red-50 border-l-4 border-red-500 rounded-r-lg p-4 shadow-sm">
                    <div class="flex items-start">
                        <svg class="w-5 h-5 text-red-500 mt-0.5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                        </svg>
                        <div class="flex-1">
                            <h3 class="text-sm font-semibold text-red-800 mb-1">Se encontraron errores:</h3>
                            <ul class="list-disc list-inside text-sm text-red-700 space-y-1">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Formulario -->
            <form action="{{ route('admin.persona.update', $persona->ci) }}" method="POST" class="bg-white rounded-xl shadow-lg p-8 space-y-6">
                @csrf
                @method('PUT')

                <!-- CI (solo lectura) -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">CI</label>
                    <input type="text" value="{{ $persona->ci }}" class="w-full px-4 py-3 bg-gray-50 border border-gray-300 rounded-lg text-gray-500 cursor-not-allowed" disabled>
                </div>

                <!-- Nombre -->
                <div>
                    <label for="nombre" class="block text-sm font-medium text-gray-700 mb-2">Nombre</label>
                    <input type="text" name="nombre" id="nombre" value="{{ $persona->nombre }}" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" required>
                </div>

                <!-- Apellido -->
                <div>
                    <label for="apellido" class="block text-sm font-medium text-gray-700 mb-2">Apellido</label>
                    <input type="text" name="apellido" id="apellido" value="{{ $persona->apellido }}" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" required>
                </div>

                <!-- Teléfono -->
                <div>
                    <label for="telefono" class="block text-sm font-medium text-gray-700 mb-2">Teléfono</label>
                    <input type="text" name="telefono" id="telefono" value="{{ $persona->telefono }}" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" required>
                </div>

                <!-- Correo (solo lectura) -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Correo Institucional</label>
                    <div class="bg-green-50 border border-green-300 rounded-lg p-3">
                        <div class="flex items-center gap-2">
                            <svg class="w-5 h-5 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"></path>
                                <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"></path>
                            </svg>
                            <span class="text-green-700 font-semibold">{{ $persona->correo }}</span>
                        </div>
                    </div>
                    <p class="text-xs text-gray-500 mt-1">Generado automáticamente • No editable</p>
                    <!-- Campo oculto para enviar correo -->
                    <input type="hidden" name="correo" value="{{ $persona->correo }}">
                </div>

                <!-- Sexo -->
                <div>
                    <label for="sexo" class="block text-sm font-medium text-gray-700 mb-2">Sexo</label>
                    <select name="sexo" id="sexo" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" required>
                        <option value="">Seleccione...</option>
                        <option value="M" {{ $persona->sexo == 'M' ? 'selected' : '' }}>Masculino</option>
                        <option value="F" {{ $persona->sexo == 'F' ? 'selected' : '' }}>Femenino</option>
                    </select>
                </div>

                <!-- Contraseña (solo lectura) - Solo para usuarios (admin, secretaria, tutor) -->
                @if($persona->tipou == '1')
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Contraseña</label>
                    <div class="bg-gray-50 border border-gray-300 rounded-lg p-4">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                </svg>
                                <div>
                                    <p class="text-sm text-gray-700">Contraseña actual: <span id="password-display" class="font-mono font-bold text-green-600">{{ $persona->contrasena }}</span></p>
                                    <p class="text-xs text-gray-500 mt-1">El usuario puede cambiarla desde su perfil</p>
                                </div>
                            </div>
                            <button type="button" onclick="restablecerContrasena()" class="px-4 py-2 bg-green-500 hover:bg-green-600 text-white rounded-lg text-sm font-medium transition-colors flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                </svg>
                                Restablecer al CI
                            </button>
                        </div>
                    </div>
                    <!-- Campo oculto para enviar contraseña -->
                    <input type="hidden" name="contrasena" id="contrasena" value="{{ $persona->contrasena }}">
                </div>
                @else
                <div>
                    <div class="bg-gray-100 border border-gray-300 rounded-lg p-3">
                        <p class="text-sm text-gray-600">
                            <svg class="w-4 h-4 inline mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                            </svg>
                            Sin contraseña (no es usuario del sistema)
                        </p>
                    </div>
                    <input type="hidden" name="contrasena" value="">
                </div>
                @endif

                <!-- Tipos (roles) - Solo lectura -->
                <div>
                    <span class="block text-sm font-medium text-gray-700 mb-3">Roles Asignados:</span>
                    <div class="flex flex-wrap gap-2">
                        @if($persona->tipou == '1')
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                                </svg>
                                Usuario
                            </span>
                            <input type="hidden" name="tipou" value="1">
                        @else
                            <input type="hidden" name="tipou" value="0">
                        @endif

                        @if($persona->tipoe == '1')
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3zM3.31 9.397L5 10.12v4.102a8.969 8.969 0 00-1.05-.174 1 1 0 01-.89-.89 11.115 11.115 0 01.25-3.762zM9.3 16.573A9.026 9.026 0 007 14.935v-3.957l1.818.78a3 3 0 002.364 0l5.508-2.361a11.026 11.026 0 01.25 3.762 1 1 0 01-.89.89 8.968 8.968 0 00-5.35 2.524 1 1 0 01-1.4 0zM6 18a1 1 0 001-1v-2.065a8.935 8.935 0 00-2-.712V17a1 1 0 001 1z"/>
                                </svg>
                                Estudiante
                            </span>
                            <input type="hidden" name="tipoe" value="1">
                        @else
                            <input type="hidden" name="tipoe" value="0">
                        @endif

                        @if($persona->tipot == '1')
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-purple-100 text-purple-800">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"/>
                                </svg>
                                Tutor
                            </span>
                            <input type="hidden" name="tipot" value="1">
                        @else
                            <input type="hidden" name="tipot" value="0">
                        @endif

                        @if($persona->tipom == '1')
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-indigo-100 text-indigo-800">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                                </svg>
                                Maestro
                            </span>
                            <input type="hidden" name="tipom" value="1">
                        @else
                            <input type="hidden" name="tipom" value="0">
                        @endif

                        @if($persona->tipoa == '1')
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.533 1.533 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.533 1.533 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd"/>
                                </svg>
                                Admin
                            </span>
                            <input type="hidden" name="tipoa" value="1">
                        @else
                            <input type="hidden" name="tipoa" value="0">
                        @endif

                        @if($persona->tipos == '1')
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M6 6V5a3 3 0 013-3h2a3 3 0 013 3v1h2a2 2 0 012 2v3.57A22.952 22.952 0 0110 13a22.95 22.95 0 01-8-1.43V8a2 2 0 012-2h2zm2-1a1 1 0 011-1h2a1 1 0 011 1v1H8V5zm1 5a1 1 0 011-1h.01a1 1 0 110 2H10a1 1 0 01-1-1z" clip-rule="evenodd"/>
                                    <path d="M2 13.692V16a2 2 0 002 2h12a2 2 0 002-2v-2.308A24.974 24.974 0 0110 15c-2.796 0-5.487-.46-8-1.308z"/>
                                </svg>
                                Secretaría
                            </span>
                            <input type="hidden" name="tipos" value="1">
                        @else
                            <input type="hidden" name="tipos" value="0">
                        @endif
                    </div>
                    <p class="text-xs text-gray-500 mt-2">Los roles no se pueden modificar desde aquí</p>
                </div>

                <!-- Códigos (dinámicos según rol) -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <!-- Código Estudiante - Solo visible si es estudiante -->
                    <div id="codestudiante-container" class="hidden">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Código Estudiante</label>
                        <div class="bg-gray-50 border border-gray-300 rounded-lg p-3">
                            <p class="text-sm text-gray-700 font-mono">{{ $persona->codestudiante ?? 'Se generará automáticamente' }}</p>
                        </div>
                        <input type="hidden" name="codestudiante" value="{{ $persona->codestudiante ?? '' }}">
                    </div>
                    
                    <!-- Código Maestro - Solo visible si es maestro -->
                    <div id="codmaestro-container" class="hidden">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Código Maestro</label>
                        <div class="bg-gray-50 border border-gray-300 rounded-lg p-3">
                            <p class="text-sm text-gray-700 font-mono">{{ $persona->codmaestro ?? 'Se generará automáticamente' }}</p>
                        </div>
                        <input type="hidden" name="codmaestro" value="{{ $persona->codmaestro ?? '' }}">
                    </div>
                </div>

                <!-- Botón -->
                <div class="flex items-center justify-end gap-4 pt-6 border-t border-gray-200">
                    <a href="{{ route('admin.persona.index') }}" class="px-6 py-3 bg-gray-200 hover:bg-gray-300 text-gray-700 font-medium rounded-lg transition-colors">
                        Cancelar
                    </a>
                    <button type="submit" class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors shadow-md hover:shadow-lg">
                        Actualizar Persona
                    </button>
                </div>
            </form>
        </div>
    </div>
        <script>
            // Mostrar códigos según roles al cargar la página
            const codestudianteContainer = document.getElementById('codestudiante-container');
            const codmaestroContainer = document.getElementById('codmaestro-container');

            // Verificar roles desde PHP
            const esEstudiante = {{ $persona->tipoe == '1' ? 'true' : 'false' }};
            const esMaestro = {{ $persona->tipom == '1' ? 'true' : 'false' }};

            // Mostrar códigos si corresponde
            if (esEstudiante && codestudianteContainer) {
                codestudianteContainer.classList.remove('hidden');
            }

            if (esMaestro && codmaestroContainer) {
                codmaestroContainer.classList.remove('hidden');
            }

            // Función para restablecer contraseña al CI
            function restablecerContrasena() {
                const ci = '{{ $persona->ci }}';
                const contrasenaInput = document.getElementById('contrasena');
                const passwordDisplay = document.getElementById('password-display');
                
                if (confirm('¿Está seguro de restablecer la contraseña al número de CI (' + ci + ')?')) {
                    // Actualizar el campo oculto
                    contrasenaInput.value = ci;
                    
                    // Actualizar la visualización de la contraseña
                    if (passwordDisplay) {
                        passwordDisplay.textContent = ci;
                        // Añadir efecto de parpadeo
                        passwordDisplay.classList.add('animate-pulse');
                        setTimeout(() => {
                            passwordDisplay.classList.remove('animate-pulse');
                        }, 1000);
                    }
                    
                    // Mostrar mensaje de confirmación
                    const mensaje = document.createElement('div');
                    mensaje.className = 'fixed top-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg z-50';
                    mensaje.innerHTML = `
                        <div class="flex items-center gap-2">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                            <span>Contraseña restablecida al CI. Guarde los cambios.</span>
                        </div>
                    `;
                    document.body.appendChild(mensaje);
                    
                    setTimeout(() => {
                        mensaje.remove();
                    }, 3000);
                }
            }
        </script>
    </div>
</x-admin-layout>
