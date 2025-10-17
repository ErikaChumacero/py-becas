<x-admin-layout>
    <div class="w-full max-w-xl p-6 bg-white rounded shadow">
        <h2 class="text-2xl font-bold mb-4">Nuevo Semestre</h2>
        @if ($errors->any())
            <div class="mb-4 p-3 rounded bg-rose-100 text-rose-800">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form method="POST" action="{{ route('admin.semestre.store') }}" class="space-y-4">
            @csrf
            <div>
                <label class="block text-gray-700">Año</label>
                <input type="number" name="anio" value="{{ old('anio') }}" class="mt-1 block w-full p-2 border rounded" required>
            </div>
            <div>
                <label class="block text-gray-700">Periodo</label>
                <input type="text" name="periodo" value="{{ old('periodo') }}" class="mt-1 block w-full p-2 border rounded" required>
            </div>
            <div>
                <label class="block text-gray-700">Descripción</label>
                <input type="text" name="descripcion" value="{{ old('descripcion') }}" class="mt-1 block w-full p-2 border rounded" required>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route('admin.semestre.index') }}" class="px-3 py-2 bg-gray-200 rounded">Cancelar</a>
                <button type="submit" class="px-3 py-2 bg-blue-600 hover:bg-blue-500 text-white rounded">Guardar</button>
            </div>
        </form>
    </div>
</x-admin-layout>
