<x-secretaria-layout>
    <div class="space-y-6">
        <!-- Header -->
        <div class="bg-gradient-to-r from-green-600 to-emerald-600 rounded-xl shadow-lg p-8 text-white">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-6">
                    <div class="h-24 w-24 rounded-full bg-white/20 backdrop-blur-sm flex items-center justify-center border-4 border-white/30">
                        <span class="text-4xl font-bold text-white">
                            {{ strtoupper(substr($estudiante->nombre, 0, 1)) }}{{ strtoupper(substr($estudiante->apellido, 0, 1)) }}
                        </span>
                    </div>
                    <div>
                        <h1 class="text-4xl font-bold mb-2">{{ $estudiante->nombre }} {{ $estudiante->apellido }}</h1>
                        <p class="text-green-100 text-lg">CI: {{ $estudiante->ci }} • Código: {{ $estudiante->codestudiante ?? 'N/A' }}</p>
                    </div>
                </div>
                <div class="flex gap-3">
                    <a href="{{ route('secretaria.persona.edit', $estudiante->ci) }}" 
                       class="bg-white text-green-600 px-6 py-3 rounded-lg font-semibold hover:bg-green-50 transition-colors shadow-lg flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                        Editar
                    </a>
                    <a href="{{ route('secretaria.persona.index', ['tipo' => 'estudiantes']) }}" 
                       class="bg-white/10 backdrop-blur-sm text-white px-6 py-3 rounded-lg font-semibold hover:bg-white/20 transition-colors border-2 border-white/30 flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Volver
                    </a>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Columna Izquierda: Información Personal -->
            <div class="lg:col-span-1 space-y-6">
                <!-- Datos Personales -->
                <div class="bg-white rounded-xl shadow-md p-6">
                    <h2 class="text-xl font-bold text-gray-800 mb-4 flex items-center gap-2">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        Datos Personales
                    </h2>
                    <div class="space-y-3">
                        <div>
                            <p class="text-xs text-gray-500 uppercase tracking-wide">Nombre Completo</p>
                            <p class="text-sm font-semibold text-gray-900">{{ $estudiante->nombre }} {{ $estudiante->apellido }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 uppercase tracking-wide">CI</p>
                            <p class="text-sm font-semibold text-gray-900">{{ $estudiante->ci }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 uppercase tracking-wide">Sexo</p>
                            <p class="text-sm font-semibold text-gray-900">{{ $estudiante->sexo === 'M' ? 'Masculino' : 'Femenino' }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 uppercase tracking-wide">Código Estudiante</p>
                            <p class="text-sm font-mono font-semibold text-gray-900">{{ $estudiante->codestudiante ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 uppercase tracking-wide">Fecha de Registro</p>
                            <p class="text-sm font-semibold text-gray-900">{{ \Carbon\Carbon::parse($estudiante->fecharegistro)->format('d/m/Y') }}</p>
                        </div>
                    </div>
                </div>

                <!-- Datos de Contacto -->
                <div class="bg-white rounded-xl shadow-md p-6">
                    <h2 class="text-xl font-bold text-gray-800 mb-4 flex items-center gap-2">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                        Contacto
                    </h2>
                    <div class="space-y-3">
                        <div>
                            <p class="text-xs text-gray-500 uppercase tracking-wide">Correo Electrónico</p>
                            <p class="text-sm font-semibold text-gray-900">{{ $estudiante->correo ?? 'No registrado' }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 uppercase tracking-wide">Teléfono</p>
                            <p class="text-sm font-semibold text-gray-900">{{ $estudiante->telefono ?? 'No registrado' }}</p>
                        </div>
                    </div>
                </div>

                <!-- Información del Tutor -->
                @if($tutor)
                    <div class="bg-blue-50 border border-blue-200 rounded-xl shadow-md p-6">
                        <h2 class="text-xl font-bold text-gray-800 mb-4 flex items-center gap-2">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                            Tutor (Padre/Madre)
                        </h2>
                        <div class="flex items-center gap-4 mb-4">
                            <div class="h-16 w-16 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center font-bold text-xl">
                                {{ strtoupper(substr($tutor->nombre, 0, 1)) }}{{ strtoupper(substr($tutor->apellido, 0, 1)) }}
                            </div>
                            <div>
                                <p class="text-lg font-bold text-gray-900">{{ $tutor->nombre }} {{ $tutor->apellido }}</p>
                                <p class="text-sm text-gray-600">CI: {{ $tutor->ci }}</p>
                            </div>
                        </div>
                        <div class="space-y-2 text-sm">
                            <p><span class="text-gray-600">Correo:</span> <span class="font-semibold">{{ $tutor->correo ?? 'No registrado' }}</span></p>
                            <p><span class="text-gray-600">Teléfono:</span> <span class="font-semibold">{{ $tutor->telefono ?? 'No registrado' }}</span></p>
                        </div>
                    </div>
                @else
                    <div class="bg-red-50 border border-red-200 rounded-xl shadow-md p-6">
                        <p class="text-red-700 font-semibold flex items-center gap-2">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                            </svg>
                            Sin tutor asignado
                        </p>
                    </div>
                @endif
            </div>

            <!-- Columna Derecha: Información Académica -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Inscripciones -->
                <div class="bg-white rounded-xl shadow-md p-6">
                    <h2 class="text-xl font-bold text-gray-800 mb-4 flex items-center gap-2">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        Inscripciones ({{ count($inscripciones) }})
                    </h2>
                    @if(count($inscripciones) > 0)
                        <div class="space-y-3">
                            @foreach($inscripciones as $inscripcion)
                                <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <p class="font-bold text-gray-900">{{ $inscripcion->gestion }}</p>
                                            <p class="text-sm text-gray-600">{{ $inscripcion->nivel }} - {{ $inscripcion->curso }}</p>
                                            <p class="text-xs text-gray-500 mt-1">Inscrito: {{ \Carbon\Carbon::parse($inscripcion->fecharegis)->format('d/m/Y') }}</p>
                                        </div>
                                        <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs font-semibold">
                                            Activo
                                        </span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-500 text-center py-8">No hay inscripciones registradas</p>
                    @endif
                </div>

                <!-- Estado de Pagos por Gestión -->
                <div class="bg-white rounded-xl shadow-md p-6">
                    <h2 class="text-xl font-bold text-gray-800 mb-6 flex items-center gap-2">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                        </svg>
                        Estado de Pagos por Gestión
                    </h2>
                    
                    @if(count($mensualidadesPendientes) > 0)
                        @php
                            $porGestion = collect($mensualidadesPendientes)->groupBy('gestion');
                        @endphp
                        
                        @foreach($porGestion as $gestion => $meses)
                            <div class="mb-6 last:mb-0">
                                <div class="bg-gradient-to-r from-blue-500 to-blue-600 text-white px-4 py-3 rounded-t-lg">
                                    <h3 class="font-bold text-lg">Gestión {{ $gestion }}</h3>
                                    <p class="text-sm text-blue-100">
                                        {{ $meses->where('pagado', 1)->count() }} de {{ $meses->count() }} mensualidades pagadas
                                    </p>
                                </div>
                                
                                <div class="border-2 border-blue-200 rounded-b-lg p-4">
                                    <div class="grid grid-cols-5 md:grid-cols-10 gap-2">
                                        @foreach($meses as $mes)
                                            @if($mes->pagado == 1)
                                                <!-- Pagado -->
                                                <div class="bg-green-600 text-white rounded-lg p-3 text-center font-bold text-lg hover:bg-green-700 transition-colors">
                                                    {{ $mes->mes }}
                                                </div>
                                            @else
                                                <!-- Pendiente -->
                                                <div class="bg-gray-200 text-gray-600 rounded-lg p-3 text-center font-semibold text-lg border-2 border-gray-300">
                                                    {{ $mes->mes }}
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                    
                                    <!-- Leyenda -->
                                    <div class="mt-4 flex items-center justify-center gap-6 text-sm">
                                        <div class="flex items-center gap-2">
                                            <div class="w-6 h-6 bg-green-600 rounded"></div>
                                            <span class="text-gray-700">Pagado</span>
                                        </div>
                                        <div class="flex items-center gap-2">
                                            <div class="w-6 h-6 bg-gray-200 border-2 border-gray-300 rounded"></div>
                                            <span class="text-gray-700">Pendiente</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <p class="text-gray-500 text-center py-8">No hay mensualidades configuradas</p>
                    @endif
                </div>

                <!-- Historial de Pagos -->
                <div class="bg-white rounded-xl shadow-md p-6">
                    <h2 class="text-xl font-bold text-gray-800 mb-6 flex items-center gap-2">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Historial de Pagos ({{ count($mensualidades) }})
                    </h2>
                    @if(count($mensualidades) > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase">Gestión</th>
                                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase">Concepto</th>
                                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase">Monto</th>
                                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase">Fecha Pago</th>
                                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase">Tipo Pago</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($mensualidades as $mensualidad)
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-4 py-3 text-sm text-gray-900">{{ $mensualidad->gestion }}</td>
                                            <td class="px-4 py-3 text-sm text-gray-900">{{ $mensualidad->mes }}</td>
                                            <td class="px-4 py-3 text-sm font-semibold text-green-600">Bs. {{ number_format($mensualidad->monto, 2) }}</td>
                                            <td class="px-4 py-3 text-sm text-gray-600">{{ \Carbon\Carbon::parse($mensualidad->fechamen)->format('d/m/Y') }}</td>
                                            <td class="px-4 py-3">
                                                <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $mensualidad->tipopago === 'E' ? 'bg-blue-100 text-blue-800' : 'bg-purple-100 text-purple-800' }}">
                                                    {{ $mensualidad->tipopago === 'E' ? 'Efectivo' : 'QR' }}
                                                </span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-gray-500 text-center py-8">No hay mensualidades registradas</p>
                    @endif
                </div>

                <!-- Becas -->
                <div class="bg-white rounded-xl shadow-md p-6">
                    <h2 class="text-xl font-bold text-gray-800 mb-4 flex items-center gap-2">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7"></path>
                        </svg>
                        Becas ({{ count($becas) }})
                    </h2>
                    @if(count($becas) > 0)
                        <div class="space-y-3">
                            @foreach($becas as $beca)
                                <div class="border border-green-200 bg-green-50 rounded-lg p-4">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <p class="font-bold text-gray-900">Beca {{ $beca->porcentaje }}%</p>
                                            <p class="text-sm text-gray-600">Gestión: {{ $beca->gestion }}</p>
                                            <p class="text-xs text-gray-500 mt-1">{{ $beca->observacion ?? 'Sin observaciones' }}</p>
                                        </div>
                                        <span class="px-4 py-2 bg-green-600 text-white rounded-full text-sm font-bold">
                                            {{ $beca->porcentaje }}%
                                        </span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-500 text-center py-8">No tiene becas asignadas</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-secretaria-layout>
