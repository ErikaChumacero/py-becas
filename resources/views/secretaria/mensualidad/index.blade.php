<x-secretaria-layout>
    <div class="space-y-6">
        <!-- Header -->
        <div class="bg-gradient-to-r from-green-600 to-emerald-600 rounded-xl shadow-lg p-8 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-4xl font-bold mb-2">Gestión de Mensualidades</h1>
                    <p class="text-green-100 text-lg">Registro y control de pagos mensuales</p>
                </div>
                <a href="{{ route('secretaria.mensualidad.create') }}" class="bg-white text-green-600 px-6 py-3 rounded-lg font-semibold hover:bg-green-50 transition-colors shadow-lg flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Registrar Pago
                </a>
            </div>
        </div>

        <!-- Estadísticas -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-blue-600">
                <p class="text-sm text-gray-600 font-medium uppercase tracking-wide">Total Pagos</p>
                <p class="text-4xl font-bold text-gray-900 mt-3">{{ $totalMensualidades }}</p>
            </div>

            <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-green-600">
                <p class="text-sm text-gray-600 font-medium uppercase tracking-wide">Monto Total</p>
                <p class="text-4xl font-bold text-green-600 mt-3">Bs. {{ number_format($totalMonto, 2) }}</p>
            </div>

            <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-yellow-600">
                <p class="text-sm text-gray-600 font-medium uppercase tracking-wide">Descuentos/Becas</p>
                <p class="text-4xl font-bold text-yellow-600 mt-3">Bs. {{ number_format($totalDescuentos, 2) }}</p>
            </div>
        </div>

        <!-- Mensajes -->
        @if(session('success'))
            <div id="mensaje-exito" class="bg-green-100 border-2 border-green-500 rounded-xl p-6 shadow-lg animate-pulse transition-all duration-500">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <svg class="w-8 h-8 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-xl font-bold text-green-800">REGISTRO DE PAGO EXITOSO</h3>
                        <p class="text-green-700 font-medium mt-1">{{ session('success') }}</p>
                    </div>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div id="mensaje-error" class="bg-red-100 border-2 border-red-500 rounded-xl p-6 shadow-lg transition-all duration-500">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <svg class="w-8 h-8 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-xl font-bold text-red-800">ERROR</h3>
                        <p class="text-red-700 font-medium mt-1">{{ session('error') }}</p>
                    </div>
                </div>
            </div>
        @endif

        <!-- Filtros -->
        <div class="bg-white rounded-xl shadow-md p-6">
            <h2 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2">
                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
                </svg>
                Filtros
            </h2>
            
            <div class="flex flex-wrap gap-3">
                <a href="{{ route('secretaria.mensualidad.index') }}" 
                   class="px-4 py-2 rounded-lg font-medium transition-colors {{ !$gestion && !$estado ? 'bg-green-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                    Todos
                </a>
                
                @foreach($gestiones as $g)
                    <a href="{{ route('secretaria.mensualidad.index', ['gestion' => $g->gestion]) }}" 
                       class="px-4 py-2 rounded-lg font-medium transition-colors {{ $gestion == $g->gestion ? 'bg-blue-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                        {{ $g->gestion }}
                    </a>
                @endforeach

                <div class="border-l border-gray-300 mx-2"></div>

                <a href="{{ route('secretaria.mensualidad.index', ['estado' => '1']) }}" 
                   class="px-4 py-2 rounded-lg font-medium transition-colors {{ $estado == '1' ? 'bg-green-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                    Activos
                </a>
                
                <a href="{{ route('secretaria.mensualidad.index', ['estado' => '0']) }}" 
                   class="px-4 py-2 rounded-lg font-medium transition-colors {{ $estado == '0' ? 'bg-red-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                    Inactivos
                </a>
            </div>
        </div>

        <!-- Tabla de Mensualidades -->
        <div class="bg-white rounded-xl shadow-md overflow-hidden">
            <div class="p-6 border-b border-gray-200">
                <h2 class="text-xl font-bold text-gray-800 flex items-center gap-2">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                    </svg>
                    Listado de Pagos ({{ count($mensualidades) }})
                </h2>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estudiante</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Gestión</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nivel/Curso</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Concepto</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Monto</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Descuento/Beca</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tipo Pago</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fecha</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($mensualidades as $mensualidad)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="text-sm font-mono text-gray-900">#{{ $mensualidad->idmensualidad }}</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10 bg-gradient-to-br from-green-400 to-emerald-500 rounded-full flex items-center justify-center text-white font-bold">
                                            {{ substr($mensualidad->estudiante_nombre, 0, 1) }}{{ substr($mensualidad->estudiante_apellido, 0, 1) }}
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">{{ $mensualidad->estudiante_nombre }} {{ $mensualidad->estudiante_apellido }}</div>
                                            <div class="text-xs text-gray-500">{{ $mensualidad->codestudiante }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                        {{ $mensualidad->gestion }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $mensualidad->nivel }}</div>
                                    <div class="text-xs text-gray-500">{{ $mensualidad->curso }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="text-sm text-gray-900">{{ $mensualidad->detalle_descripcion }}</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="text-sm font-semibold text-gray-900">Bs. {{ number_format($mensualidad->monto, 2) }}</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($mensualidad->descuento > 0 || $mensualidad->beca_porcentaje > 0)
                                        <div class="text-xs">
                                            @if($mensualidad->descuento > 0)
                                                <span class="text-orange-600">-{{ $mensualidad->descuento }}%</span>
                                            @endif
                                            @if($mensualidad->beca_porcentaje > 0)
                                                <span class="text-yellow-600">Beca -{{ $mensualidad->beca_porcentaje }}%</span>
                                            @endif
                                        </div>
                                    @else
                                        <span class="text-xs text-gray-400">Sin descuento</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="text-sm font-bold text-green-600">Bs. {{ number_format($mensualidad->montototal, 2) }}</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full 
                                        {{ $mensualidad->tipopago == '1' ? 'bg-green-100 text-green-800' : '' }}
                                        {{ $mensualidad->tipopago == '2' ? 'bg-purple-100 text-purple-800' : '' }}
                                        {{ $mensualidad->tipopago == '3' ? 'bg-blue-100 text-blue-800' : '' }}">
                                        {{ $mensualidad->tipo_pago_texto }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="text-sm text-gray-600">{{ \Carbon\Carbon::parse($mensualidad->fechamen)->format('d/m/Y') }}</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <a href="{{ route('secretaria.mensualidad.show', $mensualidad->idmensualidad) }}" 
                                       class="text-blue-600 hover:text-blue-800 transition-colors" title="Ver detalle">
                                        <svg class="w-5 h-5 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                        </svg>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="11" class="px-6 py-12 text-center">
                                    <div class="flex flex-col items-center justify-center text-gray-400">
                                        <svg class="w-16 h-16 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                        <p class="text-lg font-medium">No hay pagos registrados</p>
                                        <p class="text-sm mt-2">Comienza registrando el primer pago</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        // Auto-ocultar mensaje de éxito después de 5 segundos
        const mensajeExito = document.getElementById('mensaje-exito');
        if (mensajeExito) {
            setTimeout(() => {
                mensajeExito.style.opacity = '0';
                mensajeExito.style.transform = 'translateY(-20px)';
                setTimeout(() => {
                    mensajeExito.remove();
                }, 500);
            }, 5000);
        }

        // Auto-ocultar mensaje de error después de 8 segundos
        const mensajeError = document.getElementById('mensaje-error');
        if (mensajeError) {
            setTimeout(() => {
                mensajeError.style.opacity = '0';
                mensajeError.style.transform = 'translateY(-20px)';
                setTimeout(() => {
                    mensajeError.remove();
                }, 500);
            }, 8000);
        }
    </script>
</x-secretaria-layout>
