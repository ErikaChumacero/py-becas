<x-tutor-layout>
    <div class="space-y-6">
        <!-- Header -->
        <div class="bg-gradient-to-r from-cyan-600 to-blue-600 rounded-xl shadow-lg p-8 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-4xl font-bold mb-2">Mensualidades</h1>
                    <p class="text-cyan-100 text-lg">Pagos realizados y pendientes de tus hijos</p>
                </div>
                <div class="hidden md:block">
                    <svg class="w-20 h-20 text-cyan-200 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
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

        <!-- Estadísticas -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-green-500">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm font-medium uppercase">Pagadas</p>
                        <p class="text-3xl font-bold text-gray-800 mt-2">{{ $estadisticas->total_pagadas }}</p>
                    </div>
                    <div class="bg-green-100 rounded-full p-3">
                        <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-red-500">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm font-medium uppercase">Pendientes</p>
                        <p class="text-3xl font-bold text-gray-800 mt-2">{{ $estadisticas->total_pendientes }}</p>
                    </div>
                    <div class="bg-red-100 rounded-full p-3">
                        <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-cyan-500">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm font-medium uppercase">Total Pagado</p>
                        <p class="text-2xl font-bold text-gray-800 mt-2">Bs. {{ number_format($estadisticas->total_pagado, 2) }}</p>
                    </div>
                    <div class="bg-cyan-100 rounded-full p-3">
                        <svg class="w-8 h-8 text-cyan-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filtros -->
        <div class="bg-white rounded-xl shadow-md p-6">
            <h2 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2">
                <svg class="w-5 h-5 text-cyan-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
                </svg>
                Filtros
            </h2>

            <form method="GET" action="{{ route('tutor.mensualidad.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <!-- Filtro Estado -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Estado</label>
                    <select name="estado" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-transparent">
                        <option value="todas" {{ $filtroEstado === 'todas' ? 'selected' : '' }}>Todas</option>
                        <option value="pagadas" {{ $filtroEstado === 'pagadas' ? 'selected' : '' }}>✅ Pagadas</option>
                        <option value="pendientes" {{ $filtroEstado === 'pendientes' ? 'selected' : '' }}>⏳ Pendientes</option>
                    </select>
                </div>

                <!-- Filtro Hijo -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Hijo</label>
                    <select name="hijo" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-transparent">
                        <option value="todos" {{ $filtroHijo === 'todos' ? 'selected' : '' }}>Todos</option>
                        @foreach($hijos as $hijo)
                            <option value="{{ $hijo->ci }}" {{ $filtroHijo === $hijo->ci ? 'selected' : '' }}>
                                {{ $hijo->nombre }} {{ $hijo->apellido }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Filtro Gestión -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Gestión</label>
                    <select name="gestion" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-transparent">
                        <option value="todas" {{ $filtroGestion === 'todas' ? 'selected' : '' }}>Todas</option>
                        @foreach($gestiones as $gestion)
                            <option value="{{ $gestion->idgestion }}" {{ $filtroGestion == $gestion->idgestion ? 'selected' : '' }}>
                                {{ $gestion->detalleges }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Botones -->
                <div class="flex items-end gap-2">
                    <button type="submit" class="flex-1 px-4 py-2 bg-cyan-600 text-white rounded-lg hover:bg-cyan-700 transition-colors font-medium">
                        Filtrar
                    </button>
                    <a href="{{ route('tutor.mensualidad.index') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                        </svg>
                    </a>
                </div>
            </form>
        </div>

        <!-- Tabla de Mensualidades -->
        <div class="bg-white rounded-xl shadow-md overflow-hidden">
            <div class="p-6 border-b border-gray-200">
                <h2 class="text-xl font-bold text-gray-800 flex items-center gap-2">
                    <svg class="w-6 h-6 text-cyan-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                    </svg>
                    Listado de Mensualidades ({{ count($mensualidades) }})
                </h2>
            </div>

            @if(count($mensualidades) > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase">Estado</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase">Estudiante</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase">Mes</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase">Gestión</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase">Nivel/Curso</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase">Monto</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase">Fecha Pago</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($mensualidades as $mensualidad)
                                <tr class="hover:bg-gray-50 {{ $mensualidad->estado === 'PENDIENTE' ? 'bg-red-50' : '' }}">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($mensualidad->estado === 'PAGADA')
                                            <span class="px-3 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                                ✅ Pagada
                                            </span>
                                        @else
                                            <span class="px-3 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">
                                                ⏳ Pendiente
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 w-8 h-8 rounded-full bg-cyan-100 text-cyan-600 flex items-center justify-center font-bold text-xs">
                                                {{ strtoupper(substr($mensualidad->estudiante, 0, 2)) }}
                                            </div>
                                            <div class="ml-3">
                                                <p class="text-sm font-medium text-gray-900">{{ $mensualidad->estudiante }}</p>
                                                <p class="text-xs text-gray-500">{{ $mensualidad->codestudiante }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                        {{ $mensualidad->mes }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                        {{ $mensualidad->gestion }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                        {{ $mensualidad->nivel }} - {{ $mensualidad->curso }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold {{ $mensualidad->estado === 'PAGADA' ? 'text-green-600' : 'text-red-600' }}">
                                        Bs. {{ number_format($mensualidad->monto, 2) }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                        @if($mensualidad->fechamen)
                                            {{ \Carbon\Carbon::parse($mensualidad->fechamen)->format('d/m/Y') }}
                                        @else
                                            <span class="text-gray-400">-</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        @if($mensualidad->estado === 'PAGADA')
                                            <a href="{{ route('tutor.mensualidad.show', $mensualidad->idmensualidad) }}" 
                                                class="text-cyan-600 hover:text-cyan-900 font-medium">
                                                Ver Detalle
                                            </a>
                                        @else
                                            <span class="text-gray-400">-</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="p-12 text-center">
                    <svg class="w-20 h-20 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                    </svg>
                    <h3 class="text-xl font-semibold text-gray-700 mb-2">No hay mensualidades</h3>
                    <p class="text-gray-500">No se encontraron mensualidades con los filtros seleccionados.</p>
                </div>
            @endif
        </div>
    </div>
</x-tutor-layout>
