<x-app-layout>
    <div class="space-y-6">
        <!-- Header -->
        <div class="bg-gradient-to-r from-green-600 to-green-800 rounded-lg shadow-lg p-8 text-white">
            <h1 class="text-4xl font-bold mb-2">Panel de Estudiante</h1>
            <p class="text-green-100 text-lg">Bienvenido, {{ $estudiante->nombre ?? 'Estudiante' }} {{ $estudiante->apellido ?? '' }}</p>
        </div>

        <!-- Información del Estudiante -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-blue-500">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm font-medium uppercase">Código Estudiante</p>
                        <p class="text-2xl font-bold text-gray-800 mt-2">{{ $estudiante->codestudiante ?? 'N/A' }}</p>
                    </div>
                    <div class="bg-blue-100 rounded-full p-3">
                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-purple-500">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm font-medium uppercase">Inscripciones</p>
                        <p class="text-2xl font-bold text-gray-800 mt-2">{{ $estudiante->total_inscripciones ?? 0 }}</p>
                    </div>
                    <div class="bg-purple-100 rounded-full p-3">
                        <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-amber-500">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm font-medium uppercase">Mensualidades</p>
                        <p class="text-2xl font-bold text-gray-800 mt-2">{{ $estudiante->total_mensualidades ?? 0 }}</p>
                    </div>
                    <div class="bg-amber-100 rounded-full p-3">
                        <svg class="w-8 h-8 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Mensaje informativo -->
        <div class="bg-blue-50 border-l-4 border-blue-500 p-6 rounded-r-lg">
            <div class="flex items-start">
                <svg class="w-6 h-6 text-blue-500 mr-3 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                </svg>
                <div>
                    <h3 class="text-lg font-semibold text-blue-800 mb-2">Panel de Estudiante</h3>
                    <p class="text-blue-700">
                        Este es tu panel de estudiante. Aquí podrás ver tu información académica, inscripciones, mensualidades y más.
                    </p>
                    <p class="text-blue-600 text-sm mt-2">
                        <strong>Nota:</strong> Los módulos adicionales están en desarrollo.
                    </p>
                </div>
            </div>
        </div>

        <!-- Accesos Rápidos (Deshabilitados temporalmente) -->
        <div>
            <h2 class="text-2xl font-bold text-gray-800 mb-6">Accesos Rápidos</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-gray-300 opacity-50 cursor-not-allowed">
                    <div class="flex items-center gap-4">
                        <div class="bg-gray-100 rounded-full p-3">
                            <svg class="w-8 h-8 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-800">Mis Inscripciones</h3>
                            <p class="text-sm text-gray-500">Próximamente</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-gray-300 opacity-50 cursor-not-allowed">
                    <div class="flex items-center gap-4">
                        <div class="bg-gray-100 rounded-full p-3">
                            <svg class="w-8 h-8 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-800">Mis Pagos</h3>
                            <p class="text-sm text-gray-500">Próximamente</p>
                        </div>
                    </div>
                </div>

                <a href="{{ route('estudiante.perfil.index') }}" class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition-shadow border-l-4 border-green-500">
                    <div class="flex items-center gap-4">
                        <div class="bg-green-100 rounded-full p-3">
                            <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-800">Mi Perfil</h3>
                            <p class="text-sm text-gray-500">Ver y editar</p>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
