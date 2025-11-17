<x-admin-layout>
    <div class="max-w-4xl mx-auto space-y-6">
        <!-- Header -->
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.maestromater.index') }}"
               class="inline-flex items-center justify-center w-10 h-10 rounded-lg bg-gray-100 hover:bg-gray-200 transition-colors">
                <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
            </a>
            <div>
                <h1 class="text-3xl font-bold text-gray-800">Editar Asignación</h1>
                <p class="text-gray-600 mt-1">Modifica los datos de la asignación</p>
            </div>
        </div>

        <!-- Formulario -->
        <div class="bg-white rounded-lg shadow-md p-8">
            <form action="{{ route('admin.maestromater.update', [$asignacion->ci, $asignacion->idmateria]) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                <!-- Información de la Asignación (solo lectura) -->
                <div class="bg-gray-50 border border-gray-200 rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Información de la Asignación</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <p class="text-xs font-medium text-gray-500 uppercase">Maestro</p>
                            <p class="text-sm font-bold text-gray-900">{{ $asignacion->maestro_nombre }}</p>
                            <p class="text-xs text-gray-600">{{ $asignacion->codmaestro }} - CI: {{ $asignacion->ci }}</p>
                        </div>
                        <div>
                            <p class="text-xs font-medium text-gray-500 uppercase">Materia</p>
                            <p class="text-sm font-bold text-gray-900">{{ $asignacion->materia_sigla }} - {{ $asignacion->materia_descripcion }}</p>
                        </div>
                        <div>
                            <p class="text-xs font-medium text-gray-500 uppercase">Nivel</p>
                            <p class="text-sm font-bold text-gray-900">{{ $asignacion->nivel_nombre }}</p>
                        </div>
                        <div>
                            <p class="text-xs font-medium text-gray-500 uppercase">Curso</p>
                            <p class="text-sm font-bold text-gray-900">{{ $asignacion->curso_nombre }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-amber-50 border-l-4 border-amber-500 p-4 rounded-r-lg">
                    <div class="flex items-start">
                        <svg class="w-5 h-5 text-amber-500 mt-0.5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                        </svg>
                        <div>
                            <h3 class="text-sm font-semibold text-amber-800 mb-1">Nota importante</h3>
                            <p class="text-sm text-amber-700">No se puede cambiar el maestro ni la materia. Solo se pueden modificar la gestión, fecha, asesor y observaciones.</p>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Gestión -->
                    <div>
                        <label for="idgestion" class="block text-sm font-semibold text-gray-700 mb-2">
                            Gestión <span class="text-red-500">*</span>
                        </label>
                        <select name="idgestion" id="idgestion" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent @error('idgestion') border-red-500 @enderror">
                            @foreach($gestiones as $gestion)
                                <option value="{{ $gestion->idgestion }}" {{ old('idgestion', $asignacion->idgestion) == $gestion->idgestion ? 'selected' : '' }}>
                                    {{ $gestion->detalleges }}
                                </option>
                            @endforeach
                        </select>
                        @error('idgestion')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Fecha de Registro -->
                    <div>
                        <label for="fecharegis" class="block text-sm font-semibold text-gray-700 mb-2">
                            Fecha de Asignación <span class="text-red-500">*</span>
                        </label>
                        <input type="date" name="fecharegis" id="fecharegis" 
                               value="{{ old('fecharegis', $asignacion->fecharegis) }}" required
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent @error('fecharegis') border-red-500 @enderror">
                        @error('fecharegis')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Asesor -->
                    <div>
                        <label for="asesor" class="block text-sm font-semibold text-gray-700 mb-2">
                            ¿Es Asesor de Curso? <span class="text-red-500">*</span>
                        </label>
                        <select name="asesor" id="asesor" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent @error('asesor') border-red-500 @enderror">
                            <option value="0" {{ old('asesor', $asignacion->asesor) == '0' ? 'selected' : '' }}>No</option>
                            <option value="1" {{ old('asesor', $asignacion->asesor) == '1' ? 'selected' : '' }}>Sí</option>
                        </select>
                        @error('asesor')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Observaciones -->
                    <div class="md:col-span-2">
                        <label for="observacion" class="block text-sm font-semibold text-gray-700 mb-2">
                            Observaciones (opcional)
                        </label>
                        <textarea name="observacion" id="observacion" rows="3"
                                  placeholder="Observaciones adicionales sobre la asignación"
                                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">{{ old('observacion', $asignacion->observacion) }}</textarea>
                        <p class="mt-1 text-xs text-gray-500">Máximo 200 caracteres</p>
                    </div>
                </div>

                <!-- Botones -->
                <div class="flex items-center gap-4 pt-4 border-t">
                    <a href="{{ route('admin.maestromater.index') }}"
                       class="px-6 py-3 bg-gray-200 hover:bg-gray-300 text-gray-800 font-medium rounded-lg transition-colors">
                        Cancelar
                    </a>
                    <button type="submit"
                            class="px-6 py-3 bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 text-white font-medium rounded-lg transition-all duration-200 transform hover:scale-105 shadow-lg hover:shadow-xl">
                        Actualizar Asignación
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-admin-layout>
