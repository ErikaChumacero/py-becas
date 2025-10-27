<x-student-layout>
    <div class="space-y-6">
        <!-- Header -->
        <div class="bg-gradient-to-r from-blue-600 to-blue-800 rounded-lg shadow-lg p-8 text-white">
            <h1 class="text-4xl font-bold mb-2">Principal</h1>
            @php($u = session('usuario'))
            @if($u)
                <p class="text-blue-100 text-lg">Bienvenido/a, {{ $u['nombre'] ?? '' }} {{ $u['apellido'] ?? '' }}</p>
            @else
                <p class="text-blue-100 text-lg">Sistema de Gestión de Becas</p>
            @endif
        </div>

        <!-- Becas Disponibles -->
        <div>
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-2xl font-bold text-gray-800">Becas Disponibles</h2>
                <a href="{{ route('estudiante.convocatoria.index') }}" class="text-blue-600 hover:text-blue-800 font-medium flex items-center gap-2">
                    Ver todas las convocatorias
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($becas as $beca)
                    <div class="bg-white rounded-xl shadow-md hover:shadow-xl transition-all duration-300 overflow-hidden group">
                        <!-- Header de la tarjeta -->
                        <div class="bg-gradient-to-r from-blue-500 to-blue-600 p-6 text-white">
                            <div class="flex items-start justify-between">
                                <div class="flex-1">
                                    <h3 class="text-xl font-bold mb-2">{{ $beca->nombre_beca }}</h3>
                                    <div class="flex items-center gap-2">
                                        <span class="bg-white/20 backdrop-blur-sm px-3 py-1 rounded-full text-sm font-medium">
                                            {{ $beca->convocatorias_activas }} {{ $beca->convocatorias_activas == 1 ? 'Convocatoria' : 'Convocatorias' }}
                                        </span>
                                    </div>
                                </div>
                                <div class="bg-white/20 backdrop-blur-sm rounded-full p-3">
                                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>

                        <!-- Contenido de la tarjeta -->
                        <div class="p-6">
                            <p class="text-gray-600 text-sm mb-4 line-clamp-3">
                                {{ $beca->descripcion ?: 'Beca disponible para estudiantes universitarios. Revisa los requisitos y postula ahora.' }}
                            </p>

                            <!-- Fechas -->
                            <div class="bg-gray-50 rounded-lg p-4 mb-4">
                                <div class="flex items-center justify-between text-sm">
                                    <div>
                                        <p class="text-gray-500 text-xs">Inicio</p>
                                        <p class="font-semibold text-gray-800">{{ \Carbon\Carbon::parse($beca->fecha_inicio)->format('d/m/Y') }}</p>
                                    </div>
                                    <div class="text-gray-400">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                                        </svg>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-gray-500 text-xs">Fin</p>
                                        <p class="font-semibold text-gray-800">{{ \Carbon\Carbon::parse($beca->fecha_fin)->format('d/m/Y') }}</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Botón de acción -->
                            <a href="{{ route('estudiante.postulacion.create') }}" 
                               class="block w-full text-center bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white font-medium py-3 px-4 rounded-lg transition-all duration-200 transform group-hover:scale-105">
                                Postular Ahora
                            </a>
                        </div>

                        <!-- Footer con indicador -->
                        <div class="bg-blue-50 border-t border-blue-100 px-6 py-3">
                            <div class="flex items-center gap-2 text-blue-700">
                                <div class="w-2 h-2 bg-blue-500 rounded-full animate-pulse"></div>
                                <span class="text-sm font-medium">Convocatoria abierta</span>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full">
                        <div class="bg-gray-50 rounded-lg p-12 text-center">
                            <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                            </svg>
                            <h3 class="text-lg font-semibold text-gray-700 mb-2">No hay becas disponibles en este momento</h3>
                            <p class="text-gray-500 mb-4">Las convocatorias aparecerán aquí cuando estén activas</p>
                            <a href="{{ route('estudiante.convocatoria.index') }}" class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-6 rounded-lg transition">
                                Ver Historial de Convocatorias
                            </a>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</x-student-layout>
