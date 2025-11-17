<x-secretaria-layout>
    <div class="max-w-6xl mx-auto space-y-6">
        <!-- Header -->
        <div class="bg-gradient-to-r from-green-600 to-emerald-600 rounded-xl shadow-lg p-8 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-4xl font-bold mb-2">Vincular Tutor con Estudiante</h1>
                    <p class="text-green-100 text-lg">{{ $estudiante->nombre }} {{ $estudiante->apellido }} (CI: {{ $estudiante->ci }})</p>
                </div>
                <a href="{{ route('secretaria.persona.index', ['tipo' => 'estudiantes']) }}" class="bg-white text-green-600 px-6 py-3 rounded-lg font-semibold hover:bg-green-50 transition-colors shadow-lg flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Volver
                </a>
            </div>
        </div>

        <!-- Información -->
        <div class="bg-blue-50 border-l-4 border-blue-500 p-4 rounded-r-lg">
            <div class="flex items-start">
                <svg class="w-5 h-5 text-blue-500 mr-3 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                </svg>
                <div>
                    <p class="text-blue-700 font-medium">Nota Importante</p>
                    <p class="text-blue-600 text-sm mt-1">La vinculación de tutores con estudiantes se realiza a través del módulo de <strong>Inscripciones</strong>. Aquí puedes ver las inscripciones actuales y los tutores asignados. Para cambiar o asignar un tutor, debes editar la inscripción correspondiente.</p>
                </div>
            </div>
        </div>

        <!-- Inscripciones Actuales -->
        <div class="bg-white rounded-xl shadow-md p-6">
            <h2 class="text-2xl font-bold text-gray-800 mb-6 flex items-center gap-2">
                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                Inscripciones del Estudiante
            </h2>

            @if(count($inscripciones) > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gradient-to-r from-gray-50 to-gray-100">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase">Gestión</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase">Nivel</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase">Curso</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase">Tutor Asignado</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase">Fecha Inscripción</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($inscripciones as $inscripcion)
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="text-sm font-medium text-gray-900">{{ $inscripcion->gestion }}</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="text-sm text-gray-600">{{ $inscripcion->nivel }}</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="text-sm text-gray-600">{{ $inscripcion->curso }}</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($inscripcion->tutor_nombre)
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0 h-8 w-8">
                                                    <div class="h-8 w-8 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center font-bold text-xs">
                                                        {{ strtoupper(substr($inscripcion->tutor_nombre, 0, 1)) }}{{ strtoupper(substr($inscripcion->tutor_apellido, 0, 1)) }}
                                                    </div>
                                                </div>
                                                <div class="ml-3">
                                                    <div class="text-sm font-medium text-gray-900">{{ $inscripcion->tutor_nombre }} {{ $inscripcion->tutor_apellido }}</div>
                                                    <div class="text-xs text-gray-500">CI: {{ $inscripcion->citutor }}</div>
                                                </div>
                                            </div>
                                        @else
                                            <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                                Sin tutor asignado
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="text-sm text-gray-600">{{ \Carbon\Carbon::parse($inscripcion->fecharegis)->format('d/m/Y') }}</span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-12">
                    <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <p class="text-gray-500 text-lg font-medium">No hay inscripciones registradas</p>
                    <p class="text-gray-400 text-sm mt-1">El estudiante debe tener al menos una inscripción para asignar un tutor</p>
                </div>
            @endif
        </div>

        <!-- Tutores Disponibles -->
        <div class="bg-white rounded-xl shadow-md p-6">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-2xl font-bold text-gray-800 flex items-center gap-2">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                    Tutores Disponibles
                </h2>
                <button onclick="mostrarFormularioTutor()" class="bg-gradient-to-r from-blue-600 to-blue-700 text-white px-6 py-3 rounded-lg font-semibold hover:from-blue-700 hover:to-blue-800 transition-all shadow-lg flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Crear Nuevo Tutor
                </button>
            </div>

            @if(count($tutores) > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach($tutores as $tutor)
                        <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow">
                            <div class="flex items-start gap-3">
                                <div class="flex-shrink-0">
                                    <div class="h-12 w-12 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center font-bold">
                                        {{ strtoupper(substr($tutor->nombre, 0, 1)) }}{{ strtoupper(substr($tutor->apellido, 0, 1)) }}
                                    </div>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-semibold text-gray-900 truncate">{{ $tutor->nombre }} {{ $tutor->apellido }}</p>
                                    <p class="text-xs text-gray-500 mt-1">CI: {{ $tutor->ci }}</p>
                                    <p class="text-xs text-gray-500">{{ $tutor->correo ?? 'Sin correo' }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-500 text-center py-8">No hay tutores registrados. Cree uno nuevo para poder asignarlo.</p>
            @endif
        </div>

        <!-- Formulario para crear nuevo tutor (oculto por defecto) -->
        <div id="formularioTutor" class="hidden bg-white rounded-xl shadow-md p-8">
            <h2 class="text-2xl font-bold text-gray-800 mb-6">Registrar Nuevo Tutor</h2>
            
            <form id="formCrearTutor" class="space-y-6">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">CI <span class="text-red-500">*</span></label>
                        <input type="text" name="ci" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Nombre <span class="text-red-500">*</span></label>
                        <input type="text" name="nombre" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Apellido <span class="text-red-500">*</span></label>
                        <input type="text" name="apellido" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Sexo <span class="text-red-500">*</span></label>
                        <select name="sexo" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                            <option value="">Seleccione...</option>
                            <option value="M">Masculino</option>
                            <option value="F">Femenino</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Correo</label>
                        <input type="email" name="correo" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Teléfono</label>
                        <input type="text" name="telefono" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Contraseña <span class="text-red-500">*</span></label>
                        <input type="password" name="contrasena" required minlength="6" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                    </div>
                </div>

                <div class="flex items-center justify-end gap-4 pt-6 border-t border-gray-200">
                    <button type="button" onclick="ocultarFormularioTutor()" class="px-6 py-3 bg-gray-100 text-gray-700 rounded-lg font-semibold hover:bg-gray-200 transition-colors">
                        Cancelar
                    </button>
                    <button type="submit" class="px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-700 text-white rounded-lg font-semibold hover:from-blue-700 hover:to-blue-800 transition-all shadow-lg">
                        Crear Tutor
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function mostrarFormularioTutor() {
            document.getElementById('formularioTutor').classList.remove('hidden');
            document.getElementById('formularioTutor').scrollIntoView({ behavior: 'smooth' });
        }

        function ocultarFormularioTutor() {
            document.getElementById('formularioTutor').classList.add('hidden');
            document.getElementById('formCrearTutor').reset();
        }

        document.getElementById('formCrearTutor').addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            const data = Object.fromEntries(formData);

            try {
                const response = await fetch('{{ route("secretaria.persona.tutor.crear") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                    },
                    body: JSON.stringify(data)
                });

                const result = await response.json();

                if (result.success) {
                    alert('Tutor creado exitosamente');
                    window.location.reload();
                } else {
                    alert('Error: ' + result.message);
                }
            } catch (error) {
                alert('Error al crear tutor: ' + error.message);
            }
        });
    </script>
</x-secretaria-layout>
