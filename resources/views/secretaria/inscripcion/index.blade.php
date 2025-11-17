<x-secretaria-layout>
    <div class="space-y-6">
        <!-- Header -->
        <div class="bg-gradient-to-r from-green-600 to-emerald-600 rounded-xl shadow-lg p-8 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-4xl font-bold mb-2">Gestión de Inscripciones</h1>
                    <p class="text-green-100 text-lg">Administrar inscripciones de estudiantes</p>
                </div>
                <a href="{{ route('secretaria.inscripcion.create') }}" class="bg-white text-green-600 px-6 py-3 rounded-lg font-semibold hover:bg-green-50 transition-colors shadow-lg flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Nueva Inscripción
                </a>
            </div>
        </div>

        <!-- Mensajes -->
        @if(session('success'))
            <div class="bg-green-50 border-l-4 border-green-500 p-4 rounded-r-lg">
                <div class="flex items-center">
                    <svg class="w-5 h-5 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                    </svg>
                    <p class="text-green-700 font-medium">{{ session('success') }}</p>
                </div>
            </div>
        @endif

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

        <!-- Filtros -->
        <div class="bg-white rounded-xl shadow-md p-6">
            <div class="flex items-center justify-between flex-wrap gap-4">
                <div class="flex items-center gap-3">
                    <a href="{{ route('secretaria.inscripcion.index') }}" 
                       class="px-6 py-2.5 rounded-lg font-semibold transition-all {{ !$gestion ? 'bg-green-600 text-white shadow-lg' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                        Todas las Gestiones
                    </a>
                    @foreach($gestiones as $g)
                        <a href="{{ route('secretaria.inscripcion.index', ['gestion' => $g->gestion]) }}" 
                           class="px-6 py-2.5 rounded-lg font-semibold transition-all {{ $gestion === $g->gestion ? 'bg-blue-600 text-white shadow-lg' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                            {{ $g->gestion }}
                        </a>
                    @endforeach
                </div>
                <div class="text-sm text-gray-600">
                    Total de inscripciones: <span class="font-bold text-gray-800">{{ count($inscripciones) }}</span>
                </div>
            </div>
        </div>

        <!-- Tabla de Inscripciones -->
        <div class="bg-white rounded-xl shadow-md overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gradient-to-r from-gray-50 to-gray-100">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase">ID</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase">Estudiante</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase">Tutor</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase">Gestión</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase">Nivel/Curso</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase">Beca</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase">Fecha</th>
                            <th class="px-6 py-4 text-center text-xs font-semibold text-gray-700 uppercase">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($inscripciones as $inscripcion)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="text-sm font-mono font-medium text-gray-900">{{ $inscripcion->ci }}</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10">
                                            <div class="h-10 w-10 rounded-full bg-green-100 text-green-600 flex items-center justify-center font-bold">
                                                {{ strtoupper(substr($inscripcion->estudiante_nombre, 0, 1)) }}{{ strtoupper(substr($inscripcion->estudiante_apellido, 0, 1)) }}
                                            </div>
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">{{ $inscripcion->estudiante_nombre }} {{ $inscripcion->estudiante_apellido }}</div>
                                            <div class="text-xs text-gray-500">CI: {{ $inscripcion->ci }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $inscripcion->tutor_nombre }} {{ $inscripcion->tutor_apellido }}</div>
                                    <div class="text-xs text-gray-500">CI: {{ $inscripcion->citutor }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                        {{ $inscripcion->gestion }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $inscripcion->nivel }}</div>
                                    <div class="text-xs text-gray-500">{{ $inscripcion->curso }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($inscripcion->beca_porcentaje)
                                        <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                            {{ $inscripcion->beca_porcentaje }}%
                                        </span>
                                    @else
                                        <span class="text-xs text-gray-400">Sin beca</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="text-sm text-gray-600">{{ \Carbon\Carbon::parse($inscripcion->fecharegis)->format('d/m/Y') }}</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <div class="flex items-center justify-center gap-2">
                                        <!-- Botón Ver Información -->
                                        <a href="{{ route('secretaria.persona.show', $inscripcion->ci) }}" 
                                           class="inline-flex items-center px-3 py-1.5 bg-green-600 hover:bg-green-700 text-white text-xs font-medium rounded transition-colors" 
                                           title="Ver información del estudiante">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                            </svg>
                                            Ver Info
                                        </a>
                                        
                                        <!-- Botón Editar -->
                                        <a href="{{ route('secretaria.inscripcion.edit', [$inscripcion->ci, $inscripcion->idcurso, $inscripcion->idnivel]) }}" 
                                           class="inline-flex items-center px-3 py-1.5 bg-blue-600 hover:bg-blue-700 text-white text-xs font-medium rounded transition-colors" 
                                           title="Editar inscripción">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                            </svg>
                                            Editar
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="px-6 py-12 text-center">
                                    <div class="flex flex-col items-center justify-center">
                                        <svg class="w-16 h-16 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                        <p class="text-gray-500 text-lg font-medium">No hay inscripciones registradas</p>
                                        <p class="text-gray-400 text-sm mt-1">Comienza agregando una nueva inscripción</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-secretaria-layout>
