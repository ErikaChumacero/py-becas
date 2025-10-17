<x-admin-layout>

    <!-- Mensajes de éxito -->
    @if (session('success'))
        <div class="bg-green-500 text-white p-4 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <!-- Mensajes de error generales -->
    @if (session('error'))
        <div class="bg-red-500 text-white p-4 rounded mb-4">
            {{ session('error') }}
        </div>
    @endif

    <!-- Mensajes de validación específicos (por ejemplo, persona ya registrada) -->
    @if ($errors->any())
        <div class="bg-red-500 text-white p-4 rounded mb-4">
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <table class="min-w-full bg-white border border-gray-300">
        <thead>
            <tr class="bg-gray-200 text-gray-600">
                <th class="py-3 px-4 border-b">CI</th>
                <th class="py-3 px-4 border-b">Nombre</th>
                <th class="py-3 px-4 border-b">Apellido</th>
                <th class="py-3 px-4 border-b">Telefono</th>
                <th class="py-3 px-4 border-b">Sexo</th>
                <th class="py-3 px-4 border-b">Correo</th>
                <th class="py-3 px-4 border-b">U</th>
                <th class="py-3 px-4 border-b">A</th>
                <th class="py-3 px-4 border-b">E</th>
                <th class="py-3 px-4 border-b">Código</th>
                <th class="py-3 px-4 border-b">Nro Reg.</th>
                <th class="py-3 px-4 border-b">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($personas as $persona)
                <tr class="hover:bg-gray-100">
                    <td class="py-3 px-4 border-b text-center">{{ $persona->ci }}</td>
                    <td class="py-3 px-4 border-b text-center">{{ $persona->nombre }}</td>
                    <td class="py-3 px-4 border-b text-center">{{ $persona->apellido }}</td>
                    <td class="py-3 px-4 border-b text-center">{{ $persona->telefono }}</td>
                    <td class="py-3 px-4 border-b text-center">{{ $persona->sexo }}</td>
                    <td class="py-3 px-4 border-b text-center">{{ $persona->correo }}</td>
                    <td class="py-3 px-4 border-b text-center">{{ $persona->tipou }}</td>
                    <td class="py-3 px-4 border-b text-center">{{ $persona->tipoa }}</td>
                    <td class="py-3 px-4 border-b text-center">{{ $persona->tipoe }}</td>
                    <td class="py-3 px-4 border-b text-center">{{ $persona->codigo ?? '-' }}</td>
                    <td class="py-3 px-4 border-b text-center">{{ $persona->nroregistro ?? '-' }}</td>
                    <td class="py-3 px-4 border-b text-center">
                        <a href="{{ route('admin.persona.edit', $persona->ci) }}"
                            class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-700">Editar</a>

                        <!-- Botón deshabilitar que abre el modal -->
                        <button type="button" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-700"
                            onclick="openDeleteModal({{ \Illuminate\Support\Js::from($persona->ci) }})">
                            Deshabilitar
                        </button>

                        <!-- Modal de confirmación -->
                        <div id="deleteModal-{{ $persona->ci }}"
                            class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
                            <div class="bg-white rounded-lg shadow-lg p-6 w-96 text-center">
                                <h2 class="text-lg font-semibold mb-4">¿Estás seguro?</h2>
                                <p class="mb-6">Esta acción deshabilitará este registro (U/A/E en 0).</p>

                                <div class="flex justify-center gap-4">
                                    <form action="{{ route('admin.persona.destroy', $persona->ci) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-700">Sí,
                                            deshabilitar</button>
                                    </form>
                                    <button onclick="closeDeleteModal({{ \Illuminate\Support\Js::from($persona->ci) }})"
                                        class="bg-gray-300 px-4 py-2 rounded hover:bg-gray-400">Cancelar</button>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="12" class="py-3 px-4 border-b text-center text-gray-500">
                        No hay registros disponibles.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <script>
        // Abrir modal de eliminar
        function openDeleteModal(ci) {
            const modal = document.getElementById('deleteModal-' + ci);
            modal.classList.remove('hidden');
        }

        // Cerrar modal de eliminar
        function closeDeleteModal(ci) {
            const modal = document.getElementById('deleteModal-' + ci);
            modal.classList.add('hidden');
        }
    </script>

</x-admin-layout>
