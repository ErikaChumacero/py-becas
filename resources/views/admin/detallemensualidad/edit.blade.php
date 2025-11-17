<x-admin-layout>
    @if ($errors->any())
        <div class="bg-red-500 text-white p-4 rounded mb-4">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="container mx-auto mt-5">
        <h1 class="text-2xl font-bold mb-4">Editar Detalle de Mensualidad</h1>

        @if($totalMensualidades > 0)
        <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 mb-4">
            <p class="font-bold">⚠️ Advertencia</p>
            <p>Este detalle tiene {{ $totalMensualidades }} mensualidad(es) asociada(s). Los cambios afectarán el cálculo de montos.</p>
        </div>
        @endif

        <form action="{{ route('admin.detallemensualidad.update', $detalle->iddetallemensualidad) }}" method="POST" class="bg-white p-6 rounded shadow">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-2 gap-4">
                <!-- ID (solo lectura) -->
                <div>
                    <label class="block text-gray-700 font-medium mb-2">ID</label>
                    <input type="text" value="{{ $detalle->iddetallemensualidad }}" 
                           class="w-full border rounded px-3 py-2 bg-gray-100" readonly>
                </div>

                <!-- Gestión Actual (solo lectura) -->
                <div>
                    <label class="block text-gray-700 font-medium mb-2">Gestión Actual</label>
                    <input type="text" value="{{ $detalle->gestion_nombre }}" 
                           class="w-full border rounded px-3 py-2 bg-gray-100" readonly>
                </div>

                <!-- Descripción -->
                <div class="col-span-2">
                    <label class="block text-gray-700 font-medium mb-2">Nivel Educativo *</label>
                    <select name="descripcion" id="descripcion" class="w-full border rounded px-3 py-2" required>
                        <option value="Inicial" data-monto="350" {{ old('descripcion', $detalle->descripcion) == 'Inicial' ? 'selected' : '' }}>Inicial (Sugerido: Bs. 350)</option>
                        <option value="Primaria" data-monto="480" {{ old('descripcion', $detalle->descripcion) == 'Primaria' ? 'selected' : '' }}>Primaria (Sugerido: Bs. 480)</option>
                        <option value="Secundaria" data-monto="550" {{ old('descripcion', $detalle->descripcion) == 'Secundaria' ? 'selected' : '' }}>Secundaria (Sugerido: Bs. 550)</option>
                    </select>
                    @error('descripcion')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                    <p class="text-sm text-gray-500 mt-1">Cambiar el nivel actualizará el monto sugerido</p>
                </div>

                <!-- Gestión -->
                <div>
                    <label class="block text-gray-700 font-medium mb-2">Cambiar Gestión *</label>
                    <select name="idgestion" class="w-full border rounded px-3 py-2" required>
                        @foreach($gestiones as $gestion)
                            <option value="{{ $gestion->idgestion }}" 
                                {{ old('idgestion', $detalle->idgestion) == $gestion->idgestion ? 'selected' : '' }}>
                                {{ $gestion->detalleges }}
                            </option>
                        @endforeach
                    </select>
                    @error('idgestion')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Estado -->
                <div>
                    <label class="block text-gray-700 font-medium mb-2">Estado *</label>
                    <select name="estado" class="w-full border rounded px-3 py-2" required>
                        <option value="1" {{ old('estado', $detalle->estado) == '1' ? 'selected' : '' }}>Activo</option>
                        <option value="0" {{ old('estado', $detalle->estado) == '0' ? 'selected' : '' }}>Inactivo</option>
                    </select>
                    @error('estado')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Monto -->
                <div>
                    <label class="block text-gray-700 font-medium mb-2">Monto (Bs.) *</label>
                    <input type="number" name="monto" value="{{ old('monto', $detalle->monto) }}" 
                           class="w-full border rounded px-3 py-2" required min="0" step="0.01">
                    @error('monto')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Cantidad de Mensualidades -->
                <div>
                    <label class="block text-gray-700 font-medium mb-2">Cantidad de Cuotas *</label>
                    <input type="number" name="cantidadmesualidades" value="{{ old('cantidadmesualidades', $detalle->cantidadmesualidades) }}" 
                           class="w-full border rounded px-3 py-2" required min="1">
                    @error('cantidadmesualidades')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Aplicar Descuento -->
                <div>
                    <label class="block text-gray-700 font-medium mb-2">¿Aplicar Descuento?</label>
                    <select name="nodescuento" id="nodescuento" class="w-full border rounded px-3 py-2" required>
                        <option value="0" {{ old('nodescuento', $detalle->nodescuento) == '0' ? 'selected' : '' }}>No</option>
                        <option value="1" {{ old('nodescuento', $detalle->nodescuento) == '1' ? 'selected' : '' }}>Sí</option>
                    </select>
                    @error('nodescuento')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Descuento % -->
                <div>
                    <label class="block text-gray-700 font-medium mb-2">Descuento (%) *</label>
                    <input type="number" name="descuento" id="descuento" value="{{ old('descuento', $detalle->descuento) }}" 
                           class="w-full border rounded px-3 py-2" required min="0" max="100">
                    @error('descuento')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Monto Total Calculado (solo lectura) -->
                <div class="col-span-2 bg-blue-50 p-4 rounded">
                    <label class="block text-gray-700 font-medium mb-2">Monto Total Actual</label>
                    <p class="text-2xl font-bold text-blue-600">Bs. {{ number_format($detalle->montototal, 2) }}</p>
                    <p class="text-sm text-gray-600">Se recalculará automáticamente al guardar</p>
                </div>
            </div>

            <div class="mt-6 flex gap-2">
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                    Actualizar
                </button>
                <a href="{{ route('admin.detallemensualidad.index') }}" 
                   class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
                    Cancelar
                </a>
            </div>
        </form>
    </div>

    <script>
        // Auto-completar monto según nivel educativo
        document.getElementById('descripcion').addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            const montoSugerido = selectedOption.getAttribute('data-monto');
            const montoInput = document.querySelector('input[name="monto"]');
            
            if (montoSugerido && montoInput) {
                montoInput.value = montoSugerido;
            }
        });

        // Deshabilitar campo descuento si no se aplica
        document.getElementById('nodescuento').addEventListener('change', function() {
            const descuentoInput = document.getElementById('descuento');
            if (this.value === '0') {
                descuentoInput.value = 0;
                descuentoInput.disabled = true;
            } else {
                descuentoInput.disabled = false;
            }
        });

        // Inicializar estado
        if (document.getElementById('nodescuento').value === '0') {
            document.getElementById('descuento').disabled = true;
        }
    </script>
</x-admin-layout>
