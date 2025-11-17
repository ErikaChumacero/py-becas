<x-admin-layout>
    <div class="max-w-6xl mx-auto space-y-6">
        <!-- Header -->
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.inscripcion.index') }}"
               class="inline-flex items-center justify-center w-10 h-10 rounded-lg bg-gray-100 hover:bg-gray-200 transition-colors">
                <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
            </a>
            <div>
                <h1 class="text-3xl font-bold text-gray-800">Nueva Inscripción</h1>
                <p class="text-gray-600 mt-1">Registra un estudiante en un curso</p>
            </div>
        </div>

        <!-- Formulario -->
        <div class="bg-white rounded-lg shadow-md p-8">
            <form action="{{ route('admin.inscripcion.store') }}" method="POST" class="space-y-6">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Estudiante -->
                    <div>
                        <label for="ci" class="block text-sm font-semibold text-gray-700 mb-2">
                            Estudiante <span class="text-red-500">*</span>
                        </label>
                        <select name="ci" id="ci" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent @error('ci') border-red-500 @enderror">
                            <option value="">Seleccione un estudiante</option>
                            @foreach($estudiantes as $estudiante)
                                <option value="{{ $estudiante->ci }}" {{ old('ci') == $estudiante->ci ? 'selected' : '' }}>
                                    {{ $estudiante->apellido }} {{ $estudiante->nombre }} ({{ $estudiante->ci }})
                                    @if($estudiante->codestudiante) - {{ $estudiante->codestudiante }} @endif
                                </option>
                            @endforeach
                        </select>
                        @error('ci')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Tutor -->
                    <div>
                        <label for="citutor" class="block text-sm font-semibold text-gray-700 mb-2">
                            Tutor <span class="text-red-500">*</span>
                        </label>
                        <select name="citutor" id="citutor" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent @error('citutor') border-red-500 @enderror">
                            <option value="">Seleccione un tutor</option>
                            @foreach($tutores as $tutor)
                                <option value="{{ $tutor->ci }}" {{ old('citutor') == $tutor->ci ? 'selected' : '' }}>
                                    {{ $tutor->apellido }} {{ $tutor->nombre }} ({{ $tutor->ci }})
                                </option>
                            @endforeach
                        </select>
                        @error('citutor')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Gestión -->
                    <div>
                        <label for="idgestion" class="block text-sm font-semibold text-gray-700 mb-2">
                            Gestión <span class="text-red-500">*</span>
                        </label>
                        <select name="idgestion" id="idgestion" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent @error('idgestion') border-red-500 @enderror">
                            <option value="">Seleccione una gestión</option>
                            @foreach($gestiones as $gestion)
                                <option value="{{ $gestion->idgestion }}" {{ old('idgestion') == $gestion->idgestion ? 'selected' : '' }}>
                                    {{ $gestion->detalleges }} 
                                    @if($gestion->estado == '1')
                                        <span class="text-green-600">(Activa)</span>
                                    @endif
                                </option>
                            @endforeach
                        </select>
                        @error('idgestion')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Fecha de Registro -->
                    <div>
                        <label for="fecharegis" class="block text-sm font-semibold text-gray-700 mb-2">
                            Fecha de Registro <span class="text-red-500">*</span>
                        </label>
                        <input type="date" name="fecharegis" id="fecharegis" 
                               value="{{ old('fecharegis', date('Y-m-d')) }}" required
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent @error('fecharegis') border-red-500 @enderror">
                        @error('fecharegis')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Nivel -->
                    <div>
                        <label for="idnivel" class="block text-sm font-semibold text-gray-700 mb-2">
                            Nivel <span class="text-red-500">*</span>
                        </label>
                        <select name="idnivel" id="idnivel" required onchange="filtrarCursos()"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent @error('idnivel') border-red-500 @enderror">
                            <option value="">Seleccione un nivel</option>
                            @foreach($niveles as $nivel)
                                <option value="{{ $nivel->idnivel }}" {{ old('idnivel') == $nivel->idnivel ? 'selected' : '' }}>
                                    {{ $nivel->descripcion }}
                                </option>
                            @endforeach
                        </select>
                        @error('idnivel')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Curso -->
                    <div>
                        <label for="idcurso" class="block text-sm font-semibold text-gray-700 mb-2">
                            Curso <span class="text-red-500">*</span>
                        </label>
                        <select name="idcurso" id="idcurso" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent @error('idcurso') border-red-500 @enderror">
                            <option value="">Primero seleccione un nivel</option>
                        </select>
                        @error('idcurso')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Beca (opcional) -->
                    <div>
                        <label for="codbeca" class="block text-sm font-semibold text-gray-700 mb-2">
                            Beca (opcional)
                        </label>
                        <select name="codbeca" id="codbeca"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent @error('codbeca') border-red-500 @enderror">
                            <option value="">Sin beca</option>
                            @foreach($becas as $beca)
                                <option value="{{ $beca->codbeca }}" {{ old('codbeca') == $beca->codbeca ? 'selected' : '' }}>
                                    {{ $beca->nombrebeca }} - {{ $beca->porcentaje }}% ({{ $beca->tipobeca }})
                                </option>
                            @endforeach
                        </select>
                        @error('codbeca')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-xs text-gray-500">Seleccione una beca o deje "Sin beca"</p>
                    </div>
                </div>

                <!-- Observaciones -->
                <div>
                    <label for="observaciones" class="block text-sm font-semibold text-gray-700 mb-2">
                        Observaciones (opcional)
                    </label>
                    <textarea name="observaciones" id="observaciones" rows="3"
                              placeholder="Si se deja vacío, se asignará 'Inscripción Regular' automáticamente"
                              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent @error('observaciones') border-red-500 @enderror">{{ old('observaciones') }}</textarea>
                    @error('observaciones')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-xs text-gray-500">Máximo 200 caracteres. Si no se especifica, se asignará "Inscripción Regular".</p>
                </div>

                <!-- Botones -->
                <div class="flex items-center gap-4 pt-4 border-t">
                    <a href="{{ route('admin.inscripcion.index') }}"
                       class="px-6 py-3 bg-gray-200 hover:bg-gray-300 text-gray-800 font-medium rounded-lg transition-colors">
                        Cancelar
                    </a>
                    <button type="submit"
                            class="px-6 py-3 bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 text-white font-medium rounded-lg transition-all duration-200 transform hover:scale-105 shadow-lg hover:shadow-xl">
                        Registrar Inscripción
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Datos de cursos por nivel
        const cursosPorNivel = @json($cursos->groupBy('idnivel'));
        const cursoSeleccionado = "{{ old('idcurso') }}";

        function filtrarCursos() {
            const nivelSelect = document.getElementById('idnivel');
            const cursoSelect = document.getElementById('idcurso');
            const nivelId = nivelSelect.value;

            // Limpiar opciones
            cursoSelect.innerHTML = '<option value="">Seleccione un curso</option>';

            if (nivelId && cursosPorNivel[nivelId]) {
                cursosPorNivel[nivelId].forEach(curso => {
                    const option = document.createElement('option');
                    option.value = curso.idcurso;
                    option.textContent = curso.descripcion;
                    if (curso.idcurso == cursoSeleccionado) {
                        option.selected = true;
                    }
                    cursoSelect.appendChild(option);
                });
            }
        }

        // Ejecutar al cargar si hay nivel seleccionado
        document.addEventListener('DOMContentLoaded', function() {
            if (document.getElementById('idnivel').value) {
                filtrarCursos();
            }
        });
    </script>
</x-admin-layout>
