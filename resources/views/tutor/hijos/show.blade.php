<x-tutor-layout>
    <div class="space-y-6">
        <!-- Header -->
        <div class="bg-gradient-to-r from-green-600 to-emerald-600 rounded-xl shadow-lg p-8 text-white">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-4">
                    <a href="{{ route('tutor.hijos.index') }}" class="bg-white/20 hover:bg-white/30 rounded-lg p-2 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                        </svg>
                    </a>
                    <div>
                        <h1 class="text-4xl font-bold mb-2">{{ $hijo->nombre }} {{ $hijo->apellido }}</h1>
                        <p class="text-green-100 text-lg">Información detallada del estudiante</p>
                    </div>
                </div>
                <div class="hidden md:block">
                    <div class="w-20 h-20 rounded-full bg-white text-green-600 flex items-center justify-center font-bold text-3xl shadow-lg">
                        {{ strtoupper(substr($hijo->nombre, 0, 1)) }}{{ strtoupper(substr($hijo->apellido, 0, 1)) }}
                    </div>
                </div>
            </div>
        </div>

        <!-- Estadísticas -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-blue-500">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm font-medium uppercase">Gestiones</p>
                        <p class="text-3xl font-bold text-gray-800 mt-2">{{ $estadisticas->total_gestiones }}</p>
                    </div>
                    <div class="bg-blue-100 rounded-full p-3">
                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-cyan-500">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm font-medium uppercase">Mensualidades</p>
                        <p class="text-3xl font-bold text-gray-800 mt-2">{{ $estadisticas->total_mensualidades }}</p>
                    </div>
                    <div class="bg-cyan-100 rounded-full p-3">
                        <svg class="w-8 h-8 text-cyan-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-green-500">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm font-medium uppercase">Total Pagado</p>
                        <p class="text-2xl font-bold text-gray-800 mt-2">Bs. {{ number_format($estadisticas->total_pagado, 2) }}</p>
                    </div>
                    <div class="bg-green-100 rounded-full p-3">
                        <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-yellow-500">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm font-medium uppercase">Becas</p>
                        <p class="text-3xl font-bold text-gray-800 mt-2">{{ $estadisticas->tiene_becas }}</p>
                    </div>
                    <div class="bg-yellow-100 rounded-full p-3">
                        <svg class="w-8 h-8 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Información Personal -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-xl shadow-md p-6">
                    <h2 class="text-xl font-bold text-gray-800 mb-4 flex items-center gap-2">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        Información Personal
                    </h2>

                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-semibold text-gray-600 mb-1">CI</label>
                            <p class="text-lg text-gray-900">{{ $hijo->ci }}</p>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-600 mb-1">Código de Estudiante</label>
                            <p class="text-lg text-gray-900">{{ $hijo->codestudiante }}</p>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-600 mb-1">Sexo</label>
                            <p class="text-lg text-gray-900">{{ $hijo->sexo === 'M' ? 'Masculino' : 'Femenino' }}</p>
                        </div>

                        @if($hijo->correo)
                            <div>
                                <label class="block text-sm font-semibold text-gray-600 mb-1">Correo</label>
                                <p class="text-lg text-gray-900">{{ $hijo->correo }}</p>
                            </div>
                        @endif

                        @if($hijo->telefono)
                            <div>
                                <label class="block text-sm font-semibold text-gray-600 mb-1">Teléfono</label>
                                <p class="text-lg text-gray-900">{{ $hijo->telefono }}</p>
                            </div>
                        @endif

                        <div>
                            <label class="block text-sm font-semibold text-gray-600 mb-1">Fecha de Registro</label>
                            <p class="text-lg text-gray-900">{{ \Carbon\Carbon::parse($hijo->fecharegistro)->format('d/m/Y') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Inscripciones -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-xl shadow-md p-6">
                    <h2 class="text-xl font-bold text-gray-800 mb-4 flex items-center gap-2">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        Historial de Inscripciones ({{ count($inscripciones) }})
                    </h2>

                    @if(count($inscripciones) > 0)
                        <div class="space-y-4">
                            @foreach($inscripciones as $inscripcion)
                                <div class="border border-gray-200 rounded-lg p-4 hover:bg-gray-50 transition-colors {{ $inscripcion->gestion_activa == '1' ? 'border-green-500 bg-green-50' : '' }}">
                                    <div class="flex items-start justify-between">
                                        <div class="flex-1">
                                            <div class="flex items-center gap-2 mb-2">
                                                <h3 class="font-bold text-gray-900">{{ $inscripcion->gestion }}</h3>
                                                @if($inscripcion->gestion_activa == '1')
                                                    <span class="px-2 py-1 bg-green-600 text-white text-xs font-semibold rounded-full">Activa</span>
                                                @endif
                                            </div>
                                            <div class="grid grid-cols-2 gap-3 text-sm">
                                                <div>
                                                    <span class="text-gray-600">Nivel:</span>
                                                    <span class="font-semibold text-gray-900 ml-1">{{ $inscripcion->nivel }}</span>
                                                </div>
                                                <div>
                                                    <span class="text-gray-600">Curso:</span>
                                                    <span class="font-semibold text-gray-900 ml-1">{{ $inscripcion->curso }}</span>
                                                </div>
                                                <div>
                                                    <span class="text-gray-600">Fecha:</span>
                                                    <span class="font-semibold text-gray-900 ml-1">{{ \Carbon\Carbon::parse($inscripcion->fechainscripcion)->format('d/m/Y') }}</span>
                                                </div>
                                                @if($inscripcion->beca)
                                                    <div class="col-span-2">
                                                        <div class="flex items-center gap-2 bg-yellow-50 border border-yellow-200 rounded px-2 py-1">
                                                            <svg class="w-4 h-4 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7"></path>
                                                            </svg>
                                                            <span class="text-sm font-semibold text-yellow-900">{{ $inscripcion->beca }} ({{ $inscripcion->porcentaje_beca }}%)</span>
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>
                                            @if($inscripcion->observacion)
                                                <p class="mt-2 text-sm text-gray-600 italic">{{ $inscripcion->observacion }}</p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-500 text-center py-8">No hay inscripciones registradas</p>
                    @endif
                </div>
            </div>
        </div>

        <!-- Mensualidades -->
        <div class="bg-white rounded-xl shadow-md p-6">
            <h2 class="text-xl font-bold text-gray-800 mb-4 flex items-center gap-2">
                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                Historial de Mensualidades ({{ count($mensualidades) }})
            </h2>

            @if(count($mensualidades) > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase">Fecha</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase">Mes</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase">Gestión</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase">Nivel/Curso</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase">Monto</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase">Tipo Pago</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($mensualidades as $mensualidad)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ \Carbon\Carbon::parse($mensualidad->fechamen)->format('d/m/Y') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                        {{ $mensualidad->mes }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                        {{ $mensualidad->gestion }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                        {{ $mensualidad->nivel }} - {{ $mensualidad->curso }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-green-600">
                                        Bs. {{ number_format($mensualidad->monto, 2) }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 py-1 text-xs font-medium rounded-full {{ $mensualidad->tipopago === 'E' ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800' }}">
                                            {{ $mensualidad->tipopago === 'E' ? 'Efectivo' : 'Transferencia' }}
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
    </div>
</x-tutor-layout>
