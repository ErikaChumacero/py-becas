<x-admin-layout>
    <div class="max-w-4xl mx-auto space-y-6">
        <!-- Header -->
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.beca.index') }}"
               class="inline-flex items-center justify-center w-10 h-10 rounded-lg bg-gray-100 hover:bg-gray-200 transition-colors">
                <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
            </a>
            <div>
                <h1 class="text-3xl font-bold text-gray-800">Editar Beca</h1>
                <p class="text-gray-600 mt-1">Modifica los datos de la beca</p>
            </div>
        </div>

        <!-- Formulario -->
        <div class="bg-white rounded-lg shadow-md p-8">
            <form action="{{ route('admin.beca.update', $beca->codbeca) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                <!-- Código de Beca (solo lectura) -->
                <div class="bg-gray-50 border border-gray-200 rounded-lg p-4">
                    <div class="flex items-center gap-3">
                        <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                        </svg>
                        <div>
                            <p class="text-xs font-medium text-gray-500 uppercase">Código de Beca</p>
                            <p class="text-lg font-bold text-gray-900">{{ $beca->codbeca }}</p>
                        </div>
                    </div>
                </div>

                <!-- Nombre de Beca -->
                <div>
                    <label for="nombrebeca" class="block text-sm font-semibold text-gray-700 mb-2">
                        Nombre de la Beca <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           name="nombrebeca" 
                           id="nombrebeca" 
                           value="{{ old('nombrebeca', $beca->nombrebeca) }}"
                           placeholder="Ej: Beca Excelencia Académica, Beca Deportiva"
                           maxlength="100"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-transparent transition-all @error('nombrebeca') border-red-500 @enderror"
                           required
                           autofocus>
                    @error('nombrebeca')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-xs text-gray-500">Máximo 100 caracteres. Debe ser único.</p>
                </div>

                <!-- Tipo de Beca -->
                <div>
                    <label for="tipobeca" class="block text-sm font-semibold text-gray-700 mb-2">
                        Tipo de Beca <span class="text-red-500">*</span>
                    </label>
                    <select name="tipobeca" id="tipobeca" required onchange="actualizarPorcentaje()"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-transparent @error('tipobeca') border-red-500 @enderror">
                        <option value="">Seleccione un tipo</option>
                        <option value="C" {{ old('tipobeca', $beca->tipobeca) == 'C' ? 'selected' : '' }}>Completa (100%)</option>
                        <option value="P" {{ old('tipobeca', $beca->tipobeca) == 'P' ? 'selected' : '' }}>Parcial (menos de 100%)</option>
                    </select>
                    @error('tipobeca')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Porcentaje -->
                <div>
                    <label for="porcentaje" class="block text-sm font-semibold text-gray-700 mb-2">
                        Porcentaje de Descuento <span class="text-red-500">*</span>
                    </label>
                    <div class="flex items-center gap-4">
                        <input type="number" 
                               name="porcentaje" 
                               id="porcentaje" 
                               value="{{ old('porcentaje', $beca->porcentaje) }}"
                               min="1"
                               max="100"
                               placeholder="0"
                               class="w-32 px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-transparent transition-all @error('porcentaje') border-red-500 @enderror"
                               required>
                        <span class="text-2xl font-bold text-amber-600">%</span>
                        <div class="flex-1">
                            <div class="w-full bg-gray-200 rounded-full h-3">
                                <div id="barra-porcentaje" class="bg-gradient-to-r from-amber-500 to-amber-600 h-3 rounded-full transition-all duration-300" style="width: {{ $beca->porcentaje }}%"></div>
                            </div>
                        </div>
                    </div>
                    @error('porcentaje')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-xs text-gray-500">Ingrese un valor entre 1 y 100.</p>
                </div>

                <!-- Información de dependencias -->
                @if($totalEstudiantes > 0)
                    <div class="bg-amber-50 border-l-4 border-amber-500 p-4 rounded-r-lg">
                        <div class="flex items-start">
                            <svg class="w-5 h-5 text-amber-500 mt-0.5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                            </svg>
                            <div>
                                <h3 class="text-sm font-semibold text-amber-800 mb-1">Esta beca tiene estudiantes asignados</h3>
                                <p class="text-sm text-amber-700">
                                    • <strong>{{ $totalEstudiantes }}</strong> estudiante{{ $totalEstudiantes != 1 ? 's' : '' }} inscrito{{ $totalEstudiantes != 1 ? 's' : '' }} con esta beca
                                </p>
                                <p class="text-xs text-amber-600 mt-2">Los cambios se aplicarán a todas las inscripciones existentes.</p>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Botones -->
                <div class="flex items-center gap-4 pt-4 border-t">
                    <a href="{{ route('admin.beca.index') }}"
                       class="px-6 py-3 bg-gray-200 hover:bg-gray-300 text-gray-800 font-medium rounded-lg transition-colors">
                        Cancelar
                    </a>
                    <button type="submit"
                            class="px-6 py-3 bg-gradient-to-r from-amber-600 to-amber-700 hover:from-amber-700 hover:to-amber-800 text-white font-medium rounded-lg transition-all duration-200 transform hover:scale-105 shadow-lg hover:shadow-xl">
                        Actualizar Beca
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function actualizarPorcentaje() {
            const tipoBeca = document.getElementById('tipobeca').value;
            const porcentajeInput = document.getElementById('porcentaje');
            
            if (tipoBeca === 'C') {
                // Sugerir 100% pero permitir edición
                if (!porcentajeInput.value || porcentajeInput.value === '') {
                    porcentajeInput.value = 100;
                }
            }
            actualizarBarra();
        }

        function actualizarBarra() {
            const porcentaje = document.getElementById('porcentaje').value || 0;
            document.getElementById('barra-porcentaje').style.width = porcentaje + '%';
        }

        document.getElementById('porcentaje').addEventListener('input', actualizarBarra);
        document.addEventListener('DOMContentLoaded', function() {
            actualizarBarra();
        });
    </script>
</x-admin-layout>
