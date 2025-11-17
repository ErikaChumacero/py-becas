<x-admin-layout>
    <div class="max-w-6xl mx-auto space-y-6">
        <!-- Header -->
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.mensualidad.index') }}"
               class="inline-flex items-center justify-center w-10 h-10 rounded-lg bg-gray-100 hover:bg-gray-200 transition-colors">
                <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
            </a>
            <div>
                <h1 class="text-3xl font-bold text-gray-800">Editar Pago de Mensualidad</h1>
                <p class="text-gray-600 mt-1">Modifica solo la fecha, tipo de pago y observaciones</p>
            </div>
        </div>

        <!-- Formulario -->
        <div class="bg-white rounded-lg shadow-md p-8">
            <form action="{{ route('admin.mensualidad.update', $mensualidad->idmensualidad) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                <!-- Información del Estudiante (solo lectura) -->
                <div class="bg-gray-50 border border-gray-200 rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Información del Pago</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <p class="text-xs font-medium text-gray-500 uppercase">ID Mensualidad</p>
                            <p class="text-sm font-bold text-gray-900">{{ $mensualidad->idmensualidad }}</p>
                        </div>
                        <div>
                            <p class="text-xs font-medium text-gray-500 uppercase">Estudiante</p>
                            <p class="text-sm font-bold text-gray-900">{{ $mensualidad->estudiante_nombre }}</p>
                            <p class="text-xs text-gray-600">CI: {{ $mensualidad->ci }}</p>
                        </div>
                        <div>
                            <p class="text-xs font-medium text-gray-500 uppercase">Curso</p>
                            <p class="text-sm font-bold text-gray-900">{{ $mensualidad->nivel_nombre }} / {{ $mensualidad->curso_nombre }}</p>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Fecha de Pago -->
                    <div>
                        <label for="fechamen" class="block text-sm font-semibold text-gray-700 mb-2">
                            Fecha de Pago <span class="text-red-500">*</span>
                        </label>
                        <input type="date" name="fechamen" id="fechamen" 
                               value="{{ old('fechamen', $mensualidad->fechamen) }}" required
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 @error('fechamen') border-red-500 @enderror">
                        @error('fechamen')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Tipo de Pago -->
                    <div>
                        <label for="tipopago" class="block text-sm font-semibold text-gray-700 mb-2">
                            Tipo de Pago <span class="text-red-500">*</span>
                        </label>
                        <select name="tipopago" id="tipopago" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 @error('tipopago') border-red-500 @enderror">
                            <option value="E" {{ old('tipopago', $mensualidad->tipopago) == 'E' ? 'selected' : '' }}>Efectivo</option>
                            <option value="Q" {{ old('tipopago', $mensualidad->tipopago) == 'Q' ? 'selected' : '' }}>QR</option>
                        </select>
                        @error('tipopago')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Monto Pagado (Solo lectura) -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Monto Pagado
                        </label>
                        <div class="flex items-center gap-3 p-4 bg-gray-50 border border-gray-200 rounded-lg">
                            <div class="flex-1">
                                <p class="text-2xl font-bold text-gray-900">{{ number_format($mensualidad->montototal, 2) }} Bs</p>
                                <p class="text-xs text-gray-600 mt-1">El monto no se puede modificar una vez registrado el pago</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Observaciones -->
                <div>
                    <label for="observacion" class="block text-sm font-semibold text-gray-700 mb-2">
                        Observaciones (opcional)
                    </label>
                    <textarea name="observacion" id="observacion" rows="3"
                              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500">{{ old('observacion', $mensualidad->observacion) }}</textarea>
                </div>

                <!-- Botones -->
                <div class="flex items-center gap-4 pt-4 border-t">
                    <a href="{{ route('admin.mensualidad.index') }}"
                       class="px-6 py-3 bg-gray-200 hover:bg-gray-300 text-gray-800 font-medium rounded-lg transition-colors">
                        Cancelar
                    </a>
                    <button type="submit"
                            class="px-6 py-3 bg-gradient-to-r from-emerald-600 to-emerald-700 hover:from-emerald-700 hover:to-emerald-800 text-white font-medium rounded-lg transition-all duration-200 transform hover:scale-105 shadow-lg hover:shadow-xl">
                        Actualizar Pago
                    </button>
                </div>
            </form>
        </div>
    </div>

</x-admin-layout>
