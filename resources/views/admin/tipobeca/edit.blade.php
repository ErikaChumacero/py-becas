<x-admin-layout>
    @includeIf('layouts.partials.gheader')

    <div class="w-full max-w-2xl p-6 bg-white rounded shadow">
        <h2 class="text-2xl font-bold mb-4">Editar Tipo de Beca</h2>

        @if ($errors->any())
            <div class="mb-4 p-3 rounded bg-rose-100 text-rose-800">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('admin.tipobeca.update', $row->idtipobeca) }}" class="space-y-4">
            @csrf
            @method('PUT')
            <div>
                <label class="block text-gray-700">ID</label>
                <input type="text" value="{{ $row->idtipobeca }}" class="mt-1 block w-full p-2 border rounded bg-gray-100" disabled>
            </div>
            <div>
                <label class="block text-gray-700">Nombre</label>
                <input type="text" name="nombre" value="{{ old('nombre', $row->nombre) }}" class="mt-1 block w-full p-2 border rounded" required>
            </div>
            <div>
                <label class="block text-gray-700">Descripción</label>
                <textarea name="descripcion" class="mt-1 block w-full p-2 border rounded" rows="4" required>{{ old('descripcion', $row->descripcion) }}</textarea>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route('admin.tipobeca.index') }}" class="px-3 py-2 bg-gray-200 rounded">Cancelar</a>
                <button type="submit" class="px-3 py-2 bg-blue-600 hover:bg-blue-500 text-white rounded">Actualizar</button>
            </div>
        </form>

        
    </div>
</x-admin-layout>
