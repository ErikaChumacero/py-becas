<x-admin-layout>
    <div class="space-y-6">
        <!-- Header -->
        <div class="bg-gradient-to-r from-green-600 to-teal-600 rounded-xl shadow-lg p-8 text-white">
            <h1 class="text-4xl font-bold mb-2">Panel de Administración</h1>
            <p class="text-green-100 text-lg">Sistema de Gestión Escolar</p>
        </div>

        <!-- Estadísticas Rápidas -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            <div class="bg-gradient-to-br from-green-100 to-emerald-200 rounded-xl shadow-lg p-6 hover:shadow-2xl hover:scale-105 transition-all duration-300 border border-green-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-green-700 text-xs font-semibold uppercase tracking-wide">Gestiones Activas</p>
                        <p class="text-4xl font-bold text-green-800 mt-2">{{ $stats->gestiones_activas }}</p>
                    </div>
                    <div class="bg-green-200/50 backdrop-blur-sm rounded-2xl p-3 shadow-lg">
                        <svg class="w-10 h-10 text-green-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-gradient-to-br from-amber-100 to-yellow-200 rounded-xl shadow-lg p-6 hover:shadow-2xl hover:scale-105 transition-all duration-300 border border-amber-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-amber-700 text-xs font-semibold uppercase tracking-wide">Inscripciones</p>
                        <p class="text-4xl font-bold text-amber-800 mt-2">{{ $stats->total_inscripciones }}</p>
                    </div>
                    <div class="bg-amber-200/50 backdrop-blur-sm rounded-2xl p-3 shadow-lg">
                        <svg class="w-10 h-10 text-amber-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-gradient-to-br from-teal-100 to-cyan-200 rounded-xl shadow-lg p-6 hover:shadow-2xl hover:scale-105 transition-all duration-300 border border-teal-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-teal-700 text-xs font-semibold uppercase tracking-wide">Estudiantes</p>
                        <p class="text-4xl font-bold text-teal-800 mt-2">{{ $stats->total_estudiantes }}</p>
                    </div>
                    <div class="bg-teal-200/50 backdrop-blur-sm rounded-2xl p-3 shadow-lg">
                        <svg class="w-10 h-10 text-teal-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-gradient-to-br from-lime-100 to-green-200 rounded-xl shadow-lg p-6 hover:shadow-2xl hover:scale-105 transition-all duration-300 border border-lime-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-lime-700 text-xs font-semibold uppercase tracking-wide">Maestros</p>
                        <p class="text-4xl font-bold text-lime-800 mt-2">{{ $stats->total_maestros }}</p>
                    </div>
                    <div class="bg-lime-200/50 backdrop-blur-sm rounded-2xl p-3 shadow-lg">
                        <svg class="w-10 h-10 text-lime-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Accesos Rápidos -->
        <div>
            <h2 class="text-2xl font-bold text-gray-800 mb-6">Accesos Rápidos</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <a href="{{ route('admin.persona.index') }}" class="group bg-gradient-to-br from-purple-100 to-indigo-200 rounded-xl shadow-lg p-6 hover:shadow-2xl hover:scale-105 transition-all duration-300 border border-purple-200">
                    <div class="flex items-center gap-4">
                        <div class="bg-purple-200/50 backdrop-blur-sm rounded-2xl p-3 group-hover:bg-purple-300/50 transition-all">
                            <svg class="w-8 h-8 text-purple-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-bold text-purple-800 text-lg">Personas</h3>
                            <p class="text-sm text-purple-600">Gestionar usuarios</p>
                        </div>
                    </div>
                </a>

                <a href="{{ route('admin.inscripcion.index') }}" class="group bg-gradient-to-br from-pink-100 to-rose-200 rounded-xl shadow-lg p-6 hover:shadow-2xl hover:scale-105 transition-all duration-300 border border-pink-200">
                    <div class="flex items-center gap-4">
                        <div class="bg-pink-200/50 backdrop-blur-sm rounded-2xl p-3 group-hover:bg-pink-300/50 transition-all">
                            <svg class="w-8 h-8 text-pink-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-bold text-pink-800 text-lg">Inscripciones</h3>
                            <p class="text-sm text-pink-600">Gestionar inscripciones</p>
                        </div>
                    </div>
                </a>

                <a href="{{ route('admin.beca.index') }}" class="group bg-gradient-to-br from-orange-100 to-amber-200 rounded-xl shadow-lg p-6 hover:shadow-2xl hover:scale-105 transition-all duration-300 border border-orange-200">
                    <div class="flex items-center gap-4">
                        <div class="bg-orange-200/50 backdrop-blur-sm rounded-2xl p-3 group-hover:bg-orange-300/50 transition-all">
                            <svg class="w-8 h-8 text-orange-700" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-bold text-orange-800 text-lg">Becas</h3>
                            <p class="text-sm text-orange-600">Gestionar becas</p>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
</x-admin-layout>
