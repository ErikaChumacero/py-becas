<x-admin-layout>
    @includeIf('layouts.partials.gheader')

    <div class="w-full max-w-2xl p-6 bg-white rounded shadow">
        <h2 class="text-2xl font-bold mb-4">Nuevo Estudiante</h2>

        @if ($errors->any())
            <div class="mb-4 p-3 rounded bg-rose-100 text-rose-800">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.estudiante.store') }}" method="POST" class="space-y-4">
            @csrf
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-gray-700">CI</label>
                    <input type="text" name="ci" value="{{ old('ci') }}" class="mt-1 block w-full p-2 border rounded" required>
                </div>
                <div>
                    <label class="block text-gray-700">Teléfono</label>
                    <input type="text" name="telefono" value="{{ old('telefono') }}" class="mt-1 block w-full p-2 border rounded" required>
                </div>
                <div>
                    <label class="block text-gray-700">Nombre</label>
                    <input type="text" name="nombre" value="{{ old('nombre') }}" class="mt-1 block w-full p-2 border rounded" required>
                </div>
                <div>
                    <label class="block text-gray-700">Apellido</label>
                    <input type="text" name="apellido" value="{{ old('apellido') }}" class="mt-1 block w-full p-2 border rounded" required>
                </div>
                <div>
                    <label class="block text-gray-700">Sexo</label>
                    <select name="sexo" class="mt-1 block w-full p-2 border rounded" required>
                        <option value="">Seleccione</option>
                        <option value="M" {{ old('sexo')==='M' ? 'selected' : '' }}>M</option>
                        <option value="F" {{ old('sexo')==='F' ? 'selected' : '' }}>F</option>
                    </select>
                </div>
                <div>
                    <label class="block text-gray-700">Correo</label>
                    <input type="email" name="correo" value="{{ old('correo') }}" class="mt-1 block w-full p-2 border rounded" required>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-gray-700">Contraseña</label>
                    <input type="text" name="contrasena" value="{{ old('contrasena') }}" class="mt-1 block w-full p-2 border rounded" required>
                </div>
                <div>
                    <label class="block text-gray-700">Código</label>
                    <input type="text" name="codigo" value="{{ old('codigo') }}" class="mt-1 block w-full p-2 border rounded">
                </div>
                <div>
                    <label class="block text-gray-700">Nro Registro</label>
                    <input type="text" name="nroregistro" value="{{ old('nroregistro') }}" class="mt-1 block w-full p-2 border rounded">
                </div>
            </div>

            <div class="flex items-center gap-4">
                <label class="inline-flex items-center">
                    <input type="checkbox" name="tipou" value="1" {{ old('tipou') ? 'checked' : '' }}>
                    <span class="ml-2">Usuario</span>
                </label>
                <label class="inline-flex items-center">
                    <input type="checkbox" name="tipoa" value="1" {{ old('tipoa') ? 'checked' : '' }}>
                    <span class="ml-2">Admin</span>
                </label>
                <span class="text-sm text-gray-600">El estado Estudiante se activa automáticamente</span>
            </div>

            <div class="flex items-center gap-2">
                <a href="{{ route('admin.estudiante.index') }}" class="px-3 py-2 bg-gray-200 rounded">Cancelar</a>
                <button type="submit" class="px-3 py-2 bg-blue-600 hover:bg-blue-500 text-white rounded">Guardar</button>
            </div>
        </form>
    </div>
</x-admin-layout>
