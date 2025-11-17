<x-secretaria-layout>
    <div class="w-full max-w-xl p-6 bg-white rounded shadow">
        <h2 class="text-2xl font-bold mb-4">Registro de Persona</h2>

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

        <form action="{{ route('secretaria.persona.store') }}" method="POST" class="space-y-4">
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
                <input type="text" name="telefono" id="telefono" value="{{ old('telefono') }}" class="mt-1 block w-full p-2 border border-gray-300 rounded">
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

                <!-- Contraseña automática -->
                <div class="bg-green-50 border-l-4 border-green-500 p-4 rounded-r-lg">
                    <div class="flex items-start">
                        <svg class="w-5 h-5 text-green-600 mr-3 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                        </svg>
                        <div>
                            <p class="text-sm font-semibold text-green-800">Contraseña automática</p>
                            <p class="text-xs text-green-700 mt-1">La contraseña inicial será el número de CI.</p>
                        </div>
                    </div>
                </div>

                <!-- Código automático para estudiantes -->
                <div id="codigo-info" class="bg-purple-50 border-l-4 border-purple-500 p-4 rounded-r-lg hidden">
                    <div class="flex items-start">
                        <svg class="w-5 h-5 text-purple-600 mr-3 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 2a1 1 0 011 1v1.323l3.954 1.582 1.599-.8a1 1 0 01.894 1.79l-1.233.616 1.738 5.42a1 1 0 01-.285 1.05A3.989 3.989 0 0115 15a3.989 3.989 0 01-2.667-1.019 1 1 0 01-.285-1.05l1.715-5.349L11 6.477V16h2a1 1 0 110 2H7a1 1 0 110-2h2V6.477L6.237 7.582l1.715 5.349a1 1 0 01-.285 1.05A3.989 3.989 0 015 15a3.989 3.989 0 01-2.667-1.019 1 1 0 01-.285-1.05l1.738-5.42-1.233-.617a1 1 0 01.894-1.788l1.599.799L9 4.323V3a1 1 0 011-1zm-5 8.274l-.818 2.552c.25.112.526.174.818.174.292 0 .569-.062.818-.174L5 10.274zm10 0l-.818 2.552c.25.112.526.174.818.174.292 0 .569-.062.818-.174L15 10.274z" clip-rule="evenodd"></path>
                        </svg>
                        <div>
                            <p class="text-sm font-semibold text-purple-800">Código de estudiante automático</p>
                            <p class="text-xs text-purple-700 mt-1">Se generará automáticamente (EST-0001, EST-0002, etc.)</p>
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
                <label class="block text-gray-700 font-semibold mb-3">Tipo de Persona:</label>
                <div class="grid grid-cols-2 gap-4 bg-gray-50 p-4 rounded-lg border border-gray-200">
                    <div>
                        <label class="inline-flex items-center cursor-pointer">
                            <input type="radio" name="tipo_persona" value="estudiante" {{ old('tipo_persona') == 'estudiante' ? 'checked' : '' }} 
                                   class="w-4 h-4 text-blue-600 focus:ring-blue-500" required>
                            <span class="ml-2 text-gray-700">Estudiante</span>
                        </label>
                    </div>
                    <div>
                        <label class="inline-flex items-center cursor-pointer">
                            <input type="radio" name="tipo_persona" value="tutor" {{ old('tipo_persona') == 'tutor' ? 'checked' : '' }}
                                   class="w-4 h-4 text-blue-600 focus:ring-blue-500" required>
                            <span class="ml-2 text-gray-700">Tutor</span>
                        </label>
                    </div>
                </div>
            </div>

            <!-- Asignar Tutor (Solo si es estudiante) -->
            <div id="tutorSection" style="display: none;">
                <label for="citutor" class="block text-gray-700">Tutor (Padre/Madre):</label>
                <select name="citutor" id="citutor" class="mt-1 block w-full p-2 border border-gray-300 rounded">
                    <option value="">Seleccione un tutor...</option>
                    @foreach($tutores as $tutor)
                        <option value="{{ $tutor->ci }}" {{ old('citutor') === $tutor->ci ? 'selected' : '' }}>
                            {{ $tutor->nombre }} {{ $tutor->apellido }} (CI: {{ $tutor->ci }})
                        </option>
                    @endforeach
                </select>
                @error('citutor')
                    <div class="text-red-600">{{ $message }}</div>
                @enderror
                <p class="text-xs text-gray-500 mt-1">Todo estudiante debe tener un tutor asignado</p>
            </div>

            <div class="flex items-center gap-3 pt-2">
                <a href="{{ route('secretaria.persona.index') }}" class="px-3 py-2 bg-gray-200 rounded">Cancelar</a>
                <button type="submit" class="px-3 py-2 bg-blue-600 hover:bg-blue-500 text-white rounded">Registrar</button>
            </div>
        </form>
    </div>

    <script>
        // Control de visibilidad de sección de tutor y código según tipo de persona
        document.addEventListener('DOMContentLoaded', function() {
            const radioButtons = document.querySelectorAll('input[name="tipo_persona"]');
            const tutorSection = document.getElementById('tutorSection');
            const codigoInfo = document.getElementById('codigo-info');
            const citutor = document.getElementById('citutor');

            function toggleSections() {
                const tipoSeleccionado = document.querySelector('input[name="tipo_persona"]:checked');
                
                if (tipoSeleccionado && tipoSeleccionado.value === 'estudiante') {
                    // Mostrar sección de tutor y código
                    tutorSection.style.display = 'block';
                    codigoInfo.classList.remove('hidden');
                    citutor.required = true;
                } else {
                    // Ocultar sección de tutor y código
                    tutorSection.style.display = 'none';
                    codigoInfo.classList.add('hidden');
                    citutor.required = false;
                    citutor.value = '';
                }
            }

            // Ejecutar al cargar
            toggleSections();

            // Ejecutar al cambiar radio button
            radioButtons.forEach(radio => {
                radio.addEventListener('change', toggleSections);
            });
        });
    </script>
</x-secretaria-layout>
