<x-admin-layout>
    <div class="space-y-8 w-full">
        <!-- Hero Header -->
        <div class="bg-gradient-to-br from-green-600 via-emerald-600 to-teal-600 rounded-2xl shadow-xl p-12 text-white overflow-hidden relative">
            <div class="absolute top-0 right-0 w-96 h-96 bg-white/10 rounded-full -mr-48 -mt-48"></div>
            <div class="absolute bottom-0 left-0 w-72 h-72 bg-white/5 rounded-full -ml-36 -mb-36"></div>
            <div class="relative z-10">
                <h1 class="text-5xl font-bold mb-2">ESCUELA CRISTIANA CAMIREÑA</h1>
                <p class="text-green-100 text-lg">Bienvenido al Panel de Administración</p>
            </div>
        </div>

        <!-- Estadísticas Destacadas -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- Estudiantes -->
            <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-2xl shadow-lg p-8 border-l-4 border-blue-600 hover:shadow-xl transition-all duration-300 transform hover:scale-105">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-blue-600 text-sm font-semibold uppercase tracking-wide">Estudiantes</p>
                        <p class="text-4xl font-bold text-blue-900 mt-2">{{ $stats->total_estudiantes }}</p>
                    </div>
                    <div class="bg-blue-600 rounded-full p-4">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Maestros -->
            <div class="bg-gradient-to-br from-purple-50 to-purple-100 rounded-2xl shadow-lg p-8 border-l-4 border-purple-600 hover:shadow-xl transition-all duration-300 transform hover:scale-105">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-purple-600 text-sm font-semibold uppercase tracking-wide">Maestros</p>
                        <p class="text-4xl font-bold text-purple-900 mt-2">{{ $stats->total_maestros }}</p>
                    </div>
                    <div class="bg-purple-600 rounded-full p-4">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Inscripciones -->
            <div class="bg-gradient-to-br from-green-50 to-green-100 rounded-2xl shadow-lg p-8 border-l-4 border-green-600 hover:shadow-xl transition-all duration-300 transform hover:scale-105">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-green-600 text-sm font-semibold uppercase tracking-wide">Inscripciones</p>
                        <p class="text-4xl font-bold text-green-900 mt-2">{{ $stats->total_inscripciones }}</p>
                    </div>
                    <div class="bg-green-600 rounded-full p-4">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Accesos Rápidos Principales -->
        <div>
            <h2 class="text-2xl font-bold text-gray-900 mb-6">Accesos Rápidos</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Registrar Persona -->
                <a href="{{ route('admin.persona.create') }}" class="group bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl shadow-lg p-8 text-white hover:shadow-2xl transition-all duration-300 transform hover:scale-105 hover:-translate-y-1">
                    <div class="bg-white/20 rounded-full p-4 w-fit mb-4 group-hover:bg-white/30 transition-colors">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold mb-2">Registrar Persona</h3>
                    <p class="text-blue-100 text-sm">Agregar nuevos usuarios al sistema</p>
                </a>

                <!-- Nueva Inscripción -->
                <a href="{{ route('admin.inscripcion.create') }}" class="group bg-gradient-to-br from-green-500 to-green-600 rounded-2xl shadow-lg p-8 text-white hover:shadow-2xl transition-all duration-300 transform hover:scale-105 hover:-translate-y-1">
                    <div class="bg-white/20 rounded-full p-4 w-fit mb-4 group-hover:bg-white/30 transition-colors">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold mb-2">Nueva Inscripción</h3>
                    <p class="text-green-100 text-sm">Registrar inscripción de estudiante</p>
                </a>

                <!-- Registrar Pago -->
                <a href="{{ route('admin.mensualidad.create') }}" class="group bg-gradient-to-br from-cyan-500 to-cyan-600 rounded-2xl shadow-lg p-8 text-white hover:shadow-2xl transition-all duration-300 transform hover:scale-105 hover:-translate-y-1">
                    <div class="bg-white/20 rounded-full p-4 w-fit mb-4 group-hover:bg-white/30 transition-colors">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold mb-2">Registrar Pago</h3>
                    <p class="text-cyan-100 text-sm">Registrar mensualidad de estudiante</p>
                </a>

                <!-- Asignar Beca -->
                <a href="{{ route('admin.beca.create') }}" class="group bg-gradient-to-br from-yellow-500 to-yellow-600 rounded-2xl shadow-lg p-8 text-white hover:shadow-2xl transition-all duration-300 transform hover:scale-105 hover:-translate-y-1">
                    <div class="bg-white/20 rounded-full p-4 w-fit mb-4 group-hover:bg-white/30 transition-colors">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold mb-2">Asignar Beca</h3>
                    <p class="text-yellow-100 text-sm">Gestionar becas de estudiantes</p>
                </a>
            </div>
        </div>
    </div>
</x-admin-layout>
