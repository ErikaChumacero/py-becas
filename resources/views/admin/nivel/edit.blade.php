<x-admin-layout>
    <div class="max-w-4xl mx-auto space-y-6">
        <!-- Header -->
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.nivel.index') }}"
               class="inline-flex items-center justify-center w-10 h-10 rounded-lg bg-gray-100 hover:bg-gray-200 transition-colors">
                <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
            </a>
            <div>
                <h1 class="text-3xl font-bold text-gray-800">Editar Nivel</h1>
                <p class="text-gray-600 mt-1">Modifica los datos del nivel educativo</p>
            </div>
        </div>

        <!-- Formulario -->
        <div class="bg-white rounded-lg shadow-md p-8">
            <form action="{{ route('admin.nivel.update', $nivel->idnivel) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                <!-- ID de Nivel (solo lectura) -->
                <div class="bg-gray-50 border border-gray-200 rounded-lg p-4">
                    <div class="flex items-center gap-3">
                        <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                        </svg>
                        <div>
                            <p class="text-xs font-medium text-gray-500 uppercase">ID de Nivel</p>
                            <p class="text-lg font-bold text-gray-900">{{ $nivel->idnivel }}</p>
                        </div>
                    </div>
                </div>

                <!-- Descripción -->
                <div>
                    <label for="descripcion" class="block text-sm font-semibold text-gray-700 mb-2">
                        Descripción del Nivel <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           name="descripcion" 
                           id="descripcion" 
                           value="{{ old('descripcion', $nivel->descripcion) }}"
                           placeholder="Ej: Primaria, Secundaria, Inicial"
                           maxlength="100"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all @error('descripcion') border-red-500 @enderror"
                           required
                           autofocus>
                    @error('descripcion')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-xs text-gray-500">Máximo 100 caracteres. Debe ser único.</p>
                </div>

                <!-- Información de dependencias -->
                @if($totalCursos > 0 || $totalMaterias > 0)
                    <div class="bg-amber-50 border-l-4 border-amber-500 p-4 rounded-r-lg">
                        <div class="flex items-start">
                            <svg class="w-5 h-5 text-amber-500 mt-0.5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                            </svg>
                            <div>
                                <h3 class="text-sm font-semibold text-amber-800 mb-1">Este nivel tiene dependencias</h3>
                                <ul class="text-sm text-amber-700 space-y-1">
                                    @if($totalCursos > 0)
                                        <li>• <strong>{{ $totalCursos }}</strong> curso{{ $totalCursos != 1 ? 's' : '' }} asociado{{ $totalCursos != 1 ? 's' : '' }}</li>
                                    @endif
                                    @if($totalMaterias > 0)
                                        <li>• <strong>{{ $totalMaterias }}</strong> materia{{ $totalMaterias != 1 ? 's' : '' }} asociada{{ $totalMaterias != 1 ? 's' : '' }}</li>
                                    @endif
                                </ul>
                                <p class="text-xs text-amber-600 mt-2">Los cambios se aplicarán a todos los registros relacionados debido a la restricción CASCADE.</p>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Botones -->
                <div class="flex items-center gap-4 pt-4 border-t">
                    <a href="{{ route('admin.nivel.index') }}"
                       class="px-6 py-3 bg-gray-200 hover:bg-gray-300 text-gray-800 font-medium rounded-lg transition-colors">
                        Cancelar
                    </a>
                    <button type="submit"
                            class="px-6 py-3 bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 text-white font-medium rounded-lg transition-all duration-200 transform hover:scale-105 shadow-lg hover:shadow-xl">
                        Actualizar Nivel
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-admin-layout>
