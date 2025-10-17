<x-admin-layout>
    @includeIf('layouts.partials.gheader')

    <div class="w-full max-w-2xl p-6 bg-white rounded shadow">
        <h2 class="text-2xl font-bold mb-4">Editar Requisito</h2>

        @if ($errors->any())
            <div class="mb-4 p-3 rounded bg-rose-100 text-rose-800">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('admin.requisito.update', $row->idrequisito) }}" class="space-y-4">
            @csrf
            @method('PUT')
            <div>
                <label class="block text-gray-700">ID</label>
                <input type="text" value="{{ $row->idrequisito }}" class="mt-1 block w-full p-2 border rounded bg-gray-100" disabled>
            </div>
            <div>
                <label class="block text-gray-700">Descripción</label>
                <textarea name="descripcion" class="mt-1 block w-full p-2 border rounded" rows="3" required>{{ old('descripcion', $row->descripcion) }}</textarea>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-gray-700">Tipo de Beca</label>
                    <select name="idtipobeca" class="mt-1 block w-full p-2 border rounded" required>
                        @foreach($tipos as $t)
                        <option value="{{ $t->idtipobeca }}" {{ old('idtipobeca', $row->idtipobeca)==$t->idtipobeca ? 'selected' : '' }}>{{ $t->nombre }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-gray-700">Obligatorio</label>
                    <select name="obligatorio" class="mt-1 block w-full p-2 border rounded" required>
                        <option value="1" {{ old('obligatorio', $row->obligatorio)==='1' ? 'selected' : '' }}>Sí</option>
                        <option value="0" {{ old('obligatorio', $row->obligatorio)==='0' ? 'selected' : '' }}>No</option>
                    </select>
                </div>
            </div>

            <div class="flex items-center gap-2">
                <a href="{{ route('admin.requisito.index') }}" class="px-3 py-2 bg-gray-200 rounded">Cancelar</a>
                <button type="submit" class="px-3 py-2 bg-blue-600 hover:bg-blue-500 text-white rounded">Actualizar</button>
            </div>
        </form>

        <div class="mt-6">
            <form action="{{ route('admin.requisito.disable', $row->idrequisito) }}" method="POST" onsubmit="return confirm('¿Deshabilitar este requisito?');">
                @csrf
                <button class="px-3 py-2 bg-rose-600 hover:bg-rose-500 text-white rounded">Deshabilitar requisito</button>
            </form>
        </div>
    </div>
</x-admin-layout>
