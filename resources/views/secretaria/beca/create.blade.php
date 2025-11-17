<x-secretaria-layout>
    <div class="max-w-4xl mx-auto space-y-6">
        <!-- Header -->
        <div class="bg-gradient-to-r from-green-600 to-emerald-600 rounded-xl shadow-lg p-8 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-4xl font-bold mb-2">Asignar Beca Manual</h1>
                    <p class="text-green-100 text-lg">Asignar beca personalizada a un estudiante</p>
                </div>
                <a href="{{ route('secretaria.beca.index') }}" class="bg-white text-green-600 px-6 py-3 rounded-lg font-semibold hover:bg-green-50 transition-colors shadow-lg flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Volver
                </a>
            </div>
        </div>

        <!-- Formulario -->
        <form action="{{ route('secretaria.beca.store') }}" method="POST" class="bg-white rounded-xl shadow-md p-8">
            @csrf

            <div class="space-y-6">
                <!-- Selección de Estudiante -->
                <div>
                    <h2 class="text-xl font-bold text-gray-800 mb-4 flex items-center gap-2">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        Estudiante
                    </h2>

                    <div>
                        <label for="estudiante_select" class="block text-sm font-semibold text-gray-700 mb-2">
                            Seleccionar Estudiante <span class="text-red-500">*</span>
                        </label>
                        <select id="estudiante_select" required onchange="seleccionarEstudiante()"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all">
                            <option value="">Seleccione un estudiante sin beca...</option>
                            @foreach($estudiantes as $estudiante)
                                <option value="{{ json_encode($estudiante) }}">
                                    {{ $estudiante->nombre }} {{ $estudiante->apellido }} - {{ $estudiante->codestudiante }} 
                                    ({{ $estudiante->gestion }} - {{ $estudiante->nivel }} - {{ $estudiante->curso }})
                                </option>
                            @endforeach
                        </select>

                        <input type="hidden" name="ci" id="ci">
                        <input type="hidden" name="idcurso" id="idcurso">
                        <input type="hidden" name="idnivel" id="idnivel">
                        <input type="hidden" name="idgestion" id="idgestion">
                    </div>
                </div>

                <!-- Datos de la Beca -->
                <div>
                    <h2 class="text-xl font-bold text-gray-800 mb-4 flex items-center gap-2">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7"></path>
                        </svg>
                        Datos de la Beca
                    </h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="nombrebeca" class="block text-sm font-semibold text-gray-700 mb-2">
                                Nombre de la Beca <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="nombrebeca" id="nombrebeca" required maxlength="100"
                                   value="{{ old('nombrebeca') }}"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all"
                                   placeholder="Ej: Beca Excelencia Académica">
                            @error('nombrebeca')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="tipobeca" class="block text-sm font-semibold text-gray-700 mb-2">
                                Tipo de Beca <span class="text-red-500">*</span>
                            </label>
                            <select name="tipobeca" id="tipobeca" required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all">
                                <option value="">Seleccione...</option>
                                <option value="1" {{ old('tipobeca') == '1' ? 'selected' : '' }}>Mérito Académico</option>
                                <option value="2" {{ old('tipobeca') == '2' ? 'selected' : '' }}>Familiar</option>
                                <option value="3" {{ old('tipobeca') == '3' ? 'selected' : '' }}>Económica</option>
                            </select>
                            @error('tipobeca')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="porcentaje" class="block text-sm font-semibold text-gray-700 mb-2">
                                Porcentaje de Descuento <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <input type="number" name="porcentaje" id="porcentaje" required min="1" max="100"
                                       value="{{ old('porcentaje') }}"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all"
                                       placeholder="0">
                                <span class="absolute right-4 top-3 text-gray-500 font-bold">%</span>
                            </div>
                            @error('porcentaje')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="md:col-span-2">
                            <label for="observacion" class="block text-sm font-semibold text-gray-700 mb-2">
                                Observaciones
                            </label>
                            <textarea name="observacion" id="observacion" rows="3"
                                      class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all"
                                      placeholder="Motivo de la asignación de beca...">{{ old('observacion') }}</textarea>
                            @error('observacion')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
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
                            class="px-6 py-3 bg-green-600 text-white rounded-lg font-semibold hover:bg-green-700 transition-colors shadow-lg flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Asignar Beca
                    </button>
                </div>
            </div>
        </form>
    </div>

    <script>
        function seleccionarEstudiante() {
            const select = document.getElementById('estudiante_select');
            const option = select.options[select.selectedIndex];
            
            if (option.value) {
                const estudiante = JSON.parse(option.value);
                document.getElementById('ci').value = estudiante.ci;
                document.getElementById('idcurso').value = estudiante.idcurso;
                document.getElementById('idnivel').value = estudiante.idnivel;
                document.getElementById('idgestion').value = estudiante.idgestion;
            }
        }
    </script>
</x-secretaria-layout>
