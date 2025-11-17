<x-admin-layout>
    <div class="space-y-6">
        <!-- Header con gradiente -->
        <div class="bg-gradient-to-r from-green-600 to-teal-600 rounded-xl shadow-lg p-8 text-white">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-4">
                    <div class="bg-white/20 backdrop-blur-sm rounded-full p-4">
                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-3xl font-bold">Gestión de Materias</h1>
                        <p class="text-green-100 mt-1">Administra las materias por nivel y curso</p>
                    </div>
                </div>
                <a href="{{ route('admin.materia.create') }}" 
                   class="inline-flex items-center gap-2 bg-white text-green-700 hover:bg-green-50 px-6 py-3 rounded-lg font-semibold transition-all duration-200 transform hover:scale-105 shadow-lg hover:shadow-xl">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Nueva Materia
                </a>
            </div>
        </div>

        <!-- Filtros -->
        <div class="bg-white rounded-xl shadow-md p-6">
            <div class="flex items-center gap-4 flex-wrap">
                <span class="text-sm font-semibold text-gray-700 flex items-center gap-2">
                    <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
                    </svg>
                    Filtrar por nivel:
                </span>
                <div class="flex gap-2 flex-wrap">
                    <a href="{{ route('admin.materia.index', ['nivel' => 'todos']) }}"
                       class="px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200 {{ $filtroNivel === 'todos' ? 'bg-teal-400 text-white shadow-md' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                        Todos
                    </a>
                    @foreach($niveles as $nivel)
                        <a href="{{ route('admin.materia.index', ['nivel' => $nivel->idnivel]) }}"
                           class="px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200 {{ $filtroNivel == $nivel->idnivel ? 'bg-emerald-400 text-white shadow-md' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                            {{ $nivel->descripcion }}
                        </a>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Mensajes de éxito/error -->
        @if(session('success'))
            <div class="bg-green-50 border-l-4 border-green-500 rounded-r-lg p-4 animate-fade-in">
                <div class="flex items-center">
                    <svg class="w-5 h-5 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                    </svg>
                    <p class="text-green-700 font-medium">{{ session('success') }}</p>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-50 border-l-4 border-red-500 rounded-r-lg p-4 animate-fade-in">
                <div class="flex items-center">
                    <svg class="w-5 h-5 text-red-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                    </svg>
                    <p class="text-red-700 font-medium">{{ session('error') }}</p>
                </div>
            </div>
        @endif

        <!-- Tabla estilizada -->
        <div class="bg-white rounded-xl shadow-md overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gradient-to-r from-gray-50 to-gray-100">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">ID</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Sigla</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Descripción</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Nivel</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Curso</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @php
                            $nivelActual = null;
                            $cursoActual = null;
                            $materiasAgrupadas = [];
                            
                            // Agrupar materias por nivel y curso
                            foreach($materias as $mat) {
                                $materiasAgrupadas[$mat->idnivel][$mat->idcurso][] = $mat;
                            }
                        @endphp
                        
                        @forelse($materiasAgrupadas as $idNivel => $cursos)
                            @php
                                $primerCurso = reset($cursos);
                                $primerMateria = reset($primerCurso);
                                $nivelNombre = $primerMateria->nivel_nombre;
                            @endphp
                            
                            <!-- Cabecera de Nivel -->
                            <tr class="bg-emerald-50">
                                <td colspan="6" class="px-6 py-3">
                                    <div class="flex items-center gap-2">
                                        <svg class="w-5 h-5 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                        </svg>
                                        <span class="text-sm font-bold text-emerald-800 uppercase">Nivel: {{ $nivelNombre }}</span>
                                    </div>
                                </td>
                            </tr>

                            <!-- Contenedor del Acordeón -->
                            @foreach($cursos as $idCurso => $materiasCurso)
                                @php
                                    $cursoNombre = $materiasCurso[0]->curso_nombre;
                                    $acordeonId = "curso-{$idNivel}-{$idCurso}";
                                @endphp
                                
                                <tbody x-data="{ open: false }">
                                    <!-- Cabecera de Curso (Acordeón) -->
                                    <tr class="bg-cyan-50">
                                        <td colspan="6" class="px-6 py-2 pl-12">
                                            <button @click="open = !open" class="w-full flex items-center justify-between gap-2 hover:bg-cyan-100 rounded px-2 py-1 transition-colors">
                                                <div class="flex items-center gap-2">
                                                    <svg class="w-4 h-4 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                                    </svg>
                                                    <span class="text-xs font-semibold text-cyan-800">Curso: {{ $cursoNombre }}</span>
                                                    <span class="text-xs text-cyan-700">({{ count($materiasCurso) }} materias)</span>
                                                </div>
                                                <svg class="w-4 h-4 text-teal-600 transition-transform duration-200" :class="{ 'rotate-180': !open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                                </svg>
                                            </button>
                                        </td>
                                    </tr>

                                    <!-- Materias del Curso (Contenido del Acordeón) -->
                                    @foreach($materiasCurso as $materia)
                                        <tr class="hover:bg-green-50 transition-colors" 
                                            x-show="open" 
                                            x-transition:enter="transition ease-out duration-200" 
                                            x-transition:enter-start="opacity-0 transform scale-95" 
                                            x-transition:enter-end="opacity-100 transform scale-100"
                                            x-transition:leave="transition ease-in duration-150"
                                            x-transition:leave-start="opacity-100 transform scale-100"
                                            x-transition:leave-end="opacity-0 transform scale-95">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-semibold text-gray-900">{{ $materia->idmateria }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-teal-100 text-teal-800">
                                        {{ $materia->sigla }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm font-medium text-gray-900">{{ $materia->descripcion }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-xs text-gray-600">{{ $materia->nivel_nombre }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-xs text-gray-600">{{ $materia->curso_nombre }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <a href="{{ route('admin.materia.edit', $materia->idmateria) }}"
                                       class="inline-flex items-center gap-1.5 bg-gradient-to-r from-lime-500 to-lime-600 hover:from-lime-600 hover:to-lime-700 text-white px-3 py-1.5 rounded-lg transition-all duration-200 transform hover:scale-105 shadow-sm hover:shadow-md text-xs">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                        Editar
                                    </a>
                                </td>
                            </tr>
                                    @endforeach
                                </tbody>
                            @endforeach
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center">
                                    <div class="flex flex-col items-center justify-center">
                                        <div class="inline-flex items-center justify-center w-16 h-16 bg-gray-100 rounded-full mb-4">
                                            <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                            </svg>
                                        </div>
                                        <h3 class="text-sm font-semibold text-gray-900 mb-1">No hay materias disponibles</h3>
                                        <p class="text-sm text-gray-500">Crea la primera materia para comenzar</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</x-admin-layout>
