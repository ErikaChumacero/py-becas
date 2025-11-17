<x-admin-layout>
    <div class="max-w-4xl mx-auto space-y-6">
        <!-- Header -->
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.gestion.index') }}"
               class="inline-flex items-center justify-center w-10 h-10 rounded-lg bg-gray-100 hover:bg-gray-200 transition-colors">
                <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
            </a>
            <div>
                <h1 class="text-3xl font-bold text-gray-800">Nueva Gestión</h1>
                <p class="text-gray-600 mt-1">Registra una nueva gestión académica</p>
            </div>
        </div>

        <!-- Formulario -->
        <div class="bg-white rounded-lg shadow-md p-8">
            <form action="{{ route('admin.gestion.store') }}" method="POST" class="space-y-6">
                @csrf

                <!-- Detalle de Gestión -->
                <div>
                    <label for="detalleges" class="block text-sm font-semibold text-gray-700 mb-2">
                        Detalle de Gestión <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           name="detalleges" 
                           id="detalleges" 
                           value="{{ old('detalleges') }}"
                           placeholder="Ej: Gestión 2024"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all @error('detalleges') border-red-500 @enderror"
                           required>
                    @error('detalleges')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Observación -->
                <div>
                    <label for="observacion" class="block text-sm font-semibold text-gray-700 mb-2">
                        Observación
                    </label>
                    <textarea name="observacion" 
                              id="observacion" 
                              rows="3"
                              placeholder="Observaciones adicionales (opcional)"
                              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all @error('observacion') border-red-500 @enderror">{{ old('observacion') }}</textarea>
                    @error('observacion')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Fechas -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Fecha de Apertura -->
                    <div>
                        <label for="fechaapertura" class="block text-sm font-semibold text-gray-700 mb-2">
                            Fecha de Apertura <span class="text-red-500">*</span>
                        </label>
                        <input type="date" 
                               name="fechaapertura" 
                               id="fechaapertura" 
                               value="{{ old('fechaapertura') }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all @error('fechaapertura') border-red-500 @enderror"
                               required>
                        @error('fechaapertura')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Fecha de Cierre -->
                    <div>
                        <label for="fechacierre" class="block text-sm font-semibold text-gray-700 mb-2">
                            Fecha de Cierre <span class="text-red-500">*</span>
                        </label>
                        <input type="date" 
                               name="fechacierre" 
                               id="fechacierre" 
                               value="{{ old('fechacierre') }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all @error('fechacierre') border-red-500 @enderror"
                               required>
                        @error('fechacierre')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Estado -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-3">
                        Estado <span class="text-red-500">*</span>
                    </label>
                    <div class="flex items-center gap-6">
                        <label class="inline-flex items-center cursor-pointer">
                            <input type="radio" 
                                   name="estado" 
                                   value="1" 
                                   {{ old('estado', '1') === '1' ? 'checked' : '' }}
                                   class="w-4 h-4 text-green-600 border-gray-300 focus:ring-green-500">
                            <span class="ml-2 text-sm font-medium text-gray-700">Activa</span>
                        </label>
                        <label class="inline-flex items-center cursor-pointer">
                            <input type="radio" 
                                   name="estado" 
                                   value="0" 
                                   {{ old('estado') === '0' ? 'checked' : '' }}
                                   class="w-4 h-4 text-red-600 border-gray-300 focus:ring-red-500">
                            <span class="ml-2 text-sm font-medium text-gray-700">Inactiva</span>
                        </label>
                    </div>
                    @error('estado')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Botones -->
                <div class="flex items-center gap-4 pt-4 border-t">
                    <a href="{{ route('admin.gestion.index') }}"
                       class="px-6 py-3 bg-gray-200 hover:bg-gray-300 text-gray-800 font-medium rounded-lg transition-colors">
                        Cancelar
                    </a>
                    <button type="submit"
                            class="px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-medium rounded-lg transition-all duration-200 transform hover:scale-105 shadow-lg hover:shadow-xl">
                        Registrar Gestión
                    </button>
                </div>
            </form>
        </div>

        <!-- Información adicional -->
        <div class="bg-blue-50 border-l-4 border-blue-500 p-4 rounded-r-lg">
            <div class="flex items-start">
                <svg class="w-5 h-5 text-blue-500 mt-0.5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                </svg>
                <div>
                    <h3 class="text-sm font-semibold text-blue-800 mb-1">Información</h3>
                    <p class="text-sm text-blue-700">
                        Una gestión representa un año o período académico. Asegúrate de configurar correctamente las fechas de apertura y cierre.
                    </p>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
