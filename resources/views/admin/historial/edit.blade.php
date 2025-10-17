<x-admin-layout>
    @includeIf('layouts.partials.gheader')

    <div class="w-full max-w-2xl p-6 bg-white rounded shadow">
        <h2 class="text-2xl font-bold mb-4">Editar Historial</h2>

        @if ($errors->any())
            <div class="mb-4 p-3 rounded bg-rose-100 text-rose-800">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('admin.historial.update', $row->idhistorialestado) }}" class="space-y-4">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-gray-700">ID</label>
                    <input type="text" value="{{ $row->idhistorialestado }}" class="mt-1 block w-full p-2 border rounded bg-gray-100" disabled>
                </div>
                <div>
                    <label class="block text-gray-700">Postulación</label>
                    <select name="idpostulacion" class="mt-1 block w-full p-2 border rounded" required>
                        @foreach($postulaciones as $p)
                        <option value="{{ $p->idpostulacion }}" {{ old('idpostulacion', $row->idpostulacion)==$p->idpostulacion ? 'selected' : '' }}>
                            #{{ $p->idpostulacion }} - {{ $p->etiqueta }} (Estado actual: {{ $p->estado }})
                        </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-gray-700">Estado Anterior</label>
                    <input type="text" name="estadoanterior" value="{{ old('estadoanterior', $row->estadoanterior) }}" class="mt-1 block w-full p-2 border rounded" required>
                </div>
                <div>
                    <label class="block text-gray-700">Estado Nuevo</label>
                    <input type="text" name="estadonuevo" value="{{ old('estadonuevo', $row->estadonuevo) }}" class="mt-1 block w-full p-2 border rounded" required>
                </div>
                <div>
                    <label class="block text-gray-700">Fecha de cambio</label>
                    <input type="date" name="fechacambio" value="{{ old('fechacambio', \Carbon\Carbon::parse($row->fechacambio)->format('Y-m-d')) }}" class="mt-1 block w-full p-2 border rounded" required>
                </div>
            </div>

            <div class="flex items-center gap-2">
                <a href="{{ route('admin.historial.index') }}" class="px-3 py-2 bg-gray-200 rounded">Cancelar</a>
                <button type="submit" class="px-3 py-2 bg-blue-600 hover:bg-blue-500 text-white rounded">Actualizar</button>
            </div>
        </form>

        <div class="mt-6">
            <form action="{{ route('admin.historial.disable', $row->idhistorialestado) }}" method="POST" onsubmit="return confirm('¿Deshabilitar este historial (estado nuevo a 0)?');">
                @csrf
                <button class="px-3 py-2 bg-rose-600 hover:bg-rose-500 text-white rounded">Deshabilitar historial</button>
            </form>
        </div>
    </div>
</x-admin-layout>
