<x-admin-layout>
    <div class="max-w-6xl mx-auto space-y-6">
        <!-- Header -->
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.maestromater.index') }}"
               class="inline-flex items-center justify-center w-10 h-10 rounded-lg bg-gray-100 hover:bg-gray-200 transition-colors">
                <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
            </a>
            <div>
                <h1 class="text-3xl font-bold text-gray-800">Asignar Materia a Maestro</h1>
                <p class="text-gray-600 mt-1">Registra una nueva asignación de materia</p>
            </div>
        </div>

        <!-- Formulario -->
        <div class="bg-white rounded-lg shadow-md p-8">
            <form action="{{ route('admin.maestromater.store') }}" method="POST" class="space-y-6">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Maestro -->
                    <div>
                        <label for="ci" class="block text-sm font-semibold text-gray-700 mb-2">
                            Maestro <span class="text-red-500">*</span>
                        </label>
                        <select name="ci" id="ci" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent @error('ci') border-red-500 @enderror">
                            <option value="">Seleccione un maestro</option>
                            @foreach($maestros as $maestro)
                                <option value="{{ $maestro->ci }}" {{ old('ci') == $maestro->ci ? 'selected' : '' }}>
                                    {{ $maestro->apellido }} {{ $maestro->nombre }} ({{ $maestro->codmaestro }}) - CI: {{ $maestro->ci }}
                                </option>
                            @endforeach
                        </select>
                        @error('ci')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Gestión -->
                    <div>
                        <label for="idgestion" class="block text-sm font-semibold text-gray-700 mb-2">
                            Gestión <span class="text-red-500">*</span>
                        </label>
                        <select name="idgestion" id="idgestion" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('idgestion') border-red-500 @enderror">
                            <option value="">Seleccione una gestión</option>
                            @foreach($gestiones as $gestion)
                                <option value="{{ $gestion->idgestion }}" {{ old('idgestion') == $gestion->idgestion ? 'selected' : '' }}>
                                    {{ $gestion->detalleges }}
                                </option>
                            @endforeach
                        </select>
                        @error('idgestion')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Nivel -->
                    <div>
                        <label for="idnivel" class="block text-sm font-semibold text-gray-700 mb-2">
                            Nivel <span class="text-red-500">*</span>
                        </label>
                        <select name="idnivel" id="idnivel" required onchange="cargarCursos()"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('idnivel') border-red-500 @enderror">
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
                        <select name="idcurso" id="idcurso" required onchange="cargarMaterias()"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('idcurso') border-red-500 @enderror">
                            <option value="">Primero seleccione un nivel</option>
                        </select>
                        @error('idcurso')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Materia -->
                    <div class="md:col-span-2">
                        <label for="idmateria" class="block text-sm font-semibold text-gray-700 mb-2">
                            Materia <span class="text-red-500">*</span>
                        </label>
                        <select name="idmateria" id="idmateria" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('idmateria') border-red-500 @enderror">
                            <option value="">Primero seleccione un curso</option>
                        </select>
                        @error('idmateria')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Fecha de Registro -->
                    <div>
                        <label for="fecharegis" class="block text-sm font-semibold text-gray-700 mb-2">
                            Fecha de Asignación <span class="text-red-500">*</span>
                        </label>
                        <input type="date" name="fecharegis" id="fecharegis" 
                               value="{{ old('fecharegis', date('Y-m-d')) }}" required
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('fecharegis') border-red-500 @enderror">
                        @error('fecharegis')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Asesor -->
                    <div>
                        <label for="asesor" class="block text-sm font-semibold text-gray-700 mb-2">
                            ¿Es Asesor de Curso? <span class="text-red-500">*</span>
                        </label>
                        <select name="asesor" id="asesor" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('asesor') border-red-500 @enderror">
                            <option value="0" {{ old('asesor') == '0' ? 'selected' : '' }}>No</option>
                            <option value="1" {{ old('asesor') == '1' ? 'selected' : '' }}>Sí</option>
                        </select>
                        @error('asesor')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Observaciones -->
                    <div class="md:col-span-2">
                        <label for="observacion" class="block text-sm font-semibold text-gray-700 mb-2">
                            Observaciones (opcional)
                        </label>
                        <textarea name="observacion" id="observacion" rows="3"
                                  placeholder="Observaciones adicionales sobre la asignación"
                                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">{{ old('observacion') }}</textarea>
                        <p class="mt-1 text-xs text-gray-500">Máximo 200 caracteres</p>
                    </div>
                </div>

                <!-- Botones -->
                <div class="flex items-center gap-4 pt-4 border-t">
                    <a href="{{ route('admin.maestromater.index') }}"
                       class="px-6 py-3 bg-gray-200 hover:bg-gray-300 text-gray-800 font-medium rounded-lg transition-colors">
                        Cancelar
                    </a>
                    <button type="submit"
                            class="px-6 py-3 bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 text-white font-medium rounded-lg transition-all duration-200 transform hover:scale-105 shadow-lg hover:shadow-xl">
                        Asignar Materia
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        const cursos = @json($cursos);

        function cargarCursos() {
            const nivelId = document.getElementById('idnivel').value;
            const cursoSelect = document.getElementById('idcurso');
            const materiaSelect = document.getElementById('idmateria');
            
            // Limpiar selects
            cursoSelect.innerHTML = '<option value="">Seleccione un curso</option>';
            materiaSelect.innerHTML = '<option value="">Primero seleccione un curso</option>';
            
            if (nivelId) {
                const cursosFiltrados = cursos.filter(c => c.idnivel == nivelId);
                cursosFiltrados.forEach(curso => {
                    const option = document.createElement('option');
                    option.value = curso.idcurso;
                    option.textContent = curso.curso_nombre;
                    cursoSelect.appendChild(option);
                });
            }
        }

        function cargarMaterias() {
            const cursoId = document.getElementById('idcurso').value;
            const nivelId = document.getElementById('idnivel').value;
            const materiaSelect = document.getElementById('idmateria');
            
            materiaSelect.innerHTML = '<option value="">Cargando materias...</option>';
            
            if (cursoId && nivelId) {
                fetch(`/admin/maestromater/materias/${cursoId}/${nivelId}`)
                    .then(response => response.json())
                    .then(materias => {
                        materiaSelect.innerHTML = '<option value="">Seleccione una materia</option>';
                        materias.forEach(materia => {
                            const option = document.createElement('option');
                            option.value = materia.idmateria;
                            option.textContent = `${materia.sigla} - ${materia.descripcion}`;
                            materiaSelect.appendChild(option);
                        });
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        materiaSelect.innerHTML = '<option value="">Error al cargar materias</option>';
                    });
            }
        }

        // Cargar cursos si hay un nivel seleccionado (old input)
        document.addEventListener('DOMContentLoaded', function() {
            const nivelId = document.getElementById('idnivel').value;
            if (nivelId) {
                cargarCursos();
                const cursoId = '{{ old("idcurso") }}';
                if (cursoId) {
                    setTimeout(() => {
                        document.getElementById('idcurso').value = cursoId;
                        cargarMaterias();
                    }, 100);
                }
            }
        });
    </script>
</x-admin-layout>
