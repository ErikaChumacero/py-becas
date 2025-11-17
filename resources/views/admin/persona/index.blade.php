<x-admin-layout>
    <div class="max-w-7xl mx-auto space-y-6">
        <!-- Header con gradiente -->
        <div class="bg-gradient-to-r from-green-600 to-teal-600 rounded-xl shadow-lg p-8 text-white">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-4">
                    <div class="bg-white/20 backdrop-blur-sm rounded-full p-4">
                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-3xl font-bold">Gestión de Personas</h1>
                        <p class="text-green-100 mt-1">Administra estudiantes, maestros, tutores y administradores</p>
                    </div>
                </div>
                <a href="{{ route('admin.persona.create') }}" 
                   class="inline-flex items-center gap-2 bg-white text-green-700 hover:bg-green-50 px-6 py-3 rounded-lg font-semibold transition-all duration-200 transform hover:scale-105 shadow-lg hover:shadow-xl">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Agregar Persona
                </a>
            </div>
        </div>

        <!-- Mensajes de estado -->
        @if (session('success'))
            <div class="bg-teal-50 border-l-4 border-teal-500 p-4 rounded-r-lg shadow-sm">
                <div class="flex items-center">
                    <svg class="w-5 h-5 text-teal-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                    </svg>
                    <p class="text-teal-700 font-medium">{{ session('success') }}</p>
                </div>
            </div>
        @endif

        @if (session('error'))
            <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded-r-lg shadow-sm">
                <div class="flex items-center">
                    <svg class="w-5 h-5 text-red-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                    </svg>
                    <p class="text-red-700 font-medium">{{ session('error') }}</p>
                </div>
            </div>
        @endif

        @if ($errors->any())
            <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded-r-lg shadow-sm">
                <div class="flex items-start">
                    <svg class="w-5 h-5 text-red-500 mr-3 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                    </svg>
                    <div>
                        <p class="text-red-700 font-medium mb-2">Se encontraron los siguientes errores:</p>
                        <ul class="list-disc list-inside text-red-600 space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif

        <!-- Filtros y Búsqueda -->
        <div class="bg-white rounded-xl shadow-md p-6 space-y-4">
            <!-- Barra de búsqueda -->
            <form method="GET" action="{{ route('admin.persona.index') }}" class="flex gap-3">
                <input type="hidden" name="tipo" value="{{ $tipo }}">
                <div class="relative flex-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                    <input 
                        type="text" 
                        name="buscar" 
                        value="{{ $buscar }}"
                        placeholder="Buscar por CI, nombre o apellido..." 
                        class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all"
                    >
                </div>
                <button type="submit" class="px-6 py-2.5 bg-green-600 hover:bg-green-700 text-white font-medium rounded-lg transition-colors flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                    Buscar
                </button>
                @if($buscar)
                    <a href="{{ route('admin.persona.index', ['tipo' => $tipo]) }}" class="px-4 py-2.5 bg-gray-200 hover:bg-gray-300 text-gray-700 font-medium rounded-lg transition-colors flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                        Limpiar
                    </a>
                @endif
            </form>

            <!-- Filtros por tipo -->
            <div class="flex flex-wrap items-center gap-3">
                <span class="text-gray-700 font-semibold flex items-center gap-2">
                    <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
                    </svg>
                    Filtrar por:
                </span>
                <a href="{{ route('admin.persona.index', ['tipo' => 'todos', 'buscar' => $buscar]) }}" 
                   class="px-4 py-2 rounded-lg transition-all duration-200 {{ $tipo === 'todos' ? 'bg-teal-600 text-white shadow-md transform scale-105' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                    Todos
                </a>
                <a href="{{ route('admin.persona.index', ['tipo' => 'estudiantes', 'buscar' => $buscar]) }}" 
                   class="px-4 py-2 rounded-lg transition-all duration-200 {{ $tipo === 'estudiantes' ? 'bg-teal-600 text-white shadow-md transform scale-105' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                    Estudiantes
                </a>
                <a href="{{ route('admin.persona.index', ['tipo' => 'maestros', 'buscar' => $buscar]) }}" 
                   class="px-4 py-2 rounded-lg transition-all duration-200 {{ $tipo === 'maestros' ? 'bg-teal-600 text-white shadow-md transform scale-105' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                    Maestros
                </a>
                <a href="{{ route('admin.persona.index', ['tipo' => 'tutores', 'buscar' => $buscar]) }}" 
                   class="px-4 py-2 rounded-lg transition-all duration-200 {{ $tipo === 'tutores' ? 'bg-teal-600 text-white shadow-md transform scale-105' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                    Tutores
                </a>
                <a href="{{ route('admin.persona.index', ['tipo' => 'administradores', 'buscar' => $buscar]) }}" 
                   class="px-4 py-2 rounded-lg transition-all duration-200 {{ $tipo === 'administradores' ? 'bg-teal-600 text-white shadow-md transform scale-105' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                    Administradores
                </a>
                <a href="{{ route('admin.persona.index', ['tipo' => 'secretarias', 'buscar' => $buscar]) }}" 
                   class="px-4 py-2 rounded-lg transition-all duration-200 {{ $tipo === 'secretarias' ? 'bg-cyan-600 text-white shadow-md transform scale-105' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                    Secretarías
                </a>
                <span class="ml-auto text-sm bg-emerald-50 text-emerald-700 px-4 py-2 rounded-lg font-medium">
                    Total: <strong>{{ $pagination['total'] }}</strong> {{ $tipo === 'todos' ? 'personas' : ($tipo === 'estudiantes' ? 'estudiantes' : ($tipo === 'administradores' ? 'administradores' : ($tipo === 'secretarias' ? 'secretarías' : $tipo))) }}
                </span>
            </div>
        </div>

        <!-- Tabla estilizada -->
        <div class="bg-white rounded-xl shadow-md overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gradient-to-r from-gray-50 to-gray-100">
                        <tr>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                                <div class="flex items-center gap-2">
                                    <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"></path>
                                    </svg>
                                    CI
                                </div>
                            </th>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                                <div class="flex items-center gap-2">
                                    <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                    Nombre
                                </div>
                            </th>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Apellido</th>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                                <div class="flex items-center gap-2">
                                    <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                    </svg>
                                    Teléfono
                                </div>
                            </th>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                                <div class="flex items-center gap-2">
                                    <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                    </svg>
                                    Correo
                                </div>
                            </th>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Roles</th>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Códigos</th>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($personas as $persona)
                            <tr class="hover:bg-green-50 transition-colors duration-150">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center justify-center px-3 py-1 rounded-full bg-gray-100 text-gray-700 text-sm font-mono font-semibold">
                                        {{ $persona->ci }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">{{ $persona->nombre }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-700">{{ $persona->apellido }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-700">{{ $persona->telefono }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm text-gray-700">{{ $persona->correo }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex gap-1 flex-wrap">
                                        @if($persona->tipou === '1')
                                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700" title="Usuario Activo">U</span>
                                        @endif
                                        @if($persona->tipoe === '1')
                                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-semibold bg-teal-100 text-teal-800" title="Estudiante">E</span>
                                        @endif
                                        @if($persona->tipot === '1')
                                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-semibold bg-teal-100 text-teal-800" title="Tutor">T</span>
                                        @endif
                                        @if($persona->tipom === '1')
                                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-semibold bg-teal-100 text-teal-800" title="Maestro">M</span>
                                        @endif
                                        @if($persona->tipoa === '1')
                                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-semibold bg-teal-100 text-teal-800" title="Administrador">A</span>
                                        @endif
                                        @if($persona->tipos === '1')
                                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-semibold bg-cyan-100 text-cyan-800" title="Secretaría">S</span>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-xs text-gray-700 space-y-1">
                                        @if($persona->codestudiante)
                                            <div><span class="font-semibold">Est:</span> {{ $persona->codestudiante }}</div>
                                        @endif
                                        @if($persona->codmaestro)
                                            <div><span class="font-semibold">Prof:</span> {{ $persona->codmaestro }}</div>
                                        @endif
                                        @if(!$persona->codestudiante && !$persona->codmaestro)
                                            <span class="text-gray-400">-</span>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <a href="{{ route('admin.persona.edit', $persona->ci) }}"
                                       class="inline-flex items-center gap-1.5 bg-gradient-to-r from-lime-500 to-lime-600 hover:from-lime-600 hover:to-lime-700 text-white px-3 py-1.5 rounded-lg transition-all duration-200 transform hover:scale-105 shadow-sm hover:shadow-md text-xs">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                        Editar
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="px-6 py-12 text-center">
                                    <div class="flex flex-col items-center justify-center">
                                        <div class="inline-flex items-center justify-center w-16 h-16 bg-gray-100 rounded-full mb-4">
                                            <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                            </svg>
                                        </div>
                                        <h3 class="text-sm font-semibold text-gray-900 mb-1">No hay registros disponibles</h3>
                                        <p class="text-sm text-gray-500">No se encontraron personas con los filtros aplicados</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Paginación -->
            @if($pagination['last_page'] > 1)
                <div class="bg-gray-50 px-6 py-4 border-t border-gray-200">
                    <div class="flex items-center justify-between">
                        <!-- Información de registros -->
                        <div class="text-sm text-gray-700">
                            Mostrando <span class="font-semibold">{{ $pagination['from'] }}</span> a <span class="font-semibold">{{ $pagination['to'] }}</span> de <span class="font-semibold">{{ $pagination['total'] }}</span> resultados
                        </div>

                        <!-- Botones de paginación -->
                        <div class="flex items-center gap-2">
                            @if($pagination['current_page'] > 1)
                                <a href="{{ route('admin.persona.index', ['tipo' => $tipo, 'buscar' => $buscar, 'page' => $pagination['current_page'] - 1]) }}" 
                                   class="px-3 py-2 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                                    <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                                    </svg>
                                </a>
                            @else
                                <span class="px-3 py-2 bg-gray-100 border border-gray-200 rounded-lg cursor-not-allowed opacity-50">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                                    </svg>
                                </span>
                            @endif

                            <!-- Números de página -->
                            @php
                                $start = max(1, $pagination['current_page'] - 2);
                                $end = min($pagination['last_page'], $pagination['current_page'] + 2);
                            @endphp

                            @if($start > 1)
                                <a href="{{ route('admin.persona.index', ['tipo' => $tipo, 'buscar' => $buscar, 'page' => 1]) }}" 
                                   class="px-3 py-2 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors text-sm font-medium text-gray-700">
                                    1
                                </a>
                                @if($start > 2)
                                    <span class="px-2 text-gray-500">...</span>
                                @endif
                            @endif

                            @for($i = $start; $i <= $end; $i++)
                                <a href="{{ route('admin.persona.index', ['tipo' => $tipo, 'buscar' => $buscar, 'page' => $i]) }}" 
                                   class="px-3 py-2 rounded-lg transition-colors text-sm font-medium {{ $i == $pagination['current_page'] ? 'bg-green-600 text-white' : 'bg-white border border-gray-300 text-gray-700 hover:bg-gray-50' }}">
                                    {{ $i }}
                                </a>
                            @endfor

                            @if($end < $pagination['last_page'])
                                @if($end < $pagination['last_page'] - 1)
                                    <span class="px-2 text-gray-500">...</span>
                                @endif
                                <a href="{{ route('admin.persona.index', ['tipo' => $tipo, 'buscar' => $buscar, 'page' => $pagination['last_page']]) }}" 
                                   class="px-3 py-2 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors text-sm font-medium text-gray-700">
                                    {{ $pagination['last_page'] }}
                                </a>
                            @endif

                            @if($pagination['current_page'] < $pagination['last_page'])
                                <a href="{{ route('admin.persona.index', ['tipo' => $tipo, 'buscar' => $buscar, 'page' => $pagination['current_page'] + 1]) }}" 
                                   class="px-3 py-2 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                                    <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </a>
                            @else
                                <span class="px-3 py-2 bg-gray-100 border border-gray-200 rounded-lg cursor-not-allowed opacity-50">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

</x-admin-layout>
