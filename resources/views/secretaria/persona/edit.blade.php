<x-secretaria-layout>
    <div class="w-full max-w-xl p-6 bg-white rounded shadow">
        <h2 class="text-2xl font-bold mb-4">Editar Persona</h2>
        <p class="text-gray-600 mb-4">{{ $persona->nombre }} {{ $persona->apellido }} (CI: {{ $persona->ci }})</p>

        <!-- Mensajes de error -->
        @if ($errors->any())
            <div class="mb-4 bg-red-50 border-l-4 border-red-500 p-4 rounded-r-lg shadow-sm">
                <div class="flex items-start">
                    <svg class="w-6 h-6 text-red-500 mr-3 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                    </svg>
                    <div class="flex-1">
                        <p class="text-red-800 font-semibold mb-2">Error al actualizar</p>
                        <ul class="list-disc list-inside text-red-700 text-sm space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif

        <form action="{{ route('secretaria.persona.update', $persona->ci) }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')

            <!-- Campos NO editables -->
            @if($persona->codestudiante)
            <div>
                <label class="block text-gray-700">Código:</label>
                <input type="text" value="{{ $persona->codestudiante }}" disabled class="mt-1 block w-full p-2 border border-gray-300 rounded bg-gray-50 text-gray-500">
            </div>
            @endif
            
            <div>
                <label class="block text-gray-700">Correo:</label>
                <input type="text" value="{{ $persona->correo }}" disabled class="mt-1 block w-full p-2 border border-gray-300 rounded bg-gray-50 text-gray-500">
            </div>

            <!-- Nombre -->
            <div>
                <label for="nombre" class="block text-gray-700">Nombre:</label>
                <input type="text" name="nombre" id="nombre" value="{{ old('nombre', $persona->nombre) }}" required class="mt-1 block w-full p-2 border border-gray-300 rounded">
                @error('nombre')
                    <div class="text-red-600">{{ $message }}</div>
                @enderror
            </div>

            <!-- Apellido -->
            <div>
                <label for="apellido" class="block text-gray-700">Apellido:</label>
                <input type="text" name="apellido" id="apellido" value="{{ old('apellido', $persona->apellido) }}" required class="mt-1 block w-full p-2 border border-gray-300 rounded">
                @error('apellido')
                    <div class="text-red-600">{{ $message }}</div>
                @enderror
            </div>

            <!-- Teléfono -->
            <div>
                <label for="telefono" class="block text-gray-700">Teléfono:</label>
                <input type="text" name="telefono" id="telefono" value="{{ old('telefono', $persona->telefono) }}" class="mt-1 block w-full p-2 border border-gray-300 rounded">
                @error('telefono')
                    <div class="text-red-600">{{ $message }}</div>
                @enderror
            </div>

            <!-- Sexo -->
            <div>
                <label for="sexo" class="block text-gray-700">Sexo:</label>
                <select name="sexo" id="sexo" required class="mt-1 block w-full p-2 border border-gray-300 rounded">
                    <option value="M" {{ old('sexo', $persona->sexo) === 'M' ? 'selected' : '' }}>Masculino</option>
                    <option value="F" {{ old('sexo', $persona->sexo) === 'F' ? 'selected' : '' }}>Femenino</option>
                </select>
                @error('sexo')
                    <div class="text-red-600">{{ $message }}</div>
                @enderror
            </div>

            <!-- Restablecer Contraseña (Solo si es tutor/usuario) -->
            @if($persona->tipot === '1')
            <div>
                <label class="block text-gray-700">Contraseña:</label>
                <div class="mt-1 flex items-center gap-3">
                    <input type="text" value="••••••••" disabled class="flex-1 p-2 border border-gray-300 rounded bg-gray-50 text-gray-500">
                    <form action="{{ route('secretaria.persona.restablecer', $persona->ci) }}" method="POST" class="inline"
                          onsubmit="return confirm('¿Restablecer contraseña a: {{ $persona->ci }}?');">
                        @csrf
                        <button type="submit" class="px-3 py-2 bg-blue-600 hover:bg-blue-500 text-white rounded">
                            Restablecer
                        </button>
                    </form>
                </div>
                <p class="text-xs text-gray-500 mt-1">La contraseña se restablecerá al número de CI</p>
            </div>
            @endif

            <!-- Tutor (Solo si es estudiante) -->
            @if($persona->tipoe === '1')
            <div>
                <label for="citutor" class="block text-gray-700">Tutor (Padre/Madre):</label>
                @if($tutorActual)
                    <p class="text-sm text-gray-600 mb-1">Actual: {{ $tutorActual->nombre }} {{ $tutorActual->apellido }}</p>
                @endif
                <select name="citutor" id="citutor" required class="mt-1 block w-full p-2 border border-gray-300 rounded">
                    <option value="">Seleccione un tutor...</option>
                    @foreach($tutores as $tutor)
                        <option value="{{ $tutor->ci }}" {{ (old('citutor', $tutorActual->ci ?? '') === $tutor->ci) ? 'selected' : '' }}>
                            {{ $tutor->nombre }} {{ $tutor->apellido }} (CI: {{ $tutor->ci }})
                        </option>
                    @endforeach
                </select>
                @error('citutor')
                    <div class="text-red-600">{{ $message }}</div>
                @enderror
            </div>
            @endif

            <!-- Botones -->
            <div class="flex items-center gap-3 pt-2">
                <a href="{{ route('secretaria.persona.index', ['tipo' => $persona->tipoe === '1' ? 'estudiantes' : 'tutores']) }}" class="px-3 py-2 bg-gray-200 rounded">Cancelar</a>
                <button type="submit" class="px-3 py-2 bg-blue-600 hover:bg-blue-500 text-white rounded">Guardar</button>
            </div>
        </form>
    </div>
</x-secretaria-layout>
