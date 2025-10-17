<x-admin-layout>
    <h1 class="text-2xl font-semibold mb-4">Nueva Convocatoria</h1>

    @error('general')
        <div class="mb-4 p-3 rounded bg-rose-100 text-rose-800">{{ $message }}</div>
    @enderror

    <form method="POST" action="{{ route('admin.convocatoria.store') }}" class="space-y-4">
        @csrf
        <div>
            <label class="block text-sm font-medium mb-1">Título</label>
            <input type="text" name="titulo" class="w-full border rounded p-2" value="{{ old('titulo') }}" maxlength="100" required>
            @error('titulo')<div class="text-rose-600 text-sm mt-1">{{ $message }}</div>@enderror
        </div>
        <div>
            <label class="block text-sm font-medium mb-1">Descripción</label>
            <textarea name="descripcion" class="w-full border rounded p-2" maxlength="500" required>{{ old('descripcion') }}</textarea>
            @error('descripcion')<div class="text-rose-600 text-sm mt-1">{{ $message }}</div>@enderror
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium mb-1">Fecha inicio</label>
                <input type="date" name="fechainicio" class="w-full border rounded p-2" value="{{ old('fechainicio') }}" required>
                @error('fechainicio')<div class="text-rose-600 text-sm mt-1">{{ $message }}</div>@enderror
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Fecha fin</label>
                <input type="date" name="fechafin" class="w-full border rounded p-2" value="{{ old('fechafin') }}" required>
                @error('fechafin')<div class="text-rose-600 text-sm mt-1">{{ $message }}</div>@enderror
            </div>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium mb-1">Tipo de Beca</label>
                <select name="idtipobeca" class="w-full border rounded p-2" required>
                    <option value="">Seleccione...</option>
                    @foreach($tipos as $t)
                        <option value="{{ $t->idtipobeca }}" @selected(old('idtipobeca')==$t->idtipobeca)>{{ $t->nombre }}</option>
                    @endforeach
                </select>
                @error('idtipobeca')<div class="text-rose-600 text-sm mt-1">{{ $message }}</div>@enderror
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Estado</label>
                <select name="estado" class="w-full border rounded p-2" required>
                    <option value="1" @selected(old('estado','1')==='1')>Activa</option>
                    <option value="0" @selected(old('estado')==='0')>Inactiva</option>
                </select>
                @error('estado')<div class="text-rose-600 text-sm mt-1">{{ $message }}</div>@enderror
            </div>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.convocatoria.index') }}" class="px-3 py-2 bg-gray-200 rounded">Cancelar</a>
            <button class="px-3 py-2 bg-blue-600 hover:bg-blue-500 text-white rounded">Guardar</button>
        </div>
    </form>
</x-admin-layout>
