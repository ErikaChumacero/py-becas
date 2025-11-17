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
                <h1 class="text-3xl font-bold text-gray-800">Nueva Beca</h1>
                <p class="text-gray-600 mt-1">Registra un nuevo tipo de beca</p>
            </div>
        </div>

        <!-- Formulario -->
        <div class="bg-white rounded-lg shadow-md p-8">
            <form action="{{ route('admin.beca.store') }}" method="POST" class="space-y-6">
                @csrf

                <!-- Nombre de Beca -->
                <div>
                    <label for="nombrebeca" class="block text-sm font-semibold text-gray-700 mb-2">
                        Nombre de la Beca <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           name="nombrebeca" 
                           id="nombrebeca" 
                           value="{{ old('nombrebeca') }}"
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
                        <option value="C" {{ old('tipobeca') == 'C' ? 'selected' : '' }}>Completa (100%)</option>
                        <option value="P" {{ old('tipobeca') == 'P' ? 'selected' : '' }}>Parcial (menos de 100%)</option>
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
                               value="{{ old('porcentaje') }}"
                               min="1"
                               max="100"
                               placeholder="0"
                               class="w-32 px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-transparent transition-all @error('porcentaje') border-red-500 @enderror"
                               required>
                        <span class="text-2xl font-bold text-amber-600">%</span>
                        <div class="flex-1">
                            <div class="w-full bg-gray-200 rounded-full h-3">
                                <div id="barra-porcentaje" class="bg-gradient-to-r from-amber-500 to-amber-600 h-3 rounded-full transition-all duration-300" style="width: 0%"></div>
                            </div>
                        </div>
                    </div>
                    @error('porcentaje')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-xs text-gray-500">Ingrese un valor entre 1 y 100.</p>
                </div>

                <!-- Información -->
                <div class="bg-blue-50 border-l-4 border-blue-500 p-4 rounded-r-lg">
                    <div class="flex items-start">
                        <svg class="w-5 h-5 text-blue-500 mt-0.5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                        </svg>
                        <div>
                            <h3 class="text-sm font-semibold text-blue-800 mb-1">Reglas de negocio</h3>
                            <ul class="text-sm text-blue-700 space-y-1">
                                <li>• <strong>Beca Completa (C):</strong> Debe tener exactamente 100% de descuento</li>
                                <li>• <strong>Beca Parcial (P):</strong> Debe tener menos de 100% de descuento</li>
                                <li>• El porcentaje determina el descuento en las mensualidades</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Botones -->
                <div class="flex items-center gap-4 pt-4 border-t">
                    <a href="{{ route('admin.beca.index') }}"
                       class="px-6 py-3 bg-gray-200 hover:bg-gray-300 text-gray-800 font-medium rounded-lg transition-colors">
                        Cancelar
                    </a>
                    <button type="submit"
                            class="px-6 py-3 bg-gradient-to-r from-amber-600 to-amber-700 hover:from-amber-700 hover:to-amber-800 text-white font-medium rounded-lg transition-all duration-200 transform hover:scale-105 shadow-lg hover:shadow-xl">
                        Registrar Beca
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
                porcentajeInput.value = 100;
                porcentajeInput.readOnly = true;
                porcentajeInput.classList.add('bg-gray-100');
            } else {
                porcentajeInput.readOnly = false;
                porcentajeInput.classList.remove('bg-gray-100');
                if (porcentajeInput.value == 100) {
                    porcentajeInput.value = '';
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
            if (document.getElementById('tipobeca').value) {
                actualizarPorcentaje();
            }
        });
    </script>
</x-admin-layout>
