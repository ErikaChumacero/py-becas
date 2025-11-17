<x-secretaria-layout>
    <div class="max-w-4xl mx-auto space-y-6">
        <!-- Header -->
        <div class="bg-gradient-to-r from-green-600 to-emerald-600 rounded-xl shadow-lg p-8 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-4xl font-bold mb-2">Registrar Pago</h1>
                    <p class="text-green-100 text-lg">Nueva mensualidad con descuentos y becas</p>
                </div>
                <a href="{{ route('secretaria.mensualidad.index') }}" class="bg-white text-green-600 px-6 py-3 rounded-lg font-semibold hover:bg-green-50 transition-colors shadow-lg flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Volver
                </a>
            </div>
        </div>

        <!-- Formulario -->
        <form action="{{ route('secretaria.mensualidad.store') }}" method="POST" class="bg-white rounded-xl shadow-md p-8">
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
                        <label for="ci" class="block text-sm font-semibold text-gray-700 mb-2">
                            Seleccionar Estudiante <span class="text-red-500">*</span>
                        </label>
                        <select name="ci" id="ci" required onchange="cargarInscripciones()"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all">
                            <option value="">Seleccione un estudiante...</option>
                            @foreach($estudiantes as $estudiante)
                                <option value="{{ $estudiante->ci }}" {{ old('ci') == $estudiante->ci ? 'selected' : '' }}>
                                    {{ $estudiante->nombre }} {{ $estudiante->apellido }} - {{ $estudiante->codestudiante }}
                                </option>
                            @endforeach
                        </select>
                        @error('ci')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Inscripción del Estudiante -->
                <div id="inscripcion-container" style="display: none;">
                    <h2 class="text-xl font-bold text-gray-800 mb-4 flex items-center gap-2">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        Inscripción
                    </h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="inscripcion_select" class="block text-sm font-semibold text-gray-700 mb-2">
                                Seleccionar Inscripción <span class="text-red-500">*</span>
                            </label>
                            <select id="inscripcion_select" required onchange="seleccionarInscripcion()"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all">
                                <option value="">Seleccione...</option>
                            </select>
                        </div>

                        <input type="hidden" name="idcurso" id="idcurso">
                        <input type="hidden" name="idnivel" id="idnivel">

                        <div id="beca-info" class="md:col-span-2 bg-yellow-50 border border-yellow-200 rounded-lg p-4" style="display: none;">
                            <p class="text-sm font-semibold text-yellow-800">
                                Este estudiante tiene una beca del <span id="beca-porcentaje">0</span>%
                            </p>
                            <p class="text-xs text-yellow-700 mt-1">El descuento se aplicará automáticamente al monto</p>
                        </div>
                    </div>
                </div>

                <!-- Detalle de Pago -->
                <div>
                    <h2 class="text-xl font-bold text-gray-800 mb-4 flex items-center gap-2">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Detalle del Pago
                    </h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="iddetallemensualidad" class="block text-sm font-semibold text-gray-700 mb-2">
                                Concepto <span class="text-red-500">*</span>
                            </label>
                            <select name="iddetallemensualidad" id="iddetallemensualidad" required onchange="calcularMonto()"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all">
                                <option value="">Seleccione un concepto...</option>
                                @foreach($detalles as $detalle)
                                    <option value="{{ $detalle->iddetallemensualidad }}" 
                                            data-monto="{{ $detalle->monto }}"
                                            data-descuento="{{ $detalle->descuento }}"
                                            data-nodescuento="{{ $detalle->nodescuento }}"
                                            {{ old('iddetallemensualidad') == $detalle->iddetallemensualidad ? 'selected' : '' }}>
                                        {{ $detalle->descripcion }} - {{ $detalle->gestion }} (Bs. {{ number_format($detalle->monto, 2) }})
                                    </option>
                                @endforeach
                            </select>
                            @error('iddetallemensualidad')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="tipopago" class="block text-sm font-semibold text-gray-700 mb-2">
                                Tipo de Pago <span class="text-red-500">*</span>
                            </label>
                            <select name="tipopago" id="tipopago" required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all">
                                <option value="">Seleccione...</option>
                                <option value="E" {{ old('tipopago') == 'E' ? 'selected' : '' }}>Efectivo</option>
                                <option value="Q" {{ old('tipopago') == 'Q' ? 'selected' : '' }}>QR</option>
                            </select>
                            @error('tipopago')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="md:col-span-2">
                            <label for="observacion" class="block text-sm font-semibold text-gray-700 mb-2">
                                Observaciones
                            </label>
                            <textarea name="observacion" id="observacion" rows="3"
                                      class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all"
                                      placeholder="Observaciones adicionales...">{{ old('observacion') }}</textarea>
                            @error('observacion')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Resumen de Cálculo -->
                <div id="calculo-container" class="bg-gradient-to-br from-green-50 to-emerald-50 border-2 border-green-200 rounded-xl p-6" style="display: none;">
                    <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                        </svg>
                        Resumen del Pago
                    </h3>
                    
                    <div class="space-y-3">
                        <div class="flex justify-between items-center">
                            <span class="text-gray-700 font-medium">Monto Base:</span>
                            <span class="text-gray-900 font-bold text-lg" id="monto-base">Bs. 0.00</span>
                        </div>
                        
                        <div class="flex justify-between items-center text-orange-600" id="descuento-row" style="display: none;">
                            <span class="font-medium">Descuento (<span id="descuento-porcentaje">0</span>%):</span>
                            <span class="font-bold" id="descuento-monto">- Bs. 0.00</span>
                        </div>
                        
                        <div class="flex justify-between items-center text-yellow-600" id="beca-row" style="display: none;">
                            <span class="font-medium">Beca (<span id="beca-calc-porcentaje">0</span>%):</span>
                            <span class="font-bold" id="beca-monto">- Bs. 0.00</span>
                        </div>
                        
                        <div class="border-t-2 border-green-300 pt-3 mt-3">
                            <div class="flex justify-between items-center">
                                <span class="text-gray-900 font-bold text-xl">Total a Pagar:</span>
                                <span class="text-green-600 font-bold text-2xl" id="monto-final">Bs. 0.00</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Botones -->
                <div class="flex items-center justify-end gap-4 pt-6 border-t border-gray-200">
                    <a href="{{ route('secretaria.mensualidad.index') }}" 
                       class="px-6 py-3 border border-gray-300 rounded-lg text-gray-700 font-semibold hover:bg-gray-50 transition-colors">
                        Cancelar
                    </a>
                    <button type="submit" 
                            class="px-6 py-3 bg-green-600 text-white rounded-lg font-semibold hover:bg-green-700 transition-colors shadow-lg flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Registrar Pago
                    </button>
                </div>
            </div>
        </form>
    </div>

    <script>
        let inscripciones = [];
        let becaPorcentaje = 0;

        async function cargarInscripciones() {
            const ci = document.getElementById('ci').value;
            const container = document.getElementById('inscripcion-container');
            const select = document.getElementById('inscripcion_select');
            
            if (!ci) {
                container.style.display = 'none';
                return;
            }

            try {
                const response = await fetch(`/secretaria/mensualidad/inscripcion/${ci}`);
                inscripciones = await response.json();
                
                select.innerHTML = '<option value="">Seleccione...</option>';
                
                inscripciones.forEach((insc, index) => {
                    const option = document.createElement('option');
                    option.value = index;
                    option.textContent = `${insc.gestion} - ${insc.nivel} - ${insc.curso}${insc.beca_porcentaje ? ' (Beca ' + insc.beca_porcentaje + '%)' : ''}`;
                    select.appendChild(option);
                });
                
                container.style.display = 'block';
            } catch (error) {
                console.error('Error al cargar inscripciones:', error);
                alert('Error al cargar las inscripciones del estudiante');
            }
        }

        function seleccionarInscripcion() {
            const index = document.getElementById('inscripcion_select').value;
            
            if (index === '') {
                document.getElementById('beca-info').style.display = 'none';
                becaPorcentaje = 0;
                return;
            }
            
            const insc = inscripciones[index];
            document.getElementById('idcurso').value = insc.idcurso;
            document.getElementById('idnivel').value = insc.idnivel;
            
            if (insc.beca_porcentaje && insc.beca_porcentaje > 0) {
                becaPorcentaje = insc.beca_porcentaje;
                document.getElementById('beca-porcentaje').textContent = insc.beca_porcentaje;
                document.getElementById('beca-info').style.display = 'block';
            } else {
                becaPorcentaje = 0;
                document.getElementById('beca-info').style.display = 'none';
            }
            
            calcularMonto();
        }

        function calcularMonto() {
            const select = document.getElementById('iddetallemensualidad');
            const option = select.options[select.selectedIndex];
            
            if (!option || !option.value) {
                document.getElementById('calculo-container').style.display = 'none';
                return;
            }
            
            const montoBase = parseFloat(option.dataset.monto);
            const descuentoBase = parseFloat(option.dataset.descuento);
            const noDescuento = option.dataset.nodescuento === '1';
            
            let montoConDescuento = montoBase;
            let descuentoAplicado = 0;
            
            // Aplicar descuento base
            if (descuentoBase > 0) {
                descuentoAplicado = montoBase * descuentoBase / 100;
                montoConDescuento = montoBase - descuentoAplicado;
                document.getElementById('descuento-porcentaje').textContent = descuentoBase;
                document.getElementById('descuento-monto').textContent = '- Bs. ' + descuentoAplicado.toFixed(2);
                document.getElementById('descuento-row').style.display = 'flex';
            } else {
                document.getElementById('descuento-row').style.display = 'none';
            }
            
            // Aplicar beca
            let becaAplicada = 0;
            if (becaPorcentaje > 0 && !noDescuento) {
                becaAplicada = montoConDescuento * becaPorcentaje / 100;
                montoConDescuento = montoConDescuento - becaAplicada;
                document.getElementById('beca-calc-porcentaje').textContent = becaPorcentaje;
                document.getElementById('beca-monto').textContent = '- Bs. ' + becaAplicada.toFixed(2);
                document.getElementById('beca-row').style.display = 'flex';
            } else {
                document.getElementById('beca-row').style.display = 'none';
            }
            
            // Mostrar resultados
            document.getElementById('monto-base').textContent = 'Bs. ' + montoBase.toFixed(2);
            document.getElementById('monto-final').textContent = 'Bs. ' + montoConDescuento.toFixed(2);
            document.getElementById('calculo-container').style.display = 'block';
        }
    </script>
</x-secretaria-layout>
