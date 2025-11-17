<x-admin-layout>
    <div class="w-full max-w-xl p-6 bg-white rounded shadow">
        <h2 class="text-2xl font-bold mb-4">Registro de Persona</h2>

        <!-- Mensaje de éxito -->
        @if (session('success'))
            <div class="mb-4 bg-green-50 border-l-4 border-green-500 p-4 rounded-r-lg shadow-sm animate-fade-in">
                <div class="flex items-center">
                    <svg class="w-6 h-6 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                    </svg>
                    <div>
                        <p class="text-green-800 font-semibold">¡Registro exitoso!</p>
                        <p class="text-green-700 text-sm">{{ session('success') }}</p>
                    </div>
                </div>
            </div>
        @endif

        <!-- Mensajes de error -->
        @if ($errors->any())
            <div class="mb-4 bg-red-50 border-l-4 border-red-500 p-4 rounded-r-lg shadow-sm">
                <div class="flex items-start">
                    <svg class="w-6 h-6 text-red-500 mr-3 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                    </svg>
                    <div class="flex-1">
                        <p class="text-red-800 font-semibold mb-2">Error al registrar</p>
                        <ul class="list-disc list-inside text-red-700 text-sm space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif

        <form action="{{ route('admin.persona.store') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label for="ci" class="block text-gray-700">CI:</label>
                <input type="text" name="ci" id="ci" value="{{ old('ci') }}" class="mt-1 block w-full p-2 border border-gray-300 rounded" required>
                @error('ci')
                    <div class="text-red-600">{{ $message }}</div>
                @enderror
            </div>
            <div>
                <label for="nombre" class="block text-gray-700">Nombre:</label>
                <input type="text" name="nombre" id="nombre" value="{{ old('nombre') }}" class="mt-1 block w-full p-2 border border-gray-300 rounded" required>
                @error('nombre')
                    <div class="text-red-600">{{ $message }}</div>
                @enderror
            </div>
            <div>
                <label for="apellido" class="block text-gray-700">Apellido:</label>
                <input type="text" name="apellido" id="apellido" value="{{ old('apellido') }}" class="mt-1 block w-full p-2 border border-gray-300 rounded" required>
                @error('apellido')
                    <div class="text-red-600">{{ $message }}</div>
                @enderror
            </div>
            <div>
                <label for="telefono" class="block text-gray-700">Telefono:</label>
                <input type="text" name="telefono" id="telefono" value="{{ old('telefono') }}" class="mt-1 block w-full p-2 border border-gray-300 rounded" required>
                @error('telefono')
                    <div class="text-red-600">{{ $message }}</div>
                @enderror
            </div>
            <!-- Mensajes informativos automáticos -->
            <div class="space-y-3">
                <!-- Correo automático -->
                <div class="bg-blue-50 border-l-4 border-blue-500 p-4 rounded-r-lg">
                    <div class="flex items-start">
                        <svg class="w-5 h-5 text-blue-600 mr-3 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"></path>
                            <path fill-rule="evenodd" d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"></path>
                        </svg>
                        <div>
                            <p class="text-sm font-semibold text-blue-800">Correo automático</p>
                            <p class="text-xs text-blue-700 mt-1">El correo se generará automáticamente: nombre.apellido@escuelacristiana.edu.bo</p>
                        </div>
                    </div>
                </div>

                <!-- Contraseña automática (solo para usuarios) -->
                <div id="password-info" class="bg-green-50 border-l-4 border-green-500 p-4 rounded-r-lg hidden">
                    <div class="flex items-start">
                        <svg class="w-5 h-5 text-green-600 mr-3 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                        </svg>
                        <div>
                            <p class="text-sm font-semibold text-green-800">Contraseña automática</p>
                            <p class="text-xs text-green-700 mt-1">La contraseña inicial será el número de CI. El usuario podrá cambiarla desde su perfil.</p>
                        </div>
                    </div>
                </div>
            </div>

            <div>
                <label for="sexo" class="block text-gray-700">Sexo:</label>
                <select name="sexo" id="sexo" class="mt-1 block w-full p-2 border border-gray-300 rounded" required>
                    <option value="">Seleccione...</option>
                    <option value="M" {{ old('sexo') == 'M' ? 'selected' : '' }}>Masculino</option>
                    <option value="F" {{ old('sexo') == 'F' ? 'selected' : '' }}>Femenino</option>
                </select>
                @error('sexo')
                    <div class="text-red-600">{{ $message }}</div>
                @enderror
            </div>

            <div>
                <label class="block text-gray-700 font-semibold mb-3">Roles del Usuario:</label>
                <div class="grid grid-cols-2 sm:grid-cols-3 gap-4 bg-gray-50 p-4 rounded-lg border border-gray-200">
                    <!-- Usuario - Solo visible para Admin, Secretaria o Tutor -->
                    <div id="usuario-container" class="hidden">
                        <label class="inline-flex items-center cursor-pointer">
                            <input id="tipou" type="checkbox" name="tipou" value="1"
                                   class="w-4 h-4 text-green-600 rounded focus:ring-green-500" disabled>
                            <span class="ml-2 text-gray-700 font-medium">Usuario</span>
                        </label>
                        <p class="text-xs text-gray-500 ml-6">Acceso al sistema</p>
                    </div>
                    <div>
                        <label class="inline-flex items-center cursor-pointer">
                            <input id="tipoe" type="checkbox" name="tipoe" value="1" {{ old('tipoe') ? 'checked' : '' }} 
                                   class="w-4 h-4 text-blue-600 rounded focus:ring-blue-500">
                            <span class="ml-2 text-gray-700">Estudiante</span>
                        </label>
                    </div>
                    <div>
                        <label class="inline-flex items-center cursor-pointer">
                            <input id="tipot" type="checkbox" name="tipot" value="1" {{ old('tipot') ? 'checked' : '' }}
                                   class="w-4 h-4 text-blue-600 rounded focus:ring-blue-500">
                            <span class="ml-2 text-gray-700">Tutor</span>
                        </label>
                    </div>
                    <div>
                        <label class="inline-flex items-center cursor-pointer">
                            <input id="tipom" type="checkbox" name="tipom" value="1" {{ old('tipom') ? 'checked' : '' }}
                                   class="w-4 h-4 text-blue-600 rounded focus:ring-blue-500">
                            <span class="ml-2 text-gray-700">Maestro</span>
                        </label>
                    </div>
                    <div>
                        <label class="inline-flex items-center cursor-pointer">
                            <input id="tipoa" type="checkbox" name="tipoa" value="1" {{ old('tipoa') ? 'checked' : '' }}
                                   class="w-4 h-4 text-blue-600 rounded focus:ring-blue-500">
                            <span class="ml-2 text-gray-700">Admin</span>
                        </label>
                    </div>
                    <div>
                        <label class="inline-flex items-center cursor-pointer">
                            <input id="tipos" type="checkbox" name="tipos" value="1" {{ old('tipos') ? 'checked' : '' }}
                                   class="w-4 h-4 text-blue-600 rounded focus:ring-blue-500">
                            <span class="ml-2 text-gray-700">Secretaría</span>
                        </label>
                    </div>
                </div>
            </div>

            <!-- Alertas de reglas de roles -->
            <div id="role-alert" class="hidden bg-yellow-50 border-l-4 border-yellow-400 p-4 rounded-r-lg">
                <div class="flex items-start">
                    <svg class="w-5 h-5 text-yellow-400 mr-3 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                    </svg>
                    <p id="role-alert-text" class="text-sm text-yellow-700 font-medium"></p>
                </div>
            </div>

            <div class="flex items-center gap-3 pt-2">
                <a href="{{ route('admin.persona.index') }}" class="px-3 py-2 bg-gray-200 rounded">Cancelar</a>
                <button type="submit" class="px-3 py-2 bg-blue-600 hover:bg-blue-500 text-white rounded">Registrar</button>
            </div>
        </form>
        <script>
            // Validación de reglas de roles en tiempo real
            const usuarioContainer = document.getElementById('usuario-container');
            const tipou = document.getElementById('tipou');
            const tipoe = document.getElementById('tipoe');
            const tipot = document.getElementById('tipot');
            const tipoa = document.getElementById('tipoa');
            const tipos = document.getElementById('tipos');
            const roleAlert = document.getElementById('role-alert');
            const roleAlertText = document.getElementById('role-alert-text');
            const passwordInfo = document.getElementById('password-info');

            function validateRoles() {
                let message = '';
                let hasConflict = false;

                // Mostrar/ocultar checkbox Usuario SOLO para Admin, Secretaria o Tutor
                if (tipoa.checked || tipos.checked || tipot.checked) {
                    usuarioContainer.classList.remove('hidden');
                    tipou.checked = true;
                    tipou.disabled = false;
                    // Mostrar mensaje de contraseña automática
                    passwordInfo.classList.remove('hidden');
                } else {
                    usuarioContainer.classList.add('hidden');
                    tipou.checked = false;
                    tipou.disabled = true;
                    // Ocultar mensaje de contraseña automática
                    passwordInfo.classList.add('hidden');
                }

                // Regla 1: Estudiante no puede ser tutor
                if (tipoe.checked && tipot.checked) {
                    message = '⚠️ Un estudiante no puede ser tutor';
                    hasConflict = true;
                    tipot.checked = false;
                }

                // Regla 2: Admin no puede ser estudiante
                if (tipoa.checked && tipoe.checked) {
                    message = '⚠️ Un administrador no puede ser estudiante';
                    hasConflict = true;
                    tipoe.checked = false;
                }

                // Mostrar/ocultar alerta
                if (hasConflict) {
                    roleAlertText.textContent = message;
                    roleAlert.classList.remove('hidden');
                    setTimeout(() => {
                        roleAlert.classList.add('hidden');
                    }, 4000);
                } else {
                    roleAlert.classList.add('hidden');
                }
            }

            // Agregar listeners a todos los checkboxes
            [tipoe, tipot, tipoa, tipos].forEach(checkbox => {
                checkbox.addEventListener('change', validateRoles);
            });

            // Ejecutar validación inicial
            validateRoles();
        </script>
    </div>
</x-admin-layout>
