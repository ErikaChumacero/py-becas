<x-admin-layout>
    <div class="max-w-3xl mx-auto py-6 px-4">
        <!-- Header -->
        <div class="flex items-center gap-3 mb-6">
            <a href="{{ route('admin.detallemensualidad.index') }}"
               class="inline-flex items-center justify-center w-9 h-9 rounded-lg bg-gray-100 hover:bg-gray-200 transition-colors">
                <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
            </a>
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Nueva Mensualidad</h1>
                <p class="text-sm text-gray-600">Define el monto de mensualidad para un nivel educativo</p>
            </div>
        </div>

        <!-- Errores -->
        @if ($errors->any())
            <div class="mb-6 bg-red-50 border-l-4 border-red-500 rounded-r-lg p-4 shadow-sm">
                <div class="flex items-start">
                    <svg class="w-5 h-5 text-red-500 mt-0.5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                    </svg>
                    <div class="flex-1">
                        <h3 class="text-sm font-semibold text-red-800 mb-1">Se encontraron errores:</h3>
                        <ul class="list-disc list-inside text-sm text-red-700 space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif

        <!-- Formulario -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <form action="{{ route('admin.detallemensualidad.store') }}" method="POST" class="space-y-5">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Nivel Educativo -->
                    <div class="col-span-2">
                        <label for="descripcion" class="block text-sm font-medium text-gray-700 mb-1.5">
                            Nivel Educativo <span class="text-red-500">*</span>
                        </label>
                        <select name="descripcion" id="descripcion" 
                                class="w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('descripcion') border-red-500 @enderror" 
                                required>
                            <option value="">Seleccione un nivel...</option>
                            <option value="Inicial" data-monto="350" {{ old('descripcion') == 'Inicial' ? 'selected' : '' }}>
                                Inicial (Bs. 350/mes)
                            </option>
                            <option value="Primaria" data-monto="480" {{ old('descripcion') == 'Primaria' ? 'selected' : '' }}>
                                Primaria (Bs. 480/mes)
                            </option>
                            <option value="Secundaria" data-monto="550" {{ old('descripcion') == 'Secundaria' ? 'selected' : '' }}>
                                Secundaria (Bs. 550/mes)
                            </option>
                        </select>
                        @error('descripcion')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-xs text-gray-500">El monto se aplicará automáticamente según el nivel</p>
                    </div>

                    <!-- Gestión -->
                    <div>
                        <label for="idgestion" class="block text-sm font-medium text-gray-700 mb-1.5">
                            Gestión <span class="text-red-500">*</span>
                        </label>
                        <select name="idgestion" id="idgestion"
                                class="w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('idgestion') border-red-500 @enderror" 
                                required>
                            <option value="">Seleccione...</option>
                            @foreach($gestiones as $gestion)
                                <option value="{{ $gestion->idgestion }}" {{ old('idgestion') == $gestion->idgestion ? 'selected' : '' }}>
                                    {{ $gestion->detalleges }}
                                </option>
                            @endforeach
                        </select>
                        @error('idgestion')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Monto -->
                    <div>
                        <label for="monto" class="block text-sm font-medium text-gray-700 mb-1.5">
                            Monto Mensual (Bs.) <span class="text-red-500">*</span>
                        </label>
                        <input type="number" name="monto" id="monto" 
                               value="{{ old('monto') }}" 
                               class="w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('monto') border-red-500 @enderror" 
                               required min="1" step="0.01"
                               placeholder="480.00">
                        @error('monto')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-xs text-gray-500">Monto base sin descuentos</p>
                    </div>

                    <!-- Cantidad de Cuotas -->
                    <div>
                        <label for="cantidadmesualidades" class="block text-sm font-medium text-gray-700 mb-1.5">
                            Cantidad de Cuotas <span class="text-red-500">*</span>
                        </label>
                        <input type="number" name="cantidadmesualidades" id="cantidadmesualidades" 
                               value="{{ old('cantidadmesualidades', 10) }}" 
                               class="w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('cantidadmesualidades') border-red-500 @enderror" 
                               required min="1" max="12"
                               placeholder="10">
                        @error('cantidadmesualidades')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-xs text-gray-500">Número de mensualidades en el año</p>
                    </div>

                    <!-- Estado -->
                    <div>
                        <label for="estado" class="block text-sm font-medium text-gray-700 mb-1.5">
                            Estado <span class="text-red-500">*</span>
                        </label>
                        <select name="estado" id="estado"
                                class="w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('estado') border-red-500 @enderror" 
                                required>
                            <option value="1" {{ old('estado', '1') == '1' ? 'selected' : '' }}>Activo</option>
                            <option value="0" {{ old('estado') == '0' ? 'selected' : '' }}>Inactivo</option>
                        </select>
                        @error('estado')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror>
                    </div>
                </div>

                <!-- Campos ocultos para descuento (siempre 0) -->
                <input type="hidden" name="nodescuento" value="0">
                <input type="hidden" name="descuento" value="0">

                <!-- Nota informativa -->
                <div class="bg-blue-50 border-l-4 border-blue-500 p-3 rounded-r-lg">
                    <div class="flex items-start gap-2">
                        <svg class="w-4 h-4 text-blue-600 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                        </svg>
                        <div>
                            <h3 class="text-xs font-semibold text-blue-800">Nota importante</h3>
                            <p class="text-xs text-blue-700 mt-1">
                                Los descuentos se aplican automáticamente según la beca asignada al estudiante en su inscripción. No es necesario configurar descuentos manuales aquí.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Botones -->
                <div class="flex items-center justify-end gap-3 pt-4 border-t">
                    <a href="{{ route('admin.detallemensualidad.index') }}"
                       class="px-5 py-2.5 bg-gray-200 hover:bg-gray-300 text-gray-800 font-medium rounded-lg transition-colors">
                        Cancelar
                    </a>
                    <button type="submit"
                            class="px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors shadow-md hover:shadow-lg">
                        Guardar Mensualidad
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Auto-completar monto según nivel educativo
        document.getElementById('descripcion').addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            const montoSugerido = selectedOption.getAttribute('data-monto');
            const montoInput = document.getElementById('monto');
            
            if (montoSugerido && montoInput) {
                montoInput.value = montoSugerido;
            }
        });
    </script>
</x-admin-layout>
