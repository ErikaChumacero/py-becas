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
                <h1 class="text-3xl font-bold text-gray-800">Registrar Pago de Mensualidad</h1>
                <p class="text-gray-600 mt-1">Registra el pago de un estudiante inscrito</p>
            </div>
        </div>

        <!-- Formulario -->
        <div class="bg-white rounded-lg shadow-md p-8">
            <form action="{{ route('admin.mensualidad.store') }}" method="POST" class="space-y-6" id="formMensualidad">
                @csrf

                <!-- Seleccionar Inscripción -->
                <div>
                    <label for="inscripcion" class="block text-sm font-semibold text-gray-700 mb-2">
                        Seleccionar Estudiante Inscrito <span class="text-red-500">*</span>
                    </label>
                    <select name="inscripcion" id="inscripcion" required onchange="cargarDatosInscripcion()"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent @error('ci') border-red-500 @enderror">
                        <option value="">Seleccione un estudiante inscrito</option>
                        @foreach($inscripciones as $inscripcion)
                            <option value="{{ $inscripcion->ci }}_{{ $inscripcion->idcurso }}_{{ $inscripcion->idnivel }}"
                                    data-ci="{{ $inscripcion->ci }}"
                                    data-idcurso="{{ $inscripcion->idcurso }}"
                                    data-idnivel="{{ $inscripcion->idnivel }}"
                                    data-estudiante="{{ $inscripcion->estudiante_nombre }}"
                                    data-curso="{{ $inscripcion->curso_nombre }}"
                                    data-nivel="{{ $inscripcion->nivel_nombre }}"
                                    data-gestion="{{ $inscripcion->gestion_nombre }}"
                                    data-codbeca="{{ $inscripcion->codbeca }}"
                                    data-descuento="{{ $inscripcion->descuento_beca ?? 0 }}"
                                    data-nombrebeca="{{ $inscripcion->nombrebeca ?? 'Sin beca' }}"
                                    data-montobase="{{ $inscripcion->monto_base ?? 0 }}"
                                    {{ old('inscripcion') == $inscripcion->ci.'_'.$inscripcion->idcurso.'_'.$inscripcion->idnivel ? 'selected' : '' }}>
                                {{ $inscripcion->estudiante_nombre }} - {{ $inscripcion->nivel_nombre }} / {{ $inscripcion->curso_nombre }} ({{ $inscripcion->gestion_nombre }})
                                @if($inscripcion->codestudiante) - {{ $inscripcion->codestudiante }} @endif
                            </option>
                        @endforeach
                    </select>
                    @error('ci')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    
                    <!-- Campos ocultos -->
                    <input type="hidden" name="ci" id="ci" value="{{ old('ci') }}">
                    <input type="hidden" name="idcurso" id="idcurso" value="{{ old('idcurso') }}">
                    <input type="hidden" name="idnivel" id="idnivel" value="{{ old('idnivel') }}">
                </div>

                <!-- Información del Estudiante (se muestra al seleccionar) -->
                <div id="infoEstudiante" class="hidden bg-indigo-50 border border-indigo-200 rounded-lg p-4">
                    <h3 class="text-sm font-semibold text-indigo-800 mb-3">Información del Estudiante</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <p class="text-xs text-indigo-600 font-medium">Estudiante</p>
                            <p class="text-sm font-bold text-indigo-900" id="displayEstudiante">-</p>
                        </div>
                        <div>
                            <p class="text-xs text-indigo-600 font-medium">Curso</p>
                            <p class="text-sm font-bold text-indigo-900" id="displayCurso">-</p>
                        </div>
                        <div>
                            <p class="text-xs text-indigo-600 font-medium">Gestión</p>
                            <p class="text-sm font-bold text-indigo-900" id="displayGestion">-</p>
                        </div>
                    </div>
                    <div id="infoBeca" class="hidden mt-3 pt-3 border-t border-green-200">
                        <div class="flex items-center gap-2">
                            <svg class="w-5 h-5 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                            </svg>
                            <div>
                                <p class="text-xs text-green-600 font-medium">Beca Asignada</p>
                                <p class="text-sm font-bold text-green-800"><span id="displayBeca">-</span> (<span id="displayDescuento">0</span>% descuento)</p>
                            </div>
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
                               value="{{ old('fechamen', date('Y-m-d')) }}" required
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent @error('fechamen') border-red-500 @enderror">
                        @error('fechamen')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Tipo de Pago (oculto si beca 100%) -->
                    <div id="divTipoPago">
                        <label for="tipopago" class="block text-sm font-semibold text-gray-700 mb-2">
                            Tipo de Pago <span class="text-red-500">*</span>
                        </label>
                        <select name="tipopago" id="tipopago"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent @error('tipopago') border-red-500 @enderror">
                            <option value="">Seleccione tipo de pago</option>
                            <option value="E" {{ old('tipopago') == 'E' ? 'selected' : '' }}>Efectivo</option>
                            <option value="Q" {{ old('tipopago') == 'Q' ? 'selected' : '' }}>QR</option>
                        </select>
                        @error('tipopago')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <!-- Mensaje para beca 100% -->
                    <div id="mensajeBecaCompleta" class="hidden">
                        <div class="p-4 bg-green-50 border border-green-200 rounded-lg">
                            <div class="flex items-center gap-2">
                                <svg class="w-5 h-5 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                </svg>
                                <div>
                                    <p class="text-sm font-semibold text-green-800">Beca Completa (100%)</p>
                                    <p class="text-xs text-green-600">No se requiere pago para este estudiante</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Mes del Pago -->
                    <div class="md:col-span-2">
                        <label for="descripcion_detalle" class="block text-sm font-semibold text-gray-700 mb-2">
                            Mes del Pago <span class="text-red-500">*</span>
                        </label>
                        <select name="descripcion_detalle" id="descripcion_detalle" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent @error('descripcion_detalle') border-red-500 @enderror">
                            <option value="">Seleccione el mes...</option>
                            <option value="Mensualidad Enero" {{ old('descripcion_detalle') == 'Mensualidad Enero' ? 'selected' : '' }}>Enero</option>
                            <option value="Mensualidad Febrero" {{ old('descripcion_detalle') == 'Mensualidad Febrero' ? 'selected' : '' }}>Febrero</option>
                            <option value="Mensualidad Marzo" {{ old('descripcion_detalle') == 'Mensualidad Marzo' ? 'selected' : '' }}>Marzo</option>
                            <option value="Mensualidad Abril" {{ old('descripcion_detalle') == 'Mensualidad Abril' ? 'selected' : '' }}>Abril</option>
                            <option value="Mensualidad Mayo" {{ old('descripcion_detalle') == 'Mensualidad Mayo' ? 'selected' : '' }}>Mayo</option>
                            <option value="Mensualidad Junio" {{ old('descripcion_detalle') == 'Mensualidad Junio' ? 'selected' : '' }}>Junio</option>
                            <option value="Mensualidad Julio" {{ old('descripcion_detalle') == 'Mensualidad Julio' ? 'selected' : '' }}>Julio</option>
                            <option value="Mensualidad Agosto" {{ old('descripcion_detalle') == 'Mensualidad Agosto' ? 'selected' : '' }}>Agosto</option>
                            <option value="Mensualidad Septiembre" {{ old('descripcion_detalle') == 'Mensualidad Septiembre' ? 'selected' : '' }}>Septiembre</option>
                            <option value="Mensualidad Octubre" {{ old('descripcion_detalle') == 'Mensualidad Octubre' ? 'selected' : '' }}>Octubre</option>
                            <option value="Mensualidad Noviembre" {{ old('descripcion_detalle') == 'Mensualidad Noviembre' ? 'selected' : '' }}>Noviembre</option>
                            <option value="Mensualidad Diciembre" {{ old('descripcion_detalle') == 'Mensualidad Diciembre' ? 'selected' : '' }}>Diciembre</option>
                        </select>
                        @error('descripcion_detalle')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-xs text-gray-500">Seleccione el mes correspondiente al pago</p>
                    </div>

                    <!-- Monto a Pagar (Solo lectura) -->
                    <div class="md:col-span-2">
                        <label for="monto" class="block text-sm font-semibold text-gray-700 mb-2">
                            Monto a Pagar <span class="text-red-500">*</span>
                        </label>
                        <div class="flex items-center gap-3 p-4 bg-emerald-50 border border-emerald-200 rounded-lg">
                            <div class="flex-1">
                                <input type="number" name="monto" id="monto" 
                                       value="{{ old('monto') }}"
                                       readonly
                                       class="w-full px-4 py-3 bg-white border border-gray-300 rounded-lg text-2xl font-bold text-emerald-700 text-right">
                            </div>
                            <span class="text-2xl font-bold text-emerald-700">Bs</span>
                        </div>
                        <p class="mt-2 text-xs text-gray-600">
                            💡 El monto se calcula automáticamente según el nivel/curso del estudiante y su beca asignada.
                        </p>
                        @error('monto')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Campos ocultos para descuento -->
                    <input type="hidden" name="nodescuento" value="0">
                    <input type="hidden" name="descuento_manual" value="">
                </div>

                <!-- Cálculo del Total -->
                <div class="bg-emerald-50 border-l-4 border-emerald-500 p-4 rounded-r-lg">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-semibold text-emerald-800">Total a Pagar</p>
                            <p class="text-xs text-emerald-600">Monto con descuento aplicado</p>
                        </div>
                        <div class="text-right">
                            <p class="text-3xl font-bold text-emerald-700" id="totalPagar">0.00 Bs</p>
                            <p class="text-xs text-emerald-600" id="detalleCalculo">-</p>
                        </div>
                    </div>
                </div>

                <!-- Observaciones -->
                <div>
                    <label for="observacion" class="block text-sm font-semibold text-gray-700 mb-2">
                        Observaciones (opcional)
                    </label>
                    <textarea name="observacion" id="observacion" rows="3"
                              placeholder="Si se deja vacío, se asignará automáticamente según el tipo de pago"
                              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent">{{ old('observacion') }}</textarea>
                    <p class="mt-1 text-xs text-gray-500">Máximo 200 caracteres. Si está vacío: "Pago en Efectivo" o "Pago con QR"</p>
                </div>

                <!-- Botones -->
                <div class="flex items-center gap-4 pt-4 border-t">
                    <a href="{{ route('admin.mensualidad.index') }}"
                       class="px-6 py-3 bg-gray-200 hover:bg-gray-300 text-gray-800 font-medium rounded-lg transition-colors">
                        Cancelar
                    </a>
                    <button type="submit"
                            class="px-6 py-3 bg-gradient-to-r from-emerald-600 to-emerald-700 hover:from-emerald-700 hover:to-emerald-800 text-white font-medium rounded-lg transition-all duration-200 transform hover:scale-105 shadow-lg hover:shadow-xl">
                        Registrar Pago
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function cargarDatosInscripcion() {
            const select = document.getElementById('inscripcion');
            const option = select.options[select.selectedIndex];
            
            if (option.value) {
                // Cargar datos en campos ocultos
                document.getElementById('ci').value = option.dataset.ci;
                document.getElementById('idcurso').value = option.dataset.idcurso;
                document.getElementById('idnivel').value = option.dataset.idnivel;
                
                // Mostrar información
                document.getElementById('infoEstudiante').classList.remove('hidden');
                document.getElementById('displayEstudiante').textContent = option.dataset.estudiante;
                document.getElementById('displayCurso').textContent = option.dataset.nivel + ' / ' + option.dataset.curso;
                document.getElementById('displayGestion').textContent = option.dataset.gestion;
                
                // Obtener monto del detalle de mensualidad y aplicar descuento de beca
                const descuentoBeca = parseInt(option.dataset.descuento) || 0;
                const montoBase = parseFloat(option.dataset.montobase) || 0;
                
                // Mostrar beca si tiene
                if (option.dataset.codbeca) {
                    document.getElementById('infoBeca').classList.remove('hidden');
                    document.getElementById('displayBeca').textContent = option.dataset.nombrebeca;
                    document.getElementById('displayDescuento').textContent = descuentoBeca;
                } else {
                    document.getElementById('infoBeca').classList.add('hidden');
                }
                
                // Calcular monto con descuento
                if (montoBase > 0) {
                    const montoConDescuento = montoBase - (montoBase * descuentoBeca / 100);
                    
                    document.getElementById('monto').value = montoConDescuento.toFixed(2);
                    document.getElementById('totalPagar').textContent = montoConDescuento.toFixed(2) + ' Bs';
                    
                    // Ocultar tipo de pago si beca es 100%
                    const divTipoPago = document.getElementById('divTipoPago');
                    const mensajeBecaCompleta = document.getElementById('mensajeBecaCompleta');
                    const tipoPagoSelect = document.getElementById('tipopago');
                    
                    if (descuentoBeca >= 100) {
                        // Beca completa - ocultar tipo de pago
                        divTipoPago.classList.add('hidden');
                        mensajeBecaCompleta.classList.remove('hidden');
                        tipoPagoSelect.removeAttribute('required');
                        tipoPagoSelect.value = 'E'; // Valor por defecto
                    } else {
                        // Mostrar tipo de pago
                        divTipoPago.classList.remove('hidden');
                        mensajeBecaCompleta.classList.add('hidden');
                        tipoPagoSelect.setAttribute('required', 'required');
                    }
                    
                    if (descuentoBeca > 0) {
                        document.getElementById('detalleCalculo').textContent = 
                            `${montoBase.toFixed(2)} Bs - ${descuentoBeca}% (beca) = ${montoConDescuento.toFixed(2)} Bs`;
                    } else {
                        document.getElementById('detalleCalculo').textContent = 
                            `${montoBase.toFixed(2)} Bs (sin descuento)`;
                    }
                } else {
                    alert('No se encontró el detalle de mensualidad para este nivel. Por favor, configure primero el detalle de mensualidad.');
                    document.getElementById('monto').value = '';
                    document.getElementById('totalPagar').textContent = '0.00 Bs';
                    document.getElementById('detalleCalculo').textContent = '-';
                }
            } else {
                document.getElementById('infoEstudiante').classList.add('hidden');
                document.getElementById('monto').value = '';
                document.getElementById('totalPagar').textContent = '0.00 Bs';
                document.getElementById('detalleCalculo').textContent = '-';
            }
        }

        // Inicializar al cargar
        document.addEventListener('DOMContentLoaded', function() {
            if (document.getElementById('inscripcion').value) {
                cargarDatosInscripcion();
            }
        });
    </script>
</x-admin-layout>
