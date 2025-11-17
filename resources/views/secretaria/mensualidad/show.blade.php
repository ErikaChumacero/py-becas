<x-secretaria-layout>
    <div class="max-w-4xl mx-auto space-y-6">
        <!-- Header -->
        <div class="bg-gradient-to-r from-green-600 to-emerald-600 rounded-xl shadow-lg p-8 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-4xl font-bold mb-2">Detalle de Pago</h1>
                    <p class="text-green-100 text-lg">Mensualidad #{{ $mensualidad->idmensualidad }}</p>
                </div>
                <a href="{{ route('secretaria.mensualidad.index') }}" class="bg-white text-green-600 px-6 py-3 rounded-lg font-semibold hover:bg-green-50 transition-colors shadow-lg flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Volver
                </a>
            </div>
        </div>

        <!-- Información del Estudiante -->
        <div class="bg-white rounded-xl shadow-md p-8">
            <h2 class="text-xl font-bold text-gray-800 mb-6 flex items-center gap-2">
                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                </svg>
                Información del Estudiante
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="flex items-center gap-4">
                    <div class="flex-shrink-0 h-16 w-16 bg-gradient-to-br from-green-400 to-emerald-500 rounded-full flex items-center justify-center text-white font-bold text-2xl">
                        {{ substr($mensualidad->estudiante_nombre, 0, 1) }}{{ substr($mensualidad->estudiante_apellido, 0, 1) }}
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Nombre Completo</p>
                        <p class="text-lg font-bold text-gray-900">{{ $mensualidad->estudiante_nombre }} {{ $mensualidad->estudiante_apellido }}</p>
                    </div>
                </div>

                <div>
                    <p class="text-sm text-gray-500">Código de Estudiante</p>
                    <p class="text-lg font-bold text-gray-900">{{ $mensualidad->codestudiante }}</p>
                </div>

                <div>
                    <p class="text-sm text-gray-500">CI</p>
                    <p class="text-lg font-bold text-gray-900">{{ $mensualidad->ci }}</p>
                </div>

                <div>
                    <p class="text-sm text-gray-500">Correo Electrónico</p>
                    <p class="text-lg font-bold text-gray-900">{{ $mensualidad->estudiante_correo ?? 'No registrado' }}</p>
                </div>

                <div>
                    <p class="text-sm text-gray-500">Teléfono</p>
                    <p class="text-lg font-bold text-gray-900">{{ $mensualidad->estudiante_telefono ?? 'No registrado' }}</p>
                </div>
            </div>
        </div>

        <!-- Información Académica -->
        <div class="bg-white rounded-xl shadow-md p-8">
            <h2 class="text-xl font-bold text-gray-800 mb-6 flex items-center gap-2">
                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                </svg>
                Información Académica
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div>
                    <p class="text-sm text-gray-500">Gestión</p>
                    <span class="inline-block mt-2 px-4 py-2 bg-blue-100 text-blue-800 rounded-lg font-bold">
                        {{ $mensualidad->gestion }}
                    </span>
                </div>

                <div>
                    <p class="text-sm text-gray-500">Nivel</p>
                    <p class="text-lg font-bold text-gray-900 mt-2">{{ $mensualidad->nivel }}</p>
                </div>

                <div>
                    <p class="text-sm text-gray-500">Curso</p>
                    <p class="text-lg font-bold text-gray-900 mt-2">{{ $mensualidad->curso }}</p>
                </div>
            </div>

            @if($mensualidad->beca_porcentaje && $mensualidad->beca_porcentaje > 0)
                <div class="mt-6 bg-yellow-50 border-2 border-yellow-200 rounded-lg p-4">
                    <p class="text-sm font-bold text-yellow-800">
                        Beca Activa: {{ $mensualidad->nombrebeca ?? 'Beca ' . $mensualidad->beca_porcentaje . '%' }}
                    </p>
                    <p class="text-sm text-yellow-700 mt-1">Descuento del {{ $mensualidad->beca_porcentaje }}% aplicado en este pago</p>
                </div>
            @endif
        </div>

        <!-- Detalle del Pago -->
        <div class="bg-white rounded-xl shadow-md p-8">
            <h2 class="text-xl font-bold text-gray-800 mb-6 flex items-center gap-2">
                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                Detalle del Pago
            </h2>

            <div class="space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <p class="text-sm text-gray-500">Concepto</p>
                        <p class="text-lg font-bold text-gray-900 mt-1">{{ $mensualidad->detalle_descripcion }}</p>
                    </div>

                    <div>
                        <p class="text-sm text-gray-500">Fecha de Pago</p>
                        <p class="text-lg font-bold text-gray-900 mt-1">{{ \Carbon\Carbon::parse($mensualidad->fechamen)->format('d/m/Y') }}</p>
                    </div>

                    <div>
                        <p class="text-sm text-gray-500">Tipo de Pago</p>
                        <span class="inline-block mt-1 px-4 py-2 rounded-lg font-bold
                            {{ $mensualidad->tipopago == '1' ? 'bg-green-100 text-green-800' : '' }}
                            {{ $mensualidad->tipopago == '2' ? 'bg-purple-100 text-purple-800' : '' }}
                            {{ $mensualidad->tipopago == '3' ? 'bg-blue-100 text-blue-800' : '' }}">
                            {{ $mensualidad->tipo_pago_texto }}
                        </span>
                    </div>

                    <div>
                        <p class="text-sm text-gray-500">ID de Mensualidad</p>
                        <p class="text-lg font-mono font-bold text-gray-900 mt-1">#{{ $mensualidad->idmensualidad }}</p>
                    </div>
                </div>

                @if($mensualidad->observacion)
                    <div class="bg-gray-50 rounded-lg p-4">
                        <p class="text-sm text-gray-500 mb-2">Observaciones</p>
                        <p class="text-gray-900">{{ $mensualidad->observacion }}</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Cálculo del Monto -->
        <div class="bg-gradient-to-br from-green-50 to-emerald-50 border-2 border-green-200 rounded-xl shadow-md p-8">
            <h2 class="text-xl font-bold text-gray-800 mb-6 flex items-center gap-2">
                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                </svg>
                Desglose del Pago
            </h2>

            <div class="space-y-4">
                <div class="flex justify-between items-center pb-3 border-b border-green-200">
                    <span class="text-gray-700 font-medium">Monto Base:</span>
                    <span class="text-gray-900 font-bold text-xl">Bs. {{ number_format($mensualidad->monto, 2) }}</span>
                </div>

                @if($mensualidad->descuento > 0)
                    <div class="flex justify-between items-center text-orange-600 pb-3 border-b border-green-200">
                        <span class="font-medium">Descuento ({{ $mensualidad->descuento }}%):</span>
                        <span class="font-bold text-lg">- Bs. {{ number_format($mensualidad->monto * $mensualidad->descuento / 100, 2) }}</span>
                    </div>
                @endif

                @if($mensualidad->beca_porcentaje && $mensualidad->beca_porcentaje > 0)
                    @php
                        $montoConDescuento = $mensualidad->monto - ($mensualidad->monto * $mensualidad->descuento / 100);
                        $becaMonto = $montoConDescuento * $mensualidad->beca_porcentaje / 100;
                    @endphp
                    <div class="flex justify-between items-center text-yellow-600 pb-3 border-b border-green-200">
                        <span class="font-medium">Beca ({{ $mensualidad->beca_porcentaje }}%):</span>
                        <span class="font-bold text-lg">- Bs. {{ number_format($becaMonto, 2) }}</span>
                    </div>
                @endif

                <div class="flex justify-between items-center pt-4">
                    <span class="text-gray-900 font-bold text-2xl">Total Pagado:</span>
                    <span class="text-green-600 font-bold text-3xl">Bs. {{ number_format($mensualidad->montototal, 2) }}</span>
                </div>

                @if($mensualidad->nodescuento == '1')
                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-3 mt-4">
                        <p class="text-sm text-blue-800 flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Este concepto no permite descuentos adicionales
                        </p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Acciones Disponibles -->
        <div class="bg-white rounded-xl shadow-md p-6">
            <h2 class="text-xl font-bold text-gray-800 mb-6 flex items-center gap-2">
                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"></path>
                </svg>
                Acciones Disponibles
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <!-- Imprimir Comprobante -->
                <button onclick="window.print()" class="flex flex-col items-center justify-center p-6 bg-blue-50 hover:bg-blue-100 border-2 border-blue-200 rounded-lg transition-all group">
                    <svg class="w-12 h-12 text-blue-600 mb-3 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                    </svg>
                    <span class="font-semibold text-blue-800">Imprimir Comprobante</span>
                    <span class="text-xs text-blue-600 mt-1">Generar recibo físico</span>
                </button>

                <!-- Ver Estudiante -->
                <a href="{{ route('secretaria.persona.show', $mensualidad->ci) }}" class="flex flex-col items-center justify-center p-6 bg-green-50 hover:bg-green-100 border-2 border-green-200 rounded-lg transition-all group">
                    <svg class="w-12 h-12 text-green-600 mb-3 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                    <span class="font-semibold text-green-800">Ver Estudiante</span>
                    <span class="text-xs text-green-600 mt-1">Información completa</span>
                </a>

                <!-- Agregar Observación -->
                <button onclick="document.getElementById('modal-observacion').classList.remove('hidden')" class="flex flex-col items-center justify-center p-6 bg-yellow-50 hover:bg-yellow-100 border-2 border-yellow-200 rounded-lg transition-all group">
                    <svg class="w-12 h-12 text-yellow-600 mb-3 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                    <span class="font-semibold text-yellow-800">Agregar Observación</span>
                    <span class="text-xs text-yellow-600 mt-1">Notas adicionales</span>
                </button>
            </div>
        </div>
    </div>

    <!-- Modal para Agregar Observación -->
    <div id="modal-observacion" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white rounded-xl shadow-2xl max-w-md w-full mx-4">
            <div class="bg-gradient-to-r from-yellow-500 to-orange-500 p-6 rounded-t-xl">
                <h3 class="text-2xl font-bold text-white">Agregar Observación</h3>
            </div>
            <form action="{{ route('secretaria.mensualidad.observacion', $mensualidad->idmensualidad) }}" method="POST" class="p-6">
                @csrf
                @method('PUT')
                <div class="mb-4">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Observación Actual:</label>
                    <p class="text-gray-600 bg-gray-50 p-3 rounded-lg">{{ $mensualidad->observacion ?? 'Sin observaciones' }}</p>
                </div>
                <div class="mb-6">
                    <label for="observacion" class="block text-sm font-semibold text-gray-700 mb-2">Nueva Observación:</label>
                    <textarea name="observacion" id="observacion" rows="4" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-transparent" placeholder="Escriba la observación...">{{ $mensualidad->observacion }}</textarea>
                </div>
                <div class="flex gap-3">
                    <button type="button" onclick="document.getElementById('modal-observacion').classList.add('hidden')" class="flex-1 px-4 py-2 bg-gray-200 text-gray-700 rounded-lg font-semibold hover:bg-gray-300 transition-colors">
                        Cancelar
                    </button>
                    <button type="submit" class="flex-1 px-4 py-2 bg-yellow-600 text-white rounded-lg font-semibold hover:bg-yellow-700 transition-colors">
                        Guardar
                    </button>
                </div>
            </form>
        </div>
    </div>

    <style>
        @media print {
            .no-print {
                display: none !important;
            }
        }
    </style>
</x-secretaria-layout>
