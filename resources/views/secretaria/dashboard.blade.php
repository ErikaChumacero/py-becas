<x-secretaria-layout>
    <div class="space-y-8">
        <!-- Header -->
        <div class="bg-gradient-to-r from-emerald-600 to-green-600 rounded-xl shadow-lg p-8 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-4xl font-bold mb-2">Panel de Secretaría</h1>
                    <p class="text-emerald-100 text-lg">Sistema de Gestión Escolar - Bienvenido/a</p>
                </div>
                <div class="hidden md:block">
                    <svg class="w-20 h-20 text-emerald-200 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Estadísticas Principales -->
        <div>
            <h2 class="text-2xl font-bold text-gray-800 mb-4 flex items-center gap-2">
                <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                </svg>
                Estadísticas Generales
            </h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-emerald-500 hover:shadow-lg transition-shadow">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm font-medium uppercase">Gestiones</p>
                        <p class="text-3xl font-bold text-gray-800 mt-2">{{ $stats->gestiones_activas }}</p>
                    </div>
                    <div class="bg-emerald-100 rounded-full p-3">
                        <svg class="w-8 h-8 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>  
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-emerald-500 hover:shadow-lg transition-shadow">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm font-medium uppercase">Inscripciones</p>
                        <p class="text-3xl font-bold text-gray-800 mt-2">{{ $stats->total_inscripciones }}</p>
                    </div>
                    <div class="bg-emerald-100 rounded-full p-3">
                        <svg class="w-8 h-8 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-green-500 hover:shadow-lg transition-shadow">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm font-medium uppercase">Estudiantes</p>
                        <p class="text-3xl font-bold text-gray-800 mt-2">{{ $stats->total_estudiantes }}</p>
                    </div>
                    <div class="bg-green-100 rounded-full p-3">
                        <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-cyan-500 hover:shadow-lg transition-shadow">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm font-medium uppercase">Mensualidades</p>
                        <p class="text-3xl font-bold text-gray-800 mt-2">{{ $stats->total_mensualidades }}</p>
                    </div>
                    <div class="bg-cyan-100 rounded-full p-3">
                        <svg class="w-8 h-8 text-cyan-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-teal-600 hover:shadow-lg transition-shadow">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm font-medium uppercase">Maestros</p>
                        <p class="text-3xl font-bold text-gray-800 mt-2">{{ $stats->total_maestros }}</p>
                    </div>
                    <div class="bg-teal-100 rounded-full p-3">
                        <svg class="w-8 h-8 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-lime-500 hover:shadow-lg transition-shadow">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm font-medium uppercase">Niveles</p>
                        <p class="text-3xl font-bold text-gray-800 mt-2">{{ $stats->total_niveles }}</p>
                    </div>
                    <div class="bg-lime-100 rounded-full p-3">
                        <svg class="w-8 h-8 text-lime-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                        </svg>
                    </div>
                </div>
            </div>
            </div>
        </div>

        <!-- Actividad Reciente -->
        <div>
            <h2 class="text-2xl font-bold text-gray-800 mb-4 flex items-center gap-2">
                <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                Actividad Reciente
            </h2>
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Últimas Inscripciones -->
            <div class="bg-white rounded-xl shadow-md p-6 hover:shadow-lg transition-shadow">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-bold text-gray-800 flex items-center gap-2">
                        <div class="bg-teal-100 p-2 rounded-lg">
                            <svg class="w-5 h-5 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                        Últimas Inscripciones
                    </h3>
                    <a href="{{ route('secretaria.inscripcion.index') }}" class="text-teal-600 hover:text-teal-700 text-sm font-medium flex items-center gap-1">
                        Ver todas
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </a>
                </div>

                @if(count($ultimasInscripciones) > 0)
                    <div class="space-y-3">
                        @foreach($ultimasInscripciones as $inscripcion)
                            <div class="border border-gray-200 rounded-lg p-4 hover:bg-green-50 transition-colors">
                                <div class="flex items-start justify-between">
                                    <div class="flex-1">
                                        <h3 class="font-semibold text-gray-800">{{ $inscripcion->estudiante }}</h3>
                                        <p class="text-sm text-gray-600 mt-1">
                                            <span class="inline-flex items-center gap-1">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                                </svg>
                                                {{ $inscripcion->nivel }} - {{ $inscripcion->curso }}
                                            </span>
                                        </p>
                                        <p class="text-xs text-gray-500 mt-1">{{ \Carbon\Carbon::parse($inscripcion->fechainscripcion)->format('d/m/Y') }}</p>
                                    </div>
                                    <span class="px-3 py-1 rounded-full text-xs font-medium
                                        {{ $inscripcion->estado == '1' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                        {{ $inscripcion->estado == '1' ? 'Activa' : 'Inactiva' }}
                                    </span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8 text-gray-500">
                        <svg class="w-16 h-16 mx-auto text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        <p>No hay inscripciones registradas</p>
                    </div>
                @endif
            </div>

            <!-- Mensualidades Pendientes -->
            <div class="bg-white rounded-xl shadow-md p-6 hover:shadow-lg transition-shadow">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-bold text-gray-800 flex items-center gap-2">
                        <div class="bg-cyan-100 p-2 rounded-lg">
                            <svg class="w-5 h-5 text-cyan-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        Mensualidades Pendientes
                    </h3>
                    <a href="{{ route('secretaria.mensualidad.index') }}" class="text-cyan-600 hover:text-cyan-700 text-sm font-medium flex items-center gap-1">
                        Ver todas
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </a>
                </div>

                @if(count($mensualidadesPendientes) > 0)
                    <div class="space-y-3">
                        @foreach($mensualidadesPendientes as $mensualidad)
                            <div class="border border-gray-200 rounded-lg p-4 hover:bg-yellow-50 transition-colors">
                                <div class="flex items-start justify-between">
                                    <div class="flex-1">
                                        <h3 class="font-semibold text-gray-800">{{ $mensualidad->estudiante }}</h3>
                                        <p class="text-sm text-gray-600 mt-1">Mes: {{ $mensualidad->mes }}</p>
                                        <p class="text-sm font-medium text-cyan-600 mt-1">Bs. {{ number_format($mensualidad->monto, 2) }}</p>
                                        <p class="text-xs text-gray-500 mt-1">Vence: {{ \Carbon\Carbon::parse($mensualidad->fechavencimiento)->format('d/m/Y') }}</p>
                                    </div>
                                    <span class="px-3 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                        Pendiente
                                    </span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8 text-gray-500">
                        <svg class="w-16 h-16 mx-auto text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <p>No hay mensualidades pendientes</p>
                    </div>
                @endif
            </div>
            </div>
        </div>

        <!-- Accesos Rápidos -->
        <div>
            <h2 class="text-2xl font-bold text-gray-800 mb-4 flex items-center gap-2">
                <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                </svg>
                Accesos Rápidos
            </h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                <!-- Registrar Persona -->
                <a href="{{ route('secretaria.persona.create') }}" class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl shadow-md p-6 text-white hover:shadow-xl hover:scale-105 transition-all duration-200 group">
                    <div class="flex items-center justify-between mb-3">
                        <div class="bg-white/20 p-3 rounded-lg group-hover:bg-white/30 transition-colors">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                            </svg>
                        </div>
                        <svg class="w-5 h-5 opacity-50 group-hover:opacity-100 group-hover:translate-x-1 transition-all" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </div>
                    <h3 class="font-bold text-lg mb-1">Registrar Persona</h3>
                    <p class="text-blue-100 text-sm">Agregar nuevo estudiante o tutor</p>
                </a>

                <!-- Nueva Inscripción -->
                <a href="{{ route('secretaria.inscripcion.create') }}" class="bg-gradient-to-br from-green-500 to-green-600 rounded-xl shadow-md p-6 text-white hover:shadow-xl hover:scale-105 transition-all duration-200 group">
                    <div class="flex items-center justify-between mb-3">
                        <div class="bg-white/20 p-3 rounded-lg group-hover:bg-white/30 transition-colors">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                        <svg class="w-5 h-5 opacity-50 group-hover:opacity-100 group-hover:translate-x-1 transition-all" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </div>
                    <h3 class="font-bold text-lg mb-1">Nueva Inscripción</h3>
                    <p class="text-green-100 text-sm">Inscribir estudiante a curso</p>
                </a>

                <!-- Registrar Pago -->
                <a href="{{ route('secretaria.mensualidad.create') }}" class="bg-gradient-to-br from-cyan-500 to-cyan-600 rounded-xl shadow-md p-6 text-white hover:shadow-xl hover:scale-105 transition-all duration-200 group">
                    <div class="flex items-center justify-between mb-3">
                        <div class="bg-white/20 p-3 rounded-lg group-hover:bg-white/30 transition-colors">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                        </div>
                        <svg class="w-5 h-5 opacity-50 group-hover:opacity-100 group-hover:translate-x-1 transition-all" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </div>
                    <h3 class="font-bold text-lg mb-1">Registrar Pago</h3>
                    <p class="text-cyan-100 text-sm">Registrar mensualidad</p>
                </a>

                <!-- Asignar Beca -->
                <a href="{{ route('secretaria.beca.create') }}" class="bg-gradient-to-br from-yellow-500 to-orange-500 rounded-xl shadow-md p-6 text-white hover:shadow-xl hover:scale-105 transition-all duration-200 group">
                    <div class="flex items-center justify-between mb-3">
                        <div class="bg-white/20 p-3 rounded-lg group-hover:bg-white/30 transition-colors">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7"></path>
                            </svg>
                        </div>
                        <svg class="w-5 h-5 opacity-50 group-hover:opacity-100 group-hover:translate-x-1 transition-all" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </div>
                    <h3 class="font-bold text-lg mb-1">Asignar Beca</h3>
                    <p class="text-yellow-100 text-sm">Otorgar beca a estudiante</p>
                </a>
            </div>
        </div>
    </div>
</x-secretaria-layout>
