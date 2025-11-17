<x-admin-layout>
    <div class="max-w-3xl mx-auto py-6 px-4">
        <!-- Header -->
        <div class="flex items-center gap-3 mb-6">
            <a href="{{ route('admin.gestion.index') }}"
               class="inline-flex items-center justify-center w-9 h-9 rounded-lg bg-gray-100 hover:bg-gray-200 transition-colors">
                <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
            </a>
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Editar Gestión</h1>
                <p class="text-sm text-gray-600">Modifica los datos de la gestión académica</p>
            </div>
        </div>

        <!-- Formulario -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <form action="{{ route('admin.gestion.update', $gestion->idgestion) }}" method="POST" class="space-y-5">
                @csrf
                @method('PUT')

                <!-- ID de Gestión (solo lectura) -->
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-3">
                    <div class="flex items-center gap-2">
                        <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                        </svg>
                        <div>
                            <p class="text-xs font-medium text-blue-600">ID</p>
                            <p class="text-sm font-bold text-blue-900">{{ $gestion->idgestion }}</p>
                        </div>
                    </div>
                </div>

                <!-- Detalle de Gestión -->
                <div>
                    <label for="detalleges" class="block text-sm font-medium text-gray-700 mb-1.5">
                        Detalle de Gestión <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           name="detalleges" 
                           id="detalleges" 
                           value="{{ old('detalleges', $gestion->detalleges) }}"
                           placeholder="Ej: Gestión 2024"
                           class="w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('detalleges') border-red-500 @enderror"
                           required>
                    @error('detalleges')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Observación -->
                <div>
                    <label for="observacion" class="block text-sm font-medium text-gray-700 mb-1.5">
                        Observación
                    </label>
                    <textarea name="observacion" 
                              id="observacion" 
                              rows="2"
                              placeholder="Observaciones adicionales (opcional)"
                              class="w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('observacion') border-red-500 @enderror">{{ old('observacion', $gestion->observacion) }}</textarea>
                    @error('observacion')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Fechas -->
                <div class="grid grid-cols-2 gap-4">
                    <!-- Fecha de Apertura -->
                    <div>
                        <label for="fechaapertura" class="block text-sm font-medium text-gray-700 mb-1.5">
                            Fecha Apertura <span class="text-red-500">*</span>
                        </label>
                        <input type="date" 
                               name="fechaapertura" 
                               id="fechaapertura" 
                               value="{{ old('fechaapertura', $gestion->fechaapertura) }}"
                               class="w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('fechaapertura') border-red-500 @enderror"
                               required>
                        @error('fechaapertura')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Fecha de Cierre -->
                    <div>
                        <label for="fechacierre" class="block text-sm font-medium text-gray-700 mb-1.5">
                            Fecha Cierre <span class="text-red-500">*</span>
                        </label>
                        <input type="date" 
                               name="fechacierre" 
                               id="fechacierre" 
                               value="{{ old('fechacierre', $gestion->fechacierre) }}"
                               class="w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('fechacierre') border-red-500 @enderror"
                               required>
                        @error('fechacierre')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Estado -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Estado <span class="text-red-500">*</span>
                    </label>
                    <div class="flex items-center gap-4">
                        <label class="inline-flex items-center cursor-pointer">
                            <input type="radio" 
                                   name="estado" 
                                   value="1" 
                                   {{ old('estado', $gestion->estado) === '1' ? 'checked' : '' }}
                                   class="w-4 h-4 text-green-600 focus:ring-green-500">
                            <span class="ml-2 text-sm text-gray-700">Activa</span>
                        </label>
                        <label class="inline-flex items-center cursor-pointer">
                            <input type="radio" 
                                   name="estado" 
                                   value="0" 
                                   {{ old('estado', $gestion->estado) === '0' ? 'checked' : '' }}
                                   class="w-4 h-4 text-red-600 focus:ring-red-500">
                            <span class="ml-2 text-sm text-gray-700">Inactiva</span>
                        </label>
                    </div>
                    @error('estado')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Botones -->
                <div class="flex items-center justify-end gap-3 pt-4 border-t">
                    <a href="{{ route('admin.gestion.index') }}"
                       class="px-5 py-2.5 bg-gray-200 hover:bg-gray-300 text-gray-800 font-medium rounded-lg transition-colors">
                        Cancelar
                    </a>
                    <button type="submit"
                            class="px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors shadow-md hover:shadow-lg">
                        Actualizar Gestión
                    </button>
                </div>
            </form>
        </div>

        <!-- Información adicional -->
        <div class="bg-amber-50 border-l-4 border-amber-500 p-3 rounded-r-lg mt-4">
            <div class="flex items-start gap-2">
                <svg class="w-4 h-4 text-amber-600 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                </svg>
                <div>
                    <h3 class="text-xs font-semibold text-amber-800">Advertencia</h3>
                    <p class="text-xs text-amber-700">
                        Modificar fechas de una gestión activa puede afectar inscripciones y mensualidades.
                    </p>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
