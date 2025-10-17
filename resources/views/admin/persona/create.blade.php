<x-admin-layout>
    <div class="w-full max-w-xl p-6 bg-white rounded shadow">
        <h2 class="text-2xl font-bold mb-4">Registro de Persona</h2>

        @if (session('success'))
            <div class="mb-4 text-green-600">{{ session('success') }}</div>
        @endif

        <form action="{{ route('admin.persona.store') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label for="ci" class="block text-gray-700">CI:</label>
                <input type="text" name="ci" id="ci" value="{{ old('ci') }}" class="mt-1 block w-full p-2 border border-gray-300 rounded" required>
                @error('ci')
                    <div class="text-red-600">{{ $message }}</div>
                @enderror
            </div>
            <div>
                <label for="nombre" class="block text-gray-700">Nombre:</label>
                <input type="text" name="nombre" id="nombre" value="{{ old('nombre') }}" class="mt-1 block w-full p-2 border border-gray-300 rounded" required>
                @error('nombre')
                    <div class="text-red-600">{{ $message }}</div>
                @enderror
            </div>
            <div>
                <label for="apellido" class="block text-gray-700">Apellido:</label>
                <input type="text" name="apellido" id="apellido" value="{{ old('apellido') }}" class="mt-1 block w-full p-2 border border-gray-300 rounded" required>
                @error('apellido')
                    <div class="text-red-600">{{ $message }}</div>
                @enderror
            </div>
            <div>
                <label for="telefono" class="block text-gray-700">Telefono:</label>
                <input type="text" name="telefono" id="telefono" value="{{ old('telefono') }}" class="mt-1 block w-full p-2 border border-gray-300 rounded" required>
                @error('telefono')
                    <div class="text-red-600">{{ $message }}</div>
                @enderror
            </div>
            <div>
                <label for="sexo" class="block text-gray-700">Sexo:</label>
                <select name="sexo" id="sexo" required class="mt-1 block w-full p-2 border border-gray-300 rounded">
                    <option value="">Seleccione</option>
                    <option value="M" {{ old('sexo')=='M' ? 'selected' : '' }}>M</option>
                    <option value="F" {{ old('sexo')=='F' ? 'selected' : '' }}>F</option>
                </select>
                @error('sexo')
                    <div class="text-red-600">{{ $message }}</div>
                @enderror
            </div>
            <div>
                <label for="correo" class="block text-gray-700">Correo:</label>
                <input type="email" name="correo" id="correo" value="{{ old('correo') }}" class="mt-1 block w-full p-2 border border-gray-300 rounded" required>
                @error('correo')
                    <div class="text-red-600">{{ $message }}</div>
                @enderror
            </div>

            <div>
                <label for="contrasena" class="block text-gray-700">Contraseña:</label>
                <input type="text" name="contrasena" id="contrasena" value="{{ old('contrasena') }}" class="mt-1 block w-full p-2 border border-gray-300 rounded" required>
                @error('contrasena')
                    <div class="text-red-600">{{ $message }}</div>
                @enderror
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div>
                    <label class="inline-flex items-center">
                        <input id="tipou" type="checkbox" name="tipou" value="1" {{ old('tipou') ? 'checked' : '' }}>
                        <span class="ml-2">Usuario</span>
                    </label>
                </div>
                <div>
                    <label class="inline-flex items-center">
                        <input id="tipoa" type="checkbox" name="tipoa" value="1" {{ old('tipoa') ? 'checked' : '' }}>
                        <span class="ml-2">Admin</span>
                    </label>
                </div>
                <div>
                    <label class="inline-flex items-center">
                        <input id="tipoe" type="checkbox" name="tipoe" value="1" {{ old('tipoe') ? 'checked' : '' }}>
                        <span class="ml-2">Estudiante</span>
                    </label>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="codigo" class="block text-gray-700">Código:</label>
                    <input type="text" name="codigo" id="codigo" value="{{ old('codigo') }}" class="mt-1 block w-full p-2 border border-gray-300 rounded" disabled>
                    @error('codigo')
                        <div class="text-red-600">{{ $message }}</div>
                    @enderror
                </div>
                <div>
                    <label for="nroregistro" class="block text-gray-700">Nro Registro:</label>
                    <input type="text" name="nroregistro" id="nroregistro" value="{{ old('nroregistro') }}" class="mt-1 block w-full p-2 border border-gray-300 rounded" disabled>
                    @error('nroregistro')
                        <div class="text-red-600">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="flex items-center gap-3 pt-2">
                <a href="{{ route('admin.persona.index') }}" class="px-3 py-2 bg-gray-200 rounded">Cancelar</a>
                <button type="submit" class="px-3 py-2 bg-blue-600 hover:bg-blue-500 text-white rounded">Registrar</button>
            </div>
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
