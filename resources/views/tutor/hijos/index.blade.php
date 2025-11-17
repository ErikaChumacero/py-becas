<x-tutor-layout>
    <div class="space-y-6">
        <!-- Header -->
        <div class="bg-gradient-to-r from-green-600 to-emerald-600 rounded-xl shadow-lg p-8 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-4xl font-bold mb-2">Mis Hijos</h1>
                    <p class="text-green-100 text-lg">Información de estudiantes a tu cargo</p>
                </div>
                <div class="hidden md:block">
                    <svg class="w-20 h-20 text-green-200 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
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

        <!-- Contador -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="bg-green-100 rounded-full p-3">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600 font-medium">Total de Hijos Inscritos</p>
                        <p class="text-2xl font-bold text-gray-800">{{ count($hijos) }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Lista de Hijos -->
        @if(count($hijos) > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($hijos as $hijo)
                    <div class="bg-white rounded-xl shadow-md hover:shadow-xl transition-shadow overflow-hidden">
                        <!-- Header de la tarjeta -->
                        <div class="bg-gradient-to-r from-green-500 to-emerald-500 p-6">
                            <div class="flex items-center gap-4">
                                <div class="flex-shrink-0 w-16 h-16 rounded-full bg-white text-green-600 flex items-center justify-center font-bold text-xl shadow-lg">
                                    {{ strtoupper(substr($hijo->nombre, 0, 1)) }}{{ strtoupper(substr($hijo->apellido, 0, 1)) }}
                                </div>
                                <div class="flex-1 min-w-0">
                                    <h3 class="font-bold text-white text-lg truncate">{{ $hijo->nombre }} {{ $hijo->apellido }}</h3>
                                    <p class="text-green-100 text-sm">{{ $hijo->sexo === 'M' ? '👦 Hijo' : '👧 Hija' }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Contenido de la tarjeta -->
                        <div class="p-6 space-y-4">
                            <!-- Información básica -->
                            <div class="space-y-2">
                                <div class="flex items-center gap-2 text-sm">
                                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"></path>
                                    </svg>
                                    <span class="text-gray-600">CI:</span>
                                    <span class="font-semibold text-gray-900">{{ $hijo->ci }}</span>
                                </div>

                                <div class="flex items-center gap-2 text-sm">
                                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                    </svg>
                                    <span class="text-gray-600">Código:</span>
                                    <span class="font-semibold text-gray-900">{{ $hijo->codestudiante }}</span>
                                </div>
                            </div>

                            <!-- Información académica actual -->
                            @if($hijo->gestion_actual)
                                <div class="pt-4 border-t border-gray-200 space-y-2">
                                    <p class="text-xs font-semibold text-gray-500 uppercase">Información Actual</p>
                                    
                                    <div class="bg-blue-50 rounded-lg p-3 space-y-1">
                                        <p class="text-sm">
                                            <span class="text-gray-600">📅 Gestión:</span>
                                            <span class="font-semibold text-gray-900 ml-1">{{ $hijo->gestion_actual }}</span>
                                        </p>
                                        <p class="text-sm">
                                            <span class="text-gray-600">📚 Nivel:</span>
                                            <span class="font-semibold text-gray-900 ml-1">{{ $hijo->nivel_actual }}</span>
                                        </p>
                                        <p class="text-sm">
                                            <span class="text-gray-600">🎓 Curso:</span>
                                            <span class="font-semibold text-gray-900 ml-1">{{ $hijo->curso_actual }}</span>
                                        </p>
                                    </div>

                                    @if($hijo->beca_actual)
                                        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-3">
                                            <div class="flex items-center gap-2">
                                                <svg class="w-5 h-5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7"></path>
                                                </svg>
                                                <div>
                                                    <p class="text-sm font-semibold text-yellow-900">{{ $hijo->beca_actual }}</p>
                                                    <p class="text-xs text-yellow-700">{{ $hijo->porcentaje_beca }}% de descuento</p>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            @endif

                            <!-- Estadísticas -->
                            <div class="pt-4 border-t border-gray-200">
                                <div class="grid grid-cols-2 gap-3">
                                    <div class="bg-gray-50 rounded-lg p-3 text-center">
                                        <p class="text-2xl font-bold text-gray-800">{{ $hijo->total_gestiones }}</p>
                                        <p class="text-xs text-gray-600">Gestiones</p>
                                    </div>
                                    <div class="bg-gray-50 rounded-lg p-3 text-center">
                                        <p class="text-2xl font-bold text-gray-800">{{ $hijo->total_mensualidades }}</p>
                                        <p class="text-xs text-gray-600">Mensualidades</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Botón ver detalle -->
                            <div class="pt-4">
                                <a href="{{ route('tutor.hijos.show', $hijo->ci) }}" 
                                    class="block w-full text-center px-4 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors font-medium">
                                    Ver Detalle Completo
                                    <svg class="w-4 h-4 inline-block ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <!-- Sin hijos -->
            <div class="bg-white rounded-xl shadow-md p-12 text-center">
                <svg class="w-24 h-24 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                </svg>
                <h3 class="text-xl font-semibold text-gray-700 mb-2">No hay hijos inscritos</h3>
                <p class="text-gray-500">No se encontraron estudiantes asociados a tu cuenta.</p>
            </div>
        @endif
    </div>
</x-tutor-layout>
