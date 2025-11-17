<x-secretaria-layout>
    <div class="w-full max-w-2xl p-6 bg-white rounded shadow">
        <h2 class="text-2xl font-bold mb-4">Nueva Inscripción</h2>

        @if(session('success'))
            <div class="mb-4 bg-green-50 border-l-4 border-green-500 p-3">
                <p class="text-green-700 font-semibold">{{ session('success') }}</p>
            </div>
        @endif

        @if(session('error'))
            <div class="mb-4 bg-red-50 border-l-4 border-red-500 p-3">
                <p class="text-red-700 font-semibold">{{ session('error') }}</p>
            </div>
        @endif

        @if($errors->any())
            <div class="mb-4 bg-red-50 border-l-4 border-red-500 p-3">
                <p class="text-red-700 font-semibold">Errores:</p>
                <ul class="list-disc list-inside text-red-600 text-sm">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('secretaria.inscripcion.store') }}" method="POST" class="space-y-4">
            @csrf

            <!-- Estudiante -->
            <div>
                <label for="ci" class="block text-gray-700">Estudiante:</label>
                <select name="ci" id="ci" required onchange="cargarTutor()" class="mt-1 block w-full p-2 border border-gray-300 rounded">
                    <option value="">Seleccione...</option>
                    @foreach($estudiantes as $estudiante)
                        <option value="{{ $estudiante->ci }}" {{ old('ci') === $estudiante->ci ? 'selected' : '' }}>
                            {{ $estudiante->nombre }} {{ $estudiante->apellido }} - {{ $estudiante->codestudiante ?? 'N/A' }}
                        </option>
                    @endforeach
                </select>
                @error('ci')
                    <div class="text-red-600 text-sm">{{ $message }}</div>
                @enderror
            </div>

            <!-- Tutor -->
            <div>
                <label for="citutor" class="block text-gray-700">Tutor (Padre/Madre):</label>
                <div id="tutor-info" class="hidden text-sm text-blue-600 mb-1">
                    Sugerido: <span id="tutor-nombre" class="font-semibold"></span>
                </div>
                <select name="citutor" id="citutor" required class="mt-1 block w-full p-2 border border-gray-300 rounded">
                    <option value="">Seleccione...</option>
                    @foreach($tutores as $tutor)
                        <option value="{{ $tutor->ci }}" {{ old('citutor') === $tutor->ci ? 'selected' : '' }}>
                            {{ $tutor->nombre }} {{ $tutor->apellido }}
                        </option>
                    @endforeach
                </select>
                @error('citutor')
                    <div class="text-red-600 text-sm">{{ $message }}</div>
                @enderror
            </div>

            <!-- Gestión -->
            <div>
                <label for="idgestion" class="block text-gray-700">Gestión (solo activas):</label>
                <select name="idgestion" id="idgestion" required class="mt-1 block w-full p-2 border border-gray-300 rounded">
                    <option value="">Seleccione...</option>
                    @foreach($gestiones as $gestion)
                        <option value="{{ $gestion->idgestion }}" {{ old('idgestion') == $gestion->idgestion ? 'selected' : '' }}>
                            {{ $gestion->detalleges }}
                        </option>
                    @endforeach
                </select>
                @error('idgestion')
                    <div class="text-red-600 text-sm">{{ $message }}</div>
                @enderror
            </div>

            <!-- Nivel -->
            <div>
                <label for="idnivel" class="block text-gray-700">Nivel:</label>
                <select name="idnivel" id="idnivel" required onchange="filtrarCursos()" class="mt-1 block w-full p-2 border border-gray-300 rounded">
                    <option value="">Seleccione...</option>
                    @foreach($niveles as $nivel)
                        <option value="{{ $nivel->idnivel }}" {{ old('idnivel') == $nivel->idnivel ? 'selected' : '' }}>
                            {{ $nivel->descripcion }}
                        </option>
                    @endforeach
                </select>
                @error('idnivel')
                    <div class="text-red-600 text-sm">{{ $message }}</div>
                @enderror
            </div>

            <!-- Curso -->
            <div>
                <label for="idcurso" class="block text-gray-700">Curso:</label>
                <select name="idcurso" id="idcurso" required class="mt-1 block w-full p-2 border border-gray-300 rounded">
                    <option value="">Primero seleccione un nivel...</option>
                </select>
                @error('idcurso')
                    <div class="text-red-600 text-sm">{{ $message }}</div>
                @enderror
            </div>

            <!-- Beca -->
            <div>
                <label for="codbeca" class="block text-gray-700">Beca (opcional):</label>
                <select name="codbeca" id="codbeca" class="mt-1 block w-full p-2 border border-gray-300 rounded">
                    <option value="">Sin beca</option>
                    @foreach($becas as $beca)
                        <option value="{{ $beca->codbeca }}" {{ old('codbeca') == $beca->codbeca ? 'selected' : '' }}>
                            {{ $beca->nombrebeca }} - {{ $beca->porcentaje }}%
                        </option>
                    @endforeach
                </select>
                @error('codbeca')
                    <div class="text-red-600 text-sm">{{ $message }}</div>
                @enderror
            </div>

            <!-- Observaciones -->
            <div>
                <label for="observaciones" class="block text-gray-700">Observaciones:</label>
                <textarea name="observaciones" id="observaciones" rows="2" class="mt-1 block w-full p-2 border border-gray-300 rounded" placeholder="Opcional...">{{ old('observaciones') }}</textarea>
                @error('observaciones')
                    <div class="text-red-600 text-sm">{{ $message }}</div>
                @enderror
            </div>

            <!-- Botones -->
            <div class="flex items-center gap-3 pt-2">
                <a href="{{ route('secretaria.inscripcion.index') }}" class="px-3 py-2 bg-gray-200 rounded">Cancelar</a>
                <button type="submit" onclick="return validarFormulario()" class="px-3 py-2 bg-blue-600 hover:bg-blue-500 text-white rounded">Registrar</button>
            </div>
        </form>
    </div>

    <script>
        // Datos de cursos por nivel
        const cursosPorNivel = @json($cursos);
        console.log('Cursos disponibles:', cursosPorNivel);

        function filtrarCursos() {
            const nivelId = document.getElementById('idnivel').value;
            const cursoSelect = document.getElementById('idcurso');
            
            console.log('Filtrando cursos para nivel:', nivelId);
            cursoSelect.innerHTML = '<option value="">Seleccione...</option>';
            
            if (nivelId) {
                const cursosFiltrados = cursosPorNivel.filter(c => c.idnivel == nivelId);
                console.log('Cursos filtrados:', cursosFiltrados);
                
                cursosFiltrados.forEach(curso => {
                    const option = document.createElement('option');
                    option.value = curso.idcurso;
                    option.textContent = curso.descripcion;
                    option.setAttribute('data-nivel', curso.idnivel);
                    cursoSelect.appendChild(option);
                });
            }
        }

        function validarFormulario() {
            const nivel = document.getElementById('idnivel').value;
            const curso = document.getElementById('idcurso').value;
            const cursoSelect = document.getElementById('idcurso');
            const selectedOption = cursoSelect.options[cursoSelect.selectedIndex];
            
            console.log('Validando formulario:');
            console.log('- Nivel seleccionado:', nivel);
            console.log('- Curso seleccionado:', curso);
            console.log('- Nivel del curso:', selectedOption.getAttribute('data-nivel'));
            
            if (!nivel || !curso) {
                alert('Por favor complete todos los campos requeridos');
                return false;
            }
            
            return true;
        }

        async function cargarTutor() {
            const ci = document.getElementById('ci').value;
            if (!ci) {
                document.getElementById('tutor-info').classList.add('hidden');
                return;
            }

            try {
                const response = await fetch(`{{ url('/secretaria/inscripcion/tutor') }}/${ci}`);
                const data = await response.json();

                if (data.success && data.tutor) {
                    document.getElementById('tutor-nombre').textContent = 
                        `${data.tutor.nombre} ${data.tutor.apellido}`;
                    document.getElementById('tutor-info').classList.remove('hidden');
                    document.getElementById('citutor').value = data.tutor.ci;
                } else {
                    document.getElementById('tutor-info').classList.add('hidden');
                }
            } catch (error) {
                console.error('Error:', error);
            }
        }

        // Filtrar cursos al cargar si hay un nivel seleccionado
        document.addEventListener('DOMContentLoaded', function() {
            const nivelId = document.getElementById('idnivel').value;
            if (nivelId) {
                filtrarCursos();
            }
        });
    </script>
</x-secretaria-layout>
