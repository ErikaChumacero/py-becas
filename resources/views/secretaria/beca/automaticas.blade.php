<x-secretaria-layout>
    <div class="max-w-4xl mx-auto space-y-6">
        <!-- Header -->
        <div class="bg-gradient-to-r from-yellow-500 to-orange-500 rounded-xl shadow-lg p-8 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-4xl font-bold mb-2">Becas Automáticas</h1>
                    <p class="text-yellow-100 text-lg">Asignación automática según reglas del sistema</p>
                </div>
                <a href="{{ route('secretaria.beca.index') }}" class="bg-white text-yellow-600 px-6 py-3 rounded-lg font-semibold hover:bg-yellow-50 transition-colors shadow-lg flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Volver
                </a>
            </div>
        </div>

        <!-- Información de Reglas -->
        <div class="bg-white rounded-xl shadow-md p-8">
            <h2 class="text-2xl font-bold text-gray-800 mb-6 flex items-center gap-2">
                <svg class="w-7 h-7 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                Reglas de Becas Automáticas
            </h2>

            <div class="space-y-6">
                <!-- Regla 1: Mejor Estudiante -->
                <div class="bg-gradient-to-r from-purple-50 to-purple-100 border-l-4 border-purple-500 rounded-lg p-6">
                    <div class="flex items-start gap-4">
                        <div class="flex-shrink-0 bg-purple-500 text-white rounded-full p-3">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path>
                            </svg>
                        </div>
                        <div class="flex-1">
                            <h3 class="text-lg font-bold text-purple-900 mb-2">Beca Mejor Estudiante</h3>
                            <p class="text-purple-800 mb-3">Se asigna al mejor estudiante de cada curso de la gestión anterior</p>
                            <div class="bg-white rounded-lg p-4 space-y-2">
                                <p class="text-sm text-gray-700"><strong>Criterio:</strong> Mejor promedio académico del curso anterior</p>
                                <p class="text-sm text-gray-700"><strong>Porcentaje:</strong> <span class="text-purple-600 font-bold">100%</span></p>
                                <p class="text-sm text-gray-700"><strong>Tipo:</strong> Mérito Académico</p>
                                <p class="text-sm text-gray-700"><strong>Condición:</strong> Debe estar inscrito en la gestión actual</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Regla 2: Tercer Hijo -->
                <div class="bg-gradient-to-r from-orange-50 to-orange-100 border-l-4 border-orange-500 rounded-lg p-6">
                    <div class="flex items-start gap-4">
                        <div class="flex-shrink-0 bg-orange-500 text-white rounded-full p-3">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                        </div>
                        <div class="flex-1">
                            <h3 class="text-lg font-bold text-orange-900 mb-2">Beca Tercer Hijo</h3>
                            <p class="text-orange-800 mb-3">Se asigna al tercer hijo (o más) del tutor que esté en el nivel más bajo</p>
                            <div class="bg-white rounded-lg p-4 space-y-2">
                                <p class="text-sm text-gray-700"><strong>Criterio:</strong> Tercer hijo o posterior del mismo tutor</p>
                                <p class="text-sm text-gray-700"><strong>Porcentaje:</strong> <span class="text-orange-600 font-bold">100%</span></p>
                                <p class="text-sm text-gray-700"><strong>Tipo:</strong> Familiar</p>
                                <p class="text-sm text-gray-700"><strong>Condición:</strong> Debe estar en el nivel más bajo entre sus hermanos</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Formulario de Ejecución -->
        <form action="{{ route('secretaria.beca.ejecutarAutomaticas') }}" method="POST" class="bg-white rounded-xl shadow-md p-8">
            @csrf

            <div class="space-y-6">
                <div>
                    <h2 class="text-xl font-bold text-gray-800 mb-4 flex items-center gap-2">
                        <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        Seleccionar Gestión
                    </h2>

                    <div>
                        <label for="idgestion" class="block text-sm font-semibold text-gray-700 mb-2">
                            Gestión Académica <span class="text-red-500">*</span>
                        </label>
                        <select name="idgestion" id="idgestion" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-transparent transition-all">
                            <option value="">Seleccione una gestión...</option>
                            @foreach($gestiones as $gestion)
                                <option value="{{ $gestion->idgestion }}">
                                    {{ $gestion->detalleges }} 
                                    ({{ \Carbon\Carbon::parse($gestion->fechaapertura)->format('d/m/Y') }} - 
                                     {{ \Carbon\Carbon::parse($gestion->fechacierre)->format('d/m/Y') }})
                                </option>
                            @endforeach
                        </select>
                        @error('idgestion')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Advertencia -->
                <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 rounded-lg">
                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-yellow-800">Importante</h3>
                            <div class="mt-2 text-sm text-yellow-700">
                                <ul class="list-disc list-inside space-y-1">
                                    <li>Este proceso asignará becas automáticamente según las reglas establecidas</li>
                                    <li>Se evaluarán todos los estudiantes de la gestión seleccionada</li>
                                    <li>Las becas se asignarán al 100% de descuento</li>
                                    <li>Puede ejecutar este proceso múltiples veces (no duplicará becas)</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Botones -->
                <div class="flex items-center justify-end gap-4 pt-6 border-t border-gray-200">
                    <a href="{{ route('secretaria.beca.index') }}" 
                       class="px-6 py-3 border border-gray-300 rounded-lg text-gray-700 font-semibold hover:bg-gray-50 transition-colors">
                        Cancelar
                    </a>
                    <button type="submit" 
                            class="px-6 py-3 bg-gradient-to-r from-yellow-500 to-orange-500 text-white rounded-lg font-semibold hover:from-yellow-600 hover:to-orange-600 transition-colors shadow-lg flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                        Ejecutar Becas Automáticas
                    </button>
                </div>
            </div>
        </form>

        <!-- Información Adicional -->
        <div class="bg-blue-50 border border-blue-200 rounded-xl p-6">
            <h3 class="text-lg font-bold text-blue-900 mb-3 flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                </svg>
                ¿Cómo funciona?
            </h3>
            <div class="text-sm text-blue-800 space-y-2">
                <p><strong>1. Beca Mejor Estudiante:</strong> El sistema busca en la gestión anterior al estudiante con mejor promedio de cada curso y le asigna la beca si está inscrito en la gestión actual.</p>
                <p><strong>2. Beca Tercer Hijo:</strong> El sistema identifica a los tutores con 3 o más hijos inscritos, y asigna la beca al tercer hijo (o posterior) que esté en el nivel más bajo.</p>
                <p><strong>3. Resultado:</strong> Al finalizar, verá un resumen con el número total de becas asignadas por cada categoría.</p>
            </div>
        </div>
    </div>

    @if(session('error'))
        <script>
            setTimeout(() => {
                alert('{{ session('error') }}');
            }, 100);
        </script>
    @endif
</x-secretaria-layout>
