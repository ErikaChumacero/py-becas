<x-admin-layout>
    <div class="max-w-5xl mx-auto space-y-6">
        <!-- Header -->
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.mensualidad.index') }}"
               class="inline-flex items-center justify-center w-10 h-10 rounded-lg bg-gray-100 hover:bg-gray-200 transition-colors">
                <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
            </a>
            <div>
                <h1 class="text-3xl font-bold text-gray-800">Detalle de Mensualidad</h1>
                <p class="text-gray-600 mt-1">Información completa del pago #{{ $mensualidad->idmensualidad }}</p>
            </div>
        </div>

        <!-- Información del Pago -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="bg-gradient-to-r from-emerald-600 to-emerald-700 px-6 py-4">
                <h2 class="text-xl font-bold text-white">Información del Pago</h2>
            </div>
            <div class="p-6 space-y-6">
                <!-- Datos del Estudiante -->
                <div>
                    <h3 class="text-lg font-semibold text-gray-800 mb-3 flex items-center gap-2">
                        <svg class="w-5 h-5 text-indigo-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                        </svg>
                        Datos del Estudiante
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 bg-gray-50 p-4 rounded-lg">
                        <div>
                            <p class="text-xs font-medium text-gray-500 uppercase">Nombre Completo</p>
                            <p class="text-sm font-bold text-gray-900">{{ $mensualidad->estudiante_nombre }}</p>
                        </div>
                        <div>
                            <p class="text-xs font-medium text-gray-500 uppercase">CI</p>
                            <p class="text-sm font-bold text-gray-900">{{ $mensualidad->ci }}</p>
                        </div>
                        <div>
                            <p class="text-xs font-medium text-gray-500 uppercase">Código Estudiante</p>
                            <p class="text-sm font-bold text-gray-900">{{ $mensualidad->codestudiante ?? 'N/A' }}</p>
                        </div>
                    </div>
                </div>

                <!-- Datos Académicos -->
                <div>
                    <h3 class="text-lg font-semibold text-gray-800 mb-3 flex items-center gap-2">
                        <svg class="w-5 h-5 text-indigo-600" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3zM3.31 9.397L5 10.12v4.102a8.969 8.969 0 00-1.05-.174 1 1 0 01-.89-.89 11.115 11.115 0 01.25-3.762zM9.3 16.573A9.026 9.026 0 007 14.935v-3.957l1.818.78a3 3 0 002.364 0l5.508-2.361a11.026 11.026 0 01.25 3.762 1 1 0 01-.89.89 8.968 8.968 0 00-5.35 2.524 1 1 0 01-1.4 0zM6 18a1 1 0 001-1v-2.065a8.935 8.935 0 00-2-.712V17a1 1 0 001 1z"></path>
                        </svg>
                        Datos Académicos
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 bg-gray-50 p-4 rounded-lg">
                        <div>
                            <p class="text-xs font-medium text-gray-500 uppercase">Nivel</p>
                            <p class="text-sm font-bold text-gray-900">{{ $mensualidad->nivel_nombre }}</p>
                        </div>
                        <div>
                            <p class="text-xs font-medium text-gray-500 uppercase">Curso</p>
                            <p class="text-sm font-bold text-gray-900">{{ $mensualidad->curso_nombre }}</p>
                        </div>
                        <div>
                            <p class="text-xs font-medium text-gray-500 uppercase">Gestión</p>
                            <p class="text-sm font-bold text-gray-900">{{ $mensualidad->gestion_nombre }}</p>
                        </div>
                    </div>
                </div>

                <!-- Beca (si tiene) -->
                @if($mensualidad->codbeca)
                <div>
                    <h3 class="text-lg font-semibold text-gray-800 mb-3 flex items-center gap-2">
                        <svg class="w-5 h-5 text-amber-600" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                        </svg>
                        Beca Asignada
                    </h3>
                    <div class="bg-amber-50 border border-amber-200 p-4 rounded-lg">
                        <p class="text-sm font-bold text-amber-900">{{ $mensualidad->nombrebeca }}</p>
                    </div>
                </div>
                @endif

                <!-- Detalle del Pago -->
                <div>
                    <h3 class="text-lg font-semibold text-gray-800 mb-3 flex items-center gap-2">
                        <svg class="w-5 h-5 text-emerald-600" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M8.433 7.418c.155-.103.346-.196.567-.267v1.698a2.305 2.305 0 01-.567-.267C8.07 8.34 8 8.114 8 8c0-.114.07-.34.433-.582zM11 12.849v-1.698c.22.071.412.164.567.267.364.243.433.468.433.582 0 .114-.07.34-.433.582a2.305 2.305 0 01-.567.267z"></path>
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a1 1 0 10-2 0v.092a4.535 4.535 0 00-1.676.662C6.602 6.234 6 7.009 6 8c0 .99.602 1.765 1.324 2.246.48.32 1.054.545 1.676.662v1.941c-.391-.127-.68-.317-.843-.504a1 1 0 10-1.51 1.31c.562.649 1.413 1.076 2.353 1.253V15a1 1 0 102 0v-.092a4.535 4.535 0 001.676-.662C13.398 13.766 14 12.991 14 12c0-.99-.602-1.765-1.324-2.246A4.535 4.535 0 0011 9.092V7.151c.391.127.68.317.843.504a1 1 0 101.511-1.31c-.563-.649-1.413-1.076-2.354-1.253V5z" clip-rule="evenodd"></path>
                        </svg>
                        Detalle del Pago
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <p class="text-xs font-medium text-gray-500 uppercase mb-1">Descripción</p>
                            <p class="text-sm font-bold text-gray-900">{{ $mensualidad->detalle_descripcion }}</p>
                        </div>
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <p class="text-xs font-medium text-gray-500 uppercase mb-1">Fecha de Pago</p>
                            <p class="text-sm font-bold text-gray-900">{{ \Carbon\Carbon::parse($mensualidad->fechamen)->format('d/m/Y') }}</p>
                        </div>
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <p class="text-xs font-medium text-gray-500 uppercase mb-1">Tipo de Pago</p>
                            @if($mensualidad->tipopago === 'E')
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800">
                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M8.433 7.418c.155-.103.346-.196.567-.267v1.698a2.305 2.305 0 01-.567-.267C8.07 8.34 8 8.114 8 8c0-.114.07-.34.433-.582zM11 12.849v-1.698c.22.071.412.164.567.267.364.243.433.468.433.582 0 .114-.07.34-.433.582a2.305 2.305 0 01-.567.267z"></path>
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a1 1 0 10-2 0v.092a4.535 4.535 0 00-1.676.662C6.602 6.234 6 7.009 6 8c0 .99.602 1.765 1.324 2.246.48.32 1.054.545 1.676.662v1.941c-.391-.127-.68-.317-.843-.504a1 1 0 10-1.51 1.31c.562.649 1.413 1.076 2.353 1.253V15a1 1 0 102 0v-.092a4.535 4.535 0 001.676-.662C13.398 13.766 14 12.991 14 12c0-.99-.602-1.765-1.324-2.246A4.535 4.535 0 0011 9.092V7.151c.391.127.68.317.843.504a1 1 0 101.511-1.31c-.563-.649-1.413-1.076-2.354-1.253V5z" clip-rule="evenodd"></path>
                                    </svg>
                                    Efectivo
                                </span>
                            @else
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-800">
                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M3 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd"></path>
                                    </svg>
                                    QR
                                </span>
                            @endif
                        </div>
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <p class="text-xs font-medium text-gray-500 uppercase mb-1">Estado</p>
                            @if($mensualidad->estado === '1')
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800">
                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                    </svg>
                                    Activo
                                </span>
                            @else
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-800">
                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                                    </svg>
                                    Inactivo
                                </span>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Cálculo del Monto -->
                <div>
                    <h3 class="text-lg font-semibold text-gray-800 mb-3 flex items-center gap-2">
                        <svg class="w-5 h-5 text-emerald-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"></path>
                        </svg>
                        Cálculo del Monto
                    </h3>
                    <div class="bg-gradient-to-r from-emerald-50 to-emerald-100 border border-emerald-200 p-6 rounded-lg">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div class="text-center">
                                <p class="text-xs font-medium text-emerald-600 uppercase mb-1">Monto Base</p>
                                <p class="text-2xl font-bold text-emerald-900">{{ number_format($mensualidad->monto, 2) }} Bs</p>
                            </div>
                            <div class="text-center">
                                <p class="text-xs font-medium text-amber-600 uppercase mb-1">Descuento</p>
                                @if($mensualidad->descuento > 0)
                                    <p class="text-2xl font-bold text-amber-800">{{ $mensualidad->descuento }}%</p>
                                    <p class="text-xs text-amber-600">-{{ number_format($mensualidad->monto * $mensualidad->descuento / 100, 2) }} Bs</p>
                                @else
                                    <p class="text-2xl font-bold text-gray-500">Sin descuento</p>
                                @endif
                            </div>
                            <div class="text-center bg-white rounded-lg p-3 shadow-sm">
                                <p class="text-xs font-medium text-emerald-600 uppercase mb-1">Total Pagado</p>
                                <p class="text-3xl font-bold text-emerald-700">{{ number_format($mensualidad->montototal, 2) }} Bs</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Observaciones -->
                @if($mensualidad->observacion)
                <div>
                    <h3 class="text-lg font-semibold text-gray-800 mb-3">Observaciones</h3>
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <p class="text-sm text-gray-700">{{ $mensualidad->observacion }}</p>
                    </div>
                </div>
                @endif

                <!-- Botones de Acción -->
                <div class="flex items-center gap-4 pt-4 border-t">
                    <a href="{{ route('admin.mensualidad.index') }}"
                       class="px-6 py-3 bg-gray-200 hover:bg-gray-300 text-gray-800 font-medium rounded-lg transition-colors">
                        Volver
                    </a>
                    <a href="{{ route('admin.mensualidad.edit', $mensualidad->idmensualidad) }}"
                       class="px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-medium rounded-lg transition-all duration-200 transform hover:scale-105 shadow-lg hover:shadow-xl">
                        Editar Pago
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
