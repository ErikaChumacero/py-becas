<x-admin-layout>
    <h1 class="text-2xl font-semibold mb-4">Editar Carrera</h1>

    <form method="POST" action="{{ route('admin.carrera.update', $row->idcarrera) }}" class="space-y-4">
        @csrf
        @method('PUT')
        <div>
            <label class="block text-sm font-medium mb-1">Plan</label>
            <input type="text" name="plancarrera" class="w-full border rounded p-2" value="{{ old('plancarrera', $row->plancarrera) }}" maxlength="50" required>
            @error('plancarrera')<div class="text-rose-600 text-sm mt-1">{{ $message }}</div>@enderror
        </div>
        <div>
            <label class="block text-sm font-medium mb-1">Código</label>
            <input type="text" name="codigo" class="w-full border rounded p-2" value="{{ old('codigo', $row->codigo) }}" maxlength="20" required>
            @error('codigo')<div class="text-rose-600 text-sm mt-1">{{ $message }}</div>@enderror
        </div>
        <div>
            <label class="block text-sm font-medium mb-1">Nombre</label>
            <input type="text" name="nombre" class="w-full border rounded p-2" value="{{ old('nombre', $row->nombre) }}" maxlength="100" required>
            @error('nombre')<div class="text-rose-600 text-sm mt-1">{{ $message }}</div>@enderror
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.carrera.index') }}" class="px-3 py-2 bg-gray-200 rounded">Cancelar</a>
            <button class="px-3 py-2 bg-blue-600 hover:bg-blue-500 text-white rounded">Actualizar</button>
        </div>
    </form>
</x-admin-layout>

