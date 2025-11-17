<x-admin-layout>
    <div class="max-w-4xl mx-auto space-y-6">
        <!-- Header -->
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.materia.index') }}"
               class="inline-flex items-center justify-center w-10 h-10 rounded-lg bg-gray-100 hover:bg-gray-200 transition-colors">
                <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
            </a>
            <div>
                <h1 class="text-3xl font-bold text-gray-800">Nueva Materia</h1>
                <p class="text-gray-600 mt-1">Registra una nueva materia académica</p>
            </div>
        </div>

        <!-- Formulario -->
        <div class="bg-white rounded-lg shadow-md p-8">
            <form action="{{ route('admin.materia.store') }}" method="POST" class="space-y-6">
                @csrf

                <!-- Sigla -->
                <div>
                    <label for="sigla" class="block text-sm font-semibold text-gray-700 mb-2">
                        Sigla <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           name="sigla" 
                           id="sigla" 
                           value="{{ old('sigla') }}"
                           placeholder="Ej: MAT-101"
                           maxlength="10"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all @error('sigla') border-red-500 @enderror"
                           required>
                    @error('sigla')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-xs text-gray-500">Máximo 10 caracteres. Debe ser única.</p>
                </div>

                <!-- Descripción -->
                <div>
                    <label for="descripcion" class="block text-sm font-semibold text-gray-700 mb-2">
                        Descripción <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           name="descripcion" 
                           id="descripcion" 
                           value="{{ old('descripcion') }}"
                           placeholder="Ej: Matemáticas Básicas"
                           maxlength="100"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all @error('descripcion') border-red-500 @enderror"
                           required>
                    @error('descripcion')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Nivel y Curso -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Nivel -->
                    <div>
                        <label for="idnivel" class="block text-sm font-semibold text-gray-700 mb-2">
                            Nivel <span class="text-red-500">*</span>
                        </label>
                        <select name="idnivel" 
                                id="idnivel" 
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all @error('idnivel') border-red-500 @enderror"
                                required
                                onchange="filtrarCursos()">
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
                        <select name="idcurso" 
                                id="idcurso" 
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all @error('idcurso') border-red-500 @enderror"
                                required>
                            <option value="">Primero seleccione un nivel</option>
                        </select>
                        @error('idcurso')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Botones -->
                <div class="flex items-center gap-4 pt-4 border-t">
                    <a href="{{ route('admin.materia.index') }}"
                       class="px-6 py-3 bg-gray-200 hover:bg-gray-300 text-gray-800 font-medium rounded-lg transition-colors">
                        Cancelar
                    </a>
                    <button type="submit"
                            class="px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-medium rounded-lg transition-all duration-200 transform hover:scale-105 shadow-lg hover:shadow-xl">
                        Registrar Materia
                    </button>
                </div>
            </form>
        </div>

    </div>

    <script>
        // Datos de cursos por nivel (pasados desde el controlador)
        const cursosPorNivel = @json($cursos->groupBy('idnivel'));
        const cursoSeleccionado = "{{ old('idcurso') }}";

        function filtrarCursos() {
            const nivelSelect = document.getElementById('idnivel');
            const cursoSelect = document.getElementById('idcurso');
            const nivelId = nivelSelect.value;

            // Limpiar opciones actuales
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

        // Ejecutar al cargar la página si hay un nivel seleccionado
        document.addEventListener('DOMContentLoaded', function() {
            const nivelSelect = document.getElementById('idnivel');
            if (nivelSelect.value) {
                filtrarCursos();
            }
        });
    </script>
</x-admin-layout>
