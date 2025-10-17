<x-admin-layout>
    @includeIf('layouts.partials.gheader')

    <div class="w-full max-w-2xl p-6 bg-white rounded shadow">
        <h2 class="text-2xl font-bold mb-4">Editar Estudiante</h2>

        @if ($errors->any())
            <div class="mb-4 p-3 rounded bg-rose-100 text-rose-800">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.estudiante.update', $persona->ci) }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-gray-700">CI</label>
                    <input type="text" value="{{ $persona->ci }}" class="mt-1 block w-full p-2 border rounded bg-gray-100" disabled>
                </div>
                <div>
                    <label class="block text-gray-700">Teléfono</label>
                    <input type="text" name="telefono" value="{{ old('telefono', $persona->telefono) }}" class="mt-1 block w-full p-2 border rounded" required>
                </div>
                <div>
                    <label class="block text-gray-700">Nombre</label>
                    <input type="text" name="nombre" value="{{ old('nombre', $persona->nombre) }}" class="mt-1 block w-full p-2 border rounded" required>
                </div>
                <div>
                    <label class="block text-gray-700">Apellido</label>
                    <input type="text" name="apellido" value="{{ old('apellido', $persona->apellido) }}" class="mt-1 block w-full p-2 border rounded" required>
                </div>
                <div>
                    <label class="block text-gray-700">Sexo</label>
                    <select name="sexo" class="mt-1 block w-full p-2 border rounded" required>
                        <option value="M" {{ old('sexo', $persona->sexo)==='M' ? 'selected' : '' }}>M</option>
                        <option value="F" {{ old('sexo', $persona->sexo)==='F' ? 'selected' : '' }}>F</option>
                    </select>
                </div>
                <div>
                    <label class="block text-gray-700">Correo</label>
                    <input type="email" name="correo" value="{{ old('correo', $persona->correo) }}" class="mt-1 block w-full p-2 border rounded" required>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-gray-700">Contraseña</label>
                    <input type="text" name="contrasena" value="{{ old('contrasena', $persona->contrasena) }}" class="mt-1 block w-full p-2 border rounded" required>
                </div>
                <div>
                    <label class="block text-gray-700">Código</label>
                    <input type="text" name="codigo" value="{{ old('codigo', $persona->codigo) }}" class="mt-1 block w-full p-2 border rounded">
                </div>
                <div>
                    <label class="block text-gray-700">Nro Registro</label>
                    <input type="text" name="nroregistro" value="{{ old('nroregistro', $persona->nroregistro) }}" class="mt-1 block w-full p-2 border rounded">
                </div>
            </div>

            <div class="flex items-center gap-4">
                <label class="inline-flex items-center">
                    <input type="checkbox" name="tipou" value="1" {{ old('tipou', $persona->tipou)==='1' ? 'checked' : '' }}>
                    <span class="ml-2">Usuario</span>
                </label>
                <label class="inline-flex items-center">
                    <input type="checkbox" name="tipoa" value="1" {{ old('tipoa', $persona->tipoa)==='1' ? 'checked' : '' }}>
                    <span class="ml-2">Admin</span>
                </label>
                <span class="text-sm text-gray-600">El estado Estudiante permanece activo</span>
            </div>

            <div class="flex items-center gap-2">
                <a href="{{ route('admin.estudiante.index') }}" class="px-3 py-2 bg-gray-200 rounded">Cancelar</a>
                <button type="submit" class="px-3 py-2 bg-blue-600 hover:bg-blue-500 text-white rounded">Actualizar</button>
            </div>
        </form>

        <div class="mt-6">
            <form action="{{ route('admin.estudiante.disable', $persona->ci) }}" method="POST" onsubmit="return confirm('¿Deshabilitar este estudiante?');">
                @csrf
                <button class="px-3 py-2 bg-rose-600 hover:bg-rose-500 text-white rounded">Deshabilitar estudiante</button>
            </form>
        </div>
    </div>
</x-admin-layout>
