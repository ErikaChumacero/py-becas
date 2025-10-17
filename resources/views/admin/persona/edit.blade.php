<x-admin-layout>
    @if (session('success'))
        <div class="bg-green-500 text-white p-4 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif
    @if (session('error'))
        <div class="bg-red-500 text-white p-4 rounded mb-4">
            {{ session('error') }}
        </div>
    @endif

    <div class="container mx-auto mt-5">
        <h1 class="text-2xl font-bold mb-4">Editar Persona</h1>

        <form action="{{ route('admin.persona.update', $persona->ci) }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')

            <!-- CI (solo lectura) -->
            <div class="mb-4">
                <label class="block text-gray-700">CI</label>
                <input type="text" value="{{ $persona->ci }}" class="border rounded w-full p-2 bg-gray-100" disabled>
            </div>

            <!-- Nombre -->
            <div class="mb-4">
                <label for="nombre" class="block text-gray-700">Nombre</label>
                <input type="text" name="nombre" id="nombre" value="{{ $persona->nombre }}"
                    class="border rounded w-full p-2" required>
            </div>

            <!-- Apellido -->
            <div class="mb-4">
                <label for="apellido" class="block text-gray-700">Apellido</label>
                <input type="text" name="apellido" id="apellido" value="{{ $persona->apellido }}"
                    class="border rounded w-full p-2" required>
            </div>

            <!-- Telefono -->
            <div class="mb-4">
                <label for="telefono" class="block text-gray-700">Telefono</label>
                <input type="text" name="telefono" id="telefono" value="{{ $persona->telefono }}"
                    class="border rounded w-full p-2" required>
            </div>

            <!-- Sexo -->
            <div class="mb-4">
                <label for="sexo" class="block text-gray-700">Sexo</label>
                <select name="sexo" id="sexo" class="border rounded w-full p-2" required>
                    <option value="" disabled>Seleccione sexo</option>
                    <option value="M" {{ $persona->sexo == 'M' ? 'selected' : '' }}>M</option>
                    <option value="F" {{ $persona->sexo == 'F' ? 'selected' : '' }}>F</option>
                </select>
            </div>

            <!-- Correo -->
            <div class="mb-4">
                <label for="correo" class="block text-gray-700">Correo</label>
                <input type="email" name="correo" id="correo" value="{{ $persona->correo }}" class="border rounded w-full p-2" required>
            </div>

            <!-- Contraseña -->
            <div class="mb-4">
                <label for="contrasena" class="block text-gray-700">Contraseña</label>
                <input type="text" name="contrasena" id="contrasena" value="{{ $persona->contrasena }}" class="border rounded w-full p-2" required>
            </div>

            <!-- Tipos (estados) -->
            <div class="mb-4">
                <span class="block text-gray-700 mb-1">Tipos</span>
                <label class="inline-flex items-center mr-4">
                    <input id="tipou" type="checkbox" name="tipou" value="1" {{ $persona->tipou == '1' ? 'checked' : '' }}>
                    <span class="ml-2">Usuario</span>
                </label>
                <label class="inline-flex items-center mr-4">
                    <input id="tipoa" type="checkbox" name="tipoa" value="1" {{ $persona->tipoa == '1' ? 'checked' : '' }}>
                    <span class="ml-2">Admin</span>
                </label>
                <label class="inline-flex items-center">
                    <input id="tipoe" type="checkbox" name="tipoe" value="1" {{ $persona->tipoe == '1' ? 'checked' : '' }}>
                    <span class="ml-2">Estudiante</span>
                </label>
            </div>

            <!-- Código y Nro Registro -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="codigo" class="block text-gray-700">Código</label>
                    <input type="text" name="codigo" id="codigo" value="{{ $persona->codigo ?? '' }}" class="border rounded w-full p-2" disabled>
                </div>
                <div>
                    <label for="nroregistro" class="block text-gray-700">Nro Registro</label>
                    <input type="text" name="nroregistro" id="nroregistro" value="{{ $persona->nroregistro ?? '' }}" class="border rounded w-full p-2" disabled>
                </div>
            </div>

            <!-- Botón -->
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-700">
                Actualizar
            </button>
        </form>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                var tipoa = document.getElementById('tipoa');
                var tipoe = document.getElementById('tipoe');
                var codigo = document.getElementById('codigo');
                var nro = document.getElementById('nroregistro');
                function sync() {
                    var a = tipoa && tipoa.checked;
                    var e = tipoe && tipoe.checked;
                    if (codigo) {
                        codigo.disabled = !a;
                        codigo.required = !!a;
                        codigo.classList.toggle('bg-blue-100', a);
                        codigo.classList.toggle('bg-white', !a);
                    }
                    if (nro) {
                        nro.disabled = !e;
                        nro.required = !!e;
                        nro.classList.toggle('bg-green-100', e);
                        nro.classList.toggle('bg-white', !e);
                    }
                }
                if (tipoa) tipoa.addEventListener('change', sync);
                if (tipoe) tipoe.addEventListener('change', sync);
                sync();
            });
        </script>
    </div>
</x-admin-layout>
