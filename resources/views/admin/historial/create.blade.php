<x-admin-layout>
    @includeIf('layouts.partials.gheader')

    <div class="w-full max-w-2xl p-6 bg-white rounded shadow">
        <h2 class="text-2xl font-bold mb-4">Nuevo Historial</h2>

        @if ($errors->any())
            <div class="mb-4 p-3 rounded bg-rose-100 text-rose-800">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('admin.historial.store') }}" class="space-y-4">
            @csrf
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-gray-700">Postulación</label>
                    <select name="idpostulacion" class="mt-1 block w-full p-2 border rounded" required>
                        <option value="">Seleccione...</option>
                        @foreach($postulaciones as $p)
                        <option value="{{ $p->idpostulacion }}" {{ old('idpostulacion')==$p->idpostulacion ? 'selected' : '' }}>
                            #{{ $p->idpostulacion }} - {{ $p->etiqueta }} (Estado actual: {{ $p->estado }})
                        </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-gray-700">Fecha de cambio</label>
                    <input type="date" name="fechacambio" value="{{ old('fechacambio', now()->format('Y-m-d')) }}" class="mt-1 block w-full p-2 border rounded" required>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-gray-700 font-medium">Estado Anterior (Automático)</label>
                    <input type="text" id="estadoanterior_display" class="mt-1 block w-full p-2 border border-gray-300 rounded bg-gray-100" readonly value="Se mostrará al seleccionar postulación">
                    <input type="hidden" name="estadoanterior" id="estadoanterior" value="{{ old('estadoanterior') }}">
                </div>
                <div>
                    <label class="block text-gray-700 font-medium">Estado Nuevo</label>
                    <select name="estadonuevo" class="mt-1 block w-full p-2 border border-gray-300 rounded focus:ring-2 focus:ring-blue-500" required>
                        <option value="">Seleccione...</option>
                        <option value="1" {{ old('estadonuevo') == '1' ? 'selected' : '' }}>Pendiente</option>
                        <option value="2" {{ old('estadonuevo') == '2' ? 'selected' : '' }}>En Revisión</option>
                        <option value="3" {{ old('estadonuevo') == '3' ? 'selected' : '' }}>Aprobado</option>
                        <option value="4" {{ old('estadonuevo') == '4' ? 'selected' : '' }}>Rechazado</option>
                    </select>
                </div>
            </div>

            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const postulacionSelect = document.querySelector('select[name="idpostulacion"]');
                    const estadoAnteriorDisplay = document.getElementById('estadoanterior_display');
                    const estadoAnteriorHidden = document.getElementById('estadoanterior');
                    
                    const estadosNombres = {
                        '1': 'Pendiente',
                        '2': 'En Revisión',
                        '3': 'Aprobado',
                        '4': 'Rechazado'
                    };
                    
                    postulacionSelect.addEventListener('change', function() {
                        const selectedOption = this.options[this.selectedIndex];
                        if (selectedOption.value) {
                            const texto = selectedOption.text;
                            const match = texto.match(/Estado actual: (\d+)/);
                            if (match) {
                                const estadoActual = match[1];
                                estadoAnteriorHidden.value = estadoActual;
                                estadoAnteriorDisplay.value = estadosNombres[estadoActual] || estadoActual;
                            }
                        } else {
                            estadoAnteriorHidden.value = '';
                            estadoAnteriorDisplay.value = 'Se mostrará al seleccionar postulación';
                        }
                    });
                });
            </script>

            <div class="flex items-center gap-2">
                <a href="{{ route('admin.historial.index') }}" class="px-3 py-2 bg-gray-200 rounded">Cancelar</a>
                <button type="submit" class="px-3 py-2 bg-blue-600 hover:bg-blue-500 text-white rounded">Guardar</button>
            </div>
        </form>
    </div>
</x-admin-layout>
