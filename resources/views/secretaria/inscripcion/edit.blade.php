<x-secretaria-layout>
    <div class="max-w-4xl mx-auto space-y-6">
        <!-- Header -->
        <div class="bg-gradient-to-r from-green-600 to-emerald-600 rounded-xl shadow-lg p-8 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-4xl font-bold mb-2">Editar Inscripción</h1>
                    <p class="text-green-100 text-lg">{{ $inscripcion->estudiante_nombre }} {{ $inscripcion->estudiante_apellido }} - {{ $inscripcion->gestion }}</p>
                </div>
                <a href="{{ route('secretaria.inscripcion.index') }}" class="bg-white text-green-600 px-6 py-3 rounded-lg font-semibold hover:bg-green-50 transition-colors shadow-lg flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Volver
                </a>
            </div>
        </div>

        <!-- Información de la Inscripción (Solo lectura) -->
        <div class="bg-gray-50 rounded-xl shadow-md p-6">
            <h2 class="text-xl font-bold text-gray-800 mb-4">Información de la Inscripción</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <p class="text-xs text-gray-500 uppercase">Estudiante</p>
                    <p class="text-sm font-semibold text-gray-900">{{ $inscripcion->estudiante_nombre }} {{ $inscripcion->estudiante_apellido }}</p>
                    <p class="text-xs text-gray-600">CI: {{ $inscripcion->ci }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-500 uppercase">Gestión</p>
                    <p class="text-sm font-semibold text-gray-900">{{ $inscripcion->gestion }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-500 uppercase">Nivel</p>
                    <p class="text-sm font-semibold text-gray-900">{{ $inscripcion->nivel }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-500 uppercase">Curso</p>
                    <p class="text-sm font-semibold text-gray-900">{{ $inscripcion->curso }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-500 uppercase">Fecha de Inscripción</p>
                    <p class="text-sm font-semibold text-gray-900">{{ \Carbon\Carbon::parse($inscripcion->fecharegis)->format('d/m/Y') }}</p>
                </div>
            </div>
        </div>

        <!-- Formulario de Edición -->
        <form action="{{ route('secretaria.inscripcion.update', [$inscripcion->ci, $inscripcion->idcurso, $inscripcion->idnivel]) }}" method="POST" class="bg-white rounded-xl shadow-md p-8">
            @csrf
            @method('PUT')

            <div class="space-y-6">
                <!-- Tutor -->
                <div>
                    <h2 class="text-xl font-bold text-gray-800 mb-4 flex items-center gap-2">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                        Tutor (Padre/Madre) <span class="text-red-500">*</span>
                    </h2>

                    <div>
                        <label for="citutor" class="block text-sm font-semibold text-gray-700 mb-2">
                            Seleccionar Tutor
                        </label>
                        <select name="citutor" id="citutor" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all">
                            @foreach($tutores as $tutor)
                                <option value="{{ $tutor->ci }}" {{ $inscripcion->citutor === $tutor->ci ? 'selected' : '' }}>
                                    {{ $tutor->nombre }} {{ $tutor->apellido }} (CI: {{ $tutor->ci }})
                                </option>
                            @endforeach
                        </select>
                        @error('citutor')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Beca -->
                <div>
                    <h2 class="text-xl font-bold text-gray-800 mb-4 flex items-center gap-2">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7"></path>
                        </svg>
                        Beca
                    </h2>

                    @if($beca)
                        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mb-4">
                            <p class="text-sm text-yellow-700 font-medium">Beca actual: {{ $beca->porcentaje }}%</p>
                        </div>
                    @endif

                    <div>
                        <label for="porcentaje_beca" class="block text-sm font-semibold text-gray-700 mb-2">
                            Porcentaje de Beca (%)
                        </label>
                        <input type="number" name="porcentaje_beca" id="porcentaje_beca" min="0" max="100" 
                               value="{{ old('porcentaje_beca', $beca->porcentaje ?? 0) }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all"
                               placeholder="0">
                        @error('porcentaje_beca')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-xs text-gray-500">Dejar en 0 para quitar la beca</p>
                    </div>
                </div>

                <!-- Observaciones -->
                <div>
                    <h2 class="text-xl font-bold text-gray-800 mb-4 flex items-center gap-2">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        Observaciones
                    </h2>

                    <div>
                        <textarea name="observaciones" id="observaciones" rows="3"
                                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all"
                                  placeholder="Observaciones adicionales...">{{ old('observaciones', $inscripcion->observaciones) }}</textarea>
                        @error('observaciones')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Botones -->
                <div class="flex items-center justify-end gap-4 pt-6 border-t border-gray-200">
                    <a href="{{ route('secretaria.inscripcion.index') }}" 
                       class="px-6 py-3 bg-gray-100 text-gray-700 rounded-lg font-semibold hover:bg-gray-200 transition-colors">
                        Cancelar
                    </a>
                    <button type="submit" 
                            class="px-6 py-3 bg-gradient-to-r from-green-600 to-emerald-600 text-white rounded-lg font-semibold hover:from-green-700 hover:to-emerald-700 transition-all shadow-lg flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Guardar Cambios
                    </button>
                </div>
            </div>
        </form>
    </div>
</x-secretaria-layout>
