<x-tutor-layout>
    <div class="space-y-6">
        <!-- Header -->
        <div class="bg-gradient-to-r from-cyan-600 to-blue-600 rounded-xl shadow-lg p-8 text-white">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-4">
                    <a href="{{ route('tutor.mensualidad.index') }}" class="bg-white/20 hover:bg-white/30 rounded-lg p-2 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                        </svg>
                    </a>
                    <div>
                        <h1 class="text-4xl font-bold mb-2">Detalle de Mensualidad</h1>
                        <p class="text-cyan-100 text-lg">Información completa del pago</p>
                    </div>
                </div>
                <div class="hidden md:block">
                    <div class="bg-white/20 rounded-full p-4">
                        <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Información Principal -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Información del Pago -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-xl shadow-md p-8">
                    <h2 class="text-2xl font-bold text-gray-800 mb-6 flex items-center gap-2">
                        <svg class="w-7 h-7 text-cyan-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        Información del Pago
                    </h2>

                    <div class="space-y-6">
                        <!-- ID y Estado -->
                        <div class="grid grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-semibold text-gray-600 mb-2">ID Mensualidad</label>
                                <p class="text-lg font-bold text-gray-900">#{{ $mensualidad->idmensualidad }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-600 mb-2">Estado</label>
                                <span class="inline-flex px-4 py-2 text-sm font-bold rounded-full bg-green-100 text-green-800">
                                    ✅ PAGADA
                                </span>
                            </div>
                        </div>

                        <!-- Mes y Monto -->
                        <div class="grid grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-semibold text-gray-600 mb-2">Mes</label>
                                <p class="text-lg font-bold text-gray-900">{{ $mensualidad->mes }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-600 mb-2">Monto Pagado</label>
                                <p class="text-2xl font-bold text-green-600">Bs. {{ number_format($mensualidad->monto, 2) }}</p>
                            </div>
                        </div>

                        <!-- Fecha y Tipo de Pago -->
                        <div class="grid grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-semibold text-gray-600 mb-2">Fecha de Pago</label>
                                <p class="text-lg text-gray-900">{{ \Carbon\Carbon::parse($mensualidad->fechamen)->format('d/m/Y') }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-600 mb-2">Tipo de Pago</label>
                                <span class="inline-flex px-3 py-1 text-sm font-semibold rounded-full {{ $mensualidad->tipopago === 'E' ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800' }}">
                                    {{ $mensualidad->tipopago === 'E' ? '💵 Efectivo' : '🏦 Transferencia' }}
                                </span>
                            </div>
                        </div>

                        <!-- Observación -->
                        @if($mensualidad->observacion)
                            <div>
                                <label class="block text-sm font-semibold text-gray-600 mb-2">Observación</label>
                                <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                                    <p class="text-gray-900">{{ $mensualidad->observacion }}</p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Información del Estudiante -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-xl shadow-md p-6 space-y-6">
                    <h2 class="text-xl font-bold text-gray-800 flex items-center gap-2">
                        <svg class="w-6 h-6 text-cyan-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        Estudiante
                    </h2>

                    <div class="text-center">
                        <div class="w-20 h-20 mx-auto rounded-full bg-cyan-100 text-cyan-600 flex items-center justify-center font-bold text-2xl mb-3">
                            {{ strtoupper(substr($mensualidad->estudiante, 0, 2)) }}
                        </div>
                        <h3 class="text-xl font-bold text-gray-900">{{ $mensualidad->estudiante }}</h3>
                        <p class="text-sm text-gray-600 mt-1">{{ $mensualidad->codestudiante }}</p>
                    </div>

                    <div class="pt-4 border-t border-gray-200 space-y-3">
                        <div>
                            <label class="block text-xs font-semibold text-gray-500 uppercase mb-1">CI</label>
                            <p class="text-sm font-medium text-gray-900">{{ $mensualidad->ci }}</p>
                        </div>
                    </div>
                </div>

                <!-- Información Académica -->
                <div class="bg-white rounded-xl shadow-md p-6 mt-6">
                    <h2 class="text-xl font-bold text-gray-800 mb-4 flex items-center gap-2">
                        <svg class="w-6 h-6 text-cyan-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                        Información Académica
                    </h2>

                    <div class="space-y-3">
                        <div>
                            <label class="block text-xs font-semibold text-gray-500 uppercase mb-1">Gestión</label>
                            <p class="text-sm font-medium text-gray-900">{{ $mensualidad->gestion }}</p>
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-gray-500 uppercase mb-1">Nivel</label>
                            <p class="text-sm font-medium text-gray-900">{{ $mensualidad->nivel }}</p>
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-gray-500 uppercase mb-1">Curso</label>
                            <p class="text-sm font-medium text-gray-900">{{ $mensualidad->curso }}</p>
                        </div>

                        @if($mensualidad->beca)
                            <div class="pt-3 border-t border-gray-200">
                                <label class="block text-xs font-semibold text-gray-500 uppercase mb-2">Beca Aplicada</label>
                                <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-3">
                                    <div class="flex items-center gap-2">
                                        <svg class="w-5 h-5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7"></path>
                                        </svg>
                                        <div>
                                            <p class="text-sm font-semibold text-yellow-900">{{ $mensualidad->beca }}</p>
                                            <p class="text-xs text-yellow-700">{{ $mensualidad->porcentaje_beca }}% de descuento</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Botones de Acción -->
        <div class="bg-white rounded-xl shadow-md p-6">
            <div class="flex items-center justify-between">
                <a href="{{ route('tutor.mensualidad.index') }}" 
                    class="px-6 py-3 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-colors font-medium flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                    Volver al Listado
                </a>

                <a href="{{ route('tutor.hijos.show', $mensualidad->ci) }}" 
                    class="px-6 py-3 bg-cyan-600 text-white rounded-lg hover:bg-cyan-700 transition-colors font-medium flex items-center gap-2">
                    Ver Perfil del Estudiante
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </a>
            </div>
        </div>
    </div>
</x-tutor-layout>
